<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Profile',
            'list' => ['Home', 'Profile']
        ];

        $activeMenu = 'profile';

        return view('profile.index', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
        ]);
    }
    public function edit()
    {
        $breadcrumb = (object) [
            'title' => 'Edit Profile',
            'list' => ['Home', 'Profile', 'Edit']
        ];

        $activeMenu = 'profile.edit';

        return view('profile.edit', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
        ]);
    }
}
