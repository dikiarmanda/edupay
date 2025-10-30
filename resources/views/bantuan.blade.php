@extends('layouts.app')

@section('title', 'Bantuan - EduPay')

@section('content')

  <!-- Content -->
  <div class="px-4 py-6">
    <div class="mb-6">
      <h2 class="mb-4 text-xl font-bold text-gray-900">Pusat Bantuan</h2>
      <p class="text-gray-600">Temukan jawaban untuk pertanyaan Anda</p>
    </div>

    <!-- Search Box -->
    <div class="mb-6">
      <div class="relative">
        <input id="helpSearch" type="text" placeholder="Cari bantuan..."
          class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 pl-10 focus:border-transparent focus:ring-2 focus:ring-purple-500">
        <i data-lucide="search" class="absolute left-3 top-3.5 h-5 w-5 text-gray-400"></i>
      </div>
    </div>

    <!-- FAQ Categories -->
    <div class="space-y-4">
      <!-- Category 1: Panduan Umum -->
      <button type="button" data-target="#faq-umum"
        class="w-full rounded-xl bg-white p-4 text-left shadow-sm transition hover:bg-gray-50">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100">
              <i data-lucide="help-circle" class="h-5 w-5 text-blue-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Panduan Umum</p>
              <p class="text-sm text-gray-500">Cara menggunakan EduPay</p>
            </div>
          </div>
          <i data-lucide="chevron-down" class="h-5 w-5 text-gray-400"></i>
        </div>
      </button>
      <div id="faq-umum" class="hidden rounded-xl border border-gray-200 bg-white p-4">
        <div class="space-y-3 text-sm text-gray-700">
          <div>
            <p class="font-semibold">Apa itu EduPay?</p>
            <p class="text-gray-600">EduPay adalah dompet digital untuk transaksi pendidikan seperti top up saldo,
              pembayaran tagihan, dan riwayat transaksi.</p>
          </div>
          <div>
            <p class="font-semibold">Cara mulai menggunakan</p>
            <ol class="mt-1 list-decimal space-y-1 pl-5">
              <li>Masuk ke akun Anda.</li>
              <li>Cek saldo di dashboard.</li>
              <li>Isi saldo melalui menu Isi Saldo.</li>
              <li>Lakukan pembayaran dari menu Riwayat atau halaman terkait.</li>
            </ol>
          </div>
          <div>
            <p class="font-semibold">Keamanan akun</p>
            <ul class="mt-1 list-disc space-y-1 pl-5">
              <li>Jaga kerahasiaan kata sandi dan OTP.</li>
              <li>Periksa URL situs dan pastikan berada di domain resmi.</li>
              <li>Keluar dari akun saat menggunakan perangkat bersama.</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Category 2: Top Up & Saldo -->
      <button type="button" data-target="#faq-topup"
        class="w-full rounded-xl bg-white p-4 text-left shadow-sm transition hover:bg-gray-50">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100">
              <i data-lucide="wallet" class="h-5 w-5 text-green-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Top Up & Saldo</p>
              <p class="text-sm text-gray-500">Cara mengisi saldo</p>
            </div>
          </div>
          <i data-lucide="chevron-down" class="h-5 w-5 text-gray-400"></i>
        </div>
      </button>
      <div id="faq-topup" class="hidden rounded-xl border border-gray-200 bg-white p-4">
        <div class="space-y-3 text-sm text-gray-700">
          <div>
            <p class="font-semibold">Langkah isi saldo</p>
            <ol class="mt-1 list-decimal space-y-1 pl-5">
              <li>Buka menu <span class="font-medium">Isi Saldo</span>.</li>
              <li>Pilih nominal atau masukkan jumlah lain.</li>
              <li>Klik <span class="font-medium">Lanjut ke Pembayaran</span>.</li>
              <li>Selesaikan pembayaran sesuai instruksi gateway.</li>
            </ol>
          </div>
          <div>
            <p class="font-semibold">Metode pembayaran top up</p>
            <p class="text-gray-600">Mendukung berbagai metode seperti transfer bank, e-wallet, dan virtual account
              (tergantung ketersediaan gateway).</p>
          </div>
          <div>
            <p class="font-semibold">Kapan saldo masuk?</p>
            <p class="text-gray-600">Umumnya <span class="font-medium">real-time</span> setelah pembayaran berhasil.
              Beberapa metode bisa memerlukan waktu verifikasi.</p>
          </div>
          <div>
            <p class="font-semibold">Kendala top up</p>
            <ul class="mt-1 list-disc space-y-1 pl-5">
              <li>Status <span class="font-medium">pending</span>: cek status di Riwayat lalu tekan <span
                  class="font-medium">Cek Status</span>.</li>
              <li>Status <span class="font-medium">gagal</span>: buat ulang invoice dan pastikan koneksi stabil.</li>
              <li>Saldo belum bertambah: tunggu 5–10 menit, lalu hubungi support jika masih sama.</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Category 3: Pembayaran -->
      <button type="button" data-target="#faq-bayar"
        class="w-full rounded-xl bg-white p-4 text-left shadow-sm transition hover:bg-gray-50">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-purple-100">
              <i data-lucide="credit-card" class="h-5 w-5 text-purple-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Pembayaran</p>
              <p class="text-sm text-gray-500">Cara melakukan pembayaran</p>
            </div>
          </div>
          <i data-lucide="chevron-down" class="h-5 w-5 text-gray-400"></i>
        </div>
      </button>
      <div id="faq-bayar" class="hidden rounded-xl border border-gray-200 bg-white p-4">
        <div class="space-y-3 text-sm text-gray-700">
          <div>
            <p class="font-semibold">Membayar dengan saldo</p>
            <ol class="mt-1 list-decimal space-y-1 pl-5">
              <li>Pastikan saldo mencukupi.</li>
              <li>Pilih transaksi/produk yang ingin dibayar.</li>
              <li>Konfirmasi pembayaran dan ikuti instruksi.</li>
            </ol>
          </div>
          <div>
            <p class="font-semibold">Status pembayaran</p>
            <ul class="mt-1 list-disc space-y-1 pl-5">
              <li><span class="font-medium">Berhasil</span>: pembayaran selesai, saldo terpotong.</li>
              <li><span class="font-medium">Pending</span>: tunggu proses, gunakan tombol <span class="font-medium">Cek
                  Status</span>.</li>
              <li><span class="font-medium">Gagal</span>: tidak ada pemotongan saldo, coba ulangi.</li>
            </ul>
          </div>
          <div>
            <p class="font-semibold">Pengembalian dana</p>
            <p class="text-gray-600">Jika pembayaran bermasalah setelah saldo terpotong, hubungi support dengan
              menyertakan <span class="font-medium">kode transaksi</span> untuk investigasi.</p>
          </div>
        </div>
      </div>

      <!-- Category 4 (opsional) -->
      {{-- <button type="button" data-target="#faq-kontak"
        class="w-full rounded-xl bg-white p-4 text-left shadow-sm transition hover:bg-gray-50">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-100">
              <i data-lucide="phone" class="h-5 w-5 text-orange-600"></i>
            </div>
            <div>
              <p class="font-medium text-gray-900">Hubungi Kami</p>
              <p class="text-sm text-gray-500">Kontak customer service</p>
            </div>
          </div>
          <i data-lucide="chevron-down" class="h-5 w-5 text-gray-400"></i>
        </div>
      </button>
      <div id="faq-kontak" class="hidden rounded-xl border border-gray-200 bg-white p-4">
        <div class="text-sm text-gray-700">
          <p>Email: support@edupay.id</p>
          <p>Jam layanan: 08.00–21.00 WIB</p>
        </div>
      </div> --}}
    </div>

    <!-- Contact Info -->
    {{-- <div class="mt-8 rounded-xl bg-purple-50 p-4 mb-18">
      <h3 class="mb-2 font-semibold text-gray-900">Butuh Bantuan Lebih Lanjut?</h3>
      <p class="mb-3 text-sm text-gray-600">Tim customer service kami siap membantu Anda 24/7</p>
      <div class="flex space-x-2">
        <button class="flex-1 rounded-lg bg-purple-600 px-4 py-2 text-sm font-medium text-white">
          <i data-lucide="message-circle" class="mr-1 inline h-4 w-4"></i>
          Chat
        </button>
        <button class="flex-1 rounded-lg border border-purple-600 bg-white px-4 py-2 text-sm font-medium text-purple-600">
          <i data-lucide="phone" class="mr-1 inline h-4 w-4"></i>
          Call
        </button>
      </div>
    </div> --}}
  </div>

  <script>
    // Toggle FAQ sections + Search
    document.addEventListener('DOMContentLoaded', function() {
      // Toggle
      document.querySelectorAll('[data-target]')?.forEach(btn => {
        btn.addEventListener('click', function() {
          const target = document.querySelector(this.getAttribute('data-target'));
          if (!target) return;
          const isHidden = target.classList.contains('hidden');
          // sembunyikan yang lain
          document.querySelectorAll('#faq-umum, #faq-topup, #faq-bayar').forEach(el => el.classList.add(
            'hidden'));
          if (isHidden) target.classList.remove('hidden');
          else target.classList.add('hidden');
        });
      });

      // Search filter
      const searchInput = document.getElementById('helpSearch');
      if (searchInput) {
        const buttons = Array.from(document.querySelectorAll('[data-target]'));
        const panelSelectors = ['#faq-umum', '#faq-topup', '#faq-bayar'];

        function applySearchFilter(query) {
          const q = (query || '').trim().toLowerCase();
          const panels = panelSelectors.map(s => document.querySelector(s));

          if (!q) {
            // Tampilkan semua tombol, sembunyikan semua panel
            buttons.forEach(btn => btn.classList.remove('hidden'));
            panels.forEach(p => p && p.classList.add('hidden'));
            return;
          }

          buttons.forEach(btn => {
            const targetSel = btn.getAttribute('data-target');
            const panel = targetSel ? document.querySelector(targetSel) : null;
            const combinedText = ((btn.innerText || '') + ' ' + (panel?.innerText || ''))
              .replace(/\s+/g, ' ')
              .toLowerCase();
            const matched = combinedText.includes(q);
            btn.classList.toggle('hidden', !matched);
            if (panel) panel.classList.toggle('hidden', !matched ? true : false);
          });
        }

        searchInput.addEventListener('input', (e) => applySearchFilter(e.target.value));
      }
    });
  </script>
@endsection
