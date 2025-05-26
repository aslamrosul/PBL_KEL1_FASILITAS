<?php

use App\Http\Controllers\Admin\BobotPrioritasController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\Admin\PeriodeController;
use App\Http\Controllers\Admin\LantaiController;
use App\Http\Controllers\Admin\GedungController;
use App\Http\Controllers\Pelapor\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::pattern('id', '[0-9]+'); //jika ada parameter id, maka harus berupa angka
// register
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'postRegister']);
// login
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
//logout
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');



Route::middleware(['auth'])->group(function () { //artinya semua route di dalam goup ini harus login dulu
    // masukkan semua route yang perlu autentikasi di sini
    
    
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/', function () {
        return redirect()->to(url('/beranda'));
    });

     Route::get('/beranda', function () {
        $user = Auth::user();
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'dosen':
                return redirect()->route('pelapor.dashboard');
            case 'mahasiswa':
                return redirect()->route('sarpras.dashboard');
            case 'perusahaan':
                return redirect()->route('teknisi.dashboard');
            default:
                return redirect()->route('login');
        }
    })->name('beranda');

 


    Route::middleware(['authorize:ADM'])->group(function () {
        Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('admin.dashboard'); // Halaman Dashboard Admin
        //route user
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index']); // menampilkan halaman awal user
            Route::post('/list', [UserController::class, 'list']); // menampilkan data user dalam bentuk json untuk datables
            Route::get('/create_ajax', [UserController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [UserController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); //Menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
            Route::get('/import', [UserController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [UserController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [UserController::class, 'export_excel']); //export excel
            Route::get('/export_pdf', [UserController::class, 'export_pdf']);
        });

        //route level
        Route::group(['prefix' => 'bobot'], function () {
            Route::get('/', [BobotPrioritasController::class, 'index']); // menampilkan halaman awal user
            Route::post('/list', [BobotPrioritasController::class, 'list']); // menampilkan data user dalam bentuk json untuk datables
            Route::get('/create_ajax', [BobotPrioritasController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [BobotPrioritasController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::get('/{id}/show_ajax', [BobotPrioritasController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [BobotPrioritasController::class, 'edit_ajax']); //Menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [BobotPrioritasController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [BobotPrioritasController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
            Route::get('/import', [BobotPrioritasController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [BobotPrioritasController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [BobotPrioritasController::class, 'export_excel']); //export excel
            Route::get('/export_pdf', [BobotPrioritasController::class, 'export_pdf']);
        });

        //route gedung
        Route::group(['prefix' => 'gedung'], function () {
            Route::get('/', [GedungController::class, 'index']); // menampilkan halaman awal user
            Route::post('/list', [GedungController::class, 'list']); // menampilkan data user dalam bentuk json untuk datables
            Route::get('/create_ajax', [GedungController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [GedungController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::get('/{id}/show_ajax', [GedungController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [GedungController::class, 'edit_ajax']); //Menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [GedungController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [GedungController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
            Route::get('/import', [GedungController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [GedungController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [GedungController::class, 'export_excel']); //export excel
            Route::get('/export_pdf', [GedungController::class, 'export_pdf']);
        });


        //route lantai
        Route::group(['prefix' => 'lantai'], function () {
            Route::get('/', [LantaiController::class, 'index']); // menampilkan halaman awal user
            Route::post('/list', [LantaiController::class, 'list']); // menampilkan data user dalam bentuk json untuk datables
            Route::get('/create_ajax', [LantaiController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [LantaiController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::get('/{id}/show_ajax', [LantaiController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [LantaiController::class, 'edit_ajax']); //Menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [LantaiController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [LantaiController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
            Route::get('/import', [LantaiController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [LantaiController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [LantaiController::class, 'export_excel']); //export excel
            Route::get('/export_pdf', [LantaiController::class, 'export_pdf']);
        });

        //route ruang
        Route::group(['prefix' => 'ruang'], function () {
            Route::get('/', [GedungController::class, 'index']); // menampilkan halaman awal user
            Route::post('/list', [GedungController::class, 'list']); // menampilkan data user dalam bentuk json untuk datables
            Route::get('/create_ajax', [GedungController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [GedungController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::get('/{id}/show_ajax', [GedungController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [GedungController::class, 'edit_ajax']); //Menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [GedungController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [GedungController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
            Route::get('/import', [GedungController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [GedungController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [GedungController::class, 'export_excel']); //export excel
            Route::get('/export_pdf', [GedungController::class, 'export_pdf']);
        });


        //route periode
        Route::group(['prefix' => 'periode'], function () {
            Route::get('/', [PeriodeController::class, 'index']); // menampilkan halaman awal user
            Route::post('/list', [PeriodeController::class, 'list']); // menampilkan data user dalam bentuk json untuk datables
            Route::get('/create_ajax', [PeriodeController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [PeriodeController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::get('/{id}/show_ajax', [PeriodeController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [PeriodeController::class, 'edit_ajax']); //Menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [PeriodeController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [PeriodeController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
            Route::get('/import', [PeriodeController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [PeriodeController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [PeriodeController::class, 'export_excel']); //export excel
            Route::get('/export_pdf', [PeriodeController::class, 'export_pdf']);
        });
    });

    // Pelapor Mahasiswa, Dosen, Tenga Kependidikan
    Route::middleware(['authorize:MHS,DSN,TNK'])->group(function () {

    });

    // Sarana Prasarana
    Route::middleware(['authorize:SPR'])->group(function () {});

    // Teknisi
    Route::middleware(['authorize:TKN'])->group(function () {});
});
