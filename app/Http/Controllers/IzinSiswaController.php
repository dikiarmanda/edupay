<?php

namespace App\Http\Controllers;

use App\Models\IzinSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IzinSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data user dari session
        $user = (object) session('auth');
        $nisn = $user->nisn_siswa ?? $user->nisn ?? null;

        // Ambil data izin siswa berdasarkan NISN
        $izinSiswa = IzinSiswa::where('nisn', $nisn)
            ->orderBy('tanggal_izin', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('izin-siswa.index', compact('izinSiswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('izin-siswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'tanggal_izin' => 'required|date|before_or_equal:today',
            'jenis_izin' => 'required|in:sakit,izin,dispensasi',
            'alasan' => 'required|string|max:500',
            'bukti_surat' => 'required|file|mimes:png,pdf,jpg,jpeg|max:2048',
        ]);

        try {
            // Ambil data user dari session
            $user = (object) session('auth');
            $nisn = $user->nisn_siswa ?? $user->nisn ?? null;
            $nama = $user->nama ?? 'Unknown';

            // Handle file upload
            if ($request->hasFile('bukti_surat')) {
                $file = $request->file('bukti_surat');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/izin-siswa', $fileName);
                $validated['bukti_surat'] = 'izin-siswa/' . $fileName;
            }

            // Tambahkan data user
            $validated['nisn'] = $nisn;
            $validated['nama'] = $nama;

            // Buat izin siswa
            IzinSiswa::create($validated);

            return redirect()->route('izin-siswa.index')
                ->with('success', 'Izin berhasil diajukan.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $izin = IzinSiswa::findOrFail($id);

        // Ambil data user dari session
        $user = (object) session('auth');
        $nisn = $user->nisn_siswa ?? $user->nisn ?? null;

        // Check ownership
        if ($izin->nisn != $nisn) {
            return redirect()->route('izin-siswa.index')
                ->with('error', 'Akses ditolak.');
        }

        return view('izin-siswa.show', compact('izin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $izin = IzinSiswa::findOrFail($id);

        // Ambil data user dari session
        $user = (object) session('auth');
        $nisn = $user->nisn_siswa ?? $user->nisn ?? null;

        // Check ownership
        if ($izin->nisn != $nisn) {
            return redirect()->route('izin-siswa.index')
                ->with('error', 'Akses ditolak.');
        }

        return view('izin-siswa.edit', compact('izin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $izin = IzinSiswa::findOrFail($id);

        // Ambil data user dari session
        $user = (object) session('auth');
        $nisn = $user->nisn_siswa ?? $user->nisn ?? null;

        // Check ownership
        if ($izin->nisn != $nisn) {
            return redirect()->route('izin-siswa.index')
                ->with('error', 'Akses ditolak.');
        }

        // Validasi input
        $validated = $request->validate([
            'tanggal_izin' => 'required|date|before_or_equal:today',
            'jenis_izin' => 'required|in:sakit,izin,dispensasi',
            'alasan' => 'required|string|max:500',
            'bukti_surat' => 'nullable|file|mimes:png,pdf,jpg,jpeg|max:2048',
        ]);

        try {
            // Handle file upload jika ada file baru
            if ($request->hasFile('bukti_surat')) {
                // Hapus file lama jika ada
                if ($izin->bukti_surat && Storage::exists('public/' . $izin->bukti_surat)) {
                    Storage::delete('public/' . $izin->bukti_surat);
                }

                // Upload file baru
                $file = $request->file('bukti_surat');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/izin-siswa', $fileName);
                $validated['bukti_surat'] = 'izin-siswa/' . $fileName;
            } else {
                // Jika tidak ada file baru, hapus dari validated agar tidak ter-update
                unset($validated['bukti_surat']);
            }

            // Update izin
            $izin->update($validated);

            return redirect()->route('izin-siswa.index')
                ->with('success', 'Izin berhasil diperbarui.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $izin = IzinSiswa::findOrFail($id);

        // Ambil data user dari session
        $user = (object) session('auth');
        $nisn = $user->nisn_siswa ?? $user->nisn ?? null;

        // Check ownership
        if ($izin->nisn != $nisn) {
            return redirect()->route('izin-siswa.index')
                ->with('error', 'Akses ditolak.');
        }

        try {
            // Hapus file jika ada
            if ($izin->bukti_surat && Storage::exists('public/' . $izin->bukti_surat)) {
                Storage::delete('public/' . $izin->bukti_surat);
            }

            // Hapus izin
            $izin->delete();

            return redirect()->route('izin-siswa.index')
                ->with('success', 'Izin berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Download file bukti surat.
     */
    public function downloadBukti($id)
    {
        $izin = IzinSiswa::findOrFail($id);

        // Ambil data user dari session
        $user = (object) session('auth');
        $nisn = $user->nisn_siswa ?? $user->nisn ?? null;

        // Check ownership
        if ($izin->nisn != $nisn) {
            return redirect()->route('izin-siswa.index')
                ->with('error', 'Akses ditolak.');
        }

        if (!$izin->bukti_surat || !Storage::exists('public/' . $izin->bukti_surat)) {
            return redirect()->route('izin-siswa.index')
                ->with('error', 'File tidak ditemukan.');
        }

        return Storage::download('public/' . $izin->bukti_surat);
    }
}

