@extends('layouts.app')

@section('content')
  <div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow-sm">
      <div class="mx-auto max-w-md px-4 py-4">
        <div class="flex items-center space-x-3">
          <button onclick="history.back()" class="flex-shrink-0">
            <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
          </button>
          <h1 class="text-lg font-semibold text-gray-900">Izin Siswa</h1>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="mx-auto max-w-md px-4 py-6">
      <!-- Title and Description -->
      <div class="mb-6">
        <h1 class="mb-2 text-2xl font-bold text-gray-900">Izin Siswa</h1>
        <p class="text-sm text-gray-600">Kelola izin sekolah Anda.</p>
      </div>

      <!-- Add Button -->
      <div class="mb-4">
        <a href="{{ route('izin-siswa.create') }}"
          class="inline-block w-full rounded-lg bg-purple-600 px-4 py-3 text-center font-medium text-white hover:bg-purple-700">
          + Ajukan Izin
        </a>
      </div>

      <!-- Izin List -->
      <div class="space-y-4">
        @forelse($izinSiswa as $izin)
          <div class="rounded-lg bg-white p-4 shadow-sm">
            <div class="flex items-start justify-between">
              <div class="flex-1">
                <div class="mb-2 flex items-center justify-between">
                  <span class="rounded-full bg-pink-100 px-3 py-1 text-sm font-medium text-pink-600">
                    {{ $izin->jenis_izin_text }}
                  </span>
                  <button onclick="deleteIzin({{ $izin->id }})"
                    class="rounded-lg bg-red-600 px-4 py-2 text-center text-sm font-medium text-white hover:bg-red-700">
                    <i data-lucide="trash" class="h-4 w-4 text-white"></i>
                  </button>
                </div>
                <p class="text-sm text-slate-800">Tanggal:
                  {{ \Carbon\Carbon::parse($izin->tanggal_izin)->translatedFormat('d M Y') }}</p>
                <p class="mt-1 line-clamp-2 text-sm text-gray-500">{{ Str::limit($izin->alasan, 80) }}</p>
              </div>
            </div>
            <div class="mt-4 flex space-x-2">
              <a href="{{ route('izin-siswa.show', $izin->id) }}"
                class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-2 text-center text-sm font-medium text-gray-700 hover:bg-gray-50">
                Detail
              </a>
              @if (true)
                <a href="{{ route('izin-siswa.edit', $izin->id) }}"
                  class="flex-1 rounded-lg border border-purple-300 bg-white px-4 py-2 text-center text-sm font-medium text-purple-700 hover:bg-purple-50">
                  Edit
                </a>
              @endif
            </div>
          </div>
        @empty
          <div class="rounded-lg bg-white p-8 text-center shadow-sm">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
              </path>
            </svg>
            <p class="mt-4 text-gray-500">Belum ada izin yang diajukan.</p>
            <a href="{{ route('izin-siswa.create') }}"
              class="mt-4 inline-block rounded-lg bg-purple-600 px-4 py-2 font-medium text-white hover:bg-purple-700">
              Ajukan Izin Pertama
            </a>
          </div>
        @endforelse
      </div>

      <!-- Pagination -->
      @if ($izinSiswa->hasPages())
        <div class="mt-6">
          {{ $izinSiswa->links() }}
        </div>
      @endif
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div id="deleteModal"
    class="z-51 pointer-events-none fixed inset-0 flex items-center justify-center bg-black/50 opacity-0 transition-opacity duration-300 ease-in-out"
    onclick="closeDeleteModal()">
    <div
      class="mx-auto max-w-md scale-95 transform rounded-lg bg-white p-6 shadow-lg transition-transform duration-300 ease-in-out">
      <h3 class="mb-4 text-lg font-semibold">Konfirmasi Hapus</h3>
      <p class="mb-6 text-gray-600">Apakah Anda yakin ingin menghapus izin ini?</p>
      <div class="flex space-x-3">
        <button onclick="closeDeleteModal()"
          class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-2 font-medium text-gray-700 hover:bg-gray-50">
          Batal
        </button>
        <form id="deleteForm" method="POST" class="flex-1">
          @csrf
          @method('DELETE')
          <button type="submit" class="w-full rounded-lg bg-red-600 px-4 py-2 font-medium text-white hover:bg-red-700">
            Hapus
          </button>
        </form>
      </div>
    </div>
  </div>

  <script>
    function deleteIzin(id) {
      const modal = document.getElementById('deleteModal');
      const modalContent = modal.querySelector('div');

      document.getElementById('deleteForm').action = "{{ url('/izin-siswa') }}/" + id;

      // Show modal with animation
      modal.classList.remove('pointer-events-none');
      modal.classList.add('opacity-100');
      modalContent.classList.remove('scale-95');
      modalContent.classList.add('scale-100');
    }

    function closeDeleteModal() {
      const modal = document.getElementById('deleteModal');
      const modalContent = modal.querySelector('div');

      // Hide modal with animation
      modal.classList.add('pointer-events-none');
      modal.classList.remove('opacity-100');
      modalContent.classList.remove('scale-100');
      modalContent.classList.add('scale-95');
    }
  </script>
@endsection
