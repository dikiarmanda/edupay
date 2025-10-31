@props([
    'type' => 'primary',
    'as' => 'button',
    'href' => null,
])

@php
  $base =
      'inline-flex items-center justify-center px-4 py-2 rounded-lg font-medium text-sm transition focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed';

  $styles = [
      // 🔹 Normal Variants
      'primary' => 'bg-purple-600 text-white hover:bg-purple-700 focus:ring-purple-500',
      'success' => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500',
      'info' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
      'neutral' => 'bg-gray-100 text-gray-700 hover:bg-gray-200 focus:ring-gray-400',
      'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',

      // 🔹 Outline Variants
      'outline' => 'border border-gray-300 text-gray-700 hover:bg-gray-100 focus:ring-gray-400',
      'outline-primary' => 'border border-purple-600 text-purple-600 hover:bg-purple-50 focus:ring-purple-500',
      'outline-danger' => 'border border-red-600 text-red-600 hover:bg-red-50 focus:ring-red-500',

      // 🔹 Inverse Variants (soft pastel style)
      'inverse' => 'bg-purple-50 text-purple-600 hover:bg-purple-100 focus:ring-purple-200',
      'inverse-danger' => 'bg-red-50 text-red-600 hover:bg-red-100 focus:ring-red-200',
      'inverse-success' => 'bg-green-50 text-green-600 hover:bg-green-100 focus:ring-green-200',
      'inverse-warning' => 'bg-yellow-50 text-yellow-600 hover:bg-yellow-100 focus:ring-yellow-200',
      'inverse-info' => 'bg-blue-50 text-blue-600 hover:bg-blue-100 focus:ring-blue-200',
  ];

  $classes = $base . ' ' . ($styles[$type] ?? $styles['primary']);
  $as ??= 'button'; // default: button
@endphp

@if ($href)
  <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
  </a>
@else
  <button type="{{ $as }}" {{ $attributes->merge(['class' => $classes]) }}>
    @isset($icon)
      <span class="inline-flex items-center">
        {{ $icon }}
      </span>
    @endisset
    {{ $slot }}
  </button>
@endif
