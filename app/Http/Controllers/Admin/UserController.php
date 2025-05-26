<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LevelModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user';

        $level = LevelModel::all(); // ambil data level untuk ditampilkan di form


        return view('admin.user.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'email', 'level_id')
            ->with('level');

        // Filter data user berdasarkan level_id
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                $showUrl = url('/user/' . $user->user_id . '/show_ajax');
                $editUrl = url('/user/' . $user->user_id . '/edit_ajax');
                $deleteUrl = url('/user/' . $user->user_id . '/delete_ajax');

                return '
                    <button onclick="modalAction(\'' . $showUrl . '\')" class="btn btn-info btn-sm">
                        <i class="fa fa-eye"></i> Detail
                    </button>
                    <button onclick="modalAction(\'' . $editUrl . '\')" class="btn btn-warning btn-sm">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    <button onclick="modalAction(\'' . $deleteUrl . '\')" class="btn btn-danger btn-sm">
                        <i class="fa fa-trash"></i> Hapus
                    </button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $level = LevelModel::all();
        return view('admin.user.create_ajax', compact('level'));
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'username' => 'required|string|min:3|unique:m_user,username',
            'email' => 'required|email|unique:m_user,email',
            'password' => 'required|min:6',
            'level_id' => 'required|integer',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            $data = $request->except('profile_photo');
            $data['password'] = Hash::make($request->password);

            // Handle file upload
            if ($request->hasFile('profile_photo')) {
                $imageName = time() . '.' . $request->profile_photo->extension();
                $request->profile_photo->move(public_path('images/profile'), $imageName);
                $data['profile_photo'] = 'images/profile/' . $imageName;
            }

            $user = UserModel::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil ditambahkan',
                'id' => $user->user_id,
                'username' => $user->username
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambah data: ' . $e->getMessage()
            ]);
        }
    }

    public function edit_ajax($user_id)
    {
        $user = UserModel::find($user_id);
        $level = LevelModel::all();
        return view('admin.user.edit_ajax', compact('user', 'level'));
    }

    public function update_ajax(Request $request, $user_id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'username' => 'required|string|min:3|unique:m_user,username,' . $user_id . ',user_id',
            'email' => 'required|email|unique:m_user,email,' . $user_id . ',user_id',
            'password' => 'nullable|min:6',
            'level_id' => 'required|integer',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $user = UserModel::find($user_id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        $data = $request->except(['password', 'profile_photo']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

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
            'message' => 'Data berhasil diupdate',
            'id' => $user->user_id,
            'username' => $user->username
        ]);
    }

    public function confirm_ajax($user_id)
    {
        $user = UserModel::find($user_id);
        return view('admin.user.confirm_ajax', compact('user'));
    }

    public function delete_ajax($user_id)
    {
        $user = UserModel::find($user_id);
        if ($user) {
            // Delete profile photo if exists
            if ($user->profile_photo && file_exists(public_path($user->profile_photo))) {
                unlink(public_path($user->profile_photo));
            }

            $user->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Data User tidak ditemukan.'
        ]);
    }

    public function show_ajax($user_id)
    {
        $user = UserModel::with('level')->find($user_id);
        return view('admin.user.show_ajax', compact('user'));
    }

    public function import()
    {
        return view('admin.user.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_user' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_user');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);
            $insert = [];
            $errors = [];

            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $username    = trim($value['A']);
                        $nama        = trim($value['B']);
                        $email       = trim($value['C']);
                        $password    = trim($value['D']);
                        $level_nama  = trim($value['E']);

                        $level = LevelModel::where('level_nama', $level_nama)->first();

                        if ($level) {
                            $insert[] = [
                                'username'    => $username,
                                'nama'        => $nama,
                                'email'       => $email,
                                'password'    => bcrypt($password),
                                'level_id'    => $level->level_id,
                                'created_at'  => now(),
                            ];
                        } else {
                            $errors[] = "Baris {$baris}: Level '{$level_nama}' tidak terdaftar di database.";
                        }
                    }
                }

                if (count($insert) > 0) {
                    UserModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status'  => count($errors) === 0,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Tidak ada data yang bisa diimport'
                ]);
            }
        }

        return redirect('/');
    }

    public function export_excel()
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'email', 'level_id')
            ->with('level')
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Username');
        $sheet->setCellValue('C1', 'Nama');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Level');

        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $user->username);
            $sheet->setCellValue('C' . $baris, $user->nama);
            $sheet->setCellValue('D' . $baris, $user->email);
            $sheet->setCellValue('E' . $baris, $user->level->level_nama ?? '');
            $no++;
            $baris++;
        }

        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data User');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_User_' . date('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $users = UserModel::with('level')->get();

        $data = [
            'users' => $users,
            'title' => 'Laporan Data Pengguna'
        ];

        $pdf = Pdf::loadView('admin.user.export_pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data User ' . date('Y-m-d H-i-s') . '.pdf');
    }
}
