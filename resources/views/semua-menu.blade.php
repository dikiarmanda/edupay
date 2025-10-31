@extends('layouts.app')

@section('title', 'Semua Menu - EduPay')

@section('content')
  <div class="mb-18 w-full p-4">
    <!-- Header -->
    <x-header title="Semua Menu" subtitle="Jelajahi semua fitur yang tersedia di aplikasi EduPay."
      backUrl="{{ route('dashboard') }}" />

    <!-- All Menu Grid -->
    <div class="py-6">
      <div class="grid grid-cols-3 gap-4">

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
