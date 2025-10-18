<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>@yield('title', 'EduPay')</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

  <!-- Styles -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    .gradient-bg {
      background: linear-gradient(135deg, #7c3aed 0%, #a855f7 50%, #c084fc 100%);
    }

    .floating-shapes {
      position: relative;
      overflow: hidden;
    }

    .floating-shapes::before {
      content: '';
      position: absolute;
      top: -50px;
      right: -50px;
      width: 100px;
      height: 100px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
    }

    .floating-shapes::after {
      content: '';
      position: absolute;
      bottom: -30px;
      left: -30px;
      width: 60px;
      height: 60px;
      background: rgba(255, 255, 255, 0.08);
      border-radius: 50%;
    }

    .menu-item {
      transition: all 0.2s ease;
    }

    .menu-item:hover {
      transform: translateY(-2px);
    }

    .bottom-nav {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      background: white;
      border-top: 1px solid #e5e7eb;
      z-index: 50;
    }

    .nav-item {
      transition: all 0.2s ease;
    }

    .nav-item.active {
      color: #7c3aed;
    }

    .nav-item.active svg {
      color: #7c3aed;
    }

    .notification-dot {
      position: absolute;
      top: -2px;
      right: -2px;
      width: 8px;
      height: 8px;
      background: #ef4444;
      border-radius: 50%;
    }

    /* Mobile specific styles */
    @media (max-width: 768px) {
      .mobile-container {
        padding-bottom: 80px;
        /* Space for bottom navigation */
      }
    }
  </style>

  @stack('styles')
</head>

<body class="bg-gray-50">
  <!-- Main Content Container -->
  <div class="mobile-container min-h-screen">
    @yield('content')
  </div>

  <!-- Bottom Navigation -->
  @include('components.bottom-navigation')

  <script>
    // Initialize Lucide icons
    lucide.createIcons();
  </script>

  @stack('scripts')
</body>

</html>
