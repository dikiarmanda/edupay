@extends('layouts.app')

@section('content')
  <div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow-sm">
      <div class="mx-auto max-w-md px-4 py-4">
        <div class="flex items-center space-x-3">
          <button onclick="history.back()" class="flex-shrink-0">
            <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
          </button>
          <h1 class="text-lg font-semibold text-gray-900">Keamanan & PIN</h1>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="mx-auto max-w-md px-4 py-6">
      <!-- Title and Description -->
      <div class="mb-6">
        <h1 class="mb-2 text-2xl font-bold text-gray-900">Keamanan & PIN</h1>
        <p class="text-sm text-gray-600">
          Kelola password dan PIN transaksi Anda untuk menjaga keamanan akun.
        </p>
      </div>

      <!-- Ubah Password Section -->
      <div class="mb-6 rounded-2xl bg-white p-6 shadow-sm">
        <div class="mb-6 flex items-center space-x-3">
          <svg class="h-6 w-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
            </path>
          </svg>
          <h2 class="text-lg font-semibold text-gray-900">Ubah Password</h2>
        </div>
        <p class="mb-6 text-sm text-gray-600">
          Gunakan password yang kuat dan unik untuk melindungi akun Anda.
        </p>

        <form action="{{ route('security.updatePassword') }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-4">
            <label for="old_password" class="mb-2 block text-sm font-medium text-gray-700">Password Lama</label>
            <input type="password" id="old_password" name="old_password"
              class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-purple-500 focus:ring-purple-500"
              required>
            @error('old_password')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label for="new_password" class="mb-2 block text-sm font-medium text-gray-700">Password Baru</label>
            <input type="password" id="new_password" name="new_password"
              class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-purple-500 focus:ring-purple-500"
              required>
            @error('new_password')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-6">
            <label for="new_password_confirmation" class="mb-2 block text-sm font-medium text-gray-700">Konfirmasi
              Password Baru</label>
            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
              class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-purple-500 focus:ring-purple-500"
              required>
          </div>

          <x-button type="primary" as="submit" class="w-full">
            Simpan Password
          </x-button>
        </form>
      </div>

      <!-- Ubah PIN Section -->
      <div class="rounded-2xl bg-white p-6 shadow-sm">
        <div class="mb-6 flex items-center space-x-3">
          <svg class="h-6 w-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 7a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V9a2 2 0 012-2h2zM5 12h.01M12 12h.01M19 12h.01"></path>
          </svg>
          <h2 class="text-lg font-semibold text-gray-900">Ubah PIN Transaksi</h2>
        </div>
        <p class="mb-6 text-sm text-gray-600">
          PIN ini digunakan untuk mengotorisasi semua transaksi keuangan Anda.
        </p>

        <form action="{{ route('security.updatePin') }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-4">
            <label for="old_pin" class="mb-2 block text-sm font-medium text-gray-700">PIN Lama (6-digit)</label>
            <input type="password" id="old_pin" name="old_pin" maxlength="6" pattern="[0-9]{6}"
              class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-purple-500 focus:ring-purple-500"
              required>
            @error('old_pin')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label for="new_pin" class="mb-2 block text-sm font-medium text-gray-700">PIN Baru (6-digit)</label>
            <input type="password" id="new_pin" name="new_pin" maxlength="6" pattern="[0-9]{6}"
              class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-purple-500 focus:ring-purple-500"
              required>
            @error('new_pin')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-6">
            <label for="new_pin_confirmation" class="mb-2 block text-sm font-medium text-gray-700">Konfirmasi PIN
              Baru</label>
            <input type="password" id="new_pin_confirmation" name="new_pin_confirmation" maxlength="6" pattern="[0-9]{6}"
              class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-purple-500 focus:ring-purple-500"
              required>
          </div>

          <x-button type="primary" as="submit" class="w-full">
            Simpan PIN
          </x-button>
        </form>
      </div>
    </div>
  </div>

  <!-- Include Toast Component -->
  @include('components.toast')

  <script>
    // PIN input validation - only allow numbers
    document.querySelectorAll('input[name*="pin"]').forEach(input => {
      input.addEventListener('input', function(e) {
        // Remove any non-numeric characters
        e.target.value = e.target.value.replace(/\D/g, '');

        // Limit to 6 digits
        if (e.target.value.length > 6) {
          e.target.value = e.target.value.slice(0, 6);
        }
      });
    });

    // Password strength indicator (optional)
    document.getElementById('new_password').addEventListener('input', function(e) {
      const password = e.target.value;
      const strength = getPasswordStrength(password);

      // You can add visual feedback here if needed
      console.log('Password strength:', strength);
    });

    function getPasswordStrength(password) {
      let strength = 0;
      if (password.length >= 8) strength++;
      if (/[a-z]/.test(password)) strength++;
      if (/[A-Z]/.test(password)) strength++;
      if (/[0-9]/.test(password)) strength++;
      if (/[^A-Za-z0-9]/.test(password)) strength++;

      return strength;
    }
  </script>
@endsection
