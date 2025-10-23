<?php

namespace App\Http\Controllers;

use App\Models\TagihanSiswa;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data user dari session
        $user = (object) session('auth');
        $saldo = $user->saldo ?? 0;

        // Ambil data tagihan siswa yang aktif
        $tagihanBelumLunas = TagihanSiswa::aktif()
            ->belumLunas()
            ->orderBy('created_at', 'desc')
            ->get();

        // Query untuk tagihan lunas dengan filter
        $tagihanLunasQuery = TagihanSiswa::aktif()
            ->lunas()
            ->orderBy('tgl_bayar', 'desc');

        // Filter berdasarkan bulan jika ada
        if ($request->filled('bulan')) {
            $tagihanLunasQuery->where('bulan', $request->bulan);
        }

        // Filter berdasarkan tahun jika ada
        if ($request->filled('tahun')) {
            $tagihanLunasQuery->where('tahun_ajaran', $request->tahun);
        }

        $tagihanLunas = $tagihanLunasQuery->get();

        // Ambil data untuk dropdown filter
        $bulanList = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        $tahunList = TagihanSiswa::aktif()
            ->lunas()
            ->distinct()
            ->pluck('tahun_ajaran')
            ->sort()
            ->values();

        return view('tagihan.index', compact('tagihanBelumLunas', 'tagihanLunas', 'bulanList', 'tahunList', 'saldo'));
    }

    public function show($id)
    {
        $tagihan = TagihanSiswa::findOrFail($id);
        return view('tagihan.show', compact('tagihan'));
    }

    public function bayar(Request $request, $id)
    {
        try {
            $tagihan = TagihanSiswa::findOrFail($id);

            // Validasi pembayaran
            $request->validate([
                'jumlah_bayar' => 'required|numeric|min:1|max:' . $tagihan->sisa,
            ]);

            $jumlahBayar = $request->jumlah_bayar;
            $sisaBaru = $tagihan->sisa - $jumlahBayar;
            $bayarBaru = $tagihan->bayar + $jumlahBayar;
            $isLunas = $sisaBaru <= 0;

            // Update status pembayaran
            $tagihan->update([
                'bayar' => $bayarBaru,
                'sisa' => $sisaBaru,
                'status_pembayaran' => $isLunas ? '1' : '0',
                'tgl_bayar' => $isLunas ? now() : null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil diproses',
                'data' => [
                    'tagihan_id' => $tagihan->id,
                    'jumlah_bayar' => $jumlahBayar,
                    'sisa' => $sisaBaru,
                    'is_lunas' => $isLunas
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function struk($id)
    {
        $tagihan = TagihanSiswa::findOrFail($id);

        if (!$tagihan->isLunas()) {
            return redirect()->route('tagihan.index')->with('error', 'Tagihan belum lunas');
        }

        return view('tagihan.struk', compact('tagihan'));
    }
}
