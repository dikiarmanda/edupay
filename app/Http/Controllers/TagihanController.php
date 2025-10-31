<?php

namespace App\Http\Controllers;

use App\Models\TagihanSiswa;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;

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
            ->where('nisn', $user->nisn)
            ->orderBy('created_at', 'desc')
            ->get();

        // Query untuk tagihan lunas dengan filter
        $tagihanLunasQuery = TagihanSiswa::aktif()
            ->lunas()
            ->where('nisn', $user->nisn)
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

        return view('tagihan.index', compact('tagihanBelumLunas', 'tagihanLunas', 'saldo'));
    }

    public function bayar(Request $request, $id)
    {
        try {
            $tagihan = TagihanSiswa::findOrFail($id);

            // Validasi pembayaran
            $request->validate([
                'jumlah_bayar' => 'required|numeric|min:1|max:' . $tagihan->total,
                'pin' => 'required|string|size:6',
            ]);

            // Validasi PIN
            $user = (object) session('auth');
            $hashedPin = $user->pin ?? null;
            $inputPin = $request->pin;

            if (!$hashedPin || !password_verify($inputPin, $hashedPin)) {
                return response()->json([
                    'success' => false,
                    'message' => 'PIN tidak valid',
                    'test' => $user
                ], 401);
            }

            $jumlahBayar = $request->jumlah_bayar;

            // Update status pembayaran
            $tagihan->update([
                'bayar' => $jumlahBayar,
                'status_pembayaran' => '1',
                'tgl_bayar' => now(),
            ]);

            // Tambahkan transaksi ke mutation_history
            $tagihan->mutationHistory()->create([
                'code_callback' => $tagihan->id,
                'nisn' => $tagihan->nisn,
                'customer_name' => $tagihan->nama,
                'information' => $tagihan->tagihan,
                'debet' => $jumlahBayar,
                'kredit' => 0,
                'date_trx' => now(),
                'merchant_name' => $tagihan->merchant_kode ?? 'EDUPAY',
            ]);

            // Tambahkan notifikasi untuk pembayaran tagihan
            $tagihan->notifications()->create([
                'merchant_kode' => $tagihan->merchant_kode ?? 'EDUPAY',
                'judul' => 'Pembayaran Tagihan Berhasil',
                'pesan' => "Pembayaran tagihan {$tagihan->tagihan} sebesar Rp " . number_format($jumlahBayar, 0, ',', '.') . " berhasil diproses.",
                'tipe' => 'success',
                'is_read' => false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil diproses',
                'data' => [
                    'tagihan_id' => $tagihan->id,
                    'jumlah_bayar' => $jumlahBayar,
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::info('Validasi gagal: ' . $e->getMessage(), $e->errors());
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

    public function downloadPdf($id)
    {
        $tagihan = TagihanSiswa::with('merchant:kode_merchant,nama_merchant,logo')
            ->findOrFail($id);

        if (!$tagihan->isLunas()) {
            return redirect()->route('tagihan.index')->with('error', 'Tagihan belum lunas');
        }

        $html = view('tagihan.struk-pdf', compact('tagihan'))->render();
        $fileName = 'pembayaran-' . $tagihan->tagihan . '-' . bulanList()[$tagihan->bulan] . '.pdf';
        $pdf = Browsershot::html($html)
            ->format('A4')
            ->margins(10, 10, 10, 10) // Kasih margin sedikit
            ->showBackground() // PENTING: Render background colors
            ->waitUntilNetworkIdle()
            ->setDelay(1000) // Tunggu 1 detik
            ->pdf();

        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }
}
