@extends('layouts.app')

@section('title', 'Dashboard - EduPay')

@section('content')
  <!-- Header -->
  <div class="bg-white px-4 py-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-600">
          <span class="text-sm font-semibold text-white">{{ strtoupper(substr($user->nama, 0, 1)) }}</span>
        </div>
        <div class="flex items-center space-x-2">
          <p class="text-xl font-semibold">{{ $user->greeting['text'] }}</p>
          <i data-lucide="{{ $user->greeting['icon'] }}" class="h-5 w-5 text-purple-600"></i>
        </div>
      </div>
      <div class="relative">
        <button onclick="toggleNotificationPanel()" class="relative">
          <i data-lucide="bell" class="h-6 w-6 text-gray-600"></i>
          @if ($unreadCount > 0)
            <div
              class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs text-white">
              {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </div>
          @endif
        </button>
      </div>
    </div>
  </div>

  <!-- Balance Card -->
  <div class="px-4 py-6">
    <div class="gradient-bg floating-shapes relative rounded-2xl p-6 text-white">
      <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center space-x-2">
          <h3 class="font-semibold">{{ $user->nama }}</h3>
        </div>
        <div class="flex items-center space-x-2">
          <div class="rounded-lg bg-purple-500 px-3 py-1">
            <span class="text-xs font-semibold">UTAMA</span>
          </div>
        </div>
      </div>

      <div class="mb-2">
        <span class="text-sm font-medium">Saldo Efektif</span>
        <button id="toggleBalance" class="transition duration-200">
          <i id="eyeIcon" data-lucide="eye-off" class="h-4 w-4 text-white"></i>
          <i id="eyeIconOn" data-lucide="eye" class="hidden h-4 w-4 text-white"></i>
        </button>
        <h2 id="balanceAmount" class="text-3xl font-bold">Rp ••••••••</h2>
        <h2 id="balanceHidden" class="hidden text-3xl font-bold">Rp {{ number_format($user->saldo, 0, ',', '.') ?? 0 }}
        </h2>
      </div>
    </div>
  </div>

  <!-- Main Menu -->
  <div class="mb-6 px-4">
    <h3 class="mb-4 text-lg font-bold text-gray-900">Menu Utama</h3>
    <div class="grid grid-cols-4 gap-4">
      @foreach ($limitedMenus as $menu)
        <a href="{{ route($menu->route) }}" class="flex flex-col items-center space-y-1">
          <div class="bg-{{ $menu->color }}-100 flex h-20 w-20 items-center justify-center rounded-xl">
            <i data-lucide="{{ $menu->icon }}" class="text-{{ $menu->color }}-600 h-10 w-10"></i>
          </div>
          <span class="text-xs font-medium text-gray-700">{{ $menu->label }}</span>
        </a>
      @endforeach

      @if ($hasMore)
        <a href="{{ route('semua-menu') }}" class="flex flex-col items-center space-y-1">
          <div class="flex h-20 w-20 items-center justify-center rounded-xl bg-gray-100">
            <i data-lucide="grid-3x3" class="h-10 w-10 text-gray-600"></i>
          </div>
          <span class="text-xs font-medium text-gray-700">Lihat Semua</span>
        </a>
      @endif
    </div>
  </div>

  <!-- Achievements and Events -->
  <div class="mb-15 px-4">
    <div class="mb-4 flex items-center justify-between">
      <h3 class="text-lg font-bold text-gray-900">Prestasi dan Event Kegiatan</h3>
      <a href="#" class="text-sm font-medium text-purple-600">Lihat Semua</a>
    </div>

    <div class="flex space-x-4 overflow-x-auto pb-2">
      <div class="flex-shrink-0">
        <div class="flex h-48 w-72 items-center justify-center rounded-xl bg-gray-200">
          <span class="font-medium text-gray-500">600 × 400</span>
        </div>
      </div>
      <div class="flex-shrink-0">
        <div class="flex h-48 w-72 items-center justify-center rounded-xl bg-gray-200">
          <span class="font-medium text-gray-500">600 × 400</span>
        </div>
      </div>
      <div class="flex-shrink-0">
        <div class="flex h-48 w-72 items-center justify-center rounded-xl bg-gray-200">
          <span class="font-medium text-gray-500">600 × 400</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Off Canvas Notification Panel -->
  <div id="notificationPanel" class="z-51 fixed inset-0 hidden transition-all duration-300 ease-in-out">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-300"
      onclick="toggleNotificationPanel()"></div>

    <!-- Panel -->
    <div
      class="fixed right-0 top-0 h-full w-96 transform bg-white shadow-xl transition-transform duration-300 ease-in-out">
      <!-- Header -->
      <div class="flex items-center justify-between border-b border-gray-200 p-4">
        <h2 class="text-lg font-semibold text-gray-900">Notifikasi</h2>
        <div class="flex items-center space-x-2">
          @if ($unreadCount > 0)
            <button onclick="markAllAsRead()" class="text-sm text-blue-600 hover:text-blue-800">
              <i data-lucide="check-check" class="inline"></i>
              Tandai Semua Dibaca
            </button>
          @endif
          <button onclick="toggleNotificationPanel()" class="text-gray-400 hover:text-gray-600">
            <i class="fas fa-times text-xl"></i>
          </button>
        </div>
      </div>

      <!-- Notification Content -->
      <div class="flex-1 overflow-y-auto">
        @if ($latestNotifications->count() > 0)
          <div class="divide-y divide-gray-200">
            @foreach ($latestNotifications as $notification)
              <div class="{{ !$notification->is_read ? 'bg-blue-50' : '' }} p-4 hover:bg-gray-50">
                <div class="flex items-start space-x-3">
                  <div class="flex-shrink-0">
                    <div
                      class="{{ $notification->getTypeClass() }} flex h-8 w-8 items-center justify-center rounded-full">
                      <i data-lucide="{{ $notification->getTypeIcon() }}" class="text-xs"></i>
                    </div>
                  </div>
                  <div class="min-w-0 flex-1">
                    <div class="flex items-center justify-between">
                      <p class="truncate text-sm font-medium text-gray-900">{{ $notification->judul }}</p>
                      @if (!$notification->is_read)
                        <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                      @endif
                    </div>
                    <p class="mt-1 line-clamp-2 text-sm text-gray-600">{{ Str::limit($notification->pesan, 80) }}</p>
                    <div class="mt-2 flex items-center justify-between">
                      <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                      <div class="flex space-x-2">
                        <a href="{{ route('notifikasi.show', $notification) }}"
                          class="text-xs text-blue-600 hover:text-blue-800">
                          Lihat
                        </a>
                        @if (!$notification->is_read)
                          <button onclick="markAsRead({{ $notification->id }})"
                            class="text-xs text-green-600 hover:text-green-800">
                            Tandai Dibaca
                          </button>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div class="flex flex-col items-center justify-center py-12 text-center">
            <i class="fas fa-bell-slash mb-4 text-4xl text-gray-300"></i>
            <h3 class="mb-2 text-lg font-medium text-gray-900">Tidak ada notifikasi</h3>
            <p class="text-sm text-gray-500">Belum ada notifikasi untuk Anda</p>
          </div>
        @endif
      </div>

      <!-- Footer -->
      <div class="border-t border-gray-200 p-4">
        <a href="{{ route('notifikasi.index') }}"
          class="block w-full rounded-lg bg-blue-600 px-4 py-2 text-center text-sm font-medium text-white hover:bg-blue-700">
          Lihat Semua Notifikasi
        </a>
      </div>
    </div>
  </div>

  <script>
    // Function untuk toggle notification panel
    function toggleNotificationPanel() {
      const panel = document.getElementById('notificationPanel');
      panel.classList.toggle('hidden');
    }

    // Function untuk menandai notifikasi sebagai sudah dibaca
    function markAsRead(notificationId) {
      fetch(`/notifikasi/${notificationId}/mark-read`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
          },
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            location.reload();
          } else {
            alert('Gagal menandai notifikasi sebagai sudah dibaca');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Terjadi kesalahan');
        });
    }

    // Function untuk menandai semua notifikasi sebagai sudah dibaca
    function markAllAsRead() {
      if (confirm('Apakah Anda yakin ingin menandai semua notifikasi sebagai sudah dibaca?')) {
        fetch('/notifikasi/mark-all-read', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Content-Type': 'application/json',
            },
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              location.reload();
            } else {
              alert('Gagal menandai semua notifikasi sebagai sudah dibaca');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
          });
      }
    }
  </script>
@endsection
