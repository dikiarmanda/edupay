<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Menampilkan halaman notifikasi dengan filter
     */
    public function index(Request $request)
    {
        $query = Notification::query();

        // Filter berdasarkan status baca
        if ($request->has('status')) {
            if ($request->status === 'unread') {
                $query->unread();
            } elseif ($request->status === 'read') {
                $query->read();
            }
        }

        // Filter berdasarkan tipe
        if ($request->has('tipe') && $request->tipe !== '') {
            $query->byType($request->tipe);
        }

        // Filter berdasarkan NISN jika user adalah siswa
        if (Auth::check() && Auth::user()->nisn) {
            $query->byNisn(Auth::user()->nisn);
        }

        // Filter berdasarkan merchant kode jika user adalah admin sekolah
        if (Auth::check() && Auth::user()->merchant_kode) {
            $query->byMerchant(Auth::user()->merchant_kode);
        }

        $notifications = $query->orderBy('created_at', 'desc')->paginate(10);

        // Statistik notifikasi
        $totalNotifications = Notification::count();
        $unreadCount = Notification::unread()->count();
        $readCount = Notification::read()->count();

        return view('notifications.index', compact(
            'notifications',
            'totalNotifications',
            'unreadCount',
            'readCount'
        ));
    }

    /**
     * Menampilkan detail notifikasi
     */
    public function show(Notification $notification)
    {
        // Tandai notifikasi sebagai sudah dibaca
        if (!$notification->is_read) {
            $notification->markAsRead();
        }

        return view('notifications.show', compact('notification'));
    }

    /**
     * Menandai notifikasi sebagai sudah dibaca
     */
    public function markAsRead(Notification $notification)
    {
        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi ditandai sebagai sudah dibaca'
        ]);
    }

    /**
     * Menandai semua notifikasi sebagai sudah dibaca
     */
    public function markAllAsRead()
    {
        $query = Notification::query();

        // Filter berdasarkan NISN jika user adalah siswa
        if (Auth::check() && Auth::user()->nisn) {
            $query->byNisn(Auth::user()->nisn);
        }

        // Filter berdasarkan merchant kode jika user adalah admin sekolah
        if (Auth::check() && Auth::user()->merchant_kode) {
            $query->byMerchant(Auth::user()->merchant_kode);
        }

        $query->unread()->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi ditandai sebagai sudah dibaca'
        ]);
    }

    /**
     * Menghapus notifikasi
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil dihapus'
        ]);
    }

    /**
     * API untuk mendapatkan notifikasi terbaru (untuk dashboard)
     */
    public function getLatest(Request $request)
    {
        $limit = $request->get('limit', 5);

        $query = Notification::query();

        // Filter berdasarkan NISN jika user adalah siswa
        if (Auth::check() && Auth::user()->nisn) {
            $query->byNisn(Auth::user()->nisn);
        }

        // Filter berdasarkan merchant kode jika user adalah admin sekolah
        if (Auth::check() && Auth::user()->merchant_kode) {
            $query->byMerchant(Auth::user()->merchant_kode);
        }

        $notifications = $query->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $notifications
        ]);
    }

    /**
     * API untuk mendapatkan jumlah notifikasi yang belum dibaca
     */
    public function getUnreadCount()
    {
        $query = Notification::query();

        // Filter berdasarkan NISN jika user adalah siswa
        if (Auth::check() && Auth::user()->nisn) {
            $query->byNisn(Auth::user()->nisn);
        }

        // Filter berdasarkan merchant kode jika user adalah admin sekolah
        if (Auth::check() && Auth::user()->merchant_kode) {
            $query->byMerchant(Auth::user()->merchant_kode);
        }

        $unreadCount = $query->unread()->count();

        return response()->json([
            'success' => true,
            'unread_count' => $unreadCount
        ]);
    }
}
