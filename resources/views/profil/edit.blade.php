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
          <h1 class="text-lg font-semibold text-gray-900">Edit Profil</h1>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="mx-auto max-w-md px-4 py-6">
      <div class="rounded-2xl bg-white p-6 shadow-sm">
        <!-- Profile Photo Section -->
        <div class="mb-8 text-center">
          <div class="relative inline-block">
            <img id="profile-image" src="https://dummyimage.com/300" alt="Profile Photo"
              class="h-30 w-30 rounded-full border-4 border-white shadow-lg">
            <button onclick="document.getElementById('photo-input').click()"
              class="absolute bottom-0 right-0 flex h-8 w-8 items-center justify-center rounded-full bg-purple-600 text-white shadow-lg hover:bg-purple-700">
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                </path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
            </button>
          </div>
          <p class="mt-3 text-sm text-gray-600">Klik ikon kamera untuk mengubah foto profil</p>
          <input type="file" id="photo-input" accept="image/*" class="hidden" onchange="previewImage(this)">
        </div>

        <!-- Edit Form -->
        <form id="edit-profile-form" action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="mb-6">
            <label class="mb-2 block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" value="John Doe"
              class="w-full rounded-lg border border-gray-200 bg-gray-100 px-4 py-3 text-gray-500" readonly>
            <p class="mt-1 text-xs text-gray-500">Nama tidak dapat diubah</p>
          </div>

          <div class="mb-6">
            <label class="mb-2 block text-sm font-medium text-gray-700">Tanggal Lahir</label>
            <input type="text" value="01 Januari 1990"
              class="w-full rounded-lg border border-gray-200 bg-gray-100 px-4 py-3 text-gray-500" readonly>
            <p class="mt-1 text-xs text-gray-500">Tanggal lahir tidak dapat diubah</p>
          </div>

          <div class="mb-6">
            <label for="hp" class="mb-2 block text-sm font-medium text-gray-700">Nomor Telepon</label>
            <input type="text" id="hp" name="hp" value="+62 812 3456 7890"
              class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-purple-500">
          </div>

          <div class="mb-6">
            <label for="email" class="mb-2 block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" value="user@example.com"
              class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-purple-500"
              placeholder="Masukkan email baru">
          </div>

          <!-- Action Buttons -->
          <div class="flex space-x-3">
            <button type="submit"
              class="flex-1 rounded-lg bg-purple-600 px-6 py-3 font-medium text-white hover:bg-purple-700">
              Simpan Perubahan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Include Toast Component -->
  @include('components.toast')

  <script>
    // Preview image function
    function previewImage(input) {
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('profile-image').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
      }
    }

    // Form submission
    document.getElementById('edit-profile-form').addEventListener('submit', function(e) {
      const email = document.getElementById('email').value;
      const hp = document.getElementById('hp').value;

      // Basic validation
      if (!email) {
        e.preventDefault();
        showToast('Email harus diisi', 'error');
        return;
      }

      if (!isValidEmail(email)) {
        e.preventDefault();
        showToast('Format email tidak valid', 'error');
        return;
      }

      // Show loading toast
      showToast('Menyimpan perubahan...', 'success');
    });

    // Email validation
    function isValidEmail(email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
    }
  </script>

  <style>
    .h-30 {
      height: 7.5rem;
    }

    .w-30 {
      width: 7.5rem;
    }
  </style>
@endsection
