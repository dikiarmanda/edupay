@extends('layouts.app')

@section('title', 'Pengumuman - EduPay')

@section('content')
  <!-- Header -->
  <div class="bg-white px-4 py-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 text-gray-600 hover:text-purple-600">
          <i data-lucide="arrow-left" class="h-5 w-5"></i>
          <span class="text-sm font-medium">Kembali</span>
        </a>
      </div>
      <div class="flex items-center space-x-2">
        <i data-lucide="megaphone" class="h-6 w-6 text-purple-600"></i>
        <h1 class="text-lg font-bold text-gray-900">Pengumuman</h1>
      </div>
      <div class="w-20"></div> <!-- Spacer untuk balance -->
    </div>
  </div>

  <!-- Search Bar -->
  <div class="px-4 py-4">
    <form method="GET" action="{{ route('pengumuman.index') }}">
      <div class="relative">
        <i data-lucide="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pengumuman..."
          class="w-full rounded-lg border border-gray-300 bg-white py-2 pl-10 pr-4 text-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
      </div>
    </form>
  </div>

  <!-- Pengumuman List -->
  <div class="px-4 pb-20">
    <div class="space-y-4">
      @forelse($pengumuman as $item)
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">

          <!-- Header -->
          <div class="mb-3 flex items-start justify-between">
            <div class="flex-1">
              <h3 class="line-clamp-2 text-lg font-semibold text-gray-900">{{ $item->judul }}</h3>
              <div class="mt-1 flex items-center space-x-2">
              </div>
            </div>
            <div class="ml-2">
              <span class="text-xs text-gray-500">{{ $item->created_at->diffForHumans() }}</span>
            </div>
          </div>

          <!-- Content Preview -->
          <div class="mb-3">
            <p class="line-clamp-3 text-sm text-gray-600">{{ $item->excerpt }}</p>
          </div>

          <!-- Footer -->
          <div class="flex items-center justify-end">
            <a href="{{ route('pengumuman.show', $item) }}"
              class="inline-flex items-center rounded-lg bg-purple-600 px-3 py-1 text-xs font-medium text-white hover:bg-purple-700">
              Baca Selengkapnya
            </a>
          </div>
        </div>
      @empty
        <div class="py-12 text-center">
          <i data-lucide="megaphone" class="mx-auto h-12 w-12 text-gray-400"></i>
          <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada pengumuman</h3>
          <p class="mt-2 text-sm text-gray-500">
            @if (request('search'))
              Tidak ditemukan pengumuman dengan kata kunci "{{ request('search') }}"
            @else
              Belum ada pengumuman yang tersedia saat ini.
            @endif
          </p>
        </div>
      @endforelse
    </div>

    <!-- Pagination -->
    @if ($pengumuman->hasPages())
      <div class="mt-6">
        {{ $pengumuman->appends(request()->query())->links() }}
      </div>
    @endif
  </div>

  <style>
    .line-clamp-2 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .line-clamp-3 {
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('navDashboard').classList.add('active');
    });
  </script>
@endsection
