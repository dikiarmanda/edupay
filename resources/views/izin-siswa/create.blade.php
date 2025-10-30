    @extends('layouts.app')

    @section('content')
      <div class="min-h-screen bg-gray-100">
        <!-- Header -->
        <div class="bg-white shadow-sm">
          <div class="mx-auto max-w-md px-4 py-5">
            <div class="flex items-center justify-between">
              <a href="{{ route('izin-siswa.index') }}"
                class="inline-flex items-center space-x-2 rounded-lg text-sm font-medium text-gray-700 transition-colors hover:text-gray-900">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                <span>Kembali</span>
              </a>
              <div class="text-right">
                <h1 class="text-lg font-semibold text-gray-900">Ajukan Izin</h1>
                <p class="text-xs text-gray-500">Formulir pengajuan izin siswa</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Main Content -->
        <div class="mx-auto max-w-md px-4 py-6 mb-18">
          <form method="POST" action="{{ route('izin-siswa.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- NISN -->
            <div>
              <label for="nisn" class="mb-2 block text-sm font-medium text-gray-700">NISN</label>
              <div class="relative">
                <i data-lucide="id-card" class="pointer-events-none absolute left-3 top-3.5 h-4 w-4 text-gray-400"></i>
                <input type="text" id="nisn" name="nisn"
                  value="{{ session('auth')['nisn_siswa'] ?? (session('auth')['nisn'] ?? '') }}"
                  class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 pl-9 text-gray-700" readonly>
              </div>
            </div>

            <!-- Nama Siswa -->
            <div>
              <label for="nama" class="mb-2 block text-sm font-medium text-gray-700">Nama Siswa</label>
              <div class="relative">
                <i data-lucide="user" class="pointer-events-none absolute left-3 top-3.5 h-4 w-4 text-gray-400"></i>
                <input type="text" id="nama" name="nama" value="{{ session('auth')['nama'] ?? '' }}"
                  class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 pl-9 text-gray-700" readonly>
              </div>
            </div>

            <!-- Tanggal Izin -->
            <div>
              <label for="tanggal_izin" class="mb-2 block text-sm font-medium text-gray-700">Tanggal Izin <span
                  class="text-red-500">*</span></label>
              <div class="relative">
                <i data-lucide="calendar" class="pointer-events-none absolute left-3 top-3.5 h-4 w-4 text-gray-400"></i>
                <input type="text" id="tanggal_izin" name="tanggal_izin" value="{{ old('tanggal_izin') }}"
                  placeholder="Pilih tanggal izin" readonly
                  class="w-full cursor-pointer rounded-lg border border-gray-300 bg-white px-4 py-3 pl-9 text-gray-900 focus:border-purple-500 focus:outline-none focus:ring-1 focus:ring-purple-500"
                  required>
              </div>
              <p class="mt-1 text-xs text-gray-500">Tanggal tidak dapat melebihi hari ini.</p>
              @error('tanggal_izin')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Jenis Izin -->
            <div>
              <label for="jenis_izin" class="mb-2 block text-sm font-medium text-gray-700">Jenis Izin <span
                  class="text-red-500">*</span></label>
              <div class="relative">
                <i data-lucide="list" class="pointer-events-none absolute left-3 top-3.5 h-4 w-4 text-gray-400"></i>
                <select id="jenis_izin" name="jenis_izin"
                  class="w-full appearance-none rounded-lg border border-gray-300 px-4 py-3 pl-9 text-gray-900 focus:border-purple-500 focus:outline-none focus:ring-1 focus:ring-purple-500"
                  required>
                  <option value="">Pilih Jenis Izin</option>
                  <option value="sakit" {{ old('jenis_izin') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                  <option value="izin" {{ old('jenis_izin') == 'izin' ? 'selected' : '' }}>Izin</option>
                  <option value="dispensasi" {{ old('jenis_izin') == 'dispensasi' ? 'selected' : '' }}>Dispensasi</option>
                </select>
              </div>
              @error('jenis_izin')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Alasan -->
            <div>
              <label for="alasan" class="mb-2 block text-sm font-medium text-gray-700">Alasan <span
                  class="text-red-500">*</span></label>
              <textarea id="alasan" name="alasan" rows="4"
                class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 focus:border-purple-500 focus:outline-none focus:ring-1 focus:ring-purple-500"
                placeholder="Tuliskan alasan izin Anda..." required>{{ old('alasan') }}</textarea>
              @error('alasan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Bukti Surat -->
            <div>
              <label for="bukti_surat" class="mb-2 block text-sm font-medium text-gray-700">Bukti Surat Izin (dengan tanda
                tangan orang tua) <span class="text-red-500">*</span></label>
              <div class="relative">
                <i data-lucide="paperclip" class="pointer-events-none absolute left-3 top-3.5 h-4 w-4 text-gray-400"></i>
                <input type="file" id="bukti_surat" name="bukti_surat" accept=".png,.pdf,.jpg,.jpeg"
                  class="w-full rounded-lg border border-gray-300 px-4 py-3 pl-9 text-gray-900 focus:border-purple-500 focus:outline-none focus:ring-1 focus:ring-purple-500"
                  required>
              </div>
              <p class="mt-1 text-sm text-gray-500">Format: PNG, PDF, JPG (Max: 2MB)</p>
              @error('bukti_surat')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex space-x-3 pt-2">
              <button type="button" onclick="history.back()"
                class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-3 font-medium text-gray-700 transition-colors hover:bg-gray-50">
                Batal
              </button>
              <button type="submit"
                class="flex-1 rounded-lg bg-purple-600 px-4 py-3 font-medium text-white transition-colors hover:bg-purple-700">
                Ajukan Izin
              </button>
            </div>
          </form>
        </div>
      </div>
    @endsection

    @push('scripts')
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const input = document.getElementById('tanggal_izin');
          if (input && window.flatpickr) {
            const picker = window.flatpickr(input, {
              locale: (window.flatpickr.l10ns && window.flatpickr.l10ns.id) ? window.flatpickr.l10ns.id : 'id',
              dateFormat: 'Y-m-d',
              allowInput: false,
              clickOpens: true,
              static: true,
              maxDate: 'today',
            });
            ['focus', 'click'].forEach(evt => input.addEventListener(evt, () => picker.open()));
          }
        });
      </script>
    @endpush
