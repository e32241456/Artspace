# ARTSPACE — Laravel 13, Blade, Tailwind CSS & PostgreSQL (OJT HEXA)

ARTSPACE adalah platform eksplorasi visual karya seni (*visual discovery* bergaya Pinterest) dan portofolio digital seniman — **bukan marketplace, toko online, atau platform transaksi**.

## Stack Final
- **Backend**: PHP 8.4+, Laravel 13 MVC
- **Frontend**: Laravel Blade, Tailwind CSS v4, HTML5, CSS3, Vanilla JavaScript
- **Database**: PostgreSQL (`pgsql`)
- **Version Control**: Git

## Fitur Utama Sesuai PRD
- **FR-01 — Autentikasi Pengguna**: Registrasi khusus Seniman, login, logout, dan pembatasan akses berbasis peran (`pengunjung`, `seniman`, `admin`).
- **FR-02 — Manajemen Profil Seniman**: Biografi, latar belakang, perjalanan berkesenian, pengalaman, foto profil, dan **Riwayat Pameran** terpadu di dalam profil seniman.
- **FR-03 — Manajemen Karya Seni**: CRUD karya milik seniman sendiri (dilindungi `KaryaSeniPolicy`), unggah foto karya, harga opsional informasional, dan publikasi otomatis berstatus `TERBIT`.
- **FR-04 — Katalog Publik & Detail Karya Dua Kolom**: Feed *masonry* ala Pinterest dan halaman detail dua kolom tanpa tombol pembelian, tanpa komentar, dan tanpa rekomendasi di bawah.
- **FR-05 — Pencarian Karya & Seniman**: Pencarian karya berdasarkan judul/media dan seniman berdasarkan nama/kota/disiplin.

## Instalasi & Menjalankan di `D:\artspace\`

```bash
# 1. Instal dependensi PHP (Laravel 13)
composer install

# 2. Instal dependensi frontend (Vite + Tailwind CSS v4 + laravel-vite-plugin)
npm install

# 3. Salin konfigurasi lingkungan & sesuaikan kredensial PostgreSQL di .env
copy .env.example .env
php artisan key:generate

# 4. Pastikan database PostgreSQL "artspace" sudah dibuat, lalu jalankan migrasi & seeder
php artisan migrate --seed

# 5. Buat tautan penyimpanan publik untuk foto unggahan
php artisan storage:link

# 6. Bangun aset frontend (produksi) atau jalankan mode pengembangan
npm run build
# atau untuk pengembangan bersamaan: npm run dev

# 7. Jalankan server Laravel
php artisan serve
```

## Akun Demonstrasi Seeder
- **Seniman**: `baskoro@artspace.id` / `artspace123` (juga tersedia `ratna@artspace.id`, `darmawan@artspace.id`, `sekarsari@artspace.id`)
- **Admin**: `admin@artspace.id` / `admin123`
