<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardTeknisiController extends Controller
{
    //
     public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard',
            'list' => ['Home', 'Dashboard']
        ];

        $activeMenu = 'dashboard';

        // Hitung data statistik
       

        return view('pelapor.dashboard', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            
        ]);
    }
}
