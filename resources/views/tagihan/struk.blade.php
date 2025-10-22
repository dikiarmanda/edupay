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
    <div class="mx-auto max-w-md px-4 py-6">
      <!-- Receipt Card -->
      <div class="rounded-lg bg-white p-6 shadow-sm">
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
            <span class="font-medium">{{ $tagihan->id }}</span>
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
      <div class="mt-6 space-y-3">
        <button onclick="printReceipt()"
          class="w-full rounded-lg bg-purple-600 px-4 py-3 font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
          Cetak Struk
        </button>

        <button onclick="shareReceipt()"
          class="w-full rounded-lg bg-gray-100 px-4 py-3 font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
          Bagikan Struk
        </button>
      </div>
    </div>
  </div>

  <script>
    function printReceipt() {
      window.print();
    }

    function shareReceipt() {
      if (navigator.share) {
        navigator.share({
          title: 'Struk Pembayaran EduPay',
          text: 'Struk pembayaran untuk {{ $tagihan->tagihan }} - {{ $tagihan->nama_bulan }} {{ $tagihan->tahun_ajaran }}',
          url: window.location.href
        });
      } else {
        // Fallback untuk browser yang tidak mendukung Web Share API
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
          alert('Link struk telah disalin ke clipboard');
        });
      }
    }

    // Print styles
    const printStyles = `
      <style>
        @media print {
          body * {
            visibility: hidden;
          }
          .print-area, .print-area * {
            visibility: visible;
          }
          .print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
          }
          .no-print {
            display: none !important;
          }
        }
      </style>
    `;

    document.head.insertAdjacentHTML('beforeend', printStyles);
  </script>
@endsection
