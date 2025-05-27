<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\UserModel;

class ProfileController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Profile',
            'list' => ['Home', 'Profile']
        ];

        $activeMenu = 'profile';
        $user = UserModel::find(Auth::id());

        return view('profile.index', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'user' => $user
        ]);
    }

    public function edit()
    {
        $breadcrumb = (object) [
            'title' => 'Edit Profile',
            'list' => ['Home', 'Profile', 'Edit']
        ];

        $activeMenu = 'profile.edit';
        $user = Auth::user();

        return view('profile.edit', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'user' => $user
        ]);
    }

    public function show()
    {
        $user = Auth::user();
        return response()->json($user);
    }

    public function update(Request $request)
    {
        $user = UserModel::find(Auth::id());

        $request->validate([
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:100|unique:m_user,username,'.$user->user_id.',user_id',
            'email' => 'required|email|max:100|unique:m_user,email,'.$user->user_id.',user_id',
        ]);

        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();

        return response()->json(['success' => 'Profile updated successfully.']);
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $user = UserModel::find(Auth::id());

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && Storage::exists('public/profile/'.$user->profile_photo)) {
                Storage::delete('public/profile/'.$user->profile_photo);
            }

            // Store new photo
            $filename = time().'.'.$request->profile_photo->extension();
            $request->profile_photo->storeAs('public/profile', $filename);

            // Update user record
            $user->profile_photo = $filename;
            $user->save();

            return response()->json([
                'success' => 'Profile photo updated successfully.',
                'photo_url' => asset('storage/profile/'.$filename)
            ]);
        }
        return response()->json(['error' => 'No photo uploaded.'], 400);
    }
}