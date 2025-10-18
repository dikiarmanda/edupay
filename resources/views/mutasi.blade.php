@extends('layouts.app')

@section('title', 'Mutasi - EduPay')

@section('content')

  <!-- Content -->
  <div class="px-4 py-6">
    <div class="mb-6">
      <h2 class="mb-4 text-xl font-bold text-gray-900">Mutasi Transaksi</h2>

      <!-- Filter Options -->
      <div class="mb-4 flex space-x-2">
        <button class="rounded-lg bg-purple-600 px-4 py-2 text-sm font-medium text-white">Semua</button>
        <button class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700">Masuk</button>
        <button class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700">Keluar</button>
      </div>
    </div>

    <!-- Transaction List -->
    <div class="space-y-4">
      <!-- Transaction Item 1 -->
      <div class="rounded-xl bg-white p-4 shadow-sm">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100">
              <i data-lucide="arrow-down" class="h-5 w-5 text-green-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Top Up Saldo</p>
              <p class="text-sm text-gray-500">12 Jan 2024, 14:30</p>
            </div>
          </div>
          <div class="text-right">
            <p class="font-semibold text-green-600">+Rp 100.000</p>
            <p class="text-xs text-gray-500">Berhasil</p>
          </div>
        </div>
      </div>

      <!-- Transaction Item 2 -->
      <div class="rounded-xl bg-white p-4 shadow-sm">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100">
              <i data-lucide="arrow-up" class="h-5 w-5 text-red-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Pembayaran SPP</p>
              <p class="text-sm text-gray-500">10 Jan 2024, 09:15</p>
            </div>
          </div>
          <div class="text-right">
            <p class="font-semibold text-red-600">-Rp 500.000</p>
            <p class="text-xs text-gray-500">Berhasil</p>
          </div>
        </div>
      </div>

      <!-- Transaction Item 3 -->
      <div class="rounded-xl bg-white p-4 shadow-sm">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100">
              <i data-lucide="credit-card" class="h-5 w-5 text-blue-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Pembayaran Ujian</p>
              <p class="text-sm text-gray-500">08 Jan 2024, 16:45</p>
            </div>
          </div>
          <div class="text-right">
            <p class="font-semibold text-red-600">-Rp 75.000</p>
            <p class="text-xs text-gray-500">Berhasil</p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
