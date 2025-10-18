<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>EduPay - Solusi Keuangan Sekolah Anda</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

  <!-- Styles -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    * {
      box-sizing: border-box;
    }

    html,
    body {
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }

    .splash-container {
      background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
      width: 100vw;
      height: 100vh;
      max-width: 100vw;
      overflow: hidden;
    }

    .brand-name {
      font-size: 2.5rem;
      font-weight: 700;
      color: #7c3aed;
      margin-bottom: 8px;
      letter-spacing: -0.025em;
    }

    .tagline {
      font-size: 1.125rem;
      color: #64748b;
      font-weight: 400;
      margin-bottom: 0;
    }

    .loading-dots {
      display: flex;
      gap: 8px;
      margin-top: 32px;
    }

    .loading-dot {
      width: 8px;
      height: 8px;
      background-color: #7c3aed;
      border-radius: 50%;
      animation: pulse 1.5s ease-in-out infinite;
    }

    .loading-dot:nth-child(2) {
      animation-delay: 0.2s;
    }

    .loading-dot:nth-child(3) {
      animation-delay: 0.4s;
    }

    @keyframes pulse {

      0%,
      100% {
        opacity: 0.3;
        transform: scale(0.8);
      }

      50% {
        opacity: 1;
        transform: scale(1);
      }
    }

    .fade-in {
      animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
      .splash-container {
        padding: 1rem;
      }

      .school-icon {
        height: 6rem;
        width: 6rem;
      }

      .school-icon i {
        height: 6rem;
        width: 6rem;
      }

      .brand-name {
        font-size: 2rem;
        margin-bottom: 6px;
      }

      .tagline {
        font-size: 1rem;
        padding: 0 1rem;
      }

      .loading-dots {
        margin-top: 24px;
      }
    }

    @media (max-width: 480px) {
      .school-icon {
        height: 5rem;
        width: 5rem;
      }

      .school-icon i {
        height: 5rem;
        width: 5rem;
      }

      .brand-name {
        font-size: 1.75rem;
      }

      .tagline {
        font-size: 0.9rem;
      }
    }
  </style>
</head>

<body class="splash-container flex min-h-screen items-center justify-center">
  <div class="fade-in text-center">
    <div class="school-icon mx-auto mb-4 flex h-32 w-32 items-center justify-center">
      <i data-lucide="school" class="text-primary h-32 w-32"></i>
    </div>

    <!-- Brand Name -->
    <h1 class="brand-name">EduPay</h1>

    <!-- Tagline -->
    <p class="tagline">Satu sentuhan, banyak kemudahan</p>

    <!-- Loading Animation -->
    <div class="flex justify-center">
      <div class="loading-dots">
        <div class="loading-dot"></div>
        <div class="loading-dot"></div>
        <div class="loading-dot"></div>
      </div>
    </div>
  </div>

  <script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Redirect ke login setelah 3 detik
    setTimeout(function() {
      window.location.href = '{{ route('login') }}';
    }, 3000);
  </script>
</body>

</html>
