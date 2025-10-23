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

        <!-- Filter Toggle Button -->
        <div id="filter-toggle" class="mt-3" style="display: none;">
          <div class="flex items-center justify-between">
            <button onclick="toggleFilter()"
              class="flex items-center space-x-2 rounded-lg bg-gray-100 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200">
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z">
                </path>
              </svg>
              <span id="filter-toggle-text">Tampilkan Filter</span>
            </button>

            @if (request('bulan') || request('tahun'))
              <div class="flex items-center space-x-2">
                <span class="text-xs text-gray-500">Filter aktif:</span>
                @if (request('bulan'))
                  <span class="rounded-full bg-purple-100 px-2 py-1 text-xs font-medium text-purple-700">
                    {{ $bulanList[request('bulan')] ?? request('bulan') }}
                  </span>
                @endif
                @if (request('tahun'))
                  <span class="rounded-full bg-purple-100 px-2 py-1 text-xs font-medium text-purple-700">
                    {{ request('tahun') }}
                  </span>
                @endif
              </div>
            @endif
          </div>
        </div>
      </div>

      <!-- Bills List -->
      <div id="content-belum-lunas" class="space-y-4">
        @forelse($tagihanBelumLunas as $tagihan)
          <div class="rounded-lg bg-white p-4 shadow-sm">
            <div class="flex items-start justify-between">
              <div class="flex-1">
                <h3 class="font-bold text-gray-900">{{ $tagihan->tagihan }}
                  {{ $tagihan->nama_bulan != null ? ' - ' . $tagihan->nama_bulan : '' }} </h3>
                <div class="mt-2 flex items-center space-x-2">
                  <span
                    class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-600">{{ $tagihan->status_pembayaran_text }}</span>
                  <span
                    class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-600">{{ $tagihan->jenis_text }}</span>
                </div>
              </div>
              <div class="text-right">
                <p class="text-lg font-bold text-gray-900">Rp{{ number_format($tagihan->total, 0, ',', '.') }}</p>
                <button onclick="openPaymentModal({{ $tagihan->id }}, {{ $tagihan }})"
                  class="mt-2 rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200">
                  Bayar
                </button>
              </div>
            </div>
          </div>
        @empty
          <div class="rounded-lg bg-white p-8 text-center shadow-sm">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
              </path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada tagihan</h3>
            <p class="mt-1 text-sm text-gray-500">Semua tagihan sudah lunas.</p>
          </div>
        @endforelse
      </div>

      <!-- Filter Section -->
      <div id="filter-section" class="mb-6" style="display: none;">
        <div class="rounded-lg bg-white p-4 shadow-sm">
          <h3 class="mb-4 text-lg font-medium text-gray-900">Filter Riwayat</h3>

          <form id="filterForm" method="GET" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Bulan</label>
                <select name="bulan" id="filterBulan" class="w-full">
                  <option value="">Semua Bulan</option>
                  @foreach ($bulanList as $key => $bulan)
                    <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>
                      {{ $bulan }}</option>
                  @endforeach
                </select>
              </div>

              <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Tahun</label>
                <select name="tahun" id="filterTahun" class="w-full">
                  <option value="">Semua Tahun</option>
                  @foreach ($tahunList as $tahun)
                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                      {{ $tahun }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="flex space-x-3">
              <button type="submit" id="filterSubmitBtn"
                class="flex-1 rounded-lg bg-purple-600 px-4 py-2 font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                <span id="filterSubmitText">Terapkan Filter</span>
                <svg id="filterLoadingIcon" class="hidden h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                  </circle>
                  <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                  </path>
                </svg>
              </button>
              <button type="button" onclick="resetFilter()"
                class="flex-1 rounded-lg bg-gray-100 px-4 py-2 font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Reset
              </button>
            </div>

          </form>
        </div>
      </div>

      <!-- History Tab Content -->
      <div id="content-riwayat" class="space-y-4" style="display: none;">
        @if (request('bulan') || request('tahun'))
          <div class="rounded-lg bg-blue-50 p-3">
            <div class="flex items-center">
              <svg class="mr-2 h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <p class="text-sm text-blue-800">
                Menampilkan {{ $tagihanLunas->count() }} tagihan
                @if (request('bulan') && request('tahun'))
                  untuk {{ $bulanList[request('bulan')] ?? request('bulan') }} {{ request('tahun') }}
                @elseif(request('bulan'))
                  untuk bulan {{ $bulanList[request('bulan')] ?? request('bulan') }}
                @elseif(request('tahun'))
                  untuk tahun {{ request('tahun') }}
                @endif
              </p>
            </div>
          </div>
        @endif

        @forelse($tagihanLunas as $tagihan)
          <div class="rounded-lg bg-white p-4 shadow-sm">
            <div class="flex items-start justify-between">
              <div class="flex-1">
                <h3 class="font-bold text-gray-900">{{ $tagihan->tagihan }} - {{ $tagihan->nama_bulan }}
                  {{ $tagihan->tahun_ajaran }}</h3>
                <div class="mt-2 flex items-center space-x-2">
                  <span
                    class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-600">{{ $tagihan->status_pembayaran_text }}</span>
                  <span
                    class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-600">{{ $tagihan->jenis_text }}</span>
                </div>
                <p class="mt-1 text-sm text-gray-500">Dibayar pada
                  {{ $tagihan->tgl_bayar ? $tagihan->tgl_bayar->format('d M Y') : '-' }}</p>
              </div>
              <div class="text-right">
                <p class="text-lg font-bold text-gray-900">Rp{{ number_format($tagihan->total, 0, ',', '.') }}</p>
                <button onclick="viewReceipt({{ $tagihan->id }})"
                  class="mt-2 rounded-lg bg-blue-50 px-4 py-2 text-sm font-medium text-blue-600 hover:bg-blue-100">
                  Lihat Struk
                </button>
              </div>
            </div>
          </div>
        @empty
          <div class="rounded-lg bg-white p-8 text-center shadow-sm">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
              </path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada riwayat</h3>
            <p class="mt-1 text-sm text-gray-500">Belum ada pembayaran yang dilakukan.</p>
          </div>
        @endforelse
      </div>
    </div>
  </div>

  <!-- Payment Modal -->
  <div id="paymentModal" class="z-60 fixed inset-0 hidden overflow-y-auto transition-all duration-300 ease-in-out">
    <div class="flex min-h-screen items-center justify-center px-4 py-4">
      <div class="fixed inset-0 bg-black/30 backdrop-blur-sm transition-opacity duration-300"
        onclick="closePaymentModal()"></div>

      <div id="modalContent"
        class="relative w-full max-w-lg scale-95 transform overflow-hidden rounded-lg bg-white text-left opacity-0 shadow-xl transition-all duration-300 ease-in-out">
        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mt-3 w-full text-center sm:mt-0 sm:text-left">
              <h3 class="mb-4 text-lg font-medium leading-6 text-gray-900">Pembayaran Tagihan</h3>

              <form id="paymentForm" method="POST">
                @csrf

                <!-- Informasi Tagihan dalam Table -->
                <div class="mb-6 overflow-hidden rounded-lg border border-gray-200">
                  <table class="w-full">
                    <thead class="bg-gray-50">
                      <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Detail</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">Nominal</th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                      <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">Nama Tagihan</td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900" id="tagihanName"></td>
                      </tr>
                      <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">Nilai Tagihan</td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900" id="nilaiTagihan"></td>
                      </tr>
                      <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">Potongan</td>
                        <td class="px-4 py-3 text-sm font-medium text-green-600" id="potonganTagihan"></td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="px-4 py-3 text-sm font-semibold text-gray-900">Total Bayar</td>
                        <td class="px-4 py-3 text-sm font-bold text-purple-600" id="totalBayar"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <!-- Informasi Saldo -->
                <div class="mb-6 overflow-hidden rounded-lg border border-gray-200">
                  <table class="w-full">
                    <thead class="bg-blue-50">
                      <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-blue-700">Informasi Saldo</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-blue-700">Nominal</th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                      <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">Saldo Tersedia</td>
                        <td class="px-4 py-3 text-sm font-medium text-blue-600" id="saldoTersedia"></td>
                      </tr>
                      <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">Jumlah Bayar</td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900" id="jumlahBayarDisplay"></td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="px-4 py-3 text-sm font-semibold text-gray-900">Sisa Saldo</td>
                        <td class="px-4 py-3 text-sm font-bold text-green-600" id="sisaSaldo"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <!-- Hidden input untuk jumlah bayar -->
                <input type="hidden" id="jumlahBayar" name="jumlah_bayar" value="">
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
    let currentTagihan = 0;
    let currentSaldo = {{ $saldo }};
    let select2RetryCount = 0;
    const maxRetries = 10;

    function switchTab(tabName) {
      const contentElements = document.querySelectorAll('#content-belum-lunas, #content-riwayat');
      const tabButtons = document.querySelectorAll('#tab-belum-lunas, #tab-riwayat');
      const filterToggle = document.getElementById('filter-toggle');
      const filterSection = document.getElementById('filter-section');

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
        filterToggle.style.display = 'none';
        filterSection.style.display = 'none';

        // Destroy Select2 when switching away from riwayat tab
        destroySelect2();
      } else if (tabName === 'riwayat') {
        contentElements[1].style.display = 'block';
        tabButtons[1].className = 'flex-1 rounded-lg bg-purple-100 px-4 py-2 text-center font-medium text-purple-700';
        tabButtons[1].classList.add('rounded-l-none');
        filterToggle.style.display = 'block';

        // Re-initialize Select2 when switching to riwayat tab
        setTimeout(() => {
          initializeSelect2();
          // Verify Select2 is working
          setTimeout(() => {
            verifySelect2Working();
          }, 200);
        }, 100);
      }
    }

    function toggleFilter() {
      const filterSection = document.getElementById('filter-section');
      const filterToggleText = document.getElementById('filter-toggle-text');

      if (filterSection.style.display === 'none' || filterSection.style.display === '') {
        filterSection.style.display = 'block';
        filterToggleText.textContent = 'Sembunyikan Filter';

        // Initialize Select2 when filter section is shown
        setTimeout(() => {
          initializeSelect2();
          // Verify Select2 is working
          setTimeout(() => {
            verifySelect2Working();
          }, 200);
        }, 100);
      } else {
        filterSection.style.display = 'none';
        filterToggleText.textContent = 'Tampilkan Filter';

        // Destroy Select2 when filter section is hidden
        destroySelect2();
      }
    }

    function resetFilter() {
      // Reset Select2 values
      $('#filterBulan').val('').trigger('change');
      $('#filterTahun').val('').trigger('change');

      // Submit form
      document.getElementById('filterForm').submit();
    }

    function autoSubmitFilter() {
      showFilterLoading();
      // Delay sedikit untuk memberikan feedback visual
      setTimeout(() => {
        document.getElementById('filterForm').submit();
      }, 100);
    }

    function showFilterLoading() {
      const submitBtn = document.getElementById('filterSubmitBtn');
      const submitText = document.getElementById('filterSubmitText');
      const loadingIcon = document.getElementById('filterLoadingIcon');

      submitBtn.disabled = true;
      submitText.textContent = 'Memproses...';
      loadingIcon.classList.remove('hidden');
    }

    function hideFilterLoading() {
      const submitBtn = document.getElementById('filterSubmitBtn');
      const submitText = document.getElementById('filterSubmitText');
      const loadingIcon = document.getElementById('filterLoadingIcon');

      submitBtn.disabled = false;
      submitText.textContent = 'Terapkan Filter';
      loadingIcon.classList.add('hidden');
    }

    // Initialize with belum lunas tab active
    document.addEventListener('DOMContentLoaded', function() {
      switchTab('belum-lunas');

      // Add form submit listener
      const filterForm = document.getElementById('filterForm');
      if (filterForm) {
        filterForm.addEventListener('submit', function() {
          showFilterLoading();
        });
      }
    });

    // Listen for Select2 ready event from CDN fallback
    window.addEventListener('select2Ready', function() {
      console.log('Select2 ready event received, attempting initialization...');
      setTimeout(() => {
        initializeSelect2();
      }, 100);
    });

    function initializeSelect2() {
      // Check if jQuery and Select2 are available
      if (typeof $ === 'undefined' || typeof $.fn.select2 === 'undefined') {
        select2RetryCount++;
        if (select2RetryCount <= maxRetries) {
          console.log(`jQuery or Select2 not available, retrying in 500ms... (${select2RetryCount}/${maxRetries})`);
          setTimeout(() => {
            initializeSelect2();
          }, 500);
        } else {
          console.log('Max retries reached. jQuery or Select2 still not available.');
          console.log('Available globals:', Object.keys(window).filter(key => key.includes('$') || key.includes(
            'jQuery') || key.includes('select2')));
        }
        return;
      }

      console.log('jQuery and Select2 are available, proceeding with initialization');
      select2RetryCount = 0; // Reset counter on success

      // Check if elements exist
      const bulanElement = document.getElementById('filterBulan');
      const tahunElement = document.getElementById('filterTahun');

      if (!bulanElement || !tahunElement) {
        console.log('Filter elements not found');
        return;
      }

      // Destroy existing instances first
      try {
        if ($('#filterBulan').hasClass('select2-hidden-accessible')) {
          $('#filterBulan').select2('destroy');
        }
        if ($('#filterTahun').hasClass('select2-hidden-accessible')) {
          $('#filterTahun').select2('destroy');
        }
      } catch (e) {
        console.log('Error destroying existing Select2:', e);
      }

      // Initialize Select2 for bulan filter
      try {
        $('#filterBulan').select2({
          placeholder: 'Pilih Bulan',
          allowClear: true,
          width: '100%',
          language: {
            noResults: function() {
              return "Tidak ada bulan ditemukan";
            },
            searching: function() {
              return "Mencari...";
            }
          }
        });
        console.log('Select2 bulan initialized');
      } catch (e) {
        console.log('Error initializing Select2 bulan:', e);
      }

      // Initialize Select2 for tahun filter
      try {
        $('#filterTahun').select2({
          placeholder: 'Pilih Tahun',
          allowClear: true,
          width: '100%',
          language: {
            noResults: function() {
              return "Tidak ada tahun ditemukan";
            },
            searching: function() {
              return "Mencari...";
            }
          }
        });
        console.log('Select2 tahun initialized');
      } catch (e) {
        console.log('Error initializing Select2 tahun:', e);
      }

      // Handle change events for auto-submit
      $('#filterBulan, #filterTahun').off('change.select2').on('change.select2', function() {
        console.log('Select2 value changed:', $(this).val());
        autoSubmitFilter();
      });

      console.log('Select2 initialization completed');
    }

    function destroySelect2() {
      // Destroy Select2 instances if they exist
      try {
        if ($('#filterBulan').length && $('#filterBulan').hasClass('select2-hidden-accessible')) {
          $('#filterBulan').select2('destroy');
        }
        if ($('#filterTahun').length && $('#filterTahun').hasClass('select2-hidden-accessible')) {
          $('#filterTahun').select2('destroy');
        }
        console.log('Select2 destroyed successfully');
      } catch (error) {
        console.log('Error destroying Select2:', error);
      }
    }

    function verifySelect2Working() {
      const bulanSelect2 = $('#filterBulan').hasClass('select2-hidden-accessible');
      const tahunSelect2 = $('#filterTahun').hasClass('select2-hidden-accessible');

      console.log('Select2 Status Check:');
      console.log('- Bulan Select2:', bulanSelect2 ? 'Working' : 'Not Working');
      console.log('- Tahun Select2:', tahunSelect2 ? 'Working' : 'Not Working');

      if (!bulanSelect2 || !tahunSelect2) {
        console.log('Select2 not working properly, attempting re-initialization...');
        setTimeout(() => {
          initializeSelect2();
        }, 500);
      } else {
        console.log('Select2 is working correctly!');
      }
    }

    // Payment modal functions
    function openPaymentModal(tagihanId, dataTagihan) {
      currentTagihanId = tagihanId;
      currentTagihan = dataTagihan;

      // Hitung nilai tagihan, potongan, dan total
      const nilaiTagihan = dataTagihan.total || 0;
      const potongan = dataTagihan.potongan || 0;
      const totalBayar = nilaiTagihan - potongan;

      // Isi data ke table
      document.getElementById('tagihanName').textContent = dataTagihan.tagihan || 'Tagihan';
      document.getElementById('nilaiTagihan').textContent = 'Rp' + nilaiTagihan.toLocaleString('id-ID');
      document.getElementById('potonganTagihan').textContent = potongan > 0 ? 'Rp' + potongan.toLocaleString('id-ID') :
        'Rp0';
      document.getElementById('totalBayar').textContent = 'Rp' + totalBayar.toLocaleString('id-ID');

      // Isi informasi saldo
      document.getElementById('saldoTersedia').textContent = 'Rp' + currentSaldo.toLocaleString('id-ID');
      document.getElementById('jumlahBayarDisplay').textContent = 'Rp' + totalBayar.toLocaleString('id-ID');
      document.getElementById('sisaSaldo').textContent = 'Rp' + (currentSaldo - totalBayar).toLocaleString('id-ID');

      // Set hidden input untuk jumlah bayar
      document.getElementById('jumlahBayar').value = totalBayar;

      // Tampilkan modal dengan transisi
      const modal = document.getElementById('paymentModal');
      const modalContent = document.getElementById('modalContent');

      modal.classList.remove('hidden');

      // Trigger animation setelah modal ditampilkan
      setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
      }, 10);
    }


    function closePaymentModal() {
      const modal = document.getElementById('paymentModal');
      const modalContent = document.getElementById('modalContent');

      // Trigger animation untuk menutup modal
      modalContent.classList.remove('scale-100', 'opacity-100');
      modalContent.classList.add('scale-95', 'opacity-0');

      // Sembunyikan modal setelah animasi selesai
      setTimeout(() => {
        modal.classList.add('hidden');
        currentTagihanId = null;
        currentTagihan = 0;
      }, 300);
    }

    function submitPayment() {
      const form = document.getElementById('paymentForm');
      const formData = new FormData(form);

      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }

      const jumlahBayar = parseInt(document.getElementById('jumlahBayar').value);
      const nilaiTagihan = currentTagihan.total || 0;
      const potongan = currentTagihan.potongan || 0;
      const totalBayar = nilaiTagihan - potongan;

      // Validasi saldo tidak mencukupi
      if (totalBayar > currentSaldo) {
        showToast('Saldo tidak mencukupi', 'error');
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

    // View receipt function
    function viewReceipt(tagihanId) {
      window.open(`/tagihan/${tagihanId}/struk`, '_blank');
    }
  </script>
@endsection
