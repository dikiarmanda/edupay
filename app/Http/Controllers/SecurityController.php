<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
