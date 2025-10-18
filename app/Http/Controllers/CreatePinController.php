<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CreatePinController extends Controller
{
    /**
     * Menampilkan halaman create PIN
     */
    public function index()
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Jika user sudah memiliki PIN, redirect ke dashboard
        if (Auth::user()->pin) {
            return redirect()->route('dashboard')->with('info', 'PIN sudah dibuat sebelumnya.');
        }

        return view('create-pin');
    }

    /**
     * Menyimpan PIN ke database
     */
    public function store(Request $request)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'pin' => 'required|string|size:6|regex:/^[0-9]+$/',
            'pin_confirmation' => 'required|same:pin',
        ], [
            'pin.required' => 'PIN harus diisi.',
            'pin.size' => 'PIN harus terdiri dari 6 digit.',
            'pin.regex' => 'PIN hanya boleh berisi angka.',
            'pin_confirmation.required' => 'Konfirmasi PIN harus diisi.',
            'pin_confirmation.same' => 'Konfirmasi PIN tidak cocok.',
        ]);

        try {
            // Update PIN user di database
            $user = Auth::user();
            $user->pin = Hash::make($request->pin);
            $user->save();

            // Simpan PIN dalam session untuk keperluan verifikasi
            $request->session()->put('user_pin', $request->pin);

            return redirect()->route('dashboard')->with('success', 'PIN keamanan berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->withErrors([
                'pin' => 'Terjadi kesalahan saat menyimpan PIN. Silakan coba lagi.',
            ])->withInput();
        }
    }

    /**
     * Verifikasi PIN untuk akses fitur tertentu
     */
    public function verify(Request $request)
    {
        $request->validate([
            'pin' => 'required|string|size:6|regex:/^[0-9]+$/',
        ], [
            'pin.required' => 'PIN harus diisi.',
            'pin.size' => 'PIN harus terdiri dari 6 digit.',
            'pin.regex' => 'PIN hanya boleh berisi angka.',
        ]);

        $user = Auth::user();

        if (!$user->pin) {
            return back()->withErrors([
                'pin' => 'PIN belum dibuat. Silakan buat PIN terlebih dahulu.',
            ]);
        }

        if (Hash::check($request->pin, $user->pin)) {
            // PIN benar, simpan dalam session untuk sementara
            $request->session()->put('pin_verified', true);
            $request->session()->put('pin_verified_at', now());

            return back()->with('success', 'PIN berhasil diverifikasi.');
        } else {
            return back()->withErrors([
                'pin' => 'PIN yang dimasukkan salah.',
            ]);
        }
    }
}
