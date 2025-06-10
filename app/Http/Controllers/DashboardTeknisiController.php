<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PerbaikanModel;
use Illuminate\Http\Request;

class DashboardTeknisiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard Teknisi',
            'list' => ['Home', 'Dashboard']
        ];

        $activeMenu = 'dashboard';

        // Hitung data statistik perbaikan
        $repairStats = [
            'total' => PerbaikanModel::where('teknisi_id', auth()->user()->user_id)->count(),
            'waiting' => PerbaikanModel::where('teknisi_id', auth()->user()->user_id)
                                ->where('status', 'menunggu')->count(),
            'in_progress' => PerbaikanModel::where('teknisi_id', auth()->user()->user_id)
                                    ->where('status', 'diproses')->count(),
            'completed' => PerbaikanModel::where('teknisi_id', auth()->user()->user_id)
                                ->where('status', 'selesai')->count(),
        ];

        // Ambil 5 perbaikan terbaru yang perlu ditangani
        $latestRepairs = PerbaikanModel::with(['laporan', 'laporan.fasilitas'])
            ->where('teknisi_id', auth()->user()->user_id)
            ->whereIn('status', ['menunggu', 'diproses'])
            ->orderBy('tanggal_mulai', 'desc')
            ->take(5)
            ->get();

        return view('teknisi.dashboard', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'repairStats' => $repairStats,
            'latestRepairs' => $latestRepairs
        ]);
    }
}