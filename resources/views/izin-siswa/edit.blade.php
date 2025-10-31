@extends('layouts.app')

@section('content')
  <div class="mb-18 w-full p-4">
    <!-- Header -->
    <x-header title="Edit Izin" backUrl="{{ route('izin-siswa.index') }}" />

    <!-- Main Content -->
    <div class="mx-auto py-6">
      <form method="POST" action="{{ route('izin-siswa.update', $izin->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- NISN -->
        <div class="mb-4">
          <label for="nisn" class="mb-2 block text-sm font-medium text-gray-700">NISN</label>
          <input type="text" id="nisn" value="{{ $izin->nisn }}"
            class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-gray-700" readonly>
        </div>

        <!-- Nama Siswa -->
        <div class="mb-4">
          <label for="nama" class="mb-2 block text-sm font-medium text-gray-700">Nama Siswa</label>
          <input type="text" id="nama" value="{{ $izin->nama }}"
            class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-gray-700" readonly>
        </div>

        <!-- Tanggal Izin -->
        <div class="mb-4">
          <label for="start_date" class="mb-2 block text-sm font-medium text-gray-700">Tanggal Izin <span
              class="text-red-500">*</span></label>
          <input type="text" id="start_date" name="tanggal_izin"
            value="{{ old('tanggal_izin', $izin->tanggal_izin->format('Y-m-d')) }}" max="{{ date('Y-m-d') }}"
            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900" required>
          @error('tanggal_izin')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Jenis Izin -->
        <div class="mb-4">
          <label for="jenis_izin" class="mb-2 block text-sm font-medium text-gray-700">Jenis Izin <span
              class="text-red-500">*</span></label>
          <select id="jenis_izin" name="jenis_izin"
            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900" required>
            <option value="">Pilih Jenis Izin</option>
            <option value="Sakit" {{ old('jenis_izin', $izin->jenis_izin) == 'Sakit' ? 'selected' : '' }}>Sakit</option>
            <option value="Izin" {{ old('jenis_izin', $izin->jenis_izin) == 'Izin' ? 'selected' : '' }}>Izin</option>
            <option value="Alpha" {{ old('jenis_izin', $izin->jenis_izin) == 'Alpha' ? 'selected' : '' }}>
              Alpha</option>
            <option value="Lainnya" {{ old('jenis_izin', $izin->jenis_izin) == 'Lainnya' ? 'selected' : '' }}>
              Lainnya</option>
          </select>
          @error('jenis_izin')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Alasan -->
        <div class="mb-4">
          <label for="alasan" class="mb-2 block text-sm font-medium text-gray-700">Alasan <span
              class="text-red-500">*</span></label>
          <textarea id="alasan" name="alasan" rows="4"
            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900" placeholder="Tuliskan alasan izin Anda..."
            required>{{ old('alasan', $izin->alasan) }}</textarea>
          @error('alasan')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Bukti Surat Lama -->
        @if ($izin->bukti_surat)
          <div class="mb-4">
            <label class="mb-2 block text-sm font-medium text-gray-700">Bukti Surat Saat Ini</label>
            <a href="{{ asset('storage/' . $izin->bukti_surat) }}" target="_blank"
              class="block text-sm text-purple-600 hover:underline">
              <svg class="inline h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                </path>
              </svg>
              Lihat File
            </a>
          </div>
        @endif

        <!-- Bukti Surat Baru -->
        <div class="mb-6">
          <label for="bukti_surat" class="mb-2 block text-sm font-medium text-gray-700">Upload Bukti Surat Baru
            (opsional)</label>
          <input type="file" id="bukti_surat" name="bukti_surat" accept=".png,.pdf,.jpg,.jpeg"
            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900">
          <p class="mt-1 text-sm text-gray-500">Format: PNG, PDF, JPG (Max: 2MB)</p>
          @error('bukti_surat')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex space-x-3">
          <x-button type="outline" href="{{ route('izin-siswa.index') }}" class="flex-1">
            Batal
          </x-button>
          <x-button type="primary" as="submit" class="flex-1">
            <i data-lucide="save" class="mr-1 h-4 w-4"></i>
            Simpan
          </x-button>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize Flatpickr when filter is shown
      if (typeof window.initializeFlatpickr === 'function') {
        window.initializeFlatpickr();
        document.getElementById('start_date').parentElement.classList.add('w-full');
      }
    });
  </script>
@endsection
