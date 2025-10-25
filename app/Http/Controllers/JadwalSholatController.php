<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class JadwalSholatController extends Controller
{
    /**
     * Menampilkan halaman jadwal sholat
     */
    public function index()
    {
        return view('jadwal-sholat.index');
    }

    /**
     * Mengambil data jadwal sholat dari API
     */
    public function getJadwalSholat(Request $request)
    {
        try {
            // Default kota Jakarta jika tidak ada parameter
            $cityId = $request->get('city_id', 1301); // Jakarta
            $date = $request->get('date', Carbon::now()->format('Y-m-d'));

            // Mengambil data dari API MyQuran
            $response = Http::get("https://api.myquran.com/v2/sholat/jadwal/{$cityId}/{$date}");

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
                'message' => 'Gagal mengambil data jadwal sholat'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mengambil daftar kota untuk dropdown
     */
    public function getCities()
    {
        try {
            $response = Http::get('https://api.myquran.com/v2/sholat/kota/semua');

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
                'message' => 'Gagal mengambil daftar kota'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
