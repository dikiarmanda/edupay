<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - EduPay</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
  <style>
    .login-container {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
    }
  </style>
</head>

<body>
  <div class="login-container flex min-h-screen items-center justify-center px-4">
    <div class="w-full max-w-sm rounded-2xl bg-white p-8 shadow-2xl">
      <!-- Logo -->
      <div class="mb-6 flex justify-center">
        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-purple-100">
          <i data-lucide="school" class="h-8 w-8 text-purple-600"></i>
        </div>
      </div>

      <!-- Welcome Message -->
      <div class="mb-2 text-center">
        <h1 class="text-2xl font-bold text-gray-800">Selamat Datang di EduPay</h1>
      </div>

      <!-- Instruction -->
      <div class="mb-8 text-center">
        <p class="text-gray-500">Silakan masuk ke akun Anda</p>
      </div>

      <!-- Login Form -->
      <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- NISN Field -->
        <div class="mb-4">
          <label for="nisn" class="mb-2 block text-sm font-medium text-gray-700">NISN</label>
          <input type="text" id="nisn" name="nisn" value="{{ old('nisn', '') }}"
            class="w-full rounded-lg border border-gray-300 px-4 py-3 transition duration-200 focus:border-transparent focus:ring-2 focus:ring-purple-500"
            placeholder="Masukkan NISN Anda" required>
          @error('nisn')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
          @enderror
        </div>

        <!-- Password Field -->
        <div class="mb-6">
          <label for="password" class="mb-2 block text-sm font-medium text-gray-700">Password</label>
          <input type="password" id="password" name="password"
            class="w-full rounded-lg border border-gray-300 px-4 py-3 transition duration-200 focus:border-transparent focus:ring-2 focus:ring-purple-500"
            placeholder="Masukkan password Anda" required>
          @error('password')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
          @enderror
        </div>

        <!-- Login Button -->
        <button type="submit"
          class="w-full rounded-lg bg-purple-600 px-4 py-3 font-bold text-white transition duration-200 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
          Masuk
        </button>
      </form>

      <!-- Forgot Password Link -->
      {{-- <div class="mt-6 text-center">
        <a href="#" class="text-sm font-medium text-purple-600 transition duration-200 hover:text-purple-700">
          Lupa password?
        </a>
      </div> --}}
    </div>
  </div>

  <script>
    lucide.createIcons();
  </script>
</body>

</html>
