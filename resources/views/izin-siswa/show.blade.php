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
          <h1 class="text-lg font-semibold text-gray-900">Detail Izin</h1>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="mx-auto max-w-md px-4 py-6">
      <div class="space-y-4">
        <!-- Status Card -->
        <div class="rounded-lg bg-white p-6 shadow-sm">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">Status</p>
              <p
                class="{{ $izin->status == '1' ? 'text-green-600' : ($izin->status == '0' ? 'text-red-600' : 'text-yellow-600') }} mt-1 text-lg font-semibold">
                @if ($izin->status == '1')
                  Disetujui
                @elseif($izin->status == '0')
                  Ditolak
                @else
                  Menunggu Persetujuan
                @endif
              </p>
            </div>
            <div class="text-right">
              <span class="rounded-full bg-purple-100 px-3 py-1 text-sm font-medium text-purple-600">
                {{ $izin->jenis_izin_text }}
              </span>
            </div>
          </div>
        </div>

        <!-- Data Card -->
        <div class="rounded-lg bg-white p-6 shadow-sm">
          <h3 class="mb-4 font-semibold text-gray-900">Informasi Izin</h3>
          <div class="space-y-3">
            <div class="flex justify-between border-b border-gray-100 pb-2">
              <span class="text-sm text-gray-600">NISN</span>
              <span class="font-medium text-gray-900">{{ $izin->nisn }}</span>
            </div>
            <div class="flex justify-between border-b border-gray-100 pb-2">
              <span class="text-sm text-gray-600">Nama Siswa</span>
              <span class="font-medium text-gray-900">{{ $izin->nama }}</span>
            </div>
            <div class="flex justify-between border-b border-gray-100 pb-2">
              <span class="text-sm text-gray-600">Tanggal Izin</span>
              <span
                class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d M Y') }}</span>
            </div>
            <div class="flex justify-between border-b border-gray-100 pb-2">
              <span class="text-sm text-gray-600">Jenis Izin</span>
              <span class="font-medium text-gray-900">{{ $izin->jenis_izin_text }}</span>
            </div>
            <div class="border-b border-gray-100 pb-2">
              <span class="mb-1 block text-sm text-gray-600">Alasan</span>
              <p class="text-sm text-gray-900">{{ $izin->alasan }}</p>
            </div>
            <div class="flex justify-between border-b border-gray-100 pb-2">
              <span class="text-sm text-gray-600">Tanggal Diajukan</span>
              <span class="font-medium text-gray-900">{{ $izin->created_at->format('d M Y H:i') }}</span>
            </div>
            @if ($izin->updated_at != $izin->created_at)
              <div class="flex justify-between">
                <span class="text-sm text-gray-600">Terakhir Diubah</span>
                <span class="font-medium text-gray-900">{{ $izin->updated_at->format('d M Y H:i') }}</span>
              </div>
            @endif
          </div>
        </div>

        <!-- Bukti Surat Card -->
        @if ($izin->bukti_surat)
          <div class="rounded-lg bg-white p-6 shadow-sm">
            <h3 class="mb-4 font-semibold text-gray-900">Bukti Surat</h3>
            <div class="space-y-3">
              <a href="{{ asset('storage/' . $izin->bukti_surat) }}" target="_blank" class="block">
                <div class="flex items-center justify-between rounded-lg border border-purple-200 bg-purple-50 p-4">
                  <div class="flex items-center space-x-3">
                    <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                      </path>
                    </svg>
                    <div>
                      <p class="font-medium text-purple-900">Bukti Surat Izin</p>
                      <p class="text-sm text-purple-600">Klik untuk melihat</p>
                    </div>
                  </div>
                  <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                  </svg>
                </div>
              </a>
              <a href="{{ route('izin-siswa.download-bukti', $izin->id) }}" class="block">
                <button class="w-full rounded-lg bg-purple-600 px-4 py-2 font-medium text-white hover:bg-purple-700">
                  Download File
                </button>
              </a>
            </div>
          </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex space-x-3">
          <a href="{{ route('izin-siswa.index') }}"
            class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-3 text-center font-medium text-gray-700 hover:bg-gray-50">
            Kembali
          </a>
          @if (!$izin->status)
            <a href="{{ route('izin-siswa.edit', $izin->id) }}"
              class="flex-1 rounded-lg border border-purple-300 bg-white px-4 py-3 text-center font-medium text-purple-700 hover:bg-purple-50">
              Edit
            </a>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
