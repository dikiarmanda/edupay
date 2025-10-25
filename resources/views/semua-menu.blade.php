@extends('layouts.app')

@section('title', 'Semua Menu - EduPay')

@section('content')
  <!-- Header -->
  <div class="bg-white px-4 py-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <button onclick="history.back()" class="rounded-lg p-2 hover:bg-gray-100">
          <i data-lucide="arrow-left" class="h-6 w-6 text-gray-600"></i>
        </button>
        <div>
          <h1 class="text-xl font-bold text-gray-900">Semua Menu</h1>
          <p class="text-sm text-gray-500">Jelajahi semua fitur yang tersedia di aplikasi EduPay.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- All Menu Grid -->
  <div class="px-4 py-6">
    <div class="mb-15 grid grid-cols-3 gap-4">

      @foreach ($menus as $menu)
        <a href="{{ route($menu->route) }}" class="flex flex-col items-center space-y-1">
          <div class="bg-{{ $menu->color }}-100 flex h-28 w-28 items-center justify-center rounded-xl">
            <i data-lucide="{{ $menu->icon }}" class="text-{{ $menu->color }}-600 h-14 w-14"></i>
          </div>
          <span class="text-xs font-medium text-gray-700">{{ $menu->label }}</span>
        </a>
      @endforeach

    </div>
  </div>

  <style>
    .menu-item {
      transition: all 0.2s ease;
      border-radius: 12px;
      background: white;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .menu-item:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .menu-item:active {
      transform: translateY(0);
    }
  </style>
@endsection
