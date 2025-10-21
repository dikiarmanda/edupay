@extends('layouts.app')

@section('title', 'Detail Notifikasi')

@section('content')
  <div class="min-h-screen bg-gray-50 py-6">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-6">
        <div class="flex items-center justify-between">
          <div>
            <nav class="flex" aria-label="Breadcrumb">
              <ol class="flex items-center space-x-4">
                <li>
                  <a href="{{ route('notifikasi.index') }}" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-bell mr-2"></i>
                    Notifikasi
                  </a>
                </li>
                <li>
                  <div class="flex items-center">
                    <i class="fas fa-chevron-right mr-4 text-gray-400"></i>
                    <span class="text-gray-500">Detail</span>
                  </div>
                </li>
              </ol>
            </nav>
            <h1 class="mt-4 text-2xl font-bold text-gray-900">Detail Notifikasi</h1>
          </div>
          <div class="flex space-x-2">
            <a href="{{ route('notifikasi.index') }}"
              class="rounded-lg bg-gray-600 px-3 py-2 text-sm text-white transition-colors hover:bg-gray-700">
              <i class="fas fa-arrow-left mr-2"></i>
              Kembali
            </a>
            @if (!$notification->is_read)
              <button onclick="markAsRead({{ $notification->id }})"
                class="rounded-lg bg-green-600 px-3 py-2 text-sm text-white transition-colors hover:bg-green-700">
                <i class="fas fa-check mr-2"></i>
                Tandai Dibaca
              </button>
            @endif
            <button onclick="deleteNotification({{ $notification->id }})"
              class="rounded-lg bg-red-600 px-3 py-2 text-sm text-white transition-colors hover:bg-red-700">
              <i class="fas fa-trash mr-2"></i>
              Hapus
            </button>
          </div>
        </div>
      </div>

      <!-- Detail Notifikasi -->
      <div class="rounded-lg bg-white shadow-sm">
        <div class="p-6">
          <!-- Header Notifikasi -->
          <div class="mb-6">
            <div class="mb-4 flex items-center space-x-3">
              <div class="{{ $notification->getTypeClass() }} flex h-12 w-12 items-center justify-center rounded-full">
                <i class="fas fa-{{ $notification->getTypeIcon() }} text-lg"></i>
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
                  <span class="capitalize">{{ $notification->tipe }}</span>
                  @if ($notification->nisn)
                    <span><i class="fas fa-user mr-1"></i>{{ $notification->nisn }}</span>
                  @endif
                  @if ($notification->merchant_kode)
                    <span><i class="fas fa-school mr-1"></i>{{ $notification->merchant_kode }}</span>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <!-- Isi Pesan -->
          <div class="border-t border-gray-200 pt-6">
            <h3 class="mb-3 text-lg font-semibold text-gray-900">Isi Pesan</h3>
            <div class="rounded-lg bg-gray-50 p-4">
              <p class="whitespace-pre-line leading-relaxed text-gray-700">{{ $notification->pesan }}</p>
            </div>
          </div>

          <!-- Actions -->
          <div class="mt-6 border-t border-gray-200 pt-6">
            <div class="flex items-center justify-between">
              <div class="text-sm text-gray-500">
                <i class="fas fa-info-circle mr-2"></i>
                Notifikasi ini {{ $notification->is_read ? 'sudah dibaca' : 'belum dibaca' }}
                @if ($notification->read_at)
                  pada {{ $notification->read_at->diffForHumans() }}
                @endif
              </div>
              <div class="flex space-x-2">
                @if (!$notification->is_read)
                  <button onclick="markAsRead({{ $notification->id }})"
                    class="rounded-lg bg-green-600 px-3 py-2 text-sm text-white transition-colors hover:bg-green-700">
                    <i class="fas fa-check mr-2"></i>
                    Tandai Dibaca
                  </button>
                @endif
                <button onclick="deleteNotification({{ $notification->id }})"
                  class="rounded-lg bg-red-600 px-3 py-2 text-sm text-white transition-colors hover:bg-red-700">
                  <i class="fas fa-trash mr-2"></i>
                  Hapus Notifikasi
                </button>
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
    }
  </script>
@endsection
