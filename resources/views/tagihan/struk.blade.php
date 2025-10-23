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
          <h1 class="text-lg font-semibold text-gray-900">Struk Pembayaran</h1>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="mb-18 mx-auto max-w-md px-4 py-6">
      <!-- Receipt Card -->
      <div class="print-area rounded-lg bg-white p-6 shadow-sm">
        <!-- Header -->
        <div class="mb-6 text-center">
          <h2 class="text-xl font-bold text-gray-900">EduPay</h2>
          <p class="text-sm text-gray-600">Sistem Pembayaran Sekolah</p>
          <div class="mt-2 h-px bg-gray-200"></div>
        </div>

        <!-- Payment Info -->
        <div class="space-y-4">
          <div class="flex justify-between">
            <span class="text-gray-600">No. Transaksi:</span>
            <span class="font-medium">{{ str_pad($tagihan->id, 8, '0', STR_PAD_LEFT) }}</span>
          </div>

          <div class="flex justify-between">
            <span class="text-gray-600">Tanggal:</span>
            <span class="font-medium">{{ $tagihan->tgl_bayar ? $tagihan->tgl_bayar->format('d M Y H:i') : '-' }}</span>
          </div>

          <div class="flex justify-between">
            <span class="text-gray-600">NISN:</span>
            <span class="font-medium">{{ $tagihan->nisn }}</span>
          </div>

          <div class="flex justify-between">
            <span class="text-gray-600">Nama:</span>
            <span class="font-medium">{{ $tagihan->nama }}</span>
          </div>

          <div class="flex justify-between">
            <span class="text-gray-600">Kelas:</span>
            <span class="font-medium">{{ $tagihan->kelas }}</span>
          </div>

          <div class="flex justify-between">
            <span class="text-gray-600">Tagihan:</span>
            <span class="font-medium">{{ $tagihan->tagihan }}</span>
          </div>

          <div class="flex justify-between">
            <span class="text-gray-600">Periode:</span>
            <span class="font-medium">{{ $tagihan->nama_bulan }} {{ $tagihan->tahun_ajaran }}</span>
          </div>

          <div class="mt-4 h-px bg-gray-200"></div>

          <div class="flex justify-between">
            <span class="text-gray-600">Total Tagihan:</span>
            <span class="font-medium">Rp{{ number_format($tagihan->total, 0, ',', '.') }}</span>
          </div>

          @if ($tagihan->potongan > 0)
            <div class="flex justify-between">
              <span class="text-gray-600">Potongan:</span>
              <span class="font-medium text-green-600">-Rp{{ number_format($tagihan->potongan, 0, ',', '.') }}</span>
            </div>
          @endif

          <div class="flex justify-between">
            <span class="text-gray-600">Total Bayar:</span>
            <span class="font-medium">Rp{{ number_format($tagihan->bayar, 0, ',', '.') }}</span>
          </div>

          <div class="mt-4 h-px bg-gray-200"></div>

          <div class="flex justify-between">
            <span class="text-gray-600">Status:</span>
            <span class="font-medium text-green-600">{{ $tagihan->status_pembayaran_text }}</span>
          </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
          <p class="text-xs text-gray-500">Terima kasih telah melakukan pembayaran</p>
          <p class="text-xs text-gray-500">Struk ini adalah bukti pembayaran yang sah</p>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="no-print mt-6 space-y-3">
        <a href="{{ route('tagihan.download-pdf', $tagihan->id) }}"
          class="block w-full rounded-lg bg-purple-600 px-4 py-3 text-center font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
          Cetak Struk (PDF)
        </a>

      </div>
    </div>
  </div>
@endsection
