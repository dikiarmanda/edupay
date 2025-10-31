@extends('layouts.app')

@push('styles')
  <style>
    /* Style untuk select filter */
    #filterBulan,
    #filterTahun {
      width: 100%;
      border-radius: 0.5rem;
      border: 1px solid #d1d5db;
      padding: 0.5rem 1rem;
      font-size: 0.875rem;
    }

    /* Select2 container */
    .select2-container {
      width: 100% !important;
    }

    .select2-container--default .select2-selection--single {
      height: 2.5rem;
      border-radius: 0.5rem;
      border: 1px solid #d1d5db;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 2.5rem;
      padding-left: 1rem;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 2.5rem;
    }
  </style>
@endpush

@section('content')
  <div class="mb-18 w-full p-4">
    <!-- Header -->
    <x-header title="Izin Siswa" subtitle="Kelola izin kehadiran Anda." backUrl="{{ route('dashboard') }}" />

    <!-- Main Content -->
    <div class="mx-auto py-6">

      <!-- Filter Toggle Button -->
      <div id="filter-toggle" class="mb-4" style="display: none;">
        <div class="flex items-center justify-between">
          <x-button type="neutral" onclick="toggleFilter()">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z">
              </path>
            </svg>
            <span id="filter-toggle-text">Tampilkan Filter</span>
          </x-button>

          @if (request('bulan') || request('tahun'))
            <div class="flex items-center space-x-2">
              <span class="text-xs text-gray-500">Filter aktif:</span>
              @if (request('bulan'))
                <span class="rounded-full bg-purple-100 px-2 py-1 text-xs font-medium text-purple-700">
                  {{ bulanList()[request('bulan')] ?? request('bulan') }}
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

      <!-- Filter Section -->
      <div id="filter-section" class="mb-4" style="display: none;">
        <div class="rounded-lg border border-gray-200 p-4 shadow-sm">
          <h3 class="mb-4 text-lg font-medium text-gray-900">Filter Izin</h3>

          <form id="filterForm" method="GET" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Bulan</label>
                <select name="bulan" id="filterBulan" class="w-full">
                  <option value="">Semua Bulan</option>
                  @foreach (bulanList() as $key => $bulan)
                    <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>
                      {{ $bulan }}</option>
                  @endforeach
                </select>
              </div>

              <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Tahun</label>
                <select name="tahun" id="filterTahun" class="w-full">
                  <option value="">Semua Tahun</option>
                  @foreach (range(date('Y') + 1, 2020) as $tahun)
                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                      {{ $tahun }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="flex space-x-3">
              <x-button type="primary" as="submit" id="filterSubmitBtn" class="flex-1">
                <span id="filterSubmitText">Terapkan Filter</span>
                <svg id="filterLoadingIcon" class="ml-2 hidden h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                  </circle>
                  <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                  </path>
                </svg>
              </x-button>
              <x-button type="neutral" onclick="resetFilter()" class="flex-1">
                Reset
              </x-button>
            </div>

          </form>
        </div>
      </div>

      <!-- Add Button -->
      <div class="mb-4">
        <x-button class="block w-full" href="{{ route('izin-siswa.create') }}">
          + Ajukan Izin
        </x-button>
      </div>

      <!-- Info Filter Aktif -->
      @if (request('bulan') || request('tahun'))
        <div class="mb-4 rounded-lg bg-blue-50 p-3">
          <div class="flex items-center">
            <svg class="mr-2 h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm text-blue-800">
              Menampilkan {{ $izinSiswa->count() }} izin
              @if (request('bulan') && request('tahun'))
                untuk {{ bulanList()[request('bulan')] ?? request('bulan') }} {{ request('tahun') }}
              @elseif(request('bulan'))
                untuk bulan {{ bulanList()[request('bulan')] ?? request('bulan') }}
              @elseif(request('tahun'))
                untuk tahun {{ request('tahun') }}
              @endif
            </p>
          </div>
        </div>
      @endif

      <!-- Izin List -->
      <div class="space-y-4">
        @forelse($izinSiswa as $izin)
          <div class="rounded-lg border border-gray-200 p-4 shadow-sm">
            <div class="flex items-start justify-between">
              <div class="flex-1">
                <div class="mb-2 flex items-center justify-between">
                  <span class="rounded-full bg-pink-100 px-3 py-1 text-sm font-medium text-pink-600">
                    {{ $izin->jenis_izin_text }}
                  </span>
                  @if (
                      \Carbon\Carbon::parse($izin->tanggal_izin)->isSameDay(now()) ||
                          \Carbon\Carbon::parse($izin->tanggal_izin)->isFuture())
                    <x-button type="danger" onclick="deleteIzin({{ $izin->id }})" class="text-sm">
                      <i data-lucide="trash" class="h-4 w-4"></i>
                    </x-button>
                  @endif
                </div>
                <p class="text-sm text-slate-800">Tanggal:
                  {{ \Carbon\Carbon::parse($izin->tanggal_izin)->translatedFormat('d M Y') }}</p>
                <p class="mt-1 line-clamp-2 text-sm text-gray-500">{{ Str::limit($izin->alasan, 80) }}</p>
              </div>
            </div>
            <div class="mt-4 flex space-x-2">
              <x-button href="{{ route('izin-siswa.show', $izin->id) }}" type="inverse-info" class="flex-1 text-sm">
                Detail
              </x-button>
              @if (
                  \Carbon\Carbon::parse($izin->tanggal_izin)->isSameDay(now()) ||
                      \Carbon\Carbon::parse($izin->tanggal_izin)->isFuture())
                <x-button href="{{ route('izin-siswa.edit', $izin->id) }}" type="outline-primary" class="flex-1 text-sm">
                  Edit
                </x-button>
              @endif
            </div>
          </div>
        @empty
          <div class="rounded-lg border border-gray-200 p-8 text-center shadow-sm">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
              </path>
            </svg>
            <p class="mt-4 text-gray-500">Belum ada izin yang diajukan.</p>
            <x-button href="{{ route('izin-siswa.create') }}" class="mt-4">
              Ajukan Izin Pertama
            </x-button>
          </div>
        @endforelse
      </div>

      <!-- Pagination -->
      @if ($izinSiswa->hasPages())
        <div class="mt-6">
          {{ $izinSiswa->links() }}
        </div>
      @endif
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div id="deleteModal"
    class="z-51 pointer-events-none fixed inset-0 flex items-center justify-center bg-black/50 opacity-0 transition-opacity duration-300 ease-in-out"
    onclick="closeDeleteModal()">
    <div
      class="mx-auto max-w-md scale-95 transform rounded-lg bg-white p-6 shadow-lg transition-transform duration-300 ease-in-out">
      <h3 class="mb-4 text-lg font-semibold">Konfirmasi Hapus</h3>
      <p class="mb-6 text-gray-600">Apakah Anda yakin ingin menghapus izin ini?</p>
      <div class="flex space-x-3">
        <x-button type="outline" onclick="closeDeleteModal()" class="flex-1">
          Batal
        </x-button>
        <form id="deleteForm" method="POST" class="flex-1">
          @csrf
          @method('DELETE')
          <x-button type="danger" as="submit" class="w-full">
            Hapus
          </x-button>
        </form>
      </div>
    </div>
  </div>

  @include('components.toast')

  <script>
    // Initialize with filter toggle visibility
    document.addEventListener('DOMContentLoaded', function() {
      if (@json(session('error'))) {
        showToast(@json(session('error')));
      }
      @if ($izinSiswa->count() > 0 || request('bulan') || request('tahun'))
        // Show filter toggle if there are izin or filters are active
        const filterToggle = document.getElementById('filter-toggle');
        if (filterToggle) {
          filterToggle.style.display = 'block';
        }
      @endif

      // Add form submit listener
      const filterForm = document.getElementById('filterForm');
      if (filterForm) {
        filterForm.addEventListener('submit', function() {
          showFilterLoading();
        });
      }
    });

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
      // Reset Select2 values if available
      if (typeof $ !== 'undefined') {
        $('#filterBulan').val('').trigger('change');
        $('#filterTahun').val('').trigger('change');
      } else {
        // Simple reset if jQuery is not available
        document.getElementById('filterBulan').value = '';
        document.getElementById('filterTahun').value = '';
      }

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

      if (submitBtn && submitText && loadingIcon) {
        submitBtn.disabled = true;
        submitText.textContent = 'Memproses...';
        loadingIcon.classList.remove('hidden');
      }
    }

    function hideFilterLoading() {
      const submitBtn = document.getElementById('filterSubmitBtn');
      const submitText = document.getElementById('filterSubmitText');
      const loadingIcon = document.getElementById('filterLoadingIcon');

      if (submitBtn && submitText && loadingIcon) {
        submitBtn.disabled = false;
        submitText.textContent = 'Terapkan Filter';
        loadingIcon.classList.add('hidden');
      }
    }

    // Listen for Select2 ready event from CDN fallback
    window.addEventListener('select2Ready', function() {
      setTimeout(() => {
        initializeSelect2();
      }, 100);
    });

    function initializeSelect2() {
      // Check if jQuery and Select2 are available
      if (typeof $ === 'undefined' || typeof $.fn.select2 === 'undefined') {
        return;
      }

      // Check if elements exist
      const bulanElement = document.getElementById('filterBulan');
      const tahunElement = document.getElementById('filterTahun');

      if (!bulanElement || !tahunElement) {
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
        // Ignore errors
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
      } catch (e) {
        // Ignore errors
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
      } catch (e) {
        // Ignore errors
      }

      // Handle change events for auto-submit
      $('#filterBulan, #filterTahun').off('change.select2').on('change.select2', function() {
        autoSubmitFilter();
      });
    }

    function destroySelect2() {
      // Destroy Select2 instances if they exist
      try {
        if (typeof $ !== 'undefined') {
          if ($('#filterBulan').length && $('#filterBulan').hasClass('select2-hidden-accessible')) {
            $('#filterBulan').select2('destroy');
          }
          if ($('#filterTahun').length && $('#filterTahun').hasClass('select2-hidden-accessible')) {
            $('#filterTahun').select2('destroy');
          }
        }
      } catch (error) {
        // Ignore errors
      }
    }

    function verifySelect2Working() {
      if (typeof $ === 'undefined') {
        return;
      }

      const bulanSelect2 = $('#filterBulan').hasClass('select2-hidden-accessible');
      const tahunSelect2 = $('#filterTahun').hasClass('select2-hidden-accessible');

      if (!bulanSelect2 || !tahunSelect2) {
        setTimeout(() => {
          initializeSelect2();
        }, 500);
      }
    }

    function deleteIzin(id) {
      const modal = document.getElementById('deleteModal');
      const modalContent = modal.querySelector('div');

      document.getElementById('deleteForm').action = "{{ url('/izin-siswa') }}/" + id;

      // Show modal with animation
      modal.classList.remove('pointer-events-none');
      modal.classList.add('opacity-100');
      modalContent.classList.remove('scale-95');
      modalContent.classList.add('scale-100');
    }

    function closeDeleteModal() {
      const modal = document.getElementById('deleteModal');
      const modalContent = modal.querySelector('div');

      // Hide modal with animation
      modal.classList.add('pointer-events-none');
      modal.classList.remove('opacity-100');
      modalContent.classList.remove('scale-100');
      modalContent.classList.add('scale-95');
    }
  </script>
@endsection
