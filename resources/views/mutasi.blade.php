@extends('layouts.app')

@section('title', 'Mutasi - EduPay')

@push('styles')
@endpush

@section('content')

  <!-- Content -->
  <div class="mb-18 px-4 py-6">
    <!-- Header -->
    <x-header title="Mutasi Transaksi" backUrl="{{ route('dashboard') }}" />

    <!-- Filter Rentang Tanggal -->
    <form method="GET" action="{{ route('mutasi') }}" class="mb-4">
      <div class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-3">
        <div>
          <label for="start_date" class="mb-2 block text-sm font-medium text-gray-700">Tanggal Mulai</label>
          <input type="text" id="start_date" name="start_date" value="{{ $startDate }}"
            placeholder="Pilih tanggal mulai"
            class="w-full cursor-pointer rounded-lg border border-gray-300 px-3 py-2 focus:border-purple-500 focus:outline-none focus:ring-1 focus:ring-purple-500"
            readonly>
        </div>
        <div>
          <label for="end_date" class="mb-2 block text-sm font-medium text-gray-700">Tanggal Akhir</label>
          <input type="text" id="end_date" name="end_date" value="{{ $endDate }}"
            placeholder="Pilih tanggal akhir"
            class="w-full cursor-pointer rounded-lg border border-gray-300 px-3 py-2 focus:border-purple-500 focus:outline-none focus:ring-1 focus:ring-purple-500"
            readonly>
        </div>
        <div class="flex items-end">
          <x-button type="primary" as="submit" class="w-full">
            <i data-lucide="search" class="mr-2 h-5 w-5"></i>Filter
          </x-button>
        </div>
      </div>
    </form>

    <!-- Filter Options -->
    <div class="mb-4 flex space-x-2">
      <x-button href="{{ route('mutasi', array_merge(request()->query(), ['type' => 'all'])) }}"
        type="{{ $type === 'all' ? 'primary' : 'neutral' }}" class="text-sm">
        Semua
      </x-button>
      <x-button href="{{ route('mutasi', array_merge(request()->query(), ['type' => 'masuk'])) }}"
        type="{{ $type === 'masuk' ? 'primary' : 'neutral' }}" class="text-sm">
        Masuk
      </x-button>
      <x-button href="{{ route('mutasi', array_merge(request()->query(), ['type' => 'keluar'])) }}"
        type="{{ $type === 'keluar' ? 'primary' : 'neutral' }}" class="text-sm">
        Keluar
      </x-button>
    </div>

    <!-- Transaction List -->
    <div class="space-y-4">
      @if ($mutations->count() > 0)
        @foreach ($mutations as $mutation)
          <div class="rounded-xl bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-3">
                <div class="{{ $mutation['bg_color'] }} flex h-10 w-10 items-center justify-center rounded-full">
                  <i data-lucide="{{ $mutation['icon'] }}" class="{{ $mutation['text_color'] }} h-5 w-5"></i>
                </div>
                <div>
                  <p class="font-medium text-gray-900">{{ $mutation['information'] }}</p>
                  <p class="text-sm text-gray-500">{{ $mutation['formatted_date'] }}</p>
                </div>
              </div>
              <div class="text-right">
                <p class="{{ $mutation['text_color'] }} font-semibold">
                  {{ $mutation['is_credit'] ? '+' : '-' }}{{ $mutation['formatted_amount'] }}
                </p>
              </div>
            </div>
          </div>
        @endforeach
      @else
        <!-- Empty State -->
        <div class="rounded-xl bg-white p-8 text-center shadow-sm">
          <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
            <i data-lucide="receipt" class="h-8 w-8 text-gray-400"></i>
          </div>
          <h3 class="mb-2 text-lg font-semibold text-gray-900">Tidak Ada Transaksi</h3>
          <p class="text-gray-500">Tidak ada transaksi ditemukan untuk rentang tanggal yang dipilih.</p>
        </div>
      @endif
    </div>
  </div>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Initialize Flatpickr menggunakan fungsi yang sudah di-import
        if (typeof window.initializeFlatpickr === 'function') {
          window.initializeFlatpickr();
        }
      });
    </script>
  @endpush
@endsection
