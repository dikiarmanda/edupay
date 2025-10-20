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

    <!-- Features -->
    <div class="mb-6">
      <h3 class="mb-4 text-lg font-bold text-gray-900">Fitur Utama</h3>
      <div class="space-y-3">
        <div class="rounded-xl bg-white p-4 shadow-sm">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100">
              <i data-lucide="credit-card" class="h-5 w-5 text-blue-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Pembayaran Tagihan</p>
              <p class="text-sm text-gray-500">Bayar SPP, ujian, dan tagihan sekolah lainnya dengan mudah</p>
            </div>
          </div>
        </div>

        <div class="rounded-xl bg-white p-4 shadow-sm">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100">
              <i data-lucide="wallet" class="h-5 w-5 text-green-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Isi Saldo</p>
              <p class="text-sm text-gray-500">Top up saldo dengan berbagai metode pembayaran</p>
            </div>
          </div>
        </div>

        <div class="rounded-xl bg-white p-4 shadow-sm">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-100">
              <i data-lucide="receipt" class="h-5 w-5 text-orange-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Riwayat Transaksi</p>
              <p class="text-sm text-gray-500">Pantau semua transaksi dengan filter tanggal</p>
            </div>
          </div>
        </div>

        <div class="rounded-xl bg-white p-4 shadow-sm">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100">
              <i data-lucide="heart" class="h-5 w-5 text-red-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Donasi</p>
              <p class="text-sm text-gray-500">Berikan donasi untuk kegiatan sekolah</p>
            </div>
          </div>
        </div>

        <div class="rounded-xl bg-white p-4 shadow-sm">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-purple-100">
              <i data-lucide="shield-check" class="h-5 w-5 text-purple-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Keamanan</p>
              <p class="text-sm text-gray-500">Transaksi aman dengan PIN dan enkripsi</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Benefits -->
    <div class="mb-6">
      <h3 class="mb-4 text-lg font-bold text-gray-900">Keunggulan EduPay</h3>
      <div class="space-y-3">
        <div class="rounded-xl bg-white p-4 shadow-sm">
          <div class="flex items-start space-x-3">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100">
              <i data-lucide="check" class="h-4 w-4 text-green-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Pembayaran Cepat</p>
              <p class="text-sm text-gray-500">Transaksi diproses dalam hitungan detik</p>
            </div>
          </div>
        </div>

        <div class="rounded-xl bg-white p-4 shadow-sm">
          <div class="flex items-start space-x-3">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100">
              <i data-lucide="smartphone" class="h-4 w-4 text-blue-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Akses Mudah</p>
              <p class="text-sm text-gray-500">Bisa diakses kapan saja dan di mana saja</p>
            </div>
          </div>
        </div>

        {{-- <div class="rounded-xl bg-white p-4 shadow-sm">
          <div class="flex items-start space-x-3">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-purple-100">
              <i data-lucide="clock" class="h-4 w-4 text-purple-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">24/7 Tersedia</p>
              <p class="text-sm text-gray-500">Layanan tersedia setiap saat</p>
            </div>
          </div>
        </div> --}}

        <div class="rounded-xl bg-white p-4 shadow-sm">
          <div class="flex items-start space-x-3">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-orange-100">
              <i data-lucide="receipt" class="h-4 w-4 text-orange-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Riwayat Lengkap</p>
              <p class="text-sm text-gray-500">Semua transaksi tercatat dengan detail</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Contact Info -->
    <div class="mb-6">
      <h3 class="mb-4 text-lg font-bold text-gray-900">Informasi Kontak</h3>
      <div class="space-y-3">
        <div class="rounded-xl bg-white p-4 shadow-sm">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100">
              <i data-lucide="mail" class="h-5 w-5 text-gray-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Email</p>
              <p class="text-sm text-gray-500">support@edupay.com</p>
            </div>
          </div>
        </div>

        <div class="rounded-xl bg-white p-4 shadow-sm">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100">
              <i data-lucide="phone" class="h-5 w-5 text-gray-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Telepon</p>
              <p class="text-sm text-gray-500">+62 21 1234 5678</p>
            </div>
          </div>
        </div>

        <div class="rounded-xl bg-white p-4 shadow-sm">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100">
              <i data-lucide="clock" class="h-5 w-5 text-gray-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Jam Operasional</p>
              <p class="text-sm text-gray-500">Senin - Jumat: 08:00 - 17:00 WIB</p>
            </div>
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
