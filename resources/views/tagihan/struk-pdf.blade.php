<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Struk Pembayaran - {{ $tagihan->id }}</title>

  <!-- Tailwind CSS - Multiple CDN fallback -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    /* Fallback jika Tailwind tidak load */
    .flex {
      display: flex;
    }

    .items-center {
      align-items: center;
    }

    .justify-center {
      justify-content: center;
    }

    .justify-between {
      justify-content: space-between;
    }

    .min-h-screen {
      min-height: 100vh;
    }

    .w-full {
      width: 100%;
    }

    .max-w-md {
      max-width: 28rem;
    }

    .rounded-3xl {
      border-radius: 1.5rem;
    }

    .shadow-2xl {
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .bg-white {
      background-color: white;
    }

    .p-5 {
      padding: 1.25rem;
    }

    .p-6 {
      padding: 1.5rem;
    }

    .px-6 {
      padding-left: 1.5rem;
      padding-right: 1.5rem;
    }

    .py-8 {
      padding-top: 2rem;
      padding-bottom: 2rem;
    }

    .mb-2 {
      margin-bottom: 0.5rem;
    }

    .mb-4 {
      margin-bottom: 1rem;
    }

    .mb-6 {
      margin-bottom: 1.5rem;
    }

    .text-center {
      text-align: center;
    }

    .text-white {
      color: white;
    }

    .font-bold {
      font-weight: 700;
    }

    .text-xl {
      font-size: 1.25rem;
    }

    .text-lg {
      font-size: 1.125rem;
    }

    .text-sm {
      font-size: 0.875rem;
    }

    .space-y-4>*+* {
      margin-top: 1rem;
    }

    .space-y-3>*+* {
      margin-top: 0.75rem;
    }

    .space-y-2>*+* {
      margin-top: 0.5rem;
    }

    .bg-gradient-purple {
      background: linear-gradient(135deg, #9333ea 0%, #7c3aed 50%, #a855f7 100%);
    }

    .icon {
      width: 16px;
      height: 16px;
      margin-right: 8px;
      color: #9333ea;
      display: inline-block;
      vertical-align: middle;
    }

    .icon-white {
      width: 20px;
      height: 20px;
      color: white;
    }

    .icon-green {
      width: 16px;
      height: 16px;
      margin-right: 8px;
      color: #10b981;
    }

    .icon-orange {
      width: 16px;
      height: 16px;
      margin-right: 8px;
      color: #f59e0b;
    }
  </style>
</head>

<body class="bg-gradient-purple flex min-h-screen items-center justify-center p-5">
  <div class="relative w-full max-w-md overflow-hidden rounded-3xl bg-white shadow-2xl">
    <!-- Top accent line -->
    <div
      style="position: absolute; left: 0; right: 0; top: 0; height: 4px; background: linear-gradient(to right, #9333ea, #a855f7, #ec4899);">
    </div>

    <!-- Header -->
    <div class="bg-gradient-purple relative px-6 py-8 text-center text-white">
      <div
        class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full border-2 border-white/30 bg-white/20 backdrop-blur-sm"
        style="width: 80px; height: 80px; margin: 0 auto 1rem; border-radius: 50%; border: 2px solid rgba(255,255,255,0.3); background: rgba(255,255,255,0.2);">
        <svg class="icon-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
          <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
        </svg>
      </div>
      <h1 class="mb-2 text-xl font-bold text-white drop-shadow-sm">SMA Negeri 1 Jakarta</h1>
      <p class="text-sm font-light opacity-90">EduPay - Sistem Pembayaran Sekolah</p>
    </div>

    <!-- Content -->
    <div class="p-6">
      <!-- Transaction Number -->
      <div class="mb-6 rounded-xl px-4 py-3 text-center text-white"
        style="background: linear-gradient(to right, #9333ea, #7c3aed); border-radius: 12px;">
        <div class="flex items-center justify-center">
          <svg class="icon-white mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            style="margin-right: 8px;">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
            <polyline points="10 9 9 9 8 9"></polyline>
          </svg>
          <span class="text-lg font-bold">No. Transaksi: {{ str_pad($tagihan->id, 8, '0', STR_PAD_LEFT) }}</span>
        </div>
      </div>

      <!-- Student Info -->
      <div class="mb-6 space-y-4">
        <div class="flex items-center justify-between border-b border-gray-100 py-3"
          style="border-bottom: 1px solid #f3f4f6; padding: 12px 0;">
          <div class="flex items-center">
            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
              <line x1="16" y1="2" x2="16" y2="6"></line>
              <line x1="8" y1="2" x2="8" y2="6"></line>
              <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            <span class="font-medium text-gray-600" style="font-weight: 500; color: #4b5563;">Tanggal Pembayaran:</span>
          </div>
          <span class="font-semibold text-gray-900"
            style="font-weight: 600; color: #111827;">{{ $tagihan->tgl_bayar ? $tagihan->tgl_bayar->translatedFormat('d M Y H:i') : '-' }}</span>
        </div>

        <div class="flex items-center justify-between border-b border-gray-100 py-3"
          style="border-bottom: 1px solid #f3f4f6; padding: 12px 0;">
          <div class="flex items-center">
            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
              <line x1="16" y1="2" x2="16" y2="6"></line>
              <line x1="8" y1="2" x2="8" y2="6"></line>
              <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            <span class="font-medium text-gray-600" style="font-weight: 500; color: #4b5563;">NISN:</span>
          </div>
          <span class="font-semibold text-gray-900"
            style="font-weight: 600; color: #111827;">{{ $tagihan->nisn }}</span>
        </div>

        <div class="flex items-center justify-between border-b border-gray-100 py-3"
          style="border-bottom: 1px solid #f3f4f6; padding: 12px 0;">
          <div class="flex items-center">
            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span class="font-medium text-gray-600" style="font-weight: 500; color: #4b5563;">Nama Siswa:</span>
          </div>
          <span class="font-semibold text-gray-900"
            style="font-weight: 600; color: #111827;">{{ $tagihan->nama }}</span>
        </div>

        <div class="flex items-center justify-between border-b border-gray-100 py-3"
          style="border-bottom: 1px solid #f3f4f6; padding: 12px 0;">
          <div class="flex items-center">
            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
              <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
            </svg>
            <span class="font-medium text-gray-600" style="font-weight: 500; color: #4b5563;">Kelas:</span>
          </div>
          <span class="font-semibold text-gray-900"
            style="font-weight: 600; color: #111827;">{{ $tagihan->kelas }}</span>
        </div>

        <div class="flex items-center justify-between border-b border-gray-100 py-3"
          style="border-bottom: 1px solid #f3f4f6; padding: 12px 0;">
          <div class="flex items-center">
            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
              <polyline points="14 2 14 8 20 8"></polyline>
              <line x1="16" y1="13" x2="8" y2="13"></line>
              <line x1="16" y1="17" x2="8" y2="17"></line>
            </svg>
            <span class="font-medium text-gray-600" style="font-weight: 500; color: #4b5563;">Jenis Tagihan:</span>
          </div>
          <span class="font-semibold text-gray-900"
            style="font-weight: 600; color: #111827;">{{ $tagihan->tagihan }}</span>
        </div>

        <div class="flex items-center justify-between py-3" style="padding: 12px 0;">
          <div class="flex items-center">
            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
              <line x1="16" y1="2" x2="16" y2="6"></line>
              <line x1="8" y1="2" x2="8" y2="6"></line>
              <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            <span class="font-medium text-gray-600" style="font-weight: 500; color: #4b5563;">Periode:</span>
          </div>
          <span class="font-semibold text-gray-900"
            style="font-weight: 600; color: #111827;">{{ $tagihan->nama_bulan }} {{ $tagihan->tahun_ajaran }}</span>
        </div>
      </div>

      <!-- Payment Summary -->
      <div class="mb-6 rounded-2xl border border-gray-200 p-5"
        style="border-radius: 16px; border: 1px solid #e5e7eb; background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%); padding: 20px;">
        <h3 class="mb-4 flex items-center text-lg font-bold text-gray-800"
          style="margin-bottom: 16px; font-size: 1.125rem; font-weight: 700; color: #1f2937;">
          <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect>
            <line x1="9" y1="10" x2="9" y2="16"></line>
            <line x1="15" y1="10" x2="15" y2="16"></line>
          </svg>
          Ringkasan Pembayaran
        </h3>

        <div class="space-y-3">
          <div class="flex items-center justify-between">
            <span class="font-semibold text-gray-700" style="font-weight: 600; color: #374151;">Total Tagihan:</span>
            <span class="text-lg font-bold text-gray-900"
              style="font-size: 1.125rem; font-weight: 700; color: #111827;">Rp{{ number_format($tagihan->total, 0, ',', '.') }}</span>
          </div>

          @if ($tagihan->potongan > 0)
            <div class="flex items-center justify-between">
              <span class="font-semibold text-gray-700" style="font-weight: 600; color: #374151;">Potongan:</span>
              <span class="rounded-lg px-3 py-1 font-bold text-white"
                style="background-color: #10b981; border-radius: 8px; padding: 4px 12px; font-weight: 700; color: white;">
                -Rp{{ number_format($tagihan->potongan, 0, ',', '.') }}
              </span>
            </div>
          @endif

          <div style="margin-top: 12px; border-top: 1px solid #d1d5db; padding-top: 12px;">
            <div class="flex items-center justify-between">
              <span class="text-lg font-bold text-gray-800"
                style="font-size: 1.125rem; font-weight: 700; color: #1f2937;">Total Bayar:</span>
              <span
                style="background: linear-gradient(to right, #f59e0b, #eab308); border-radius: 12px; padding: 8px 16px; font-size: 1.125rem; font-weight: 700; color: white;">
                Rp{{ number_format($tagihan->bayar, 0, ',', '.') }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Status -->
      <div class="mb-6 flex items-center justify-between rounded-xl px-4 py-4"
        style="background-color: #ecfdf5; border-radius: 12px; padding: 16px;">
        <div class="flex items-center">
          <svg class="icon-green" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
          </svg>
          <span class="font-semibold text-gray-700" style="font-weight: 600; color: #374151;">Status
            Pembayaran:</span>
        </div>
        <span
          style="background: linear-gradient(to right, #10b981, #059669); border-radius: 9999px; padding: 8px 16px; font-size: 0.875rem; font-weight: 700; color: white; text-transform: uppercase; letter-spacing: 0.05em;">
          {{ $tagihan->status_pembayaran_text }}
        </span>
      </div>
    </div>

    <!-- Footer -->
    <div class="border-t border-gray-200 px-6 py-5 text-center"
      style="border-top: 1px solid #e5e7eb; background-color: #f9fafb; padding: 20px 24px; text-align: center;">
      <div class="space-y-2">
        <p class="flex items-center justify-center text-sm text-gray-600"
          style="font-size: 0.875rem; color: #4b5563; margin-bottom: 8px;">
          <svg class="icon-green" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
          </svg>
          Terima kasih telah melakukan pembayaran
        </p>
        <p class="flex items-center justify-center text-sm text-gray-600"
          style="font-size: 0.875rem; color: #4b5563; margin-bottom: 8px;">
          <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <path d="M9 15h6"></path>
          </svg>
          Struk ini adalah bukti pembayaran yang sah
        </p>
        <p class="flex items-center justify-center text-sm text-gray-600"
          style="font-size: 0.875rem; color: #4b5563;">
          <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
            <path d="M9 12l2 2 4-4"></path>
          </svg>
          Dikeluarkan oleh sistem EduPay
        </p>
      </div>
    </div>
  </div>
</body>

</html>
