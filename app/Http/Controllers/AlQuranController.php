<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AlQuranController extends Controller
{
    /**
     * Menampilkan halaman Al-Quran
     */
    public function index()
    {
        return view('alquran.index');
    }

    /**
     * Menampilkan halaman detail surat
     */
    public function show(Request $request)
    {
        $nomorSurat = $request->get('surat');

        if (!$nomorSurat) {
            return redirect()->route('alquran.index')->with('error', 'Nomor surat tidak ditemukan');
        }

        return view('alquran.show', compact('nomorSurat'));
    }

    /**
     * Mengambil daftar surat dari API
     */
    public function getSurat()
    {
        try {
            // Mengambil data dari API MyQuran
            $response = Http::get('https://api.myquran.com/v2/quran/surat/semua');

            if ($response->successful()) {
                $data = $response->json();

                if ($data['status'] === true) {
                    return response()->json([
                        'success' => true,
                        'data' => $data['data']
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil daftar surat'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mengambil detail surat berdasarkan nomor surat
     */
    public function getSuratDetail(Request $request)
    {
        try {
            $nomorSurat = $request->get('nomor');

            if (!$nomorSurat) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor surat tidak ditemukan'
                ], 400);
            }

            // Mengambil data surat dari API MyQuran
            $response = Http::get("https://api.myquran.com/v2/quran/surat/{$nomorSurat}");

            if ($response->successful()) {
                $data = $response->json();

                if ($data['status'] === true) {
                    return response()->json([
                        'success' => true,
                        'data' => $data['data']
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail surat'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mengambil ayat berdasarkan nomor surat dan ayat
     */
    public function getAyat(Request $request)
    {
        try {
            $nomorSurat = $request->get('surat');
            $nomorAyat = $request->get('ayat');

            if (!$nomorSurat || !$nomorAyat) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor surat dan ayat tidak ditemukan'
                ], 400);
            }

            // Mengambil data ayat dari API MyQuran
            $response = Http::get("https://api.myquran.com/v2/quran/ayat/{$nomorSurat}/{$nomorAyat}");

            if ($response->successful()) {
                $data = $response->json();

                if ($data['status'] === true) {
                    return response()->json([
                        'success' => true,
                        'data' => $data['data']
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil ayat'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
