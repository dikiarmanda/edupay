<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SecurityController extends Controller
{
    /**
     * Display the security and PIN management page.
     */
    public function index()
    {
        return view('security.index');
    }

    /**
     * Handle password update request.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'old_password.required' => 'Password lama harus diisi.',
            'new_password.required' => 'Password baru harus diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        // Here you can add logic to update password
        // For now, we'll just return success

        return redirect()->route('security.index')->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * Handle PIN update request.
     */

    public function createPin()
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Jika user sudah memiliki PIN, redirect ke dashboard
        if (Auth::user()->pin) {
            return redirect()->route('dashboard')->with('info', 'PIN sudah dibuat sebelumnya.');
        }

        return view('security.create-pin');
    }

    /**
     * Menyimpan PIN ke database
     */
    public function storePin(Request $request)
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
    public function verifyPin(Request $request)
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

    public function updatePin(Request $request)
    {
        $request->validate([
            'old_pin' => 'required|digits:6',
            'new_pin' => 'required|digits:6|confirmed',
        ], [
            'old_pin.required' => 'PIN lama harus diisi.',
            'old_pin.digits' => 'PIN lama harus 6 digit.',
            'new_pin.required' => 'PIN baru harus diisi.',
            'new_pin.digits' => 'PIN baru harus 6 digit.',
            'new_pin.confirmed' => 'Konfirmasi PIN baru tidak cocok.',
        ]);

        // Here you can add logic to update PIN
        // For now, we'll just return success

        return redirect()->route('security.index')->with('success', 'PIN berhasil diperbarui!');
    }
}
