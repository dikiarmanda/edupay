<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengumumanController extends Controller
{
    /**
     * Menampilkan daftar pengumuman berdasarkan merchant_kode user yang login
     */
    public function index(Request $request)
    {
        // Ambil data user dari session
        $user = (object) session('auth');
        $merchantKode = $user->merchant_kode ?? null;

        if (!$merchantKode) {
            return redirect()->route('dashboard')->with('error', 'Merchant code tidak ditemukan');
        }

        // Query pengumuman berdasarkan merchant_kode yang sedang tampil
        $query = Pengumuman::byMerchant($merchantKode)->tampil();

        // Search berdasarkan judul atau isi
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('judul', 'like', "%{$searchTerm}%")
                    ->orWhere('isi', 'like', "%{$searchTerm}%");
            });
        }

        // Sorting berdasarkan tanggal dibuat (terbaru dulu)
        $pengumuman = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('pengumuman.index', compact('pengumuman'));
    }

    /**
     * Menampilkan detail pengumuman
     */
    public function show($id)
    {
        // Ambil data user dari session
        $user = (object) session('auth');
        $merchantKode = $user->merchant_kode ?? null;

        if (!$merchantKode) {
            return redirect()->route('dashboard')->with('error', 'Merchant code tidak ditemukan');
        }

        $pengumuman = Pengumuman::byMerchant($merchantKode)->tampil()->findOrFail($id);

        // Ambil pengumuman terkait (3 pengumuman terbaru lainnya yang sedang tampil)
        $relatedPengumuman = Pengumuman::byMerchant($merchantKode)
            ->tampil()
            ->where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('pengumuman.show', compact('pengumuman', 'relatedPengumuman'));
    }

}
