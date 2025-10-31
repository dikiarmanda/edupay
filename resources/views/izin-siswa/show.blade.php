@extends('layouts.app')

@section('content')
  <div class="mb-18 w-full p-4">
    <!-- Header -->
    <x-header title="Detail Izin" backUrl="{{ route('izin-siswa.index') }}" />

    <!-- Main Content -->
    <div class="mx-auto py-6">
      <div class="space-y-4">

        <!-- Data Card -->
        <div class="rounded-lg border border-gray-200 p-6 shadow-sm">
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
                class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($izin->tanggal_izin)->translatedFormat('d M Y') }}</span>
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
              <span class="font-medium text-gray-900">{{ $izin->created_at->translatedFormat('d M Y H:i') }}</span>
            </div>
            @if ($izin->updated_at != $izin->created_at)
              <div class="flex justify-between">
                <span class="text-sm text-gray-600">Terakhir Diubah</span>
                <span class="font-medium text-gray-900">{{ $izin->updated_at->translatedFormat('d M Y H:i') }}</span>
              </div>
            @endif
          </div>
        </div>

        <!-- Bukti Surat Card -->
        @if ($izin->bukti_surat)
          <div class="rounded-lg border border-gray-200 p-6 shadow-sm">
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
              <x-button href="{{ route('izin-siswa.download-bukti', $izin->id) }}" type="primary" class="w-full">
                <i data-lucide="download" class="mr-1 h-4 w-4"></i>
                Download File
              </x-button>
            </div>
          </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex space-x-3">
          <x-button href="{{ route('izin-siswa.index') }}" type="outline" class="flex-1">
            Kembali
          </x-button>
          @if (
              \Carbon\Carbon::parse($izin->tanggal_izin)->isSameDay(now()) ||
                  \Carbon\Carbon::parse($izin->tanggal_izin)->isFuture())
            <x-button href="{{ route('izin-siswa.edit', $izin->id) }}" type="outline-primary" class="flex-1">
              Edit
            </x-button>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
