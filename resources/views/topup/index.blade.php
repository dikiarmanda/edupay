@extends('layouts.app')

@section('content')
  <div class="mb-18 w-full p-4">
    <!-- Header -->
    <x-header title="Isi Saldo" backUrl="{{ route('dashboard') }}" />

    <!-- Tab Navigation -->
    <div class="mb-4">
      <div class="flex">
        <button id="tab-topup" onclick="switchTab('topup')">
          Isi Saldo
        </button>
        <button id="tab-riwayat" onclick="switchTab('riwayat')">
          Riwayat
        </button>
      </div>
    </div>

    <!-- Main Content -->
    <div class="mx-auto">
      <!-- Isi Saldo Tab Content -->
      <div id="content-topup" class="mb-18 rounded-2xl border border-gray-200 p-6 shadow-sm">

        <div class="mb-5">
          <p class="text-sm leading-relaxed text-gray-600">
            Pilih jumlah dan metode pembayaran untuk menambahkan dana ke akun Anda.
          </p>
        </div>

        <!-- Select Amount Section -->
        <div class="mb-8">
          <h2 class="mb-4 text-lg font-semibold text-gray-900">Pilih Jumlah (Rp)</h2>
          <div class="grid grid-cols-2 gap-3">
            <button onclick="selectAmount(50000)"
              class="nominal-btn rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-center font-medium text-gray-700 transition-colors hover:bg-gray-100">
              50.000
            </button>
            <button onclick="selectAmount(100000)"
              class="nominal-btn rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-center font-medium text-gray-700 transition-colors hover:bg-gray-100">
              100.000
            </button>
            <button onclick="selectAmount(250000)"
              class="nominal-btn rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-center font-medium text-gray-700 transition-colors hover:bg-gray-100">
              250.000
            </button>
            <button onclick="selectAmount(500000)"
              class="nominal-btn rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-center font-medium text-gray-700 transition-colors hover:bg-gray-100">
              500.000
            </button>
          </div>
        </div>

        <!-- Custom Amount Section -->
        <div class="mb-8">
          <h2 class="mb-4 text-lg font-semibold text-gray-900">Atau Masukkan Jumlah Lain (Rp)</h2>
          <input type="text" id="customAmount" placeholder="contoh: 75000"
            class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-purple-500">
        </div>

        <!-- Continue Button -->
        <x-button type="primary" onclick="proceedToPayment()" class="w-full py-4">
          Lanjut ke Pembayaran
        </x-button>
      </div>

      <!-- Filter Toggle Button -->
      <div id="filter-toggle" class="mb-3" style="display: none;">
        <div class="flex items-center justify-between">
          <x-button type="neutral" onclick="toggleFilter()">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z">
              </path>
            </svg>
            <span id="filter-toggle-text">Tampilkan Filter</span>
          </x-button>
        </div>
      </div>

      <!-- Filter Section -->
      <div id="filter-section" class="mb-6" style="display: none;">
        <div class="rounded-lg border border-gray-200 p-4 shadow-sm">
          <form id="filterForm" method="GET" action="{{ route('topup.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
              <div>
                <label for="start_date" class="mb-2 block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="text" id="start_date" name="start_date" value="{{ request('start_date') }}"
                  placeholder="Pilih tanggal mulai"
                  class="w-full cursor-pointer rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:outline-none focus:ring-1 focus:ring-purple-500"
                  readonly>
              </div>
              <div>
                <label for="end_date" class="mb-2 block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                <input type="text" id="end_date" name="end_date" value="{{ request('end_date') }}"
                  placeholder="Pilih tanggal akhir"
                  class="w-full cursor-pointer rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:outline-none focus:ring-1 focus:ring-purple-500"
                  readonly>
              </div>
              <div class="flex items-end space-x-2">
                <x-button type="primary" as="submit" id="filterSubmitBtn" class="w-full">
                  <span id="filterSubmitText">Filter</span>
                  <i data-lucide="search" class="ml-2 h-4 w-4"></i>
                </x-button>
              </div>
              <div class="col-span-3">
                <x-button type="neutral" onclick="resetFilter()" class="w-full">
                  Reset
                </x-button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Riwayat Tab Content -->
      <div id="content-riwayat" class="mb-18 space-y-4" style="display: none;">
        @if (request('start_date') || request('end_date'))
          <div class="rounded-lg bg-blue-50 p-3">
            <div class="flex items-center">
              <svg class="mr-2 h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <p class="text-sm text-blue-800">
                Menampilkan {{ $transactions->count() }} riwayat transaksi
                @if (request('start_date') && request('end_date'))
                  dari
                  {{ \Carbon\Carbon::parse(request('start_date'))->translatedFormat('d M Y') }} sampai
                  {{ \Carbon\Carbon::parse(request('end_date'))->translatedFormat('d M Y') }}
                @endif
              </p>
            </div>
          </div>
        @endif

        @if ($transactions && $transactions->count() > 0)
          @foreach ($transactions as $transaction)
            <div class="rounded-lg border border-gray-200 p-4 shadow-sm">
              <div class="flex items-center justify-between">
                <div class="flex-1">
                  <h3 class="font-medium text-gray-900">{{ $transaction->product }}</h3>
                  <p class="text-sm text-gray-500">{{ $transaction->created_at->translatedFormat('d M Y H:i') }}</p>
                  <div class="mt-1 flex items-center space-x-2">
                    @if ($transaction->status === 'success')
                      <i data-lucide="check-circle" class="h-4 w-4 text-green-500"></i>
                      <span class="text-sm font-medium text-green-500">{{ $transaction->status_text }}</span>
                    @elseif($transaction->status === 'pending')
                      <i data-lucide="clock" class="h-4 w-4 text-yellow-500"></i>
                      <span class="text-sm font-medium text-yellow-500">{{ $transaction->status_text }}</span>
                    @else
                      <i data-lucide="x-circle" class="h-4 w-4 text-red-500"></i>
                      <span class="text-sm font-medium text-red-500">{{ $transaction->status_text }}</span>
                    @endif
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-xl font-bold text-gray-900">
                    Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                  </p>
                  @if ($transaction->status === 'pending')
                    <div class="flex space-x-1">
                      <x-button type="inverse" onclick="checkPaymentStatus('{{ $transaction->trx_id }}')"
                        class="mt-2 py-1 text-sm">
                        Cek Status
                      </x-button>
                      <x-button type="success" href="{{ $transaction->gateway_url }}" target="_blank"
                        class="mt-2 py-1 text-sm">
                        <i data-lucide="credit-card" class="mr-1 h-4 w-4"></i>
                        <span>Bayar</span>
                      </x-button>
                    </div>
                  @else
                    <x-button type="inverse" href="{{ route('topup.callback', ['trx_id' => $transaction->trx_id]) }}"
                      class="mt-2 py-1 text-sm">
                      <i data-lucide="file-text" class="mr-1 h-4 w-4"></i>
                      <span>Lihat Detail</span>
                    </x-button>
                  @endif
                </div>
              </div>
            </div>
          @endforeach
        @else
          <div class="rounded-lg bg-white p-8 text-center shadow-sm">
            <i data-lucide="file-text" class="mx-auto h-12 w-12 text-gray-400"></i>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada riwayat</h3>
            <p class="mt-1 text-sm text-gray-500">Mulai dengan melakukan top-up saldo pertama Anda.</p>
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Include Toast Component -->
  @include('components.toast')

  <script>
    // Tab switching functionality
    function switchTab(tabName) {
      const contentElements = document.querySelectorAll('#content-topup, #content-riwayat');
      const tabButtons = document.querySelectorAll('#tab-topup, #tab-riwayat');
      const filterToggle = document.getElementById('filter-toggle');
      const filterSection = document.getElementById('filter-section');

      contentElements.forEach(element => element.style.display = 'none');
      tabButtons.forEach(button => {
        button.className = 'flex-1 rounded-lg bg-gray-100 px-4 py-2 text-center font-medium text-gray-700';
        if (button.id == 'tab-riwayat') {
          button.classList.add('rounded-l-none');
        } else {
          button.classList.add('rounded-r-none');
        }
      });

      if (tabName === 'topup') {
        contentElements[0].style.display = 'block';
        tabButtons[0].className = 'flex-1 rounded-lg bg-purple-100 px-4 py-2 text-center font-medium text-purple-700';
        tabButtons[0].classList.add('rounded-r-none');
        filterToggle.style.display = 'none';
        filterSection.style.display = 'none';
      } else if (tabName === 'riwayat') {
        contentElements[1].style.display = 'block';
        tabButtons[1].className = 'flex-1 rounded-lg bg-purple-100 px-4 py-2 text-center font-medium text-purple-700';
        tabButtons[1].classList.add('rounded-l-none');
        filterToggle.style.display = 'block';
      }
    }

    // Initialize with riwayat tab active
    document.addEventListener('DOMContentLoaded', function() {
      // Check if we have filter parameters in URL
      const urlParams = new URLSearchParams(window.location.search);
      const hasFilter = urlParams.has('start_date') || urlParams.has('end_date');

      // If coming from filtered view, show riwayat tab
      if (hasFilter) {
        switchTab('riwayat');
        // Show filter section if filter is active
        const filterSection = document.getElementById('filter-section');
        const filterToggle = document.getElementById('filter-toggle');
        const filterToggleText = document.getElementById('filter-toggle-text');

        if (filterSection) {
          filterSection.style.display = 'block';
          filterToggleText.textContent = 'Sembunyikan Filter';
        }

        // Initialize Flatpickr when filter is shown
        setTimeout(() => {
          if (typeof window.initializeFlatpickr === 'function') {
            window.initializeFlatpickr();
          }
        }, 100);
      } else {
        switchTab('topup');
      }
    });

    document.getElementById('customAmount').addEventListener('input', function(e) {
      const selectionStart = e.target.selectionStart;

      // Ambil nilai mentah
      let value = e.target.value.replace(/\D/g, '');

      if (value) {
        // Ubah ke number
        const numberValue = parseInt(value, 10);

        // Format dengan pemisah ribuan
        const formattedValue = numberValue.toLocaleString('id-ID');

        // Update nilai
        e.target.value = formattedValue;

        // Pindahkan kursor ke akhir
        e.target.setSelectionRange(formattedValue.length, formattedValue.length);
      } else {
        e.target.value = '';
      }
    });

    function selectAmount(amount) {
      // Clear custom input
      document.getElementById('customAmount').value = '';

      // Remove active class from all buttons
      document.querySelectorAll('.nominal-btn').forEach(btn => {
        btn.classList.remove('bg-purple-100', 'border-purple-300', 'text-purple-700');
        btn.classList.add('bg-gray-50', 'border-gray-200', 'text-gray-700');
      });

      // Add active class to clicked button
      event.target.classList.remove('bg-gray-50', 'border-gray-200', 'text-gray-700');
      event.target.classList.add('bg-purple-100', 'border-purple-300', 'text-purple-700');

      // Store selected amount
      document.getElementById('customAmount').value = amount.toLocaleString('id-ID');
    }

    function proceedToPayment() {
      let amount = document.getElementById('customAmount').value;

      if (!amount || amount <= 0) {
        showToast('Silakan pilih atau masukkan jumlah yang valid', 'error');
        return;
      }

      // Convert formatted amount to number
      let numericAmount = parseInt(amount.replace(/\./g, ''), 10);

      if (numericAmount < 10000) {
        showToast('Minimum top-up adalah Rp 10.000', 'error');
        return;
      }

      if (numericAmount > 10000000) {
        showToast('Maximum top-up adalah Rp 10.000.000', 'error');
        return;
      }

      // Show loading state
      const button = event.target;
      const originalText = button.textContent;
      button.textContent = 'Memproses...';
      button.disabled = true;

      // Call API to create invoice
      fetch('/topup/create-invoice', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({
            amount: numericAmount
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            showToast('Invoice berhasil dibuat! Silakan lakukan pembayaran.', 'success');

            // Redirect to payment URL if available
            if (data.data.payment_url) {
              console.log('redirect...');
              window.location.href = data.data.payment_url;
            }

            // Refresh the page to show updated history
            setTimeout(() => {
              location.reload();
            }, 10000);
          } else {
            showToast(data.message || 'Gagal membuat invoice', 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showToast('Terjadi kesalahan saat memproses pembayaran', 'error');
        })
        .finally(() => {
          // Reset button state
          button.textContent = originalText;
          button.disabled = false;
        });
    }

    function checkPaymentStatus(trxId) {
      const button = event.target;
      button.textContent = 'Proses Cek...';
      button.disabled = true;

      fetch('/topup/check-status', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({
            trx_id: trxId
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            if (data.data.status === 'success') {
              showToast('Pembayaran berhasil! Saldo telah ditambahkan.', 'success');
            } else if (data.data.status === 'pending') {
              showToast('Pembayaran masih dalam proses...', 'info');
            } else {
              showToast('Pembayaran gagal atau dibatalkan', 'error');
            }
            location.reload();
          } else {
            showToast(data.message || 'Gagal mengecek status pembayaran', 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showToast('Terjadi kesalahan saat mengecek status', 'error');
        });
    }

    function toggleFilter() {
      const filterSection = document.getElementById('filter-section');
      const filterToggleText = document.getElementById('filter-toggle-text');

      if (filterSection.style.display === 'none' || filterSection.style.display === '') {
        filterSection.style.display = 'block';
        filterToggleText.textContent = 'Sembunyikan Filter';

        // Initialize Flatpickr when filter is shown
        setTimeout(() => {
          if (typeof window.initializeFlatpickr === 'function') {
            window.initializeFlatpickr();
          }
        }, 100);
      } else {
        filterSection.style.display = 'none';
        filterToggleText.textContent = 'Tampilkan Filter';
      }
    }

    function resetFilter() {
      // Reset date values
      const today = new Date();
      const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);

      document.getElementById('start_date').value =
        `${firstDayOfMonth.getFullYear()}-${String(firstDayOfMonth.getMonth() + 1).padStart(2, '0')}-${String(firstDayOfMonth.getDate()).padStart(2, '0')}`;
      document.getElementById('end_date').value =
        `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;

      // Submit form
      document.getElementById('filterForm').submit();
    }

    function showTransactionDetail(trxId) {
      // Show transaction detail modal or redirect to detail page
      showToast(`Menampilkan detail transaksi: ${trxId}`, 'info');
    }
  </script>

  <style>
    .nominal-btn:active {
      transform: scale(0.98);
    }
  </style>
@endsection
