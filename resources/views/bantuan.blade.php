@extends('layouts.app')

@section('title', 'Bantuan - EduPay')

@section('content')

  <!-- Content -->
  <div class="px-4 py-6">
    <div class="mb-6">
      <h2 class="mb-4 text-xl font-bold text-gray-900">Pusat Bantuan</h2>
      <p class="text-gray-600">Temukan jawaban untuk pertanyaan Anda</p>
    </div>

    <!-- Search Box -->
    <div class="mb-6">
      <div class="relative">
        <input type="text" placeholder="Cari bantuan..."
          class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 pl-10 focus:border-transparent focus:ring-2 focus:ring-purple-500">
        <i data-lucide="search" class="absolute left-3 top-3.5 h-5 w-5 text-gray-400"></i>
      </div>
    </div>

    <!-- FAQ Categories -->
    <div class="space-y-4">
      <!-- Category 1 -->
      <div class="rounded-xl bg-white p-4 shadow-sm">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100">
              <i data-lucide="help-circle" class="h-5 w-5 text-blue-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Panduan Umum</p>
              <p class="text-sm text-gray-500">Cara menggunakan EduPay</p>
            </div>
          </div>
          <i data-lucide="chevron-right" class="h-5 w-5 text-gray-400"></i>
        </div>
      </div>

      <!-- Category 2 -->
      <div class="rounded-xl bg-white p-4 shadow-sm">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100">
              <i data-lucide="wallet" class="h-5 w-5 text-green-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Top Up & Saldo</p>
              <p class="text-sm text-gray-500">Cara mengisi saldo</p>
            </div>
          </div>
          <i data-lucide="chevron-right" class="h-5 w-5 text-gray-400"></i>
        </div>
      </div>

      <!-- Category 3 -->
      <div class="rounded-xl bg-white p-4 shadow-sm">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-purple-100">
              <i data-lucide="credit-card" class="h-5 w-5 text-purple-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Pembayaran</p>
              <p class="text-sm text-gray-500">Cara melakukan pembayaran</p>
            </div>
          </div>
          <i data-lucide="chevron-right" class="h-5 w-5 text-gray-400"></i>
        </div>
      </div>

      <!-- Category 4 -->
      <div class="rounded-xl bg-white p-4 shadow-sm">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-100">
              <i data-lucide="phone" class="h-5 w-5 text-orange-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Hubungi Kami</p>
              <p class="text-sm text-gray-500">Kontak customer service</p>
            </div>
          </div>
          <i data-lucide="chevron-right" class="h-5 w-5 text-gray-400"></i>
        </div>
      </div>
    </div>

    <!-- Contact Info -->
    <div class="mt-8 rounded-xl bg-purple-50 p-4">
      <h3 class="mb-2 font-semibold text-gray-900">Butuh Bantuan Lebih Lanjut?</h3>
      <p class="mb-3 text-sm text-gray-600">Tim customer service kami siap membantu Anda 24/7</p>
      <div class="flex space-x-2">
        <button class="flex-1 rounded-lg bg-purple-600 px-4 py-2 text-sm font-medium text-white">
          <i data-lucide="message-circle" class="mr-1 inline h-4 w-4"></i>
          Chat
        </button>
        <button class="flex-1 rounded-lg border border-purple-600 bg-white px-4 py-2 text-sm font-medium text-purple-600">
          <i data-lucide="phone" class="mr-1 inline h-4 w-4"></i>
          Call
        </button>
      </div>
    </div>
  </div>
@endsection
