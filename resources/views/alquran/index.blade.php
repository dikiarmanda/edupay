@extends('layouts.app')

@section('title', 'Al-Quran - EduPay')

@section('content')
  <!-- Header -->
  <div class="bg-white px-4 py-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <button onclick="history.back()" class="rounded-lg p-2 hover:bg-gray-100">
          <i data-lucide="arrow-left" class="h-6 w-6 text-gray-600"></i>
        </button>
        <div>
          <h1 class="text-xl font-bold text-gray-900">Al-Quran</h1>
          <p class="text-sm text-gray-500">Bacaan Al-Quran dengan terjemahan</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Loading State -->
  <div id="loading" class="px-4 py-8 text-center">
    <div class="inline-block h-8 w-8 animate-spin rounded-full border-b-2 border-purple-600"></div>
    <p class="mt-2 text-gray-500">Memuat daftar surat...</p>
  </div>

  <!-- Error State -->
  <div id="error" class="hidden px-4 py-8 text-center">
    <div class="rounded-lg bg-red-50 p-4">
      <i data-lucide="alert-circle" class="mx-auto mb-2 h-8 w-8 text-red-500"></i>
      <p class="font-medium text-red-700">Gagal memuat Al-Quran</p>
      <p class="mt-1 text-sm text-red-600">Silakan coba lagi nanti</p>
      <button onclick="loadSurat()" class="mt-3 rounded-lg bg-red-600 px-4 py-2 text-sm text-white hover:bg-red-700">
        Coba Lagi
      </button>
    </div>
  </div>

  <!-- Main Content -->
  <div id="main-content" class="pb-18 hidden">
    <!-- Search Bar -->
    <div class="border-b bg-white px-4 py-4">
      <div class="relative">
        <input type="text" id="search-surat" placeholder="Cari surat..."
          class="w-full rounded-lg border border-gray-300 px-4 py-3 pl-10 focus:border-transparent focus:ring-2 focus:ring-purple-500">
        <i data-lucide="search" class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"></i>
      </div>
    </div>

    <!-- Surat List -->
    <div class="px-4 py-6">
      <div id="surat-list" class="space-y-3">
        <!-- Surat items will be loaded here -->
      </div>
    </div>
  </div>

  @push('styles')
    <style>
      /* Custom styling untuk Al-Quran */
      .surat-item {
        transition: all 0.2s ease;
      }

      .surat-item:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      }
    </style>
  @endpush

  @push('scripts')
    <script>
      let suratList = [];
      let filteredSuratList = [];

      // Load daftar surat
      async function loadSurat() {
        try {
          document.getElementById('loading').classList.remove('hidden');
          document.getElementById('error').classList.add('hidden');
          document.getElementById('main-content').classList.add('hidden');

          const response = await fetch('/api/alquran/surat');
          const result = await response.json();

          if (result.success) {
            suratList = result.data;
            filteredSuratList = [...suratList];
            renderSuratList();

            document.getElementById('loading').classList.add('hidden');
            document.getElementById('main-content').classList.remove('hidden');
          } else {
            throw new Error(result.message || 'Gagal memuat daftar surat');
          }
        } catch (error) {
          console.error('Error loading surat:', error);
          document.getElementById('loading').classList.add('hidden');
          document.getElementById('error').classList.remove('hidden');
        }
      }

      // Render daftar surat
      function renderSuratList() {
        const container = document.getElementById('surat-list');
        container.innerHTML = '';
        console.log(filteredSuratList);
        filteredSuratList.forEach(surat => {
          const suratItem = document.createElement('div');
          suratItem.className = 'surat-item rounded-xl border border-gray-100 bg-white p-4 shadow-sm';
          suratItem.innerHTML = `
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
              <div class="flex h-12 w-12 items-center justify-center rounded-full bg-purple-100">
                <span class="text-lg font-bold text-purple-600">${surat.number}</span>
              </div>
              <div>
                <h3 class="font-semibold text-gray-900">${surat.name_id}</h3>
                <p class="text-sm text-gray-500">${surat.translation_id} • ${surat.number_of_verses} ayat</p>
              </div>
            </div>
            <div class="text-right">
              <p class="text-sm text-gray-500">${surat.revelation_id}</p>
                 <button onclick="openSuratDetail(${surat.number})"
                   class="mt-1 rounded-lg bg-purple-600 px-3 py-1 text-sm text-white hover:bg-purple-700">
                   Baca
                 </button>
            </div>
          </div>
        `;
          container.appendChild(suratItem);
        });
      }

      // Search surat
      function searchSurat() {
        const searchTerm = document.getElementById('search-surat').value.toLowerCase();
        filteredSuratList = suratList.filter(surat =>
          surat.name_short.toLowerCase().includes(searchTerm) ||
          surat.name_id.toLowerCase().includes(searchTerm) ||
          surat.revelation_id.toLowerCase().includes(searchTerm)
        );
        renderSuratList();
      }

      // Open surat detail page
      function openSuratDetail(nomorSurat) {
        window.location.href = `/alquran/show?surat=${nomorSurat}`;
      }

      // Event listeners
      document.getElementById('search-surat').addEventListener('input', searchSurat);

      // Initialize
      document.addEventListener('DOMContentLoaded', function() {
        loadSurat();
      });
    </script>
  @endpush
@endsection
