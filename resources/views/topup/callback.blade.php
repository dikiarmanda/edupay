@extends('layouts.app')

@section('title', 'Detail Top Up')

@section('content')
  <div class="mb-18 w-full p-4">
    <div class="mb-6">
      <div class="mb-3">
        <a href="{{ route('topup.index') }}"
          class="inline-flex items-center space-x-2 text-sm text-gray-600 transition-colors hover:text-gray-900">
          <i data-lucide="arrow-left" class="h-4 w-4"></i>
          <span>Kembali</span>
        </a>
      </div>
      <h1 class="text-2xl font-semibold tracking-tight">Detail Top Up</h1>
      <p class="text-sm text-gray-500">Pantau status dan rincian transaksi Anda</p>
    </div>

    @isset($error)
      <div class="mb-5 flex items-start space-x-3 rounded-lg border border-red-200 bg-red-50 p-3 text-red-700">
        <i data-lucide="alert-triangle" class="mt-0.5 h-4 w-4"></i>
        <div>
          <div class="font-medium">Terjadi kesalahan</div>
          <div class="text-sm">{{ $error }}</div>
        </div>
      </div>
    @endisset

    <div class="grid grid-cols-1 gap-4">
      <div class="">
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
          @if ($detail)
            @php
              $status = $detail['status'] ?? 'pending';
              $badge = match ($status) {
                  'success' => 'bg-green-100 text-green-700 border-green-200',
                  'failed' => 'bg-red-100 text-red-700 border-red-200',
                  default => 'bg-yellow-100 text-yellow-700 border-yellow-200',
              };
              $icon = match ($status) {
                  'success' => 'check-circle-2',
                  'failed' => 'x-circle',
                  default => 'hourglass',
              };
              $text = match ($status) {
                  'success' => 'Berhasil',
                  'failed' => 'Gagal',
                  default => 'Tertunda',
              };
            @endphp

            <div class="mb-5 flex items-center justify-between">
              <div class="flex items-center gap-2">
                <span
                  class="{{ $badge }} inline-flex items-center gap-1.5 rounded-full border px-2.5 py-1 text-xs">
                  <i data-lucide="{{ $icon }}" class="h-3.5 w-3.5"></i>
                  {{ $text }}
                </span>
              </div>
              <div class="text-xs text-gray-500">
                @php $paidAt = $detail['paid_at'] ?? $detail['created_at']; @endphp
                @if ($paidAt)
                  {{ \Carbon\Carbon::parse($paidAt)->translatedFormat('d F Y H:i') }}
                @else
                  —
                @endif
              </div>
            </div>

            <div class="mb-6 rounded-lg bg-gradient-to-br from-purple-50 to-indigo-50 p-4">
              <div class="text-xs text-gray-500">Nominal</div>
              <div class="mt-1 text-3xl font-bold tracking-tight text-gray-900">
                @if (isset($detail['total_amount']))
                  Rp {{ number_format((int) $detail['total_amount'], 0, ',', '.') }}
                @else
                  -
                @endif
              </div>
            </div>

            <div class="space-y-1 rounded-lg border border-gray-200 p-4">
              <div class="text-xs text-gray-500">Nama</div>
              <div class="mt-0.5 font-medium">{{ $detail['customer_name'] ?? '-' }}</div>
              <div class="mt-3 text-xs text-gray-500">Kode Transaksi</div>
              <div class="mt-0.5 font-mono text-sm">{{ $detail['trx_id'] ?? '-' }}</div>
              <div class="mt-3 flex items-center justify-between">
                <div class="text-xs text-gray-500">Reference</div>
                @if (!empty($detail['gateway_reference']))
                  <button type="button"
                    class="inline-flex items-center gap-1 text-xs text-purple-600 hover:text-purple-700"
                    onclick="navigator.clipboard && navigator.clipboard.writeText('{{ $detail['gateway_reference'] }}').then(() => this.innerText='Disalin').catch(() => {});">
                    <i data-lucide="copy" class="h-3.5 w-3.5"></i> Salin
                  </button>
                @endif
              </div>
              <div class="mt-0.5 font-mono text-sm">{{ $detail['gateway_reference'] ?? '-' }}</div>
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
              <div class="mt-6">
                <div class="mb-2 flex items-center justify-between">
                  <div class="text-sm font-semibold">Rincian Item</div>
                </div>
                <div class="overflow-hidden rounded-lg border border-gray-200">
                  <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-600">
                      <tr>
                        <th class="px-3 py-2">Nama</th>
                        <th class="px-3 py-2">Qty</th>
                        <th class="px-3 py-2 text-right">Harga</th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                      @foreach ($items as $it)
                        <tr class="hover:bg-gray-50/50">
                          <td class="px-3 py-2">{{ $it['name'] ?? '-' }}</td>
                          <td class="px-3 py-2">{{ $it['quantity'] ?? 1 }}</td>
                          <td class="px-3 py-2 text-right">Rp {{ number_format((int) ($it['price'] ?? 0), 0, ',', '.') }}
                          </td>
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
      </div>


    </div>

    <div class="mt-6">
      <a href="{{ route('topup.index') }}"
        class="flex w-full items-center justify-center gap-2 rounded-lg bg-purple-600 px-4 py-3 text-sm font-medium text-white shadow-sm transition-colors hover:bg-purple-700">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        <span>Kembali</span>
      </a>
    </div>
  </div>
@endsection
