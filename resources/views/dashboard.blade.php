@extends('layouts.app')

@section('title', 'Dashboard - EduPay')

@section('content')
  <!-- Header -->
  <div class="bg-white px-4 py-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-600">
          <span class="text-sm font-semibold text-white">{{ strtoupper(substr($user->nama, 0, 1)) }}</span>
        </div>
        <div>
          <p class="text-sm text-gray-500">Selamat Datang,</p>
          <p class="font-semibold text-gray-900">{{ $user->nama }}</p>
        </div>
      </div>
      <div class="relative">
        <i data-lucide="bell" class="h-6 w-6 text-gray-600"></i>
        <div class="notification-dot"></div>
      </div>
    </div>
  </div>

  <!-- Balance Card -->
  <div class="px-4 py-6">
    <div class="gradient-bg floating-shapes relative rounded-2xl p-6 text-white">
      <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center space-x-2">
          <span class="text-sm font-medium">Saldo Efektif</span>
          <button id="toggleBalance" class="transition duration-200">
            <i id="eyeIcon" data-lucide="eye-off" class="h-4 w-4 text-white"></i>
            <i id="eyeIconOn" data-lucide="eye" class="hidden h-4 w-4 text-white"></i>
          </button>
        </div>
        <div class="flex items-center space-x-2">
          <div class="rounded-lg bg-purple-500 px-3 py-1">
            <span class="text-xs font-semibold">UTAMA</span>
          </div>
          @if (isset($user->merchant_kode))
            {{-- <div class="rounded-lg bg-blue-500 px-3 py-1">
              <span class="text-xs font-semibold">{{ $user->merchant_kode }}</span>
            </div> --}}
          @endif
        </div>
      </div>

      <div class="mb-4">
        <h2 id="balanceAmount" class="text-3xl font-bold">Rp ••••••••</h2>
        <h2 id="balanceHidden" class="hidden text-3xl font-bold">Rp {{ number_format($user->saldo, 0, ',', '.') ?? 0 }}
        </h2>
      </div>
    </div>
  </div>

  <!-- Main Menu -->
  <div class="mb-6 px-4">
    <h3 class="mb-4 text-lg font-bold text-gray-900">Menu Utama</h3>
    <div class="grid grid-cols-4 gap-4">
      <!-- Tagihan -->
      <a href="{{ route('tagihan.index') }}" class="flex flex-col items-center space-y-1">
        <div class="flex h-20 w-20 items-center justify-center rounded-xl bg-blue-100">
          <i data-lucide="credit-card" class="h-10 w-10 text-blue-600"></i>
        </div>
        <span class="text-xs font-medium text-gray-700">Tagihan</span>
      </a>

      <!-- Isi Saldo -->
      <a href="{{ route('topup.index') }}" class="flex flex-col items-center space-y-1">
        <div class="flex h-20 w-20 items-center justify-center rounded-xl bg-green-100">
          <i data-lucide="wallet" class="h-10 w-10 text-green-600"></i>
        </div>
        <span class="text-xs font-medium text-gray-700">Isi Saldo</span>
      </a>

      <!-- Donasi -->
      <div class="flex flex-col items-center space-y-1">
        <div class="flex h-20 w-20 items-center justify-center rounded-xl bg-red-100">
          <i data-lucide="heart" class="h-10 w-10 text-red-600"></i>
        </div>
        <span class="text-xs font-medium text-gray-700">Donasi</span>
      </div>

      <!-- Kantin -->
      <div class="flex flex-col items-center space-y-1">
        <div class="flex h-20 w-20 items-center justify-center rounded-xl bg-orange-100">
          <i data-lucide="utensils" class="h-10 w-10 text-orange-600"></i>
        </div>
        <span class="text-xs font-medium text-gray-700">Kantin</span>
      </div>

      <!-- Antar Jemput -->
      <div class="flex flex-col items-center space-y-1">
        <div class="flex h-20 w-20 items-center justify-center rounded-xl bg-purple-100">
          <i data-lucide="bus" class="h-10 w-10 text-purple-600"></i>
        </div>
        <span class="text-xs font-medium text-gray-700">Antar Jemput</span>
      </div>

      <!-- Pengumuman -->
      <div class="flex flex-col items-center space-y-1">
        <div class="flex h-20 w-20 items-center justify-center rounded-xl bg-teal-100">
          <i data-lucide="megaphone" class="h-10 w-10 text-teal-600"></i>
        </div>
        <span class="text-xs font-medium text-gray-700">Pengumuman</span>
      </div>

      <!-- Berita -->
      <div class="flex flex-col items-center space-y-1">
        <div class="flex h-20 w-20 items-center justify-center rounded-xl bg-blue-100">
          <i data-lucide="newspaper" class="h-10 w-10 text-blue-600"></i>
        </div>
        <span class="text-xs font-medium text-gray-700">Berita</span>
      </div>

      <!-- Lihat Semua -->
      <a href="{{ route('semua-menu') }}" class="flex flex-col items-center space-y-1">
        <div class="flex h-20 w-20 items-center justify-center rounded-xl bg-gray-100">
          <i data-lucide="grid-3x3" class="h-10 w-10 text-gray-600"></i>
        </div>
        <span class="text-xs font-medium text-gray-700">Lihat Semua</span>
      </a>
    </div>
  </div>

  <!-- Achievements and Events -->
  <div class="mb-6 px-4">
    <div class="mb-4 flex items-center justify-between">
      <h3 class="text-lg font-bold text-gray-900">Prestasi dan Event Kegiatan</h3>
      <a href="#" class="text-sm font-medium text-purple-600">Lihat Semua</a>
    </div>

    <div class="flex space-x-4 overflow-x-auto pb-2">
      <div class="flex-shrink-0">
        <div class="flex h-48 w-72 items-center justify-center rounded-xl bg-gray-200">
          <span class="font-medium text-gray-500">600 × 400</span>
        </div>
      </div>
      <div class="flex-shrink-0">
        <div class="flex h-48 w-72 items-center justify-center rounded-xl bg-gray-200">
          <span class="font-medium text-gray-500">600 × 400</span>
        </div>
      </div>
      <div class="flex-shrink-0">
        <div class="flex h-48 w-72 items-center justify-center rounded-xl bg-gray-200">
          <span class="font-medium text-gray-500">600 × 400</span>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Balance toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
      const toggleButton = document.getElementById('toggleBalance');
      const eyeIcon = document.getElementById('eyeIcon');
      const eyeIconOn = document.getElementById('eyeIconOn');
      const balanceAmount = document.getElementById('balanceAmount');
      const balanceHidden = document.getElementById('balanceHidden');

      let isVisible = true;

      toggleButton.addEventListener('click', function() {
        if (isVisible) {
          // Hide balance
          balanceAmount.classList.add('hidden');
          balanceHidden.classList.remove('hidden');
          eyeIcon.classList.add('hidden');
          eyeIconOn.classList.remove('hidden');
          isVisible = false;
        } else {
          // Show balance
          balanceAmount.classList.remove('hidden');
          balanceHidden.classList.add('hidden');
          eyeIconOn.classList.add('hidden');
          eyeIcon.classList.remove('hidden');
          isVisible = true;
        }
      });
    });
  </script>
@endsection
