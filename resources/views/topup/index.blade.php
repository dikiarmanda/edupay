@extends('layouts.app')

@section('content')
  <div class="min-h-screen bg-gray-100">
    <!-- Tab Navigation -->
    <div class="bg-white shadow-sm">
      <div class="mx-auto max-w-md px-4 py-3">
        <div class="flex">
          <button id="tab-isi-saldo" onclick="switchTab('isi-saldo')">
            Isi Saldo
          </button>
          <button id="tab-riwayat" onclick="switchTab('riwayat')">
            Riwayat
          </button>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="mx-auto max-w-md px-4 py-6">
      <!-- Isi Saldo Tab Content -->
      <div id="content-isi-saldo" class="rounded-2xl bg-white p-6 shadow-sm">
        <!-- Title and Description -->
        <div class="mb-8">
          <h1 class="mb-2 text-2xl font-bold text-gray-900">Isi Saldo</h1>
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
        <button onclick="proceedToPayment()"
          class="w-full rounded-lg bg-purple-600 px-6 py-4 font-medium text-white transition-colors hover:bg-purple-700">
          Lanjut ke Pembayaran
        </button>
      </div>

      <!-- Riwayat Tab Content -->
      <div id="content-riwayat" class="space-y-4" style="display: none;">
        <!-- Transaction 1 - Berhasil -->
        <div class="rounded-lg bg-white p-4 shadow-sm">
          <div class="flex items-center justify-between">
            <div class="flex-1">
              <h3 class="font-medium text-gray-900">Isi Saldo via Transfer Bank</h3>
              <p class="text-sm text-gray-500">2024-07-28</p>
              <div class="mt-1 flex items-center space-x-2">
                <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-sm font-medium text-green-500">Berhasil</span>
              </div>
            </div>
            <div class="text-right">
              <p class="font-bold text-gray-900">Rp100.000</p>
              <button
                class="mt-2 flex items-center space-x-1 rounded-lg bg-purple-50 px-3 py-1 text-sm text-purple-600 hover:bg-purple-100">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                  </path>
                </svg>
                <span>Lihat Detail</span>
              </button>
            </div>
          </div>
        </div>

        <!-- Transaction 2 - Berhasil -->
        <div class="rounded-lg bg-white p-4 shadow-sm">
          <div class="flex items-center justify-between">
            <div class="flex-1">
              <h3 class="font-medium text-gray-900">Isi Saldo via e-Wallet</h3>
              <p class="text-sm text-gray-500">2024-07-25</p>
              <div class="mt-1 flex items-center space-x-2">
                <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-sm font-medium text-green-500">Berhasil</span>
              </div>
            </div>
            <div class="text-right">
              <p class="font-bold text-gray-900">Rp50.000</p>
              <button
                class="mt-2 flex items-center space-x-1 rounded-lg bg-purple-50 px-3 py-1 text-sm text-purple-600 hover:bg-purple-100">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                  </path>
                </svg>
                <span>Lihat Detail</span>
              </button>
            </div>
          </div>
        </div>

        <!-- Transaction 3 - Tertunda -->
        <div class="rounded-lg bg-white p-4 shadow-sm">
          <div class="flex items-center justify-between">
            <div class="flex-1">
              <h3 class="font-medium text-gray-900">Isi Saldo via Transfer Bank</h3>
              <p class="text-sm text-gray-500">2024-07-20</p>
              <div class="mt-1 flex items-center space-x-2">
                <svg class="h-4 w-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm font-medium text-yellow-500">Tertunda</span>
              </div>
            </div>
            <div class="text-right">
              <p class="font-bold text-gray-900">Rp250.000</p>
            </div>
          </div>
        </div>

        <!-- Transaction 4 - Gagal -->
        <div class="rounded-lg bg-white p-4 shadow-sm">
          <div class="flex items-center justify-between">
            <div class="flex-1">
              <h3 class="font-medium text-gray-900">Isi Saldo via Toko Retail</h3>
              <p class="text-sm text-gray-500">2024-07-18</p>
              <div class="mt-1 flex items-center space-x-2">
                <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                  </path>
                </svg>
                <span class="text-sm font-medium text-red-500">Gagal</span>
              </div>
            </div>
            <div class="text-right">
              <p class="font-bold text-gray-900">Rp75.000</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Include Toast Component -->
  @include('components.toast')

  <script>
    // Tab switching functionality
    function switchTab(tabName) {
      const contentElements = document.querySelectorAll('#content-isi-saldo, #content-riwayat');
      const tabButtons = document.querySelectorAll('#tab-isi-saldo, #tab-riwayat');

      contentElements.forEach(element => element.style.display = 'none');
      tabButtons.forEach(button => {
        button.className = 'flex-1 rounded-lg bg-gray-100 px-4 py-2 text-center font-medium text-gray-700';
        if (button.id == 'riwayat') {
            button.classList.add('rounded-r-none');
        } else {
            button.classList.add('rounded-l-none');
        }
      });

      if (tabName === 'isi-saldo') {
        contentElements[0].style.display = 'block';
        tabButtons[0].className = 'flex-1 rounded-lg bg-purple-100 px-4 py-2 text-center font-medium text-purple-700';
        tabButtons[0].classList.add('rounded-r-none');
      } else if (tabName === 'riwayat') {
        contentElements[1].style.display = 'block';
        tabButtons[1].className = 'flex-1 rounded-lg bg-purple-100 px-4 py-2 text-center font-medium text-purple-700';
        tabButtons[1].classList.add('rounded-l-none');
      }
    }

    // Initialize with riwayat tab active
    document.addEventListener('DOMContentLoaded', function() {
      switchTab('isi-saldo');
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

      // Show success toast
      showToast(`Proses pembayaran untuk jumlah Rp ${amount}`, 'success');
    }
  </script>

  <style>
    .nominal-btn:active {
      transform: scale(0.98);
    }
  </style>
@endsection
