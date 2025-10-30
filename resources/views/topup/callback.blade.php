@extends('layouts.app')

@section('title', 'Detail Top Up')

@section('content')
  <div class="w-full p-4">
    <div class="mb-4">
      <div class="mb-3">
        <a href="{{ route('topup.index') }}"
          class="inline-flex items-center space-x-2 text-sm text-gray-600 hover:text-gray-900">
          <i data-lucide="arrow-left" class="h-4 w-4"></i>
          <span>Kembali</span>
        </a>
      </div>
      <h1 class="text-xl font-semibold">Detail Top Up</h1>
      <p class="text-sm text-gray-500">Status dan rincian transaksi</p>
    </div>

    @isset($error)
      <div class="mb-4 rounded border border-red-200 bg-red-50 p-3 text-red-700">
        Terjadi kesalahan: {{ $error }}
      </div>
    @endisset

    <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
      @if ($detail)
        <div class="mb-4 grid grid-cols-1 gap-3">
          <div>
            <div class="text-xs text-gray-500">Kode Transaksi</div>
            <div class="font-medium">{{ $detail['trx_id'] ?? '-' }}</div>
          </div>
          <div>
            <div class="text-xs text-gray-500">Nama</div>
            <div class="font-medium">{{ $detail['customer_name'] ?? '-' }}</div>
          </div>
          <div>
            <div class="text-xs text-gray-500">Produk</div>
            <div class="font-medium">{{ $detail['product'] ?? 'Top Up Saldo' }}</div>
          </div>
          <div>
            <div class="text-xs text-gray-500">Nominal</div>
            <div class="font-semibold">
              @if (isset($detail['total_amount']))
                Rp {{ number_format((int) $detail['total_amount'], 0, ',', '.') }}
              @else
                -
              @endif
            </div>
          </div>
          <div>
            <div class="text-xs text-gray-500">Status</div>
            @php
              $status = $detail['status'] ?? 'pending';
              $badge = match ($status) {
                  'success' => 'bg-green-100 text-green-700 border-green-200',
                  'failed' => 'bg-red-100 text-red-700 border-red-200',
                  default => 'bg-yellow-100 text-yellow-700 border-yellow-200',
              };
              $text = match ($status) {
                  'success' => 'Berhasil',
                  'failed' => 'Gagal',
                  default => 'Tertunda',
              };
            @endphp
            <span
              class="{{ $badge }} inline-flex items-center rounded border px-2 py-0.5 text-xs">{{ $text }}</span>
          </div>
          <div>
            <div class="text-xs text-gray-500">Waktu Bayar</div>
            <div class="font-medium">{{ $detail['paid_at'] ?? '-' }}</div>
          </div>
          <div>
            <div class="text-xs text-gray-500">Reference</div>
            <div class="font-mono text-sm">{{ $detail['gateway_reference'] ?? '-' }}</div>
          </div>
        </div>

        @php
          $items = $detail['items'] ?? null;
          if (is_string($items)) {
              try {
                  $items = json_decode($items, true) ?: $items;
              } catch (\Throwable $e) {
              }
          }
        @endphp

        @if (is_array($items))
          <div class="mt-2">
            <div class="mb-2 text-sm font-semibold">Item</div>
            <div class="overflow-hidden rounded border border-gray-200">
              <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left">
                  <tr>
                    <th class="px-3 py-2">Nama</th>
                    <th class="px-3 py-2">Qty</th>
                    <th class="px-3 py-2">Harga</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($items as $it)
                    <tr class="border-t">
                      <td class="px-3 py-2">{{ $it['name'] ?? '-' }}</td>
                      <td class="px-3 py-2">{{ $it['quantity'] ?? 1 }}</td>
                      <td class="px-3 py-2">Rp {{ number_format((int) ($it['price'] ?? 0), 0, ',', '.') }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        @endif
      @else
        <div class="text-sm text-gray-600">Tidak ada data transaksi untuk ditampilkan.</div>
      @endif
    </div>

    <div class="mt-6">
      <a href="{{ route('dashboard') }}"
        class="flex w-full items-center justify-center space-x-2 rounded-lg bg-purple-600 px-4 py-3 font-medium text-white transition-colors hover:bg-purple-700">
        <span>Kembali</span>
      </a>
    </div>
  </div>
@endsection
