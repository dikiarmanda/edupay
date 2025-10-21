<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MutationHistory;
use App\Models\Notification;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard
     */
    public function index()
    {
        $user = (object) session('auth');
        $user->greeting = $this->greeting();

        // Ambil 5 notifikasi terbaru
        $query = Notification::query();

        // Filter berdasarkan NISN jika user adalah siswa
        if ($user->nisn) {
            $query->byNisn($user->nisn);
        }

        // Filter berdasarkan merchant kode jika user adalah admin sekolah
        if ($user->merchant_kode) {
            $query->byMerchant($user->merchant_kode);
        }

        $latestNotifications = $query->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Hitung jumlah notifikasi yang belum dibaca
        $unreadCount = $query->unread()->count();

        return view('dashboard', compact('user', 'latestNotifications', 'unreadCount'));
    }

    /**
     * Menampilkan halaman mutasi dengan filter tanggal
     */
    public function mutasi(Request $request)
    {
        $user = (object) session('auth');

        // Ambil parameter filter dari request
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        $type = $request->get('type', 'all'); // all, masuk, keluar

        // Query mutation history berdasarkan NISN user
        $query = MutationHistory::byNisn($user->nisn)
            ->byDateRange($startDate, $endDate)
            ->orderBy('date_trx', 'desc');

        // Filter berdasarkan tipe transaksi
        if ($type === 'masuk') {
            $query->credit();
        } elseif ($type === 'keluar') {
            $query->debit();
        }

        $mutations = $query->get();

        // Format data untuk view
        $mutations = $mutations->map(function ($mutation) {
            $isCredit = $mutation->kredit > 0;
            $amount = $isCredit ? $mutation->kredit : $mutation->debet;

            return [
                'id' => $mutation->id,
                'information' => $mutation->information,
                'merchant_name' => $mutation->merchant_name,
                'amount' => $amount,
                'is_credit' => $isCredit,
                'date_trx' => $mutation->date_trx,
                'formatted_date' => $mutation->date_trx->format('d M Y, H:i'),
                'formatted_amount' => 'Rp ' . number_format((float) $amount, 0, ',', '.'),
                'icon' => $isCredit ? 'arrow-down' : 'arrow-up',
                'icon_color' => $isCredit ? 'green' : 'red',
                'bg_color' => $isCredit ? 'bg-green-100' : 'bg-red-100',
                'text_color' => $isCredit ? 'text-green-600' : 'text-red-600',
            ];
        });

        return view('mutasi', compact('mutations', 'startDate', 'endDate', 'type'));
    }

    /**
     * Menampilkan halaman tentang EduPay
     */
    public function tentang()
    {
        return view('tentang');
    }

    /**
     * Buatkan salam sesuai jam
     *
     * @return array
     */
    private function greeting()
    {
        $hour = date('H');
        if ($hour < 12) {
            return [
                'text' => 'Selamat pagi',
                'icon' => 'sunrise'
            ];
        } elseif ($hour < 15) {
            return [
                'text' => 'Selamat siang',
                'icon' => 'sun'
            ];
        } elseif ($hour < 18) {
            return [
                'text' => 'Selamat sore',
                'icon' => 'sunset'
            ];
        } else {
            return [
                'text' => 'Selamat malam',
                'icon' => 'moon'
            ];
        }
    }
}
