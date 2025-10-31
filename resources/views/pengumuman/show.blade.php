@extends('layouts.app')

@section('title', $pengumuman->judul . ' - EduPay')

@section('content')
  <div class="px-4 pt-4">
    <!-- Header -->
    <x-header title="Detail Pengumuman" backUrl="{{ route('pengumuman.index') }}" />
  </div>

  <!-- Pengumuman Detail -->
  <div class="mt-5 px-4 pb-20">
    <div class="rounded-xl border border-gray-200 p-6 shadow-sm">

      <!-- Title -->
      <h1 class="mb-4 text-2xl font-bold text-gray-900">{{ $pengumuman->judul }}</h1>
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
          <span class="text-sm font-medium text-gray-900">Dari : {{ $pengumuman->author ?? 'Admin' }}</span>
        </div>
        <span class="text-sm font-medium text-gray-900">{{ $pengumuman->created_at->translatedFormat('d M Y H:i') }}</span>
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
      <hr class="mt-4">
      <div class="mt-4">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">Pengumuman Lainnya</h3>
        <div class="space-y-4">
          @foreach ($relatedPengumuman as $related)
            <div class="rounded-xl border border-gray-200 p-4 shadow-sm">
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
                <x-button href="{{ route('pengumuman.show', $related) }}" type="primary" class="py-1 text-xs">
                  Baca Selengkapnya
                </x-button>
              </div>
            </div>
          @endforeach
        </div>
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
