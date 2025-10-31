@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
  <div class="mb-18 w-full p-4">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <x-header title="Notifikasi" subtitle="{{ $totalNotifications }} total • {{ $unreadCount }} belum dibaca"
        backUrl="{{ route('dashboard') }}" />

      @if ($unreadCount > 0)
        <x-button onclick="markAllAsRead()" type="info" class="ml-auto text-sm">
          <i data-lucide="check-check" class="mr-2 h-4 w-4"></i>
          Tandai Semua Dibaca
        </x-button>
      @endif
    </div>

    <div class="mx-auto">

      <!-- Filter Tabs -->
      <div class="mb-6">
        <div class="border-b border-gray-200">
          <nav class="-mb-px flex space-x-8">
            <a href="{{ route('notifikasi.index') }}"
              class="{{ !request('status') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} border-b-2 px-1 py-2 text-sm font-medium">
              Semua ({{ $totalNotifications }})
            </a>
            <a href="{{ route('notifikasi.index', ['status' => 'unread']) }}"
              class="{{ request('status') === 'unread' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} border-b-2 px-1 py-2 text-sm font-medium">
              Belum Dibaca ({{ $unreadCount }})
            </a>
            <a href="{{ route('notifikasi.index', ['status' => 'read']) }}"
              class="{{ request('status') === 'read' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} border-b-2 px-1 py-2 text-sm font-medium">
              Sudah Dibaca ({{ $readCount }})
            </a>
          </nav>
        </div>
      </div>

      <!-- Daftar Notifikasi -->
      <div class="space-y-3">
        @if ($notifications->count() > 0)
          @foreach ($notifications as $notification)
            <div
              class="{{ !$notification->is_read ? 'border-l-4 border-blue-500' : 'border border-gray-200' }} rounded-lg p-4 shadow-sm">
              <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                  <div
                    class="{{ $notification->getTypeClass() }} flex h-10 w-10 items-center justify-center rounded-full">
                    <i data-lucide="{{ $notification->getTypeIcon() }}" class="text-xs"></i>
                  </div>
                </div>
                <div class="min-w-0 flex-1">
                  <div class="mb-2 flex items-start justify-between">
                    <div class="flex-1">
                      <div class="mb-1 flex items-center space-x-2">
                        <h3 class="text-sm font-semibold text-gray-900">{{ $notification->judul }}</h3>
                        @if (!$notification->is_read)
                          <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                        @endif
                      </div>
                      <p class="text-sm text-gray-600">{{ Str::limit($notification->pesan, 50) }}</p>
                    </div>
                    <div class="ml-4 text-right">
                      <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                  </div>
                  <div class="mt-3 flex items-center justify-end space-x-2 border-t border-gray-100 pt-3">
                    @if (!$notification->is_read)
                      <x-button onclick="markAsRead({{ $notification->id }})" type="inverse-success" class="text-xs">
                        <i data-lucide="check" class="mr-1 h-3 w-3"></i>
                        Tandai Dibaca
                      </x-button>
                    @endif
                    <x-button href="{{ route('notifikasi.show', $notification) }}" type="inverse-info" class="text-xs">
                      <i data-lucide="eye" class="mr-1 h-3 w-3"></i>
                      Lihat
                    </x-button>
                    <x-button onclick="deleteNotification({{ $notification->id }})" type="inverse-danger"
                      class="text-xs">
                      <i data-lucide="trash" class="mr-1 h-3 w-3"></i>
                      Hapus
                    </x-button>
                  </div>
                </div>
              </div>
            </div>
          @endforeach

          <!-- Pagination -->
          <div class="mt-6">
            {{ $notifications->appends(request()->query())->links() }}
          </div>
        @else
          <div class="py-12 text-center">
            <i class="fas fa-bell-slash mb-4 text-6xl text-gray-300"></i>
            <h3 class="mb-2 text-lg font-medium text-gray-900">Tidak ada notifikasi</h3>
            <p class="text-gray-500">Belum ada notifikasi yang sesuai dengan filter yang dipilih.</p>
          </div>
        @endif
      </div>
    </div>
  </div>

  <script>
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

    function deleteNotification(notificationId) {
      if (confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) {
        fetch(`/notifikasi/${notificationId}`, {
            method: 'DELETE',
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
              alert('Gagal menghapus notifikasi');
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
