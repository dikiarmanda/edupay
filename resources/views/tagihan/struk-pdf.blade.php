<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Struk Pembayaran - {{ $tagihan->id }}</title>

  <style>
    @import url('https://fonts.bunny.net/css?family=inter:400,500,600,700');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    @page {
      size: A4;
      margin: 0;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: white;
      padding: 5%;
      font-size: 13px;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .wrapper {
      width: 80%;
      max-height: 90vh;
      margin: 0 auto;
    }

    .container {
      background: white;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .top-accent {
      height: 4px;
      background: #9333ea;
    }

    .header {
      background: #9333ea;
      padding: 25px 30px;
      text-align: center;
      color: white;
    }

    .logo-circle {
      width: 70px;
      height: 70px;
      margin: 0 auto 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      border: 2px solid rgba(255, 255, 255, 0.4);
      background: rgba(255, 255, 255, 0.2);
    }

    .logo-circle svg {
      width: 35px;
      height: 35px;
      stroke: white;
      fill: none;
      stroke-width: 2;
    }

    .header h1 {
      font-size: 20px;
      font-weight: 700;
      color: white;
      margin: 0;
    }

    .content {
      padding: 25px 30px;
    }

    .transaction-box {
      background: #9333ea;
      border-radius: 12px;
      padding: 12px 16px;
      text-align: center;
      color: white;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .transaction-box svg {
      width: 18px;
      height: 18px;
      stroke: white;
      fill: none;
      stroke-width: 2;
    }

    .transaction-box span {
      font-size: 15px;
      font-weight: 700;
    }

    .info-section {
      margin-bottom: 20px;
    }

    .info-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 0;
      border-bottom: 1px solid #f3f4f6;
    }

    .info-row:last-child {
      border-bottom: none;
    }

    .info-label {
      display: flex;
      align-items: center;
      font-weight: 500;
      color: #6b7280;
      font-size: 13px;
      gap: 8px;
    }

    .info-label svg {
      width: 16px;
      height: 16px;
      stroke: #9333ea;
      fill: none;
      stroke-width: 2;
      flex-shrink: 0;
    }

    .info-value {
      font-weight: 600;
      color: #111827;
      font-size: 13px;
      text-align: right;
      max-width: 60%;
    }

    .summary-box {
      border-radius: 14px;
      border: 2px solid #e5e7eb;
      background: #f9fafb;
      padding: 18px;
      margin-bottom: 20px;
    }

    .summary-box h3 {
      margin-bottom: 15px;
      font-size: 14px;
      font-weight: 700;
      color: #1f2937;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .summary-box h3 svg {
      width: 16px;
      height: 16px;
      stroke: #9333ea;
      fill: none;
      stroke-width: 2;
    }

    .summary-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 12px;
    }

    .summary-row:last-child {
      margin-bottom: 0;
    }

    .summary-label {
      font-weight: 600;
      color: #4b5563;
      font-size: 13px;
    }

    .summary-value {
      font-size: 14px;
      font-weight: 700;
      color: #111827;
    }

    .discount-badge {
      background-color: #10b981;
      border-radius: 8px;
      padding: 4px 12px;
      font-weight: 700;
      color: white;
      font-size: 12px;
    }

    .total-divider {
      margin: 12px 0 0 0;
      border-top: 2px solid #d1d5db;
      padding-top: 12px;
    }

    .total-amount {
      background: #f59e0b;
      border-radius: 10px;
      padding: 8px 16px;
      font-size: 15px;
      font-weight: 700;
      color: white;
    }

    .status-box {
      background-color: #ecfdf5;
      border-radius: 12px;
      padding: 14px 16px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .status-label {
      display: flex;
      align-items: center;
      font-weight: 600;
      color: #4b5563;
      font-size: 13px;
      gap: 8px;
    }

    .status-label svg {
      width: 16px;
      height: 16px;
      stroke: #10b981;
      fill: none;
      stroke-width: 2;
    }

    .status-badge {
      background: #10b981;
      border-radius: 50px;
      padding: 6px 16px;
      font-size: 11px;
      font-weight: 700;
      color: white;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .footer {
      border-top: 2px solid #e5e7eb;
      background-color: #f9fafb;
      padding: 18px 30px;
      text-align: center;
    }

    .footer-text {
      font-size: 12px;
      color: #6b7280;
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .footer-text:last-child {
      margin-bottom: 0;
    }

    .footer-text svg {
      width: 14px;
      height: 14px;
      flex-shrink: 0;
    }

    .footer-text.success svg {
      stroke: #10b981;
      fill: none;
      stroke-width: 2;
    }

    .footer-text.info svg {
      stroke: #9333ea;
      fill: none;
      stroke-width: 2;
    }

    /* Print specific */
    @media print {
      body {
        background: white;
        padding: 5%;
      }

      .wrapper {
        width: 80%;
        max-height: 90%;
      }
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <div class="container">
      <div class="top-accent"></div>

      <!-- Header -->
      <div class="header">
        <div class="logo-circle">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
            <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
          </svg>
        </div>
        <h1>{{ $tagihan->merchant->nama_merchant }}</h1>
      </div>

      <!-- Content -->
      <div class="content">
        <!-- Transaction Number -->
        <div class="transaction-box">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
          </svg>
          <span>No. Transaksi: {{ str_pad($tagihan->id, 8, '0', STR_PAD_LEFT) }}</span>
        </div>

        <!-- Student Info -->
        <div class="info-section">
          <div class="info-row">
            <div class="info-label">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round"
                stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
              </svg>
              <span>Tanggal Pembayaran:</span>
            </div>
            <span
              class="info-value">{{ $tagihan->tgl_bayar ? $tagihan->tgl_bayar->translatedFormat('d M Y H:i') : '-' }}</span>
          </div>

          <div class="info-row">
            <div class="info-label">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round"
                stroke-linejoin="round">
                <line x1="4" x2="20" y1="9" y2="9" />
                <line x1="4" x2="20" y1="15" y2="15" />
                <line x1="10" x2="8" y1="3" y2="21" />
                <line x1="16" x2="14" y1="3" y2="21" />
              </svg>
              <span>NISN:</span>
            </div>
            <span class="info-value">{{ $tagihan->nisn }}</span>
          </div>

          <div class="info-row">
            <div class="info-label">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
              <span>Nama Siswa:</span>
            </div>
            <span class="info-value">{{ $tagihan->nama }}</span>
          </div>

          <div class="info-row">
            <div class="info-label">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
              </svg>
              <span>Kelas:</span>
            </div>
            <span class="info-value">{{ $tagihan->kelas }}</span>
          </div>

          <div class="info-row">
            <div class="info-label">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
              </svg>
              <span>Jenis Tagihan:</span>
            </div>
            <span class="info-value">{{ $tagihan->tagihan }}</span>
          </div>

          <div class="info-row">
            <div class="info-label">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round"
                stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
              </svg>
              <span>Periode:</span>
            </div>
            <span class="info-value">{{ bulanList()[$tagihan->bulan] }} {{ $tagihan->tahun_ajaran }}</span>
          </div>
        </div>

        <!-- Payment Summary -->
        <div class="summary-box">
          <h3>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round"
              stroke-linejoin="round">
              <rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect>
              <line x1="9" y1="10" x2="9" y2="16"></line>
              <line x1="15" y1="10" x2="15" y2="16"></line>
            </svg>
            Ringkasan Pembayaran
          </h3>

          <div class="summary-row">
            <span class="summary-label">Total Tagihan:</span>
            <span class="summary-value">Rp {{ number_format($tagihan->total, 0, ',', '.') }}</span>
          </div>

          @if ($tagihan->potongan > 0)
            <div class="summary-row">
              <span class="summary-label">Potongan:</span>
              <span class="discount-badge">-Rp {{ number_format($tagihan->potongan, 0, ',', '.') }}</span>
            </div>
          @endif

          <div class="total-divider">
            <div class="summary-row">
              <span class="summary-label" style="font-size: 14px; font-weight: 700;">Total Bayar:</span>
              <span class="total-amount">Rp {{ number_format($tagihan->bayar, 0, ',', '.') }}</span>
            </div>
          </div>
        </div>

        <!-- Status -->
        <div class="status-box">
          <div class="status-label">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round"
              stroke-linejoin="round">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
              <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            <span>Status Pembayaran:</span>
          </div>
          <span class="status-badge">{{ $tagihan->status_pembayaran_text }}</span>
        </div>
      </div>

      <!-- Footer -->
      <div class="footer">
        <div class="footer-text success">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round"
            stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
          </svg>
          <span>Terima kasih telah melakukan pembayaran</span>
        </div>
        <div class="footer-text info">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round"
            stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <path d="M9 15h6"></path>
          </svg>
          <span>Struk ini adalah bukti pembayaran yang sah</span>
        </div>
        <div class="footer-text info">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round"
            stroke-linejoin="round">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
            <path d="M9 12l2 2 4-4"></path>
          </svg>
          <span>Dikeluarkan oleh sistem EduPay</span>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
