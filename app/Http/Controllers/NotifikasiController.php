<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    //
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Notifikasi',
            'list' => ['Home', 'Notifikasi']
        ];

        $activeMenu = 'notifikasi';

        // Ambil data notifikasi dari database
        $notifikasi = []; // Ganti dengan logika untuk mengambil notifikasi

        return view('notifikasi.index', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'notifikasi' => $notifikasi,
        ]);
    }
    public function show($id)
    {
        $breadcrumb = (object) [
            'title' => 'Detail Notifikasi',
            'list' => ['Home', 'Notifikasi', 'Detail']
        ];

        $activeMenu = 'notifikasi';

        // Ambil detail notifikasi berdasarkan ID
        $notifikasi = []; // Ganti dengan logika untuk mengambil detail notifikasi

        return view('notifikasi.show', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'notifikasi' => $notifikasi,
        ]);
    }
}
