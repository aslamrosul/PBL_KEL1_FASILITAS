<?php

namespace App\Http\Controllers;

use App\Models\LaporanModel;
use App\Models\FeedbackModel;
use App\Models\PeriodeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard Admin',
            'list' => ['Home', 'Dashboard']
        ];

        $page = (object) [
            'title' => 'Dashboard Admin Sistem Pelaporan Fasilitas'
        ];

        $activeMenu = 'dashboard';

        // Get statistics for the dashboard
        $currentPeriod = PeriodeModel::where('is_aktif', 1)->first();

        $reportStats = [
            'total' => LaporanModel::count(),
            'menunggu' => LaporanModel::where('status', 'menunggu')->count(),
             'diterima' => LaporanModel::where('status', 'diterima')->count(),
            'processed' => LaporanModel::where('status', 'diproses')->count(),
            'completed' => LaporanModel::where('status', 'selesai')->count(),
            'rejected' => LaporanModel::where('status', 'ditolak')->count(),
        ];

        // Facility damage trends by category (last 6 months)
        $damageTrends = LaporanModel::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // User satisfaction statistics
        $satisfactionStats = FeedbackModel::select(
            DB::raw('AVG(rating) as average_rating'),
            DB::raw('COUNT(*) as total_feedback')
        )->first();

        // Top 5 most reported facilities
        $topFacilities = LaporanModel::select(
            't_laporan.fasilitas_id', // Explicitly specify which table's column to use
            'm_fasilitas.fasilitas_nama',
            DB::raw('COUNT(*) as total_reports')
        )
            ->join('m_fasilitas', 'm_fasilitas.fasilitas_id', '=', 't_laporan.fasilitas_id')
            ->groupBy('t_laporan.fasilitas_id', 'm_fasilitas.fasilitas_nama')
            ->orderBy('total_reports', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'currentPeriod' => $currentPeriod,
            'reportStats' => $reportStats,
            'damageTrends' => $damageTrends,
            'satisfactionStats' => $satisfactionStats,
            'topFacilities' => $topFacilities
        ]);
    }
}
