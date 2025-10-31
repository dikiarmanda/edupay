@extends('layouts.app')

@section('title', 'Detail Notifikasi')

@section('content')
  <div class="mb-18 w-full p-4">
    <!-- Header -->
    <x-header title="Detail Notifikasi" backUrl="{{ route('notifikasi.index') }}" />

    <div class="mx-auto">
      <!-- Detail Notifikasi -->
      <div class="rounded-lg border border-gray-200 shadow-sm">
        <div class="p-6">
          <!-- Header Notifikasi -->
          <div class="mb-6">
            <div class="mb-4 flex items-center space-x-3">
              <div class="{{ $notification->getTypeClass() }} flex h-12 w-12 items-center justify-center rounded-full">
                <i data-lucide="{{ $notification->getTypeIcon() }}" class="text-lg"></i>
              </div>
              <div class="flex-1">
                <div class="mb-1 flex items-center space-x-2">
                  <h2 class="text-xl font-bold text-gray-900">{{ $notification->judul }}</h2>
                  @if (!$notification->is_read)
                    <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                  @endif
                </div>
                <div class="flex items-center space-x-4 text-sm text-gray-500">
                  <span>{{ $notification->created_at->diffForHumans() }}</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Isi Pesan -->
          <div class="border-t border-gray-200 pt-6">
            <p class="whitespace-pre-line leading-relaxed text-gray-700">{{ $notification->pesan }}</p>
          </div>

          <!-- Actions -->
          <div class="mt-6 border-t border-gray-200 pt-6">
            <div class="flex flex-col items-center space-y-2">
              <div class="flex-12 text-sm text-gray-500">
                <i data-lucide="info" class="mr-2 inline"></i>
                Notifikasi ini {{ $notification->is_read ? 'sudah dibaca' : 'belum dibaca' }}
                @if ($notification->read_at)
                  pada {{ $notification->read_at->diffForHumans() }}
                @endif
              </div>
              <div class="flex w-full justify-end space-x-2">
                @if (!$notification->is_read)
                  <x-button onclick="markAsRead({{ $notification->id }})" type="success" class="text-sm">
                    <i class="fas fa-check mr-2"></i>
                    Tandai Dibaca
                  </x-button>
                @endif
                <x-button onclick="deleteNotification({{ $notification->id }})" type="danger" class="text-sm">
                  <i class="fas fa-trash mr-2"></i>
                  Hapus
                </x-button>
              </div>
            </div>
          </div>
        </div>
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

    function deleteNotification(notificationId) {
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
            window.location.href = '{{ route('notifikasi.index') }}';
          } else {
            alert('Gagal menghapus notifikasi');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Terjadi kesalahan');
        });
    }
  </script>
@endsection
