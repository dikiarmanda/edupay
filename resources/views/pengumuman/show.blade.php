@extends('layouts.app')

@section('title', $pengumuman->judul . ' - EduPay')

@section('content')
  <!-- Header -->
  <div class="bg-white px-4 py-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <a href="{{ route('pengumuman.index') }}" class="flex items-center space-x-2 text-gray-600 hover:text-purple-600">
          <i data-lucide="arrow-left" class="h-5 w-5"></i>
          <span class="text-sm font-medium">Kembali</span>
        </a>
      </div>
      <div class="flex items-center space-x-2">
        <i data-lucide="megaphone" class="h-6 w-6 text-purple-600"></i>
        <h1 class="text-lg font-bold text-gray-900">Detail Pengumuman</h1>
      </div>
      <div class="w-20"></div> <!-- Spacer untuk balance -->
    </div>
  </div>

  <!-- Pengumuman Detail -->
  <div class="mt-5 px-4 pb-20">
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

      <!-- Title -->
      <h1 class="mb-4 text-2xl font-bold text-gray-900">{{ $pengumuman->judul }}</h1>
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
          <span class="text-sm font-medium text-gray-900">Dari : {{ $pengumuman->author ?? 'Admin' }}</span>
        </div>
        <span
          class="text-sm font-medium text-gray-900">{{ $pengumuman->created_at->translatedFormat('d M Y H:i') }}</span>
      </div>

      <!-- Content -->
      <div class="mt-6">
        <div class="prose prose-sm max-w-none text-gray-700">
          {!! nl2br(e($pengumuman->isi)) !!}
        </div>
      </div>

    </div>

    <!-- Related Pengumuman -->
    @if ($relatedPengumuman && $relatedPengumuman->count() > 0)
      <div class="mt-8">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">Pengumuman Lainnya</h3>
        <div class="space-y-4">
          @foreach ($relatedPengumuman as $related)
            <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
              <div class="mb-3 flex items-start justify-between">
                <div class="flex-1">
                  <h3 class="line-clamp-2 text-lg font-semibold text-gray-900">{{ $related->judul }}</h3>
                  <div class="mt-1 flex items-center space-x-2">
                  </div>
                </div>
                <div class="ml-2">
                  <span class="text-xs text-gray-500">{{ $related->created_at->diffForHumans() }}</span>
                </div>
              </div>
              <p class="mb-3 line-clamp-2 text-sm text-gray-600">{{ $related->excerpt }}</p>
              <div class="flex items-center justify-end">
                <a href="{{ route('pengumuman.show', $related) }}"
                  class="inline-flex items-center rounded-lg bg-purple-600 px-3 py-1 text-xs font-medium text-white hover:bg-purple-700">
                  Baca Selengkapnya
                </a>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('navDashboard').classList.add('active');
    });
  </script>

  <style>
    .line-clamp-2 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .prose {
      line-height: 1.6;
    }

    .prose p {
      margin-bottom: 1rem;
    }

    .prose p:last-child {
      margin-bottom: 0;
    }
  </style>
@endsection
