<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function index()
    {
        return view('profil.index');
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        return view('profil.edit');
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'hp' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'hp.max' => 'Nomor telepon maksimal 20 karakter.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'photo.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Here you can add logic to save the profile data
        // For now, we'll just return success

        return redirect()->route('profil.index')->with('success', 'Profil berhasil diperbarui!');
    }
}
