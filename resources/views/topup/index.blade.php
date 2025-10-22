@extends('layouts.app')

@section('content')
  <div class="min-h-screen bg-gray-100">
    <!-- Tab Navigation -->
    <div class="bg-white shadow-sm">
      <div class="mx-auto max-w-md px-4 py-3">
        <div class="flex">
          <button id="tab-topup" onclick="switchTab('topup')">
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
      <div id="content-topup" class="rounded-2xl bg-white p-6 shadow-sm">
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
        @if ($transactions && $transactions->count() > 0)
          @foreach ($transactions as $transaction)
            <div class="rounded-lg bg-white p-4 shadow-sm">
              <div class="flex items-center justify-between">
                <div class="flex-1">
                  <h3 class="font-medium text-gray-900">{{ $transaction->product }}</h3>
                  <p class="text-sm text-gray-500">{{ $transaction->created_at->format('d M Y H:i') }}</p>
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
                  <p class="font-bold text-gray-900">{{ $transaction->formatted_amount }}</p>
                  @if ($transaction->status === 'success')
                    <button onclick="showTransactionDetail('{{ $transaction->trx_id }}')"
                      class="mt-2 flex items-center space-x-1 rounded-lg bg-purple-50 px-3 py-1 text-sm text-purple-600 hover:bg-purple-100">
                      <i data-lucide="file-text" class="h-4 w-4"></i>
                      <span>Lihat Detail</span>
                    </button>
                  @elseif($transaction->status === 'pending')
                    <div class="flex">
                      <button onclick="checkPaymentStatus('{{ $transaction->trx_id }}')"
                        class="mt-2 flex items-center space-x-1 rounded-lg bg-purple-50 px-3 py-1 text-sm text-purple-600 hover:bg-purple-100">
                        <i data-lucide="clock" class="h-4 w-4"></i><span>Cek Status</span></button>
                      <a href="{{ $transaction->gateway_url }}" target="_blank"
                        class="mt-2 flex items-center space-x-1 rounded-lg bg-blue-50 px-3 py-1 text-sm text-blue-600 hover:bg-blue-100">
                        <i data-lucide="credit-card" class="h-4 w-4"></i>
                        <span>Bayar</span>
                      </a>
                    </div>
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
      } else if (tabName === 'riwayat') {
        contentElements[1].style.display = 'block';
        tabButtons[1].className = 'flex-1 rounded-lg bg-purple-100 px-4 py-2 text-center font-medium text-purple-700';
        tabButtons[1].classList.add('rounded-l-none');
      }
    }

    // Initialize with riwayat tab active
    document.addEventListener('DOMContentLoaded', function() {
      switchTab('topup');
      document.getElementById('navDashboard').classList.add('active');
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
            if (data.data.paymentUrl) {
              window.location.href = data.data.paymentUrl;
            }

            // Refresh the page to show updated history
            setTimeout(() => {
              location.reload();
            }, 2000);
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

    function showTransactionDetail(trxId) {
      // Show transaction detail modal or redirect to detail page
      showToast(`Menampilkan detail transaksi: ${trxId}`, 'info');
    }

    function checkPaymentStatus(trxId) {
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
              location.reload();
            } else if (data.data.status === 'pending') {
              showToast('Pembayaran masih dalam proses...', 'info');
            } else {
              showToast('Pembayaran gagal atau dibatalkan', 'error');
            }
          } else {
            showToast(data.message || 'Gagal mengecek status pembayaran', 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showToast('Terjadi kesalahan saat mengecek status', 'error');
        });
    }
  </script>

  <style>
    .nominal-btn:active {
      transform: scale(0.98);
    }
  </style>
@endsection
