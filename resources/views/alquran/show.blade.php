@extends('layouts.app')

@section('title', 'Detail Surat - EduPay')

@section('content')
  <!-- Header -->
  <div class="bg-white px-4 py-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <button onclick="history.back()" class="rounded-lg p-2 hover:bg-gray-100">
          <i data-lucide="arrow-left" class="h-6 w-6 text-gray-600"></i>
        </button>
        <div>
          <h1 id="surat-title" class="text-xl font-bold text-gray-900">-</h1>
          <p id="surat-subtitle" class="text-sm text-gray-500">-</p>
        </div>
      </div>
      <div class="flex items-center space-x-2">
        <button id="prev-ayat" onclick="navigateAyat(-1)"
          class="rounded-lg bg-gray-100 px-3 py-2 text-sm hover:bg-gray-200 disabled:cursor-not-allowed disabled:opacity-50">
          <i data-lucide="chevron-left" class="h-4 w-4"></i>
        </button>
        <button id="next-ayat" onclick="navigateAyat(1)"
          class="rounded-lg bg-gray-100 px-3 py-2 text-sm hover:bg-gray-200 disabled:cursor-not-allowed disabled:opacity-50">
          <i data-lucide="chevron-right" class="h-4 w-4"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Loading State -->
  <div id="loading" class="px-4 py-8 text-center">
    <div class="inline-block h-8 w-8 animate-spin rounded-full border-b-2 border-purple-600"></div>
    <p class="mt-2 text-gray-500">Memuat surat...</p>
  </div>

  <!-- Error State -->
  <div id="error" class="hidden px-4 py-8 text-center">
    <div class="rounded-lg bg-red-50 p-4">
      <i data-lucide="alert-circle" class="mx-auto mb-2 h-8 w-8 text-red-500"></i>
      <p class="font-medium text-red-700">Gagal memuat surat</p>
      <p class="mt-1 text-sm text-red-600">Silakan coba lagi nanti</p>
      <button onclick="loadSuratDetail()"
        class="mt-3 rounded-lg bg-red-600 px-4 py-2 text-sm text-white hover:bg-red-700">
        Coba Lagi
      </button>
    </div>
  </div>

  <!-- Main Content -->
  <div id="main-content" class="pb-18 hidden">
    <!-- Ayat Navigation Info -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-4 py-3 text-white">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-purple-100">Ayat ke</p>
          <p id="current-ayat-info" class="text-lg font-semibold">-</p>
        </div>
        <div class="text-right">
          <p class="text-sm text-purple-100">Total ayat</p>
          <p id="total-ayat-info" class="text-lg font-semibold">-</p>
        </div>
      </div>
    </div>

    <!-- Ayat Content -->
    <div class="px-4 py-6">
      <div id="ayat-content" class="space-y-4">
        <!-- Ayat content will be loaded here -->
      </div>
    </div>

    <!-- Ayat List Navigation -->
    <div class="px-4 pb-6">
      <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
        <div class="flex items-center space-x-3">
          <label class="w-1/2 text-sm font-medium text-gray-700">Pilih Ayat:</label>
          <select id="ayat-selector"
            class="w-1/2 rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2 focus:ring-purple-500">
            <option value="">Memuat...</option>
          </select>
        </div>
      </div>
    </div>
  </div>

  @include('components.toast')

  @push('styles')
    <style>
      /* Custom styling untuk Al-Quran */
      .ayat-arabic {
        font-family: 'Amiri', 'Scheherazade', 'Arial Unicode MS', serif;
        font-size: 1.8rem;
        line-height: 2.8;
        text-align: right;
        direction: rtl;
        margin-bottom: 1rem;
      }

      .ayat-translation {
        font-size: 1rem;
        line-height: 1.7;
        color: #4b5563;
        margin-bottom: 0.5rem;
      }

      .ayat-number {
        font-size: 0.9rem;
        color: #7c3aed;
        font-weight: 600;
      }

      .ayat-button {
        transition: all 0.2s ease;
      }

      .ayat-button:hover {
        transform: translateY(-1px);
      }

      .ayat-button.active {
        background-color: #7c3aed;
        color: white;
      }

      .ayat-button.active:hover {
        background-color: #6d28d9;
      }
    </style>
  @endpush

  @push('scripts')
    <script>
      let currentSurat = null;
      let currentAyatIndex = 0;
      let suratNumber = null;

      // Get surat number from URL
      function getSuratNumber() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('surat');
      }

      // Load surat detail
      async function loadSuratDetail() {
        try {
          suratNumber = getSuratNumber();
          if (!suratNumber) {
            showToast('Nomor surat tidak ditemukan');
          }

          document.getElementById('loading').classList.remove('hidden');
          document.getElementById('error').classList.add('hidden');
          document.getElementById('main-content').classList.add('hidden');

          const response = await fetch(`/api/alquran/surat-detail?nomor=${suratNumber}`);
          const result = await response.json();

          if (result.success) {
            currentSurat = result.data;
            currentAyatIndex = 0;

            // Update header
            document.getElementById('surat-title').textContent =
              `${currentSurat.number}. ${currentSurat.name_id}`;
            document.getElementById('surat-subtitle').textContent =
              `${currentSurat.translation_id} • ${currentSurat.number_of_verses} ayat • ${currentSurat.revelation_id}`;

            // Generate ayat navigation options
            generateAyatOptions();

            // Initialize Select2
            initializeSelect2();

            // Load first ayat
            loadAyat();

            document.getElementById('loading').classList.add('hidden');
            document.getElementById('main-content').classList.remove('hidden');
          } else {
            showToast(result.message || 'Gagal memuat detail surat');
          }
        } catch (error) {
          console.error('Error loading surat detail:', error);
          document.getElementById('loading').classList.add('hidden');
          document.getElementById('error').classList.remove('hidden');
        }
      }

      // Generate ayat navigation options
      function generateAyatOptions() {
        const selector = document.getElementById('ayat-selector');
        selector.innerHTML = '';

        for (let i = 1; i <= currentSurat.number_of_verses; i++) {
          const option = document.createElement('option');
          option.value = i - 1; // 0-based index
          option.textContent = `Ayat ${i}`;
          selector.appendChild(option);
        }
      }

      // Initialize Select2
      function initializeSelect2() {
        // Tunggu sampai Select2 tersedia
        const initSelect2 = () => {
          if (typeof $ !== 'undefined' && typeof $.fn.select2 !== 'undefined') {
            $('#ayat-selector').select2({
              placeholder: 'Pilih ayat...',
              allowClear: false,
              width: '100%',
              language: {
                noResults: function() {
                  return "Ayat tidak ditemukan";
                },
                searching: function() {
                  return "Mencari...";
                }
              }
            });

            // Event listener untuk perubahan ayat dengan Select2
            $('#ayat-selector').on('select2:select', function(e) {
              const ayatIndex = parseInt(e.params.data.id);
              goToAyat(ayatIndex);
            });
          } else {
            // Jika Select2 belum tersedia, coba lagi setelah 100ms
            setTimeout(initSelect2, 100);
          }
        };

        initSelect2();
      }

      // Go to specific ayat
      function goToAyat(index) {
        currentAyatIndex = index;
        loadAyat();
        updateAyatSelector();
      }

      // Update ayat selector
      function updateAyatSelector() {
        const selector = document.getElementById('ayat-selector');
        if (typeof $ !== 'undefined' && typeof $.fn.select2 !== 'undefined') {
          $('#ayat-selector').val(currentAyatIndex).trigger('change');
        } else {
          selector.value = currentAyatIndex;
        }
      }

      // Load ayat
      async function loadAyat() {
        if (!currentSurat) return;

        try {
          const ayatNumber = currentAyatIndex + 1;
          const response = await fetch(`/api/alquran/ayat?surat=${currentSurat.number}&ayat=${ayatNumber}`);
          const result = await response.json();

          if (result.success) {
            const ayat = result.data[0];
            const container = document.getElementById('ayat-content');

            container.innerHTML = `
            <div class="rounded-xl bg-white p-6 shadow-sm border border-gray-100">
              <div class="ayat-arabic">${ayat.arab}</div>
              <div class="ayat-translation">${ayat.text}</div>
            </div>
          `;

            // Update info
            document.getElementById('current-ayat-info').textContent = ayatNumber;
            document.getElementById('total-ayat-info').textContent = currentSurat.number_of_verses;

            // Update navigation buttons
            updateNavigationButtons();
            updateAyatSelector();
          } else {
            showToast('Gagal memuat ayat', 'error');
          }
        } catch (error) {
          console.error('Error loading ayat:', error);
          showToast('Terjadi kesalahan saat memuat ayat');
        }
      }

      // Update navigation buttons
      function updateNavigationButtons() {
        const prevButton = document.getElementById('prev-ayat');
        const nextButton = document.getElementById('next-ayat');

        prevButton.disabled = currentAyatIndex === 0;
        nextButton.disabled = currentAyatIndex === currentSurat.number_of_verses - 1;
      }

      // Navigate ayat
      function navigateAyat(direction) {
        const newIndex = currentAyatIndex + direction;
        if (newIndex >= 0 && newIndex < currentSurat.number_of_verses) {
          currentAyatIndex = newIndex;
          loadAyat();
        }
      }

      // Initialize
      document.addEventListener('DOMContentLoaded', function() {
        loadSuratDetail();
      });
    </script>
  @endpush
@endsection
