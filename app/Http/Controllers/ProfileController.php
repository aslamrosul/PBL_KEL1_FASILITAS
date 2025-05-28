<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Profile',
            'list' => ['Home', 'Profile']
        ];

        $page = (object) [
            'title' => 'Profile Pengguna'
        ];

        $activeMenu = 'profile';

$user = UserModel::find(Auth::id());

        return view('profile.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

    public function show_ajax()
    {
$user = UserModel::find(Auth::id());
        return view('profile.show_ajax', compact('user'));
    }

    public function edit_ajax()
    {
$user = UserModel::find(Auth::id());
        return view('profile.edit_ajax', compact('user'));
    }

    public function update_ajax(Request $request)
    {
$user = UserModel::find(Auth::id());

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'username' => 'required|string|min:3|unique:m_user,username,' . $user->user_id . ',user_id',
            'email' => 'required|email|unique:m_user,email,' . $user->user_id . ',user_id',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $data = $request->except('profile_photo');

        // Handle file upload
        if ($request->hasFile('profile_photo')) {
            // Delete old image if exists
            if ($user->profile_photo && file_exists(public_path($user->profile_photo))) {
                unlink(public_path($user->profile_photo));
            }

            $imageName = time() . '.' . $request->profile_photo->extension();
            $request->profile_photo->move(public_path('images/profile'), $imageName);
            $data['profile_photo'] = 'images/profile/' . $imageName;
        }

        $user->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Profile berhasil diupdate'
        ]);
    }

    public function edit_password_ajax()
    {
        return view('profile.edit_password_ajax');
    }

    public function update_password_ajax(Request $request)
    {
$user = UserModel::find(Auth::id());

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6|different:current_password',
            'confirm_password' => 'required|same:new_password'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Password saat ini tidak valid'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Password berhasil diubah'
        ]);
    }
}