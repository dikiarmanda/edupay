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
          <h1 class="text-lg font-semibold text-gray-900">Detail Tagihan</h1>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="mx-auto max-w-md px-4 py-6">
      <!-- Tagihan Card -->
      <div class="mb-6 rounded-lg bg-white p-6 shadow-sm">
        <div class="mb-6 text-center">
          <h2 class="text-xl font-bold text-gray-900">{{ $tagihan->tagihan }}</h2>
          <p class="text-sm text-gray-600">{{ $tagihan->nama_bulan }} {{ $tagihan->tahun_ajaran }}</p>
        </div>

        <!-- Status Badge -->
        <div class="mb-6 text-center">
          @if ($tagihan->isLunas())
            <span class="inline-flex items-center rounded-full bg-green-100 px-4 py-2 text-sm font-medium text-green-800">
              <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              Lunas
            </span>
          @else
            <span class="inline-flex items-center rounded-full bg-red-100 px-4 py-2 text-sm font-medium text-red-800">
              <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                  clip-rule="evenodd"></path>
              </svg>
              Belum Lunas
            </span>
          @endif
        </div>

        <!-- Detail Info -->
        <div class="space-y-4">
          <div class="flex justify-between border-b border-gray-100 py-2">
            <span class="text-gray-600">NISN:</span>
            <span class="font-medium">{{ $tagihan->nisn }}</span>
          </div>

          <div class="flex justify-between border-b border-gray-100 py-2">
            <span class="text-gray-600">Nama:</span>
            <span class="font-medium">{{ $tagihan->nama }}</span>
          </div>

          <div class="flex justify-between border-b border-gray-100 py-2">
            <span class="text-gray-600">Kelas:</span>
            <span class="font-medium">{{ $tagihan->kelas }}</span>
          </div>

          <div class="flex justify-between border-b border-gray-100 py-2">
            <span class="text-gray-600">Jenis:</span>
            <span class="font-medium">{{ $tagihan->jenis_text }}</span>
          </div>

          <div class="flex justify-between border-b border-gray-100 py-2">
            <span class="text-gray-600">Total Tagihan:</span>
            <span class="font-medium">Rp{{ number_format($tagihan->total, 0, ',', '.') }}</span>
          </div>

          @if ($tagihan->potongan > 0)
            <div class="flex justify-between border-b border-gray-100 py-2">
              <span class="text-gray-600">Potongan:</span>
              <span class="font-medium text-green-600">-Rp{{ number_format($tagihan->potongan, 0, ',', '.') }}</span>
            </div>
          @endif

          <div class="flex justify-between border-b border-gray-100 py-2">
            <span class="text-gray-600">Sudah Bayar:</span>
            <span class="font-medium">Rp{{ number_format($tagihan->bayar, 0, ',', '.') }}</span>
          </div>

          <div class="flex justify-between border-b border-gray-100 py-2">
            <span class="text-gray-600">Sisa:</span>
            <span class="{{ $tagihan->sisa > 0 ? 'text-red-600' : 'text-green-600' }} font-medium">
              Rp{{ number_format($tagihan->sisa, 0, ',', '.') }}
            </span>
          </div>

          @if ($tagihan->tgl_bayar)
            <div class="flex justify-between border-b border-gray-100 py-2">
              <span class="text-gray-600">Tanggal Bayar:</span>
              <span class="font-medium">{{ $tagihan->tgl_bayar->format('d M Y H:i') }}</span>
            </div>
          @endif

          <div class="flex justify-between py-2">
            <span class="text-gray-600">Dibuat:</span>
            <span class="font-medium">{{ $tagihan->created_at->format('d M Y H:i') }}</span>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="space-y-3">
        @if (!$tagihan->isLunas())
          <button onclick="openPaymentModal({{ $tagihan->id }}, '{{ $tagihan->tagihan }}', {{ $tagihan->sisa }})"
            class="w-full rounded-lg bg-purple-600 px-4 py-3 font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
            Bayar Tagihan
          </button>
        @else
          <a href="{{ route('tagihan.struk', $tagihan->id) }}"
            class="block w-full rounded-lg bg-blue-600 px-4 py-3 text-center font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Lihat Struk
          </a>
        @endif

        <button onclick="history.back()"
          class="w-full rounded-lg bg-gray-100 px-4 py-3 font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
          Kembali
        </button>
      </div>
    </div>
  </div>

  <!-- Payment Modal -->
  <div id="paymentModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center px-4 pb-20 pt-4 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closePaymentModal()"></div>

      <div
        class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mt-3 w-full text-center sm:mt-0 sm:text-left">
              <h3 class="mb-4 text-lg font-medium leading-6 text-gray-900">Pembayaran Tagihan</h3>

              <form id="paymentForm" method="POST">
                @csrf
                <div class="mb-4">
                  <label class="mb-2 block text-sm font-medium text-gray-700">Tagihan</label>
                  <input type="text" id="tagihanName" readonly
                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-gray-600">
                </div>

                <div class="mb-4">
                  <label class="mb-2 block text-sm font-medium text-gray-700">Sisa Tagihan</label>
                  <input type="text" id="sisaTagihan" readonly
                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-gray-600">
                </div>

                <div class="mb-4">
                  <label class="mb-2 block text-sm font-medium text-gray-700">Jumlah Bayar <span
                      class="text-red-500">*</span></label>
                  <input type="number" id="jumlahBayar" name="jumlah_bayar" required min="1"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-purple-500 focus:outline-none focus:ring-1 focus:ring-purple-500">
                </div>

                <div class="mb-4">
                  <label class="mb-2 block text-sm font-medium text-gray-700">Metode Pembayaran <span
                      class="text-red-500">*</span></label>
                  <select name="metode_pembayaran" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-purple-500 focus:outline-none focus:ring-1 focus:ring-purple-500">
                    <option value="">Pilih Metode</option>
                    <option value="transfer">Transfer Bank</option>
                    <option value="bank">Bank Transfer</option>
                    <option value="ewallet">E-Wallet</option>
                  </select>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
          <button type="button" onclick="submitPayment()"
            class="inline-flex w-full justify-center rounded-lg border border-transparent bg-purple-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
            Bayar Sekarang
          </button>
          <button type="button" onclick="closePaymentModal()"
            class="mt-3 inline-flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:ml-3 sm:mt-0 sm:w-auto sm:text-sm">
            Batal
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Include Toast Component -->
  @include('components.toast')

  <script>
    let currentTagihanId = null;
    let currentSisaTagihan = 0;

    // Payment modal functions
    function openPaymentModal(tagihanId, tagihanName, sisaTagihan) {
      currentTagihanId = tagihanId;
      currentSisaTagihan = sisaTagihan;

      document.getElementById('tagihanName').value = tagihanName;
      document.getElementById('sisaTagihan').value = 'Rp' + sisaTagihan.toLocaleString('id-ID');
      document.getElementById('jumlahBayar').max = sisaTagihan;
      document.getElementById('jumlahBayar').value = '';

      document.getElementById('paymentModal').classList.remove('hidden');
    }

    function closePaymentModal() {
      document.getElementById('paymentModal').classList.add('hidden');
      currentTagihanId = null;
      currentSisaTagihan = 0;
    }

    function submitPayment() {
      const form = document.getElementById('paymentForm');
      const formData = new FormData(form);

      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }

      const jumlahBayar = parseInt(document.getElementById('jumlahBayar').value);

      if (jumlahBayar > currentSisaTagihan) {
        showToast('Jumlah bayar tidak boleh melebihi sisa tagihan', 'error');
        return;
      }

      // Submit form
      fetch(`/tagihan/${currentTagihanId}/bayar`, {
          method: 'POST',
          body: formData,
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            showToast('Pembayaran berhasil diproses', 'success');
            closePaymentModal();
            location.reload();
          } else {
            showToast(data.message || 'Terjadi kesalahan', 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showToast('Terjadi kesalahan saat memproses pembayaran', 'error');
        });
    }
  </script>
@endsection
