<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        // Jika sudah login, redirect ke halaman home
        if (Auth::check()) {
            return redirect('/');
        }

        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $login = $request->input('login');
            $password = $request->input('password');

            $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

            $credentials = [
                $field => $login,
                'password' => $password
            ];

            if (Auth::attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }

        return redirect('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }


    public function register()
    {
        $levels = LevelModel::select('level_id', 'level_nama')->get();
        return view('auth.register', compact('levels'));
    }

    public function postRegister(Request $request)
    {
        $rules = [
            'level_id' => 'required|exists:m_level,level_id',
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'email' => 'nullable|email|unique:m_user,email',
            'password' => 'required|min:6|confirmed',
            'profile_photo' => 'nullable|string|max:255' // bisa diubah ke file upload jika diperlukan
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        // Simpan user baru
        $user = UserModel::create([
            'level_id' => $request->level_id,
            'username' => $request->username,
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password, // otomatis di-hash karena ada casts
            'profile_photo' => $request->profile_photo // boleh kosong
        ]);

        // Login otomatis setelah registrasi
        Auth::login($user);

        return response()->json([
            'status' => true,
            'message' => 'Registrasi Berhasil',
            'redirect' => url('/')
        ]);
    }
}
