<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'EduPay')</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

  <!-- Fallback jQuery and Select2 CDN -->
  <script>
    // Check if jQuery is available after Vite loads
    window.addEventListener('load', function() {
      setTimeout(function() {
        if (typeof $ === 'undefined' || typeof $.fn.select2 === 'undefined') {
          console.log('Loading jQuery and Select2 from CDN as fallback...');

          // Load jQuery
          const jqueryScript = document.createElement('script');
          jqueryScript.src = 'https://code.jquery.com/jquery-3.7.1.min.js';
          jqueryScript.onload = function() {
            console.log('jQuery loaded from CDN');

            // Load Select2 CSS
            const select2CSS = document.createElement('link');
            select2CSS.rel = 'stylesheet';
            select2CSS.href = 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css';
            document.head.appendChild(select2CSS);

            // Load Select2 JS
            const select2Script = document.createElement('script');
            select2Script.src = 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js';
            select2Script.onload = function() {
              console.log('Select2 loaded from CDN');
              // Trigger custom event to notify that libraries are ready
              window.dispatchEvent(new CustomEvent('select2Ready'));
            };
            document.head.appendChild(select2Script);
          };
          document.head.appendChild(jqueryScript);
        } else {
          console.log('jQuery and Select2 already available from Vite');
        }
      }, 1000);
    });
  </script>

  <!-- Styles -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    /* Reset default margins and paddings */
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      width: 100%;
      max-width: 100vw;
    }

    /* Container untuk membatasi lebar seperti layar HP */
    .mobile-container {
      max-width: 480px;
      margin: 0 auto;
      width: 100%;
    }

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
      left: 50%;
      transform: translateX(-50%);
      width: 100%;
      max-width: 480px;
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

    /* Untuk layar yang lebih kecil dari 480px */
    @media (max-width: 480px) {
      .mobile-container {
        max-width: 100%;
        margin: 0;
      }

      .bottom-nav {
        left: 0;
        transform: none;
        max-width: 100%;
      }
    }
  </style>

  @stack('styles')
</head>

<body class="w-full overflow-x-hidden bg-gray-50">
  <!-- Main Content Container -->
  <div class="mobile-container min-h-screen w-full bg-white shadow-lg">
    @yield('content')

    <!-- Bottom Navigation -->
    @include('components.bottom-navigation')
  </div>

  <script>
    // Initialize Lucide icons
    lucide.createIcons();
  </script>

  @stack('scripts')
</body>

</html>
