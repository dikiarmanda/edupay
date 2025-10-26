@extends('layouts.app')

@section('title', 'Profil - EduPay')

@section('content')

  <!-- Content -->
  <div class="mb-18 px-4 py-6">
    <!-- Profile Info -->
    <div class="mb-6 rounded-xl bg-white p-6 shadow-sm">
      <div class="text-center">
        <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-gray-600">
          <span class="text-2xl font-semibold text-white">{{ strtoupper(substr($user->nama, 0, 1)) }}</span>
        </div>
        <h2 class="mb-1 text-xl font-bold text-gray-900">{{ $user->nama }}</h2>
        <p class="mb-4 text-gray-500">Siswa Kelas {{ $user->kelas }}</p>
        <div class="rounded-lg bg-purple-50 p-3">
          <p class="text-sm text-gray-600">NISN: {{ $user->nisn }}</p>
          <p class="text-sm text-gray-600">Email: {{ $user->email }}</p>
        </div>
      </div>
    </div>

    <!-- Menu Options -->
    <div class="space-y-4">
      <!-- Edit Profile -->
      <a href="{{ route('profil.edit') }}"
        class="block rounded-xl bg-white p-4 shadow-sm transition-colors hover:bg-gray-50">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-violet-100">
              <i data-lucide="edit" class="h-5 w-5 text-violet-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Edit Profil</p>
              <p class="text-sm text-gray-500">Ubah foto dan email</p>
            </div>
          </div>
          <i data-lucide="chevron-right" class="h-5 w-5 text-gray-400"></i>
        </div>
      </a>

      <!-- Change Password & PIN -->
      <a href="{{ route('security.index') }}"
        class="block rounded-xl bg-white p-4 shadow-sm transition-colors hover:bg-gray-50">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100">
              <i data-lucide="key" class="h-5 w-5 text-emerald-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Ubah Password & PIN</p>
              <p class="text-sm text-gray-500">Ganti Password & PIN keamanan</p>
            </div>
          </div>
          <i data-lucide="chevron-right" class="h-5 w-5 text-gray-400"></i>
        </div>
      </a>

      <!-- Notification Settings -->
      <div class="rounded-xl bg-white p-4 shadow-sm">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-sky-100">
              <i data-lucide="bell" class="h-5 w-5 text-sky-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Notifikasi</p>
              <p class="text-sm text-gray-500">Pengaturan notifikasi</p>
            </div>
          </div>
          <i data-lucide="chevron-right" class="h-5 w-5 text-gray-400"></i>
        </div>
      </div>

      <!-- About -->
      <a href="{{ route('tentang') }}"class="block rounded-xl bg-white p-4 shadow-sm transition-colors hover:bg-gray-50">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-100">
              <i data-lucide="info" class="h-5 w-5 text-amber-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Tentang EduPay</p>
              <p class="text-sm text-gray-500">Versi 1.0.0</p>
            </div>
          </div>
          <i data-lucide="chevron-right" class="h-5 w-5 text-gray-400"></i>
        </div>
      </a>

      <!-- Logout -->
      <a href="{{ route('logout') }}"
        onclick="return confirmLogout()"class="block rounded-xl bg-white p-4 shadow-sm transition-colors hover:bg-gray-50">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100">
              <i data-lucide="log-out" class="h-5 w-5 text-red-600"></i>
            </div>
            <div>
              <p class="font-medium text-red-600">Keluar</p>
              <p class="text-sm text-gray-500">Logout dari akun</p>
            </div>
          </div>
          <i data-lucide="chevron-right" class="h-5 w-5 text-gray-400"></i>
        </div>
      </a>
    </div>
  </div>

  <script>
    function confirmLogout() {
      return confirm('Apakah Anda yakin ingin keluar dari akun?');
    }
  </script>
@endsection
