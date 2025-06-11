
    public function list(Request $request)
    {
        $laporans = LaporanModel::with(['periode', 'fasilitas'])
            ->where('user_id', Auth::id())
            ->select(['laporan_id', 'judul', 'periode_id', 'fasilitas_id', 'status']);

        return datatables()->of($laporans)
            ->addIndexColumn()
            ->addColumn('aksi', function ($laporan) {
                return '
                    <a href=' . url('/pelapor/laporan/'. $laporan->laporan_id . '/edit/') . ' class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Edit</a>
                    <a href="javascript:void(0)" onclick="deleteLaporan(' . $laporan->laporan_id . ')" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</a>
                ';
            })
            ->rawColumns(['aksi', 'status'])
            ->make(true);
    }
    public function create()
    {
        $gedungs = GedungModel::all();
       

      


        return view('pelapor.laporan.create', compact('gedungs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|min:3',
            'deskripsi' => 'required|string|min:10',
            'fasilitas_id' => 'required|exists:m_fasilitas,fasilitas_id',
            'foto_path' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        try {
            $periode = PeriodeModel::where('is_aktif', true)->first();

            $data = [
                'user_id' => Auth::id(),
                'periode_id' => $periode->periode_id,
                'fasilitas_id' => $request->fasilitas_id,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'status' => 'Menunggu',
                'tanggal_lapor' => now(),
            ];

            if ($request->hasFile('foto_path')) {
                $data['foto_path'] = $request->file('foto_path')->store('laporan_photos', 'public');
            }

            LaporanModel::create($data);

            return redirect()->route('pelapor.laporan.index')->with('success', 'Laporan berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan laporan: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $laporan = LaporanModel::with(['fasilitas.ruang.lantai.gedung'])->findOrFail($id);
        $gedungs = GedungModel::all();
        $lantais = LantaiModel::where('gedung_id', $laporan->fasilitas->ruang->lantai->gedung_id)->get();
        $ruangs = RuangModel::where('lantai_id', $laporan->fasilitas->ruang->lantai_id)->get();
        $barangs = BarangModel::whereHas('fasilitas', function ($query) use ($laporan) {
            $query->where('ruang_id', $laporan->fasilitas->ruang_id);
        })->get();
        $fasilitas = FasilitasModel::where('ruang_id', $laporan->fasilitas->ruang_id)
            ->where('barang_id', $laporan->fasilitas->barang_id)
            ->get();

        $current_gedung_id = $laporan->fasilitas->ruang->lantai->gedung_id;
        $current_lantai_id = $laporan->fasilitas->ruang->lantai_id;
        $current_ruang_id = $laporan->fasilitas->ruang_id;
        $current_barang_id = $laporan->fasilitas->barang_id;

        

        $page = (object) [
            'title' => 'Daftar laporan yang dibuat oleh pelapor'
        ];
        return view('pelapor.laporan.edit', compact(
            'laporan',
            'gedungs',
            'lantais',
            'ruangs',
            'barangs',
            'fasilitas',
            'current_gedung_id',
            'current_lantai_id',
            'current_ruang_id',
            'current_barang_id',
            'page',

        ));
    }

    public function update(Request $request, $id)
    {
        $laporan = LaporanModel::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|min:3',
            'deskripsi' => 'required|string|min:10',
            'fasilitas_id' => 'required|exists:m_fasilitas,fasilitas_id',
            'foto_path' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        try {

            $data = [
                'fasilitas_id' => $request->fasilitas_id,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
            ];

            if ($request->hasFile('foto_path')) {
                if ($laporan->foto_path) {
                    Storage::disk('public')->delete($laporan->foto_path);
                }
                $data['foto_path'] = $request->file('foto_path')->store('laporan_photos', 'public');
            }

            $laporan->update($data);

            return redirect()->route('pelapor.laporan.index')->with('success', 'Laporan berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui laporan: ' . $e->getMessage());
        }
    }



    ///-


    public function create()
    {
        $gedungs = GedungModel::all();
       

      


        return view('pelapor.laporan.create', compact('gedungs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|min:3',
            'deskripsi' => 'required|string|min:10',
            'fasilitas_id' => 'required|exists:m_fasilitas,fasilitas_id',
            'foto_path' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        try {
            $periode = PeriodeModel::where('is_aktif', true)->first();

            $data = [
                'user_id' => Auth::id(),
                'periode_id' => $periode->periode_id,
                'fasilitas_id' => $request->fasilitas_id,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'status' => 'Menunggu',
                'tanggal_lapor' => now(),
            ];

            if ($request->hasFile('foto_path')) {
                $data['foto_path'] = $request->file('foto_path')->store('laporan_photos', 'public');
            }

            LaporanModel::create($data);

            return redirect()->route('pelapor.laporan.index')->with('success', 'Laporan berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan laporan: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $laporan = LaporanModel::with(['fasilitas.ruang.lantai.gedung'])->findOrFail($id);
        $gedungs = GedungModel::all();
        $lantais = LantaiModel::where('gedung_id', $laporan->fasilitas->ruang->lantai->gedung_id)->get();
        $ruangs = RuangModel::where('lantai_id', $laporan->fasilitas->ruang->lantai_id)->get();
        $barangs = BarangModel::whereHas('fasilitas', function ($query) use ($laporan) {
            $query->where('ruang_id', $laporan->fasilitas->ruang_id);
        })->get();
        $fasilitas = FasilitasModel::where('ruang_id', $laporan->fasilitas->ruang_id)
            ->where('barang_id', $laporan->fasilitas->barang_id)
            ->get();

        $current_gedung_id = $laporan->fasilitas->ruang->lantai->gedung_id;
        $current_lantai_id = $laporan->fasilitas->ruang->lantai_id;
        $current_ruang_id = $laporan->fasilitas->ruang_id;
        $current_barang_id = $laporan->fasilitas->barang_id;

        

        $page = (object) [
            'title' => 'Daftar laporan yang dibuat oleh pelapor'
        ];
        return view('pelapor.laporan.edit', compact(
            'laporan',
            'gedungs',
            'lantais',
            'ruangs',
            'barangs',
            'fasilitas',
            'current_gedung_id',
            'current_lantai_id',
            'current_ruang_id',
            'current_barang_id',
            'page',

        ));
    }

    public function update(Request $request, $id)
    {
        $laporan = LaporanModel::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|min:3',
            'deskripsi' => 'required|string|min:10',
            'fasilitas_id' => 'required|exists:m_fasilitas,fasilitas_id',
            'foto_path' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        try {

            $data = [
                'fasilitas_id' => $request->fasilitas_id,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
            ];

            if ($request->hasFile('foto_path')) {
                if ($laporan->foto_path) {
                    Storage::disk('public')->delete($laporan->foto_path);
                }
                $data['foto_path'] = $request->file('foto_path')->store('laporan_photos', 'public');
            }

            $laporan->update($data);

            return redirect()->route('pelapor.laporan.index')->with('success', 'Laporan berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui laporan: ' . $e->getMessage());
        }
    }

    public function getLantai($gedung_id)
    {
        $lantais = LantaiModel::where('gedung_id', $gedung_id)->get(['lantai_id', 'lantai_nomor']);
        return response()->json($lantais);
    }

    public function getRuang($lantai_id)
    {
        $ruangs = RuangModel::where('lantai_id', $lantai_id)->get(['ruang_id', 'ruang_nama']);
        return response()->json($ruangs);
    }

    public function getBarang($ruang_id)
    {
        $barangs = BarangModel::whereHas('fasilitas', function ($query) use ($ruang_id) {
            $query->where('ruang_id', $ruang_id);
        })->get(['barang_id', 'barang_nama']);
        return response()->json($barangs);
    }

    public function getFasilitas($barang_id)
    {
        $fasilitas = FasilitasModel::where('barang_id', $barang_id)->get(['fasilitas_id', 'fasilitas_nama']);
        return response()->json($fasilitas);
    }