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
          <h1 class="text-lg font-semibold text-gray-900">Tagihan</h1>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="mx-auto max-w-md px-4 py-6">
      <!-- Title and Description -->
      <div class="mb-6">
        <h1 class="mb-2 text-2xl font-bold text-gray-900">Tagihan</h1>
        <p class="text-sm text-gray-600">Lihat dan kelola semua tagihan sekolah Anda.</p>
      </div>

      <!-- Tab Navigation -->
      <div class="mb-4">
        <div class="flex">
          <button id="tab-belum-lunas" onclick="switchTab('belum-lunas')">
            Belum Lunas
          </button>
          <button id="tab-riwayat" onclick="switchTab('riwayat')">
            Riwayat
          </button>
        </div>
      </div>

      <!-- Date Range Selector -->
      <div class="mb-6">
        <button onclick="openDatePicker()"
          class="w-full rounded-lg border border-gray-200 bg-white px-4 py-3 text-left text-gray-600 hover:bg-gray-50">
          <div class="flex items-center space-x-3">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span>Pilih rentang tanggal</span>
          </div>
        </button>
      </div>

      <!-- Bills List -->
      <div id="content-belum-lunas" class="space-y-4">
        <!-- Bill 1 -->
        <div class="rounded-lg bg-white p-4 shadow-sm">
          <div class="flex items-start justify-between">
            <div class="flex-1">
              <h3 class="font-bold text-gray-900">SPP - Agustus 2024</h3>
              <div class="mt-2 flex items-center space-x-2">
                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-600">Belum Lunas</span>
              </div>
              <p class="mt-1 text-sm text-gray-500">Jatuh Tempo 2024-08-15</p>
            </div>
            <div class="text-right">
              <p class="text-lg font-bold text-gray-900">Rp750.000</p>
              <button onclick="payBill('SPP - Agustus 2024')"
                class="mt-2 rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200">
                Bayar
              </button>
            </div>
          </div>
        </div>

        <!-- Bill 2 -->
        <div class="rounded-lg bg-white p-4 shadow-sm">
          <div class="flex items-start justify-between">
            <div class="flex-1">
              <h3 class="font-bold text-gray-900">Biaya Transportasi - Agustus 2024</h3>
              <div class="mt-2 flex items-center space-x-2">
                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-600">Belum Lunas</span>
              </div>
              <p class="mt-1 text-sm text-gray-500">Jatuh Tempo 2024-08-15</p>
            </div>
            <div class="text-right">
              <p class="text-lg font-bold text-gray-900">Rp250.000</p>
              <button onclick="payBill('Biaya Transportasi - Agustus 2024')"
                class="mt-2 rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200">
                Bayar
              </button>
            </div>
          </div>
        </div>

        <!-- Bill 3 -->
        <div class="rounded-lg bg-white p-4 shadow-sm">
          <div class="flex items-start justify-between">
            <div class="flex-1">
              <h3 class="font-bold text-gray-900">Biaya Lab - Q2</h3>
              <div class="mt-2 flex items-center space-x-2">
                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-600">Jatuh Tempo</span>
              </div>
              <p class="mt-1 text-sm text-gray-500">Jatuh Tempo 2024-06-10</p>
            </div>
            <div class="text-right">
              <p class="text-lg font-bold text-gray-900">Rp100.000</p>
              <button onclick="payBill('Biaya Lab - Q2')"
                class="mt-2 rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200">
                Bayar
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- History Tab Content -->
      <div id="content-riwayat" class="space-y-4" style="display: none;">
        <!-- Paid Bill 1 -->
        <div class="rounded-lg bg-white p-4 shadow-sm">
          <div class="flex items-start justify-between">
            <div class="flex-1">
              <h3 class="font-bold text-gray-900">SPP - Juli 2024</h3>
              <div class="mt-2 flex items-center space-x-2">
                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-600">Lunas</span>
              </div>
              <p class="mt-1 text-sm text-gray-500">Dibayar pada 2024-07-10</p>
            </div>
            <div class="text-right">
              <p class="text-lg font-bold text-gray-900">Rp750.000</p>
              <button onclick="viewReceipt('SPP - Juli 2024')"
                class="mt-2 rounded-lg bg-blue-50 px-4 py-2 text-sm font-medium text-blue-600 hover:bg-blue-100">
                Lihat Struk
              </button>
            </div>
          </div>
        </div>

        <!-- Paid Bill 2 -->
        <div class="rounded-lg bg-white p-4 shadow-sm">
          <div class="flex items-start justify-between">
            <div class="flex-1">
              <h3 class="font-bold text-gray-900">Biaya Transportasi - Juli 2024</h3>
              <div class="mt-2 flex items-center space-x-2">
                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-600">Lunas</span>
              </div>
              <p class="mt-1 text-sm text-gray-500">Dibayar pada 2024-07-08</p>
            </div>
            <div class="text-right">
              <p class="text-lg font-bold text-gray-900">Rp250.000</p>
              <button onclick="viewReceipt('Biaya Transportasi - Juli 2024')"
                class="mt-2 rounded-lg bg-blue-50 px-4 py-2 text-sm font-medium text-blue-600 hover:bg-blue-100">
                Lihat Struk
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Include Toast Component -->
  @include('components.toast')

  <script>
    function switchTab(tabName) {
      const contentElements = document.querySelectorAll('#content-belum-lunas, #content-riwayat');
      const tabButtons = document.querySelectorAll('#tab-belum-lunas, #tab-riwayat');

      contentElements.forEach(element => element.style.display = 'none');
      tabButtons.forEach(button => {
        button.className = 'flex-1 rounded-lg bg-white px-4 py-2 text-center font-medium text-gray-700';
        if (button.id == 'tab-riwayat') {
          button.classList.add('rounded-l-none');
        } else {
          button.classList.add('rounded-r-none');
        }
      });

      if (tabName === 'belum-lunas') {
        contentElements[0].style.display = 'block';
        tabButtons[0].className = 'flex-1 rounded-lg bg-purple-100 px-4 py-2 text-center font-medium text-purple-700';
        tabButtons[0].classList.add('rounded-r-none');
      } else if (tabName === 'riwayat') {
        contentElements[1].style.display = 'block';
        tabButtons[1].className = 'flex-1 rounded-lg bg-purple-100 px-4 py-2 text-center font-medium text-purple-700';
        tabButtons[1].classList.add('rounded-l-none');
      }
    }

    // Initialize with belum lunas tab active
    document.addEventListener('DOMContentLoaded', function() {
      switchTab('belum-lunas');
    });

    // Date picker function
    function openDatePicker() {
      showToast('Fitur pemilihan tanggal akan segera tersedia', 'success');
    }

    // Pay bill function
    function payBill(billName) {
      showToast(`Memproses pembayaran untuk ${billName}`, 'success');
      // Here you can add logic to redirect to payment page
    }

    // View receipt function
    function viewReceipt(billName) {
      showToast(`Membuka struk untuk ${billName}`, 'success');
      // Here you can add logic to show receipt
    }
  </script>
@endsection
