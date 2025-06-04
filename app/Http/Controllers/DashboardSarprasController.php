<?php

namespace App\Http\Controllers;

use App\Models\LaporanModel;
use App\Models\PerbaikanModel;
use App\Models\FasilitasModel;
use App\Models\FeedbackModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardSarprasController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard Sarpras',
            'list' => ['Home', 'Dashboard']
        ];

        $page = (object) [
            'title' => 'Dashboard Sarana Prasarana'
        ];

        $activeMenu = 'dashboard';

        // Maintenance statistics
        $maintenanceStats = [
            'total' => PerbaikanModel::count(),
            'ongoing' => PerbaikanModel::where('status', 'diproses')->count(),
            'completed' => PerbaikanModel::where('status', 'selesai')->count(),
            'rejected' => PerbaikanModel::where('status', 'ditolak')->count(),
        ];

        // Facility condition statistics
        $facilityConditions = FasilitasModel::select(
            'status',
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('status')
        ->get();

        // Repair frequency by facility
        $repairFrequency = LaporanModel::select(
            'm_fasilitas.fasilitas_nama',
            DB::raw('COUNT(t_laporan.laporan_id) as report_count')
        )
        ->join('m_fasilitas', 'm_fasilitas.fasilitas_id', '=', 't_laporan.fasilitas_id')
        ->groupBy('m_fasilitas.fasilitas_nama')
        ->orderBy('report_count', 'desc')
        ->limit(5)
        ->get();

        // Average repair time
        $avgRepairTime = PerbaikanModel::select(
            DB::raw('AVG(TIMESTAMPDIFF(HOUR, tanggal_mulai, tanggal_selesai)) as avg_hours')
        )
        ->whereNotNull('tanggal_selesai')
        ->first();

        // User satisfaction by facility type
        $satisfactionByFacility = FeedbackModel::select(
            'm_fasilitas.fasilitas_nama',
            DB::raw('AVG(t_feedback.rating) as avg_rating'),
            DB::raw('COUNT(t_feedback.feedback_id) as feedback_count')
        )
        ->join('t_laporan', 't_laporan.laporan_id', '=', 't_feedback.laporan_id')
        ->join('m_fasilitas', 'm_fasilitas.fasilitas_id', '=', 't_laporan.fasilitas_id')
        ->groupBy('m_fasilitas.fasilitas_nama')
        ->orderBy('avg_rating', 'desc')
        ->get();

        return view('sarpras.dashboard', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'maintenanceStats' => $maintenanceStats,
            'facilityConditions' => $facilityConditions,
            'repairFrequency' => $repairFrequency,
            'avgRepairTime' => $avgRepairTime,
            'satisfactionByFacility' => $satisfactionByFacility
        ]);
    }
}