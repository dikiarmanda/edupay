<!-- Bottom Navigation -->
<div class="bottom-nav">
  <div class="flex items-center justify-around py-2">
    <!-- Beranda -->
    <a href="{{ route('dashboard') }}" id="navDashboard"
      class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }} flex flex-col items-center space-y-1 py-2">
      <i data-lucide="home" class="h-6 w-6"></i>
      <span class="text-xs font-medium">Beranda</span>
    </a>

    <!-- Mutasi -->
    <a href="{{ route('mutasi') }}" id="navMutation"
      class="nav-item {{ request()->routeIs('mutasi') ? 'active' : '' }} flex flex-col items-center space-y-1 py-2">
      <i data-lucide="arrow-left-right" class="h-6 w-6 text-gray-600"></i>
      <span class="text-xs font-medium text-gray-600">Mutasi</span>
    </a>

    <!-- Bantuan -->
    <a href="{{ route('bantuan') }}" id="navHelp"
      class="nav-item {{ request()->routeIs('bantuan') ? 'active' : '' }} flex flex-col items-center space-y-1 py-2">
      <i data-lucide="help-circle" class="h-6 w-6 text-gray-600"></i>
      <span class="text-xs font-medium text-gray-600">Bantuan</span>
    </a>

    <!-- Profil -->
    <a href="{{ route('profil.index') }}" id="navProfile"
      class="nav-item {{ request()->routeIs('profil.index') ? 'active' : '' }} flex flex-col items-center space-y-1 py-2">
      <i data-lucide="user" class="h-6 w-6 text-gray-600"></i>
      <span class="text-xs font-medium text-gray-600">Profil</span>
    </a>
  </div>
