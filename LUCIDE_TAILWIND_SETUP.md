# Lucide Icons & Tailwind CSS Setup

## Status Instalasi ✅

### Tailwind CSS

-   ✅ Terinstall di `package.json` (versi 4.1.14)
-   ✅ Terkonfigurasi di `tailwind.config.js`
-   ✅ Terintegrasi dengan Vite di `vite.config.js`
-   ✅ CSS sudah diimport di `resources/css/app.css`

### Lucide Icons

-   ✅ Terinstall sebagai dependency lokal (`npm install lucide`)
-   ✅ Terintegrasi ke dalam Vite bundle
-   ✅ Script inisialisasi di `resources/js/lucide-icons.js`
-   ✅ Auto-loading di `resources/js/app.js`

## Cara Penggunaan

### Lucide Icons

```html
<!-- Gunakan dengan atribut data-lucide -->
<i data-lucide="home" class="h-6 w-6"></i>
<i data-lucide="user" class="h-6 w-6 text-gray-600"></i>
<i data-lucide="check-circle" class="h-6 w-6 text-green-500"></i>
```

### Tailwind CSS

```html
<!-- Gunakan class Tailwind seperti biasa -->
<div class="bg-gradient-to-r from-purple-600 to-purple-700 p-4 rounded-lg">
    <h1 class="text-white text-xl font-bold">Title</h1>
</div>
```

## Troubleshooting

Jika icons tidak muncul:

1. Pastikan sudah menjalankan `npm run build`
2. Cek console browser untuk error messages
3. Pastikan Vite assets ter-load dengan benar

## Keuntungan Setup Ini

1. **Offline Support** - Tidak bergantung pada CDN
2. **Better Performance** - Icons ter-bundle dengan aplikasi
3. **Version Control** - Menggunakan versi yang konsisten
4. **Tree Shaking** - Hanya icons yang digunakan yang di-bundle
