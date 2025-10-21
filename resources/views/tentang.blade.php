@extends('layouts.app')

@section('title', 'Tentang EduPay - EduPay')

@section('content')
  <!-- Header -->
  <div class="bg-white px-4 py-4 shadow-sm">
    <div class="flex items-center space-x-3">
      <a href="{{ route('profil.index') }}" class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100">
        <i data-lucide="arrow-left" class="h-4 w-4 text-gray-600"></i>
      </a>
      <h1 class="text-xl font-bold text-gray-900">Tentang EduPay</h1>
    </div>
  </div>

  <!-- Content -->
  <div class="mb-18 px-4 py-6">
    <!-- App Info -->
    <div class="mb-6">
      <div class="rounded-xl bg-white p-6 shadow-sm">
        <div class="text-center">
          <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-purple-100">
            <i data-lucide="school" class="h-10 w-10 text-purple-600"></i>
          </div>
          <h2 class="mb-2 text-2xl font-bold text-gray-900">EduPay</h2>
          <p class="mb-4 text-lg text-gray-600">Platform Pembayaran Digital untuk Pendidikan</p>
          <div class="inline-flex items-center rounded-full bg-purple-100 px-3 py-1">
            <span class="text-sm font-semibold text-purple-600">Versi 1.0.0</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="rounded-xl bg-gray-50 p-6 text-center">
      <p class="text-sm text-gray-500">
        © 2025 EduPay. Semua hak dilindungi undang-undang.
      </p>
      <p class="mt-2 text-xs text-gray-400">
        Dibuat dengan ❤️ untuk kemudahan pembayaran pendidikan
      </p>
    </div>
  </div>

  <script>
    // Initialize Lucide icons
    lucide.createIcons();
    document.getElementById('navProfile').classList.add('active');
  </script>
@endsection
