@extends('layouts.app')

@section('title', 'Semua Menu - EduPay')

@section('content')
  <!-- Header -->
  <div class="bg-white px-4 py-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <button onclick="history.back()" class="rounded-lg p-2 hover:bg-gray-100">
          <i data-lucide="arrow-left" class="h-6 w-6 text-gray-600"></i>
        </button>
        <div>
          <h1 class="text-xl font-bold text-gray-900">Semua Menu</h1>
          <p class="text-sm text-gray-500">Jelajahi semua fitur yang tersedia di aplikasi EduPay.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- All Menu Grid -->
  <div class="px-4 py-6">
    <div class="grid grid-cols-3 gap-4">
      <!-- Row 1 -->
      <!-- Tagihan -->
      <a href="{{ route('tagihan.index') }}" class="flex flex-col items-center space-y-1">
        <div class="flex h-28 w-28 items-center justify-center rounded-xl bg-blue-100">
          <i data-lucide="credit-card" class="h-14 w-14 text-blue-600"></i>
        </div>
        <span class="text-center text-sm font-medium text-gray-700">Tagihan</span>
      </a>

      <!-- Isi Saldo -->
      <a href="{{ route('topup.index') }}" class="flex flex-col items-center space-y-1">
        <div class="flex h-28 w-28 items-center justify-center rounded-xl bg-green-100">
          <i data-lucide="wallet" class="h-14 w-14 text-green-600"></i>
        </div>
        <span class="text-center text-xs font-medium text-gray-700">Isi Saldo</span>
      </a>

      <!-- Donasi -->
      <div class="flex flex-col items-center space-y-1">
        <div class="flex h-28 w-28 items-center justify-center rounded-xl bg-red-100">
          <i data-lucide="heart" class="h-14 w-14 text-red-600"></i>
        </div>
        <span class="text-center text-xs font-medium text-gray-700">Donasi</span>
      </div>

      <!-- Kantin -->
      <div class="flex flex-col items-center space-y-1">
        <div class="flex h-28 w-28 items-center justify-center rounded-xl bg-orange-100">
          <i data-lucide="utensils" class="h-14 w-14 text-orange-600"></i>
        </div>
        <span class="text-center text-xs font-medium text-gray-700">Kantin</span>
      </div>

      <!-- Row 2 -->
      <!-- Antar Jemput -->
      <div class="flex flex-col items-center space-y-1">
        <div class="flex h-28 w-28 items-center justify-center rounded-xl bg-purple-100">
          <i data-lucide="bus" class="h-14 w-14 text-purple-600"></i>
        </div>
        <span class="text-center text-xs font-medium text-gray-700">Antar Jemput</span>
      </div>

      <!-- Pengumuman -->
      <div class="flex flex-col items-center space-y-1">
        <div class="flex h-28 w-28 items-center justify-center rounded-xl bg-teal-100">
          <i data-lucide="megaphone" class="h-14 w-14 text-teal-600"></i>
        </div>
        <span class="text-center text-xs font-medium text-gray-700">Pengumuman</span>
      </div>

      <!-- Berita -->
      <div class="flex flex-col items-center space-y-1">
        <div class="flex h-28 w-28 items-center justify-center rounded-xl bg-blue-100">
          <i data-lucide="newspaper" class="h-14 w-14 text-blue-600"></i>
        </div>
        <span class="text-center text-xs font-medium text-gray-700">Berita</span>
      </div>

      <!-- Absensi -->
      <div class="flex flex-col items-center space-y-1">
        <div class="flex h-28 w-28 items-center justify-center rounded-xl bg-indigo-100">
          <i data-lucide="user-check" class="h-14 w-14 text-indigo-600"></i>
        </div>
        <span class="text-center text-xs font-medium text-gray-700">Absensi</span>
      </div>

      <!-- Row 3 -->
      <!-- Jadwal Sekolah -->
      <div class="flex flex-col items-center space-y-1">
        <div class="flex h-28 w-28 items-center justify-center rounded-xl bg-violet-100">
          <i data-lucide="calendar" class="h-14 w-14 text-violet-600"></i>
        </div>
        <span class="text-center text-xs font-medium text-gray-700">Jadwal Sekolah</span>
      </div>

      <!-- Kegiatan di Rumah -->
      <div class="flex flex-col items-center space-y-1">
        <div class="flex h-28 w-28 items-center justify-center rounded-xl bg-yellow-100">
          <i data-lucide="clipboard-check" class="h-14 w-14 text-yellow-600"></i>
        </div>
        <span class="text-center text-xs font-medium text-gray-700">Kegiatan di Rumah</span>
      </div>

      <!-- Al-Quran -->
      <div class="flex flex-col items-center space-y-1">
        <div class="flex h-28 w-28 items-center justify-center rounded-xl bg-emerald-100">
          <i data-lucide="book-open" class="h-14 w-14 text-emerald-600"></i>
        </div>
        <span class="text-center text-xs font-medium text-gray-700">Al-Quran</span>
      </div>

      <!-- Jadwal Sholat -->
      <div class="flex flex-col items-center space-y-1">
        <div class="flex h-28 w-28 items-center justify-center rounded-xl bg-amber-100">
          <i data-lucide="calendar-clock" class="h-14 w-14 text-amber-600"></i>
        </div>
        <span class="text-center text-xs font-medium text-gray-700">Jadwal Sholat</span>
      </div>
    </div>
  </div>

  <style>
    .menu-item {
      transition: all 0.2s ease;
      border-radius: 12px;
      background: white;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .menu-item:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .menu-item:active {
      transform: translateY(0);
    }
  </style>

  <script>
    // Initialize Lucide icons
    lucide.createIcons();
  </script>
@endsection
