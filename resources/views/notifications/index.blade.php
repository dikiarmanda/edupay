@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
  <div class="min-h-screen bg-gray-50 py-6">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-6">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-bold text-gray-900">Notifikasi</h1>
            <p class="mt-1 text-sm text-gray-600">{{ $totalNotifications }} total • {{ $unreadCount }} belum dibaca</p>
          </div>
          @if ($unreadCount > 0)
            <button onclick="markAllAsRead()"
              class="rounded-lg bg-blue-600 px-4 py-2 text-sm text-white transition-colors hover:bg-blue-700">
              <i class="fas fa-check-double mr-2"></i>
              Tandai Semua Dibaca
            </button>
          @endif
        </div>
      </div>

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
              class="{{ !$notification->is_read ? 'border-l-4 border-blue-500' : '' }} rounded-lg bg-white p-4 shadow-sm">
              <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                  <div
                    class="{{ $notification->getTypeClass() }} flex h-10 w-10 items-center justify-center rounded-full">
                    <i class="fas fa-{{ $notification->getTypeIcon() }} text-sm"></i>
                  </div>
                </div>
                <div class="min-w-0 flex-1">
                  <div class="flex items-start justify-between">
                    <div class="flex-1">
                      <div class="mb-1 flex items-center space-x-2">
                        <h3 class="text-sm font-semibold text-gray-900">{{ $notification->judul }}</h3>
                        @if (!$notification->is_read)
                          <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                        @endif
                      </div>
                      <p class="mb-2 text-sm text-gray-600">{{ Str::limit($notification->pesan, 120) }}</p>
                      <div class="flex items-center space-x-4 text-xs text-gray-500">
                        <span>{{ $notification->created_at->diffForHumans() }}</span>
                        @if ($notification->nisn)
                          <span><i class="fas fa-user mr-1"></i>{{ $notification->nisn }}</span>
                        @endif
                        @if ($notification->merchant_kode)
                          <span><i class="fas fa-school mr-1"></i>{{ $notification->merchant_kode }}</span>
                        @endif
                      </div>
                    </div>
                    <div class="ml-4 flex flex-col space-y-1">
                      <a href="{{ route('notifikasi.show', $notification) }}"
                        class="text-xs text-blue-600 hover:text-blue-800">
                        <i class="fas fa-eye mr-1"></i>
                        Lihat
                      </a>
                      @if (!$notification->is_read)
                        <button onclick="markAsRead({{ $notification->id }})"
                          class="text-xs text-green-600 hover:text-green-800">
                          <i class="fas fa-check mr-1"></i>
                          Tandai Dibaca
                        </button>
                      @endif
                      <button onclick="deleteNotification({{ $notification->id }})"
                        class="text-xs text-red-600 hover:text-red-800">
                        <i class="fas fa-trash mr-1"></i>
                        Hapus
                      </button>
                    </div>
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
