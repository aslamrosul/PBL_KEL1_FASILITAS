<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotifikasiController;


//Admin Controllers
use App\Http\Controllers\DashboardAdminController;
// 
use App\Http\Controllers\Admin\StatistikTrenController;
use App\Http\Controllers\Admin\LaporanKerusakanController;
//  manajemen data
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PeriodeController;
use App\Http\Controllers\Admin\GedungController;
use App\Http\Controllers\Admin\LantaiController;
use App\Http\Controllers\Admin\RuangController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\BobotPrioritasController;
use App\Http\Controllers\Admin\KriteriaController;



//Pelapor Controllers
use App\Http\Controllers\DashboardPelaporController;
use App\Http\Controllers\Pelapor\FeedbackController;
use App\Http\Controllers\Pelapor\PelaporanKerusakanController;

//Sarpras Controllers
use App\Http\Controllers\DashboardSarprasController;

//Teknisi Controller
use App\Http\Controllers\DashboardTeknisiController;
use App\Http\Controllers\Teknisi\PerbaikanController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

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

    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
    Route::get('/notifikasi/read/{id}', [NotifikasiController::class, 'read'])->name('notifikasi.read');
    Route::get('/notifikasi/read-all', [NotifikasiController::class, 'readAll'])->name('notifikasi.readAll');
    Route::get('/notifikasi/unread', [NotifikasiController::class, 'unread'])->name('notifikasi.unread');
    Route::get('/notifikasi/clear', [NotifikasiController::class, 'clear'])->name('notifikasi.clear');
    Route::get('/notifikasi/clear-all', [NotifikasiController::class, 'clearAll'])->name('notifikasi.clearAll');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/', function () {
        return redirect()->to(url('/beranda'));
    });

    Route::get('/beranda', function () {
        $user = Auth::user();
          switch ($user->level->level_kode) {
            case 'ADM':
                return redirect()->route('admin.dashboard');
            case 'MHS,DSN, TNK':
                return redirect()->route('pelapor.dashboard');
            case 'SPR':
                return redirect()->route('sarpras.dashboard');
            case 'TKN':
                return redirect()->route('teknisi.dashboard');
            default:
                return redirect()->route('login');
        }
    })->name('beranda');




    Route::middleware(['authorize:ADM'])->group(function () {
        Route::prefix('admin')->middleware(['auth'])->group(function () {
            Route::get('/', [DashboardAdminController::class, 'index'])->name('admin.dashboard');
        });        //route user
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.user.index');; // menampilkan halaman awal user
            Route::post('/list', [UserController::class, 'list']); // menampilkan data user dalam bentuk json untuk datables
            Route::get('/create_ajax', [UserController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [UserController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); //Menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);

            Route::get('/import', [UserController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [UserController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [UserController::class, 'export_excel']); //export excel
            Route::get('/export_pdf', [UserController::class, 'export_pdf']);
        });

        //route level
        Route::group(['prefix' => 'bobot'], function () {
            Route::get('/', [BobotPrioritasController::class, 'index'])->name('admin.bobot.index'); // menampilkan halaman awal user
            Route::post('/list', [BobotPrioritasController::class, 'list']); // menampilkan data user dalam bentuk json untuk datables
            Route::get('/create_ajax', [BobotPrioritasController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [BobotPrioritasController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::get('/{id}/show_ajax', [BobotPrioritasController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [BobotPrioritasController::class, 'edit_ajax']); //Menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [BobotPrioritasController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [BobotPrioritasController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [BobotPrioritasController::class, 'delete_ajax']);

            Route::get('/import', [BobotPrioritasController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [BobotPrioritasController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [BobotPrioritasController::class, 'export_excel']); //export excel
            Route::get('/export_pdf', [BobotPrioritasController::class, 'export_pdf']);
        });

        //route gedung
        Route::group(['prefix' => 'gedung'], function (): void {
            Route::get('/', [GedungController::class, 'index'])->name('admin.gedung.index'); // menampilkan halaman awal user
            Route::post('/list', [GedungController::class, 'list']); // menampilkan data user dalam bentuk json untuk datables
            Route::get('/create_ajax', [GedungController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [GedungController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::get('/{id}/show_ajax', [GedungController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [GedungController::class, 'edit_ajax']); //Menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [GedungController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [GedungController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [GedungController::class, 'delete_ajax']);

            Route::get('/import', [GedungController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [GedungController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [GedungController::class, 'export_excel']); //export excel
            Route::get('/export_pdf', [GedungController::class, 'export_pdf']);
        });


        //route lantai
        Route::group(['prefix' => 'lantai'], function () {
            Route::get('/', [LantaiController::class, 'index'])->name('admin.lantai.index'); // menampilkan halaman awal user
            Route::post('/list', [LantaiController::class, 'list']); // menampilkan data user dalam bentuk json untuk datables
            Route::get('/create_ajax', [LantaiController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [LantaiController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::get('/{id}/show_ajax', [LantaiController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [LantaiController::class, 'edit_ajax']); //Menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [LantaiController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [LantaiController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [LantaiController::class, 'delete_ajax']);

            Route::get('/import', [LantaiController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [LantaiController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [LantaiController::class, 'export_excel']); //export excel
            Route::get('/export_pdf', [LantaiController::class, 'export_pdf']);
        });

        //route ruang
        Route::group(['prefix' => 'ruang'], function () {
            Route::get('/', [RuangController::class, 'index'])->name('admin.ruang.index');; // menampilkan halaman awal user
            Route::post('/list', [RuangController::class, 'list']); // menampilkan data user dalam bentuk json untuk datables
            Route::get('/create_ajax', [RuangController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [RuangController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::get('/{id}/show_ajax', [RuangController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [RuangController::class, 'edit_ajax']); //Menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [RuangController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [RuangController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [RuangController::class, 'delete_ajax']);

            Route::get('/import', [RuangController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [RuangController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [RuangController::class, 'export_excel']); //export excel
            Route::get('/export_pdf', [RuangController::class, 'export_pdf']);
        });


        //route periode
        Route::group(['prefix' => 'periode'], function () {
            Route::get('/', [PeriodeController::class, 'index'])->name('admin.periode.index');; // menampilkan halaman awal user
            Route::post('/list', [PeriodeController::class, 'list']); // menampilkan data user dalam bentuk json untuk datables
            Route::get('/create_ajax', [PeriodeController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [PeriodeController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::get('/{id}/show_ajax', [PeriodeController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [PeriodeController::class, 'edit_ajax']); //Menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [PeriodeController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [PeriodeController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [PeriodeController::class, 'delete_ajax']);

            Route::get('/import', [PeriodeController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [PeriodeController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [PeriodeController::class, 'export_excel']); //export excel
            Route::get('/export_pdf', [PeriodeController::class, 'export_pdf']);
        });

        //route kategori
        Route::group(['prefix' => 'kategori'], function () {
            Route::get('/', [KategoriController::class, 'index'])->name('admin.kategori.index');; // menampilkan halaman awal user
            Route::post('/list', [KategoriController::class, 'list']); // menampilkan data user dalam bentuk json untuk datables
            Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [KategoriController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); //Menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);

            Route::get('/import', [KategoriController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [KategoriController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [KategoriController::class, 'export_excel']); //export excel
            Route::get('/export_pdf', [KategoriController::class, 'export_pdf']);
        });

        //route periode
        Route::group(['prefix' => 'barang'], function () {
            Route::get('/', [BarangController::class, 'index'])->name('admin.barang.index');; // menampilkan halaman awal user
            Route::post('/list', [BarangController::class, 'list']); // menampilkan data user dalam bentuk json untuk datables
            Route::get('/create_ajax', [BarangController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [BarangController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); //Menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);

            Route::get('/import', [BarangController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [BarangController::class, 'export_excel']); //export excel
            Route::get('/export_pdf', [BarangController::class, 'export_pdf']);
        });

        //route fasilitas
        Route::group(['prefix' => 'fasilitas'], function () {
            Route::get('/', [FasilitasController::class, 'index'])->name('admin.fasilitas.index');; // menampilkan halaman awal user
            Route::post('/list', [FasilitasController::class, 'list']); // menampilkan data user dalam bentuk json untuk datables
            Route::get('/create_ajax', [FasilitasController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [FasilitasController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::get('/{id}/show_ajax', [FasilitasController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [FasilitasController::class, 'edit_ajax']); //Menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [FasilitasController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [FasilitasController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [FasilitasController::class, 'delete_ajax']);

            Route::get('/import', [FasilitasController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [FasilitasController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [FasilitasController::class, 'export_excel']); //export excel
            Route::get('/export_pdf', [FasilitasController::class, 'export_pdf']);
        });

        //route kriteria
        Route::group(['prefix' => 'kriteria'], function () {
            Route::get('/', [KriteriaController::class, 'index'])->name('admin.kriteria.index');; // menampilkan halaman awal user
            Route::post('/list', [KriteriaController::class, 'list']); // menampilkan data user dalam bentuk json untuk datables
            Route::get('/create_ajax', [KriteriaController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [KriteriaController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::get('/{id}/show_ajax', [KriteriaController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit_ajax', [KriteriaController::class, 'edit_ajax']); //Menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [KriteriaController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [KriteriaController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [KriteriaController::class, 'delete_ajax']);
            Route::get('/import', [KriteriaController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [KriteriaController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [KriteriaController::class, 'export_excel']); //export excel
            Route::get('/export_pdf', [KriteriaController::class, 'export_pdf']);
        });



        Route::group(['prefix' => 'laporan'], function () {
            Route::get('/', [PeriodeController::class, 'index'])->name('admin.laporan.index');; // menampilkan halaman awal user

        });

        Route::group(['prefix' => 'statistik'], function () {
            Route::get('/', [PeriodeController::class, 'index'])->name('admin.statistik.index');; // menampilkan halaman awal user

        });
    });

    // Pelapor Mahasiswa, Dosen, Tenga Kependidikan
    Route::middleware(['authorize:MHS,DSN,TNK'])->group(function () {
        Route::prefix('pelapor')->middleware(['auth'])->group(function () {
            Route::get('/', [DashboardPelaporController::class, 'index'])->name('pelapor.dashboard');
        });
    });

    // Sarana Prasarana
    Route::middleware(['authorize:SPR'])->group(function () {
        Route::prefix('sarpras')->middleware(['auth'])->group(function () {
            Route::get('/', [DashboardSarprasController::class, 'index'])->name('sarpras.dashboard');
        });
    });

    // Teknisi
    Route::middleware(['authorize:TKN'])->group(function () {
        Route::prefix('teknisi')->middleware(['auth'])->group(function () {
            Route::get('/', [DashboardTeknisiController::class, 'index'])->name('teknisi.dashboard');
        });
        Route::group(['prefix' => 'teknisi/perbaikan'], function () {
            Route::get('/', [PerbaikanController::class, 'index'])->name('teknisi.perbaikan.index');
            Route::get('/riwayat', [PerbaikanController::class, 'riwayat'])->name('teknisi.riwayat.index');
            Route::post('/list', [PerbaikanController::class, 'list']);
            Route::post('/list-riwayat', [PerbaikanController::class, 'listRiwayat']);
            Route::get('/{id}/show_ajax', [PerbaikanController::class, 'show_ajax']);
            Route::get('/{id}/edit_ajax', [PerbaikanController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [PerbaikanController::class, 'update_ajax']);

            // Tambahkan route untuk menampilkan foto
            Route::get('/images/perbaikan/{filename}', function ($filename) {
                $path = public_path('images/perbaikan/' . $filename);

                if (!File::exists($path)) {
                    abort(404);
                }

                $file = File::get($path);
                $type = File::mimeType($path);

                $response = Response::make($file, 200);
                $response->header("Content-Type", $type);

                return $response;
            })->where('filename', '.*')->name('perbaikan.foto');
        });
    });
});
