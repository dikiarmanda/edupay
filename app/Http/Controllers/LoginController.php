<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\MutationHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Proses autentikasi login dengan validasi database
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'nisn' => 'required',
            'password' => 'required',
        ], [
            'nisn.required' => 'Nisn harus diisi.',
            'password.required' => 'Password harus diisi.',
        ]);

        // Cek apakah user ada di database
        $user = User::where('nisn_siswa', $credentials['nisn'])->first();

        if (!$user) {
            return back()->withErrors([
                'nisn' => 'Nisn tidak terdaftar dalam sistem.',
            ])->onlyInput('nisn');
        }

        // Cek password dengan hash
        if (!Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'nisn' => 'NISN atau password yang dimasukkan salah.',
            ])->onlyInput('nisn');
        }

        // Login berhasil
        Auth::login($user);
        $request->session()->regenerate();

        $this->getDataUser($request, $user);

        // Redirect berdasarkan status PIN
        if ($user->pin) {
            return redirect()->intended('/dashboard');
        } else {
            return redirect()->intended('/create-pin');
        }
    }

    public function getDataUser(Request $request, $user)
    {
        $siswa = Siswa::where('nisn', $user->nisn_siswa)->first();
        if (!$siswa) {
            $siswa = (object) [
                'nama' => 'User',
                'merchant_kode' => null,
            ];
        }

        // Ambil data mutation_history berdasarkan NISN dan merchant_kode
        $mutationHistory = [];
        if ($siswa->merchant_kode) {
            $mutationHistory = MutationHistory::byNisnAndMerchant($user->nisn_siswa, $siswa->merchant_kode)
                ->orderBy('date_trx', 'desc')
                ->get();
        } else {
            // Data contoh untuk testing jika tidak ada merchant_kode
            $mutationHistory = [];
        }
        $saldo = $mutationHistory->reduce(function ($carry, $item) {
            return $carry + ($item->debet ? -$item->debet : $item->kredit);
        }, 0);

        // Simpan data user ke session untuk ditampilkan di dashboard
        $request->session()->put('auth', [
            'id' => $user->id,
            'nama' => $siswa->nama,
            'nisn' => $user->nisn_siswa,
            'username' => $user->username,
            'email' => $user->email,
            'merchant_kode' => $siswa->merchant_kode,
            'avatarUrl' => $user->avatarUrl,
            'saldo' => $saldo,
        ]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        // Hapus session auth
        $request->session()->forget('auth');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }
}
