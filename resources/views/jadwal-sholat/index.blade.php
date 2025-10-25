@extends('layouts.app')

@section('title', 'Jadwal Sholat - EduPay')

@section('content')
  <!-- Header -->
  <div class="bg-white px-4 py-4 shadow-sm">
    <div class="flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <button onclick="history.back()" class="rounded-lg p-2 hover:bg-gray-100">
          <i data-lucide="arrow-left" class="h-6 w-6 text-gray-600"></i>
        </button>
        <div>
          <h1 class="text-xl font-bold text-gray-900">Jadwal Sholat</h1>
          <p class="text-sm text-gray-500">Jadwal waktu sholat untuk hari ini</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Loading State -->
  <div id="loading" class="px-4 py-8 text-center">
    <div class="inline-block h-8 w-8 animate-spin rounded-full border-b-2 border-purple-600"></div>
    <p class="mt-2 text-gray-500">Memuat jadwal sholat...</p>
  </div>

  <!-- Error State -->
  <div id="error" class="hidden px-4 py-8 text-center">
    <div class="rounded-lg bg-red-50 p-4">
      <i data-lucide="alert-circle" class="mx-auto mb-2 h-8 w-8 text-red-500"></i>
      <p class="font-medium text-red-700">Gagal memuat jadwal sholat</p>
      <p class="mt-1 text-sm text-red-600">Silakan coba lagi nanti</p>
      <button onclick="loadJadwalSholat()"
        class="mt-3 rounded-lg bg-red-600 px-4 py-2 text-sm text-white hover:bg-red-700">
        Coba Lagi
      </button>
    </div>
  </div>

  <!-- Main Content -->
  <div id="main-content" class="pb-18 hidden">
    <!-- Location & Date Info -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-4 py-4 text-white">
      <div class="flex items-center justify-between">
        <div>
          <h2 id="location-name" class="text-lg font-semibold">Jakarta</h2>
          <p id="current-date" class="text-sm text-purple-100"></p>
        </div>
      </div>
    </div>

    <!-- City Selector -->
    <div class="border-b bg-white px-4 py-4">
      <label class="mb-2 block text-sm font-medium text-gray-700">Pilih Kota</label>
      <select id="city-selector"
        class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2 focus:ring-purple-500">
        <option value="">Memuat daftar kota...</option>
      </select>
    </div>

    <!-- Next Prayer Info -->
    <div class="px-4 py-6">
      <div class="rounded-xl bg-gradient-to-r from-green-500 to-green-600 p-4 text-white">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-green-100">Waktu sholat berikutnya</p>
            <p id="next-prayer" class="text-lg font-semibold">-</p>
          </div>
          <div class="text-right">
            <p id="time-remaining" class="text-2xl font-bold">-</p>
            <p class="text-sm text-green-100">tersisa</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Prayer Times -->
    <div class="px-4 pb-6">
      <div class="space-y-3">
        <!-- Subuh -->
        <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
              <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100">
                <i data-lucide="sunrise" class="h-5 w-5 text-blue-600"></i>
              </div>
              <div>
                <h3 class="font-semibold text-gray-900">Subuh</h3>
                <p class="text-sm text-gray-500">Fajar</p>
              </div>
            </div>
            <div class="text-right">
              <p id="subuh-time" class="text-xl font-bold text-gray-900">-</p>
              <p class="text-sm text-gray-500">WIB</p>
            </div>
          </div>
        </div>

        <!-- Dzuhur -->
        <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
              <div class="flex h-10 w-10 items-center justify-center rounded-full bg-yellow-100">
                <i data-lucide="sun" class="h-5 w-5 text-yellow-600"></i>
              </div>
              <div>
                <h3 class="font-semibold text-gray-900">Dzuhur</h3>
                <p class="text-sm text-gray-500">Tengah hari</p>
              </div>
            </div>
            <div class="text-right">
              <p id="dzuhur-time" class="text-xl font-bold text-gray-900">-</p>
              <p class="text-sm text-gray-500">WIB</p>
            </div>
          </div>
        </div>

        <!-- Ashar -->
        <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
              <div class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-100">
                <i data-lucide="sun" class="h-5 w-5 text-orange-600"></i>
              </div>
              <div>
                <h3 class="font-semibold text-gray-900">Ashar</h3>
                <p class="text-sm text-gray-500">Sore</p>
              </div>
            </div>
            <div class="text-right">
              <p id="ashar-time" class="text-xl font-bold text-gray-900">-</p>
              <p class="text-sm text-gray-500">WIB</p>
            </div>
          </div>
        </div>

        <!-- Maghrib -->
        <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
              <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100">
                <i data-lucide="sunset" class="h-5 w-5 text-red-600"></i>
              </div>
              <div>
                <h3 class="font-semibold text-gray-900">Maghrib</h3>
                <p class="text-sm text-gray-500">Terbenam</p>
              </div>
            </div>
            <div class="text-right">
              <p id="maghrib-time" class="text-xl font-bold text-gray-900">-</p>
              <p class="text-sm text-gray-500">WIB</p>
            </div>
          </div>
        </div>

        <!-- Isya -->
        <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
              <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100">
                <i data-lucide="moon" class="h-5 w-5 text-indigo-600"></i>
              </div>
              <div>
                <h3 class="font-semibold text-gray-900">Isya</h3>
                <p class="text-sm text-gray-500">Malam</p>
              </div>
            </div>
            <div class="text-right">
              <p id="isya-time" class="text-xl font-bold text-gray-900">-</p>
              <p class="text-sm text-gray-500">WIB</p>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  @push('scripts')
    <script>
      let currentCityId = 1301; // Default Jakarta
      let cities = [];
      let jadwalData = null;
      let countdownInterval = null;

      // Format waktu dari HH:MM ke format yang lebih mudah dibaca
      function formatTime(timeString) {
        return timeString;
      }

      // Hitung waktu tersisa hingga sholat berikutnya
      function calculateTimeToNextPrayer() {
        if (!jadwalData || !jadwalData.jadwal) {
          return;
        }

        const now = new Date();
        const today = now.toISOString().split('T')[0];

        // Jika data bukan untuk hari ini, tampilkan Subuh besok
        if (jadwalData.jadwal.date !== today) {
          document.getElementById('next-prayer').textContent = 'Subuh';
          document.getElementById('time-remaining').textContent = 'Besok';
          return;
        }

        const prayers = [{
            name: 'Subuh',
            time: jadwalData.jadwal.subuh
          },
          {
            name: 'Dzuhur',
            time: jadwalData.jadwal.dzuhur
          },
          {
            name: 'Ashar',
            time: jadwalData.jadwal.ashar
          },
          {
            name: 'Maghrib',
            time: jadwalData.jadwal.maghrib
          },
          {
            name: 'Isya',
            time: jadwalData.jadwal.isya
          }
        ];

        const currentTime = now.getHours() * 60 + now.getMinutes();

        for (let prayer of prayers) {
          if (!prayer.time) continue;

          const [hours, minutes] = prayer.time.split(':').map(Number);
          const prayerTime = hours * 60 + minutes;

          if (prayerTime > currentTime) {
            const timeDiff = prayerTime - currentTime;
            const hoursLeft = Math.floor(timeDiff / 60);
            const minutesLeft = timeDiff % 60;

            document.getElementById('next-prayer').textContent = prayer.name;
            document.getElementById('time-remaining').textContent =
              `${hoursLeft.toString().padStart(2, '0')}:${minutesLeft.toString().padStart(2, '0')}`;
            return;
          }
        }

        // Jika sudah lewat semua waktu sholat hari ini
        document.getElementById('next-prayer').textContent = 'Subuh';
        document.getElementById('time-remaining').textContent = 'Besok';
      }

      // Load daftar kota
      async function loadCities() {
        try {
          const response = await fetch('/api/jadwal-sholat/cities');
          const result = await response.json();

          if (result.success) {
            cities = result.data;
            const citySelector = document.getElementById('city-selector');
            citySelector.innerHTML = '';

            cities.forEach(city => {
              const option = document.createElement('option');
              option.value = city.id;
              option.textContent = city.lokasi;
              if (city.id == currentCityId) {
                option.selected = true;
              }
              citySelector.appendChild(option);
            });

            // Initialize Select2 setelah data dimuat
            initializeSelect2();
          }
        } catch (error) {
          console.error('Error loading cities:', error);
        }
      }

      // Initialize Select2
      function initializeSelect2() {
        // Tunggu sampai Select2 tersedia
        const initSelect2 = () => {
          if (typeof $ !== 'undefined' && typeof $.fn.select2 !== 'undefined') {
            $('#city-selector').select2({
              placeholder: 'Pilih kota...',
              allowClear: true,
              width: '100%',
              language: {
                noResults: function() {
                  return "Kota tidak ditemukan";
                },
                searching: function() {
                  return "Mencari...";
                }
              }
            });

            // Event listener untuk perubahan kota dengan Select2
            $('#city-selector').on('select2:select', function(e) {
              currentCityId = e.params.data.id;
              loadJadwalSholat();
            });
          } else {
            // Jika Select2 belum tersedia, coba lagi setelah 100ms
            setTimeout(initSelect2, 100);
          }
        };

        initSelect2();
      }

      // Load jadwal sholat
      async function loadJadwalSholat() {
        try {
          document.getElementById('loading').classList.remove('hidden');
          document.getElementById('error').classList.add('hidden');
          document.getElementById('main-content').classList.add('hidden');

          const response = await fetch(`/api/jadwal-sholat?city_id=${currentCityId}`);
          const result = await response.json();

          if (result.success) {
            jadwalData = result.data;

            // Update UI
            document.getElementById('location-name').textContent = jadwalData.lokasi;
            document.getElementById('current-date').textContent = jadwalData.jadwal.tanggal;

            // Update waktu sholat
            document.getElementById('subuh-time').textContent = formatTime(jadwalData.jadwal.subuh);
            document.getElementById('dzuhur-time').textContent = formatTime(jadwalData.jadwal.dzuhur);
            document.getElementById('ashar-time').textContent = formatTime(jadwalData.jadwal.ashar);
            document.getElementById('maghrib-time').textContent = formatTime(jadwalData.jadwal.maghrib);
            document.getElementById('isya-time').textContent = formatTime(jadwalData.jadwal.isya);

            // Hitung waktu sholat berikutnya
            calculateTimeToNextPrayer();

            // Start countdown
            if (countdownInterval) {
              clearInterval(countdownInterval);
            }
            countdownInterval = setInterval(calculateTimeToNextPrayer, 60000); // Update setiap menit

            document.getElementById('loading').classList.add('hidden');
            document.getElementById('main-content').classList.remove('hidden');
          } else {
            throw new Error(result.message || 'Gagal memuat jadwal sholat');
          }
        } catch (error) {
          console.error('Error loading prayer times:', error);
          document.getElementById('loading').classList.add('hidden');
          document.getElementById('error').classList.remove('hidden');
        }
      }

      // Initialize
      document.addEventListener('DOMContentLoaded', function() {
        loadCities();
        loadJadwalSholat();
      });
    </script>
  @endpush
@endsection
