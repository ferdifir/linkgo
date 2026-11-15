# LinkGo

LinkGo adalah portal web untuk menjelajahi informasi desa di Kecamatan Gending, Kabupaten Probolinggo. Warga dapat mencari desa melalui peta, membuka informasi publik, mengirim permohonan layanan atau pengaduan, dan memeriksa status permintaan. Admin mengelola data desa yang terhubung dengan akunnya.

## Fitur

- Beranda direktori desa dengan pencarian dan peta interaktif.
- Halaman publik per desa, dengan komposisi dan identitas visual masing-masing.
- Pengelolaan proyek, APBDes, usulan warga, berita, layanan, profil, media, dan data Indeks Desa dari dashboard admin.
- Pengajuan layanan dan pengaduan bertahap seperti percakapan, dengan kode tiket untuk mengecek status.
- Notifikasi email perubahan status jika warga memberikan alamat email dan menyetujuinya.
- Beberapa akun admin dengan akses yang dibatasi ke desa masing-masing.
- Ringkasan kunjungan halaman untuk membantu desa melihat informasi yang sering dibuka.

## Teknologi

- PHP 8.3 atau lebih baru
- Laravel 13
- PostgreSQL sebagai database utama
- Node.js dan npm untuk mengelola serta membangun asset frontend
- Vite, Tailwind CSS 4, dan MapLibre GL JS

## Mulai di komputer lokal

### Prasyarat

Pastikan PHP 8.3+, Composer, Node.js, npm, server PostgreSQL, dan ekstensi PHP `pdo_pgsql` tersedia.

### Instalasi

```sh
cp .env.example .env
createdb linkgo_portal
# Sesuaikan DB_HOST, DB_PORT, DB_USERNAME, dan DB_PASSWORD di .env.
make setup
npm ci
npm run build
php artisan storage:link
php artisan admin:create-village-admin
```

Perintah pembuatan admin akan meminta nama, username, email, desa, dan kata sandi. Admin masuk menggunakan username dan kata sandi.

Untuk menjalankan server lokal:

```sh
make dev
```

Secara default server berjalan di `http://127.0.0.1:8080`. Buka `/` untuk direktori desa, `/desa/curahsawo` untuk halaman desa Curahsawo, atau `/admin` untuk dashboard admin. Saat mengembangkan frontend, jalankan `npm run dev` di terminal terpisah agar Vite memperbarui asset.

`make setup` memasang dependency PHP, menyiapkan `.env`, membuat `APP_KEY` jika belum ada, dan menjalankan migrasi. Sebelum setup, buat database PostgreSQL sesuai nilai `DB_DATABASE` dan atur aksesnya melalui variabel `DB_*`. Konfigurasi bawaan memakai database `linkgo_portal` pada `127.0.0.1:5432`.

## Konfigurasi

Salin `.env.example` ke `.env` jika belum dibuat. Pengaturan utama:

| Variabel | Kegunaan |
| --- | --- |
| `APP_ENV` | Gunakan `local` untuk pengembangan dan `production` untuk server produksi. |
| `APP_DEBUG` | Aktifkan hanya di lokal; set `false` di produksi. |
| `APP_KEY` | Kunci enkripsi Laravel; buat dengan `make key`. |
| `APP_URL` | URL utama aplikasi. |
| `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` | Koneksi PostgreSQL dan kredensial database. Default database-nya `linkgo_portal`. |
| `SESSION_SECURE_COOKIE` | Set `true` jika aplikasi dilayani melalui HTTPS. |
| `TRUSTED_PROXIES` | Alamat proxy tepercaya jika aplikasi berada di belakang reverse proxy. |
| `MAIL_MAILER` dan `MAIL_*` | Pengiriman email pembaruan status. Default lokal memakai `log`, bukan mengirim email keluar. |

Akun admin disimpan di tabel `users`, bukan dibuat dari variabel `ADMIN_USERNAME` atau `ADMIN_PASSWORD`. Buat akun melalui `php artisan admin:create-village-admin`; command akan mengaitkan akun dengan satu desa.

## Perintah yang sering dipakai

```sh
php artisan migrate          # Terapkan migrasi database
php artisan storage:link     # Publikasikan storage untuk media yang diunggah
php artisan admin:create-village-admin
php artisan test              # Jalankan test suite
npm run dev                   # Vite dalam mode pengembangan
npm run build                 # Build asset untuk deployment
```

## Deployment

1. Siapkan server PHP 8.3+, Composer, Node.js/npm, dan database yang dipilih.
2. Atur environment produksi, termasuk `APP_KEY`, `APP_URL`, `APP_ENV=production`, `APP_DEBUG=false`, koneksi database, dan `SESSION_SECURE_COOKIE=true` saat memakai HTTPS.
3. Jalankan `composer install --no-dev --optimize-autoloader` dan `npm ci`.
4. Jalankan `npm run build`, `php artisan migrate --force`, dan `php artisan storage:link`.
5. Buat akun admin per desa dengan `php artisan admin:create-village-admin`.
6. Arahkan web server ke direktori `public/` dan aktifkan HTTPS. Jangan gunakan `php artisan serve` sebagai web server produksi.
7. Atur variabel `MAIL_*` jika notifikasi status perlu dikirim ke alamat email warga. Jika aplikasi berjalan di balik reverse proxy, atur `TRUSTED_PROXIES` dengan alamat proxy yang benar.

Simpan salinan database dan file media secara berkala. Jangan memasukkan `.env` atau kredensial produksi ke repository.

## Dokumentasi proyek

- [Panduan agent pengembangan website desa](docs/panduan-agent-pengembangan-website-desa.md)
- [Riset Indeks Desa Membangun](docs/riset-indeks-desa-membangun.md)
- [Template brief website desa](docs/template-brief-website-desa.md)
- [Prompt AI website desa](docs/prompt-ai-website-desa.md)
- [Komponen portal Desa Gending](docs/komponen-portal-desa-gending.md)
