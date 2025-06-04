<?php

namespace App\Http\Controllers\Pelapor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeedbackModel;
use App\Models\LaporanModel;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Show the form for creating feedback for a report.
     */
    public function create($laporan_id)
    {
        $laporan = LaporanModel::where('laporan_id', $laporan_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Check if feedback already exists
        if ($laporan->feedback) {
            return redirect()->route('pelapor.laporan.show', $laporan_id)
                ->with('error', 'Anda sudah memberikan umpan balik untuk laporan ini.');
        }

        $breadcrumb = (object)[
            'title' => 'Beri Umpan Balik',
            'list' => ['Dashboard', 'Laporan Saya', 'Beri Umpan Balik']
        ];

        return view('pelapor.feedback.create', compact('laporan', 'breadcrumb'));
    }

    /**
     * Store a newly created feedback in storage.
     */
    public function store(Request $request, $laporan_id)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'komentar' => 'nullable|string|max:500',
        ]);

        $laporan = LaporanModel::where('laporan_id', $laporan_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Check if feedback already exists
        if ($laporan->feedback) {
            return redirect()->route('pelapor.laporan.show', $laporan_id)
                ->with('error', 'Anda sudah memberikan umpan balik untuk laporan ini.');
        }

        FeedbackModel::create([
            'laporan_id' => $laporan_id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('pelapor.feedback.show', $laporan_id)
            ->with('success', 'Umpan balik berhasil dikirim!');
    }

    /**
     * Show the feedback for a report.
     */
    public function show($laporan_id)
    {
        $laporan = LaporanModel::where('laporan_id', $laporan_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!$laporan->feedback) {
            return redirect()->route('pelapor.laporan.show', $laporan_id)
                ->with('error', 'Belum ada umpan balik untuk laporan ini.');
        }

        $breadcrumb = (object)[
            'title' => 'Detail Umpan Balik',
            'list' => ['Dashboard', 'Laporan Saya', 'Detail Umpan Balik']
        ];

        return view('pelapor.feedback.show', compact('laporan', 'breadcrumb'));
    }

    /**
     * Show the form for editing the specified feedback.
     */
    public function edit($laporan_id)
    {
        $laporan = LaporanModel::where('laporan_id', $laporan_id)
            ->where('user_id', Auth::id())
            ->with('feedback')
            ->firstOrFail();

        if (!$laporan->feedback) {
            return redirect()->route('pelapor.laporan.show', $laporan_id)
                ->with('error', 'Belum ada umpan balik untuk laporan ini.');
        }

        $breadcrumb = (object)[
            'title' => 'Edit Umpan Balik',
            'list' => ['Dashboard', 'Laporan Saya', 'Edit Umpan Balik']
        ];

        return view('pelapor.feedback.edit', compact('laporan', 'breadcrumb'));
    }

    /**
     * Update the specified feedback in storage.
     */
    public function update(Request $request, $laporan_id)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'komentar' => 'nullable|string|max:500',
        ]);

        $laporan = LaporanModel::where('laporan_id', $laporan_id)
            ->where('user_id', Auth::id())
            ->with('feedback')
            ->firstOrFail();

        if (!$laporan->feedback) {
            return redirect()->route('pelapor.laporan.show', $laporan_id)
                ->with('error', 'Belum ada umpan balik untuk laporan ini.');
        }

        $laporan->feedback->update([
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('pelapor.feedback.show', $laporan_id)
            ->with('success', 'Umpan balik berhasil diperbarui!');
    }

    /**
     * Show the confirmation form for deleting feedback.
     */
    public function confirm($laporan_id)
    {
        $laporan = LaporanModel::where('laporan_id', $laporan_id)
            ->where('user_id', Auth::id())
            ->with('feedback')
            ->firstOrFail();

        if (!$laporan->feedback) {
            return redirect()->route('pelapor.laporan.show', $laporan_id)
                ->with('error', 'Belum ada umpan balik untuk laporan ini.');
        }

        $breadcrumb = (object)[
            'title' => 'Konfirmasi Hapus Umpan Balik',
            'list' => ['Dashboard', 'Laporan Saya', 'Konfirmasi Hapus']
        ];

        return view('pelapor.feedback.confirm', compact('laporan', 'breadcrumb'));
    }


    /**
     * Remove the specified feedback from storage.
     */
    public function delete($laporan_id)
    {
        $laporan = LaporanModel::where('laporan_id', $laporan_id)
            ->where('user_id', Auth::id())
            ->with('feedback')
            ->firstOrFail();

        if (!$laporan->feedback) {
            return redirect()->route('pelapor.laporan.show', $laporan_id)
                ->with('error', 'Belum ada umpan balik untuk laporan ini.');
        }

        $laporan->feedback->delete();

        return redirect()->route('pelapor.riwayat.index', $laporan_id)
            ->with('success', 'Umpan balik berhasil dihapus!');
    }
}
