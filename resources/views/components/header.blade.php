@props([
    'title' => 'Judul Halaman',
    'subtitle' => null,
    'back' => true,
    'backUrl' => null,
])

<div class="mb-6">
  {{-- Tombol kembali --}}
  @if ($back)
    <div class="mb-3">
      <a href="{{ $backUrl ?? url()->previous() }}"
        class="flex items-center space-x-2 text-sm text-gray-600 transition-colors hover:text-gray-900">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        <span>Kembali</span>
      </a>
    </div>
  @endif

  {{-- Judul halaman --}}
  <h1 class="text-2xl font-semibold tracking-tight">{{ $title }}</h1>
  {{-- Subjudul opsional --}}
  @if ($subtitle)
    <p class="text-sm text-gray-500">{{ $subtitle }}</p>
  @endif
</div>
