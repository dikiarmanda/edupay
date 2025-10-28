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
          <h1 class="text-lg font-semibold text-gray-900">Ajukan Izin</h1>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="mx-auto max-w-md px-4 py-6">
      <form method="POST" action="{{ route('izin-siswa.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- NISN -->
        <div class="mb-4">
          <label for="nisn" class="mb-2 block text-sm font-medium text-gray-700">NISN</label>
          <input type="text" id="nisn" name="nisn"
            value="{{ session('auth')['nisn_siswa'] ?? (session('auth')['nisn'] ?? '') }}"
            class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-gray-700" readonly>
        </div>

        <!-- Nama Siswa -->
        <div class="mb-4">
          <label for="nama" class="mb-2 block text-sm font-medium text-gray-700">Nama Siswa</label>
          <input type="text" id="nama" name="nama" value="{{ session('auth')['nama'] ?? '' }}"
            class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-gray-700" readonly>
        </div>

        <!-- Tanggal Izin -->
        <div class="mb-4">
          <label for="tanggal_izin" class="mb-2 block text-sm font-medium text-gray-700">Tanggal Izin <span
              class="text-red-500">*</span></label>
          <input type="date" id="tanggal_izin" name="tanggal_izin" value="{{ old('tanggal_izin') }}"
            max="{{ date('Y-m-d') }}" class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900" required>
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
            <option value="sakit" {{ old('jenis_izin') == 'sakit' ? 'selected' : '' }}>Sakit</option>
            <option value="izin" {{ old('jenis_izin') == 'izin' ? 'selected' : '' }}>Izin</option>
            <option value="dispensasi" {{ old('jenis_izin') == 'dispensasi' ? 'selected' : '' }}>Dispensasi</option>
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
            required>{{ old('alasan') }}</textarea>
          @error('alasan')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Bukti Surat -->
        <div class="mb-6">
          <label for="bukti_surat" class="mb-2 block text-sm font-medium text-gray-700">Bukti Surat Izin (dengan tanda
            tangan orang tua) <span class="text-red-500">*</span></label>
          <input type="file" id="bukti_surat" name="bukti_surat" accept=".png,.pdf,.jpg,.jpeg"
            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900" required>
          <p class="mt-1 text-sm text-gray-500">Format: PNG, PDF, JPG (Max: 2MB)</p>
          @error('bukti_surat')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex space-x-3">
          <button type="button" onclick="history.back()"
            class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-3 font-medium text-gray-700 hover:bg-gray-50">
            Batal
          </button>
          <button type="submit"
            class="flex-1 rounded-lg bg-purple-600 px-4 py-3 font-medium text-white hover:bg-purple-700">
            Ajukan Izin
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
