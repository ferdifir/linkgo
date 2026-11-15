# Prompt AI untuk Website Desa

Dokumen ini berisi prompt siap salin untuk meminta AI membuat website satu desa di Kecamatan Gending. Pengguna cukup menyebut nama desa; hasil AI harus satu file mandiri bernama `index.html`.

## Prompt siap salin

```text
Buat website untuk Desa [NAMA DESA], Kecamatan Gending, Kabupaten Probolinggo. Pengguna mungkin hanya menyebut nama desa; jangan meminta brief tambahan sebelum mulai.

Konteks:
- Bentuk slug secara otomatis dari nama desa.
- Gunakan fakta/aset lokal hanya jika pengguna memberikannya. Jika tidak, jangan meminta data tambahan; pakai placeholder dan hindari klaim identitas lokal yang tidak diketahui.
- Jika tidak ada arahan visual tambahan, tentukan sendiri konsep yang sesuai dengan portal desa.
- Ini adalah satu dari beberapa website desa dengan komponen dan fungsi inti yang sama.

Jika memiliki akses ke project/repo, periksa dokumen dan implementasi terkait sebelum membuat halaman:
1. docs/komponen-portal-desa-gending.md
2. docs/panduan-agent-pengembangan-website-desa.md
3. docs/template-brief-website-desa.md
4. Implementasi website desa yang sudah ada di resources/views/desa/ serta route, API, CSS, dan skema database yang berkaitan.

HASIL WAJIB

- Hasilkan tepat satu file bernama index.html yang berisi website lengkap dan dapat langsung dibuka di browser.
- Jika memiliki akses filesystem, tulis hasil ke index.html pada direktori kerja yang diminta. Jangan menimpa public/index.php atau entry point Laravel.
- Jika tidak bisa menulis file, keluarkan seluruh isi index.html dalam satu code block HTML agar pengguna dapat menyimpannya.
- Sertakan CSS dan JavaScript halaman di dalam file tersebut. Jangan membuat file CSS, JS, JSON, gambar, dokumentasi, atau file tambahan.
- Langsung buat halaman; jangan berhenti pada uraian konsep atau meminta persetujuan desain.
- Jangan menambahkan penjelasan panjang di luar file. Cukup sebut bahwa index.html sudah dibuat.

ATURAN DESAIN

1. Website harus langsung terasa sebagai portal desa yang berguna bagi warga: ada identitas pemerintahan desa, informasi yang dapat dipindai, akses layanan, transparansi, kegiatan, dan kontak.
2. Jangan menyalin website desa lain lalu hanya mengganti nama dan warna. Buat arah desain tersendiri melalui komposisi, tipografi, bentuk hero, ritme dan jarak antarseksi, treatment foto/ilustrasi, kartu, navigasi, dan cara informasi diprioritaskan.
3. Urutan section boleh berbeda untuk setiap desa. Pastikan semua fungsi inti dari dokumen komponen bersama tetap ada dan mudah ditemukan.
4. Jangan menggunakan ilustrasi peta, batas wilayah, motif budaya, foto, atau simbol lokal yang tidak diberikan atau tidak terverifikasi. Jangan menggambar peta rekaan lalu menyebutnya peta desa. Jika aset lokal belum ada, gunakan komposisi tipografi, bentuk grafis abstrak, foto netral berizin, atau placeholder yang jelas.
5. Placeholder boleh digunakan untuk mengisi desain dan menunjukkan bentuk konten. Gunakan placeholder yang tampak jelas, misalnya "Nama Kepala Desa", "Nama kegiatan", "Ringkasan proyek", atau "Belum tersedia". Jangan mengarang nama, angka APBDes, skor indeks, alamat rinci, nomor kontak, jadwal, status proyek, atau fakta lokal lain yang seolah-olah nyata.
6. Jangan membuat halaman terasa kosong ketika data belum tersedia. Tunjukkan bentuk yang akan diisi: kartu placeholder, baris tabel, agenda, kartu proyek, ringkasan anggaran, dan keadaan kosong yang rapi. Hindari data palsu yang menyerupai data resmi.
7. Jaga jarak antarseksi dan hierarki dengan jelas. Beri ruang yang cukup di antara heading, deskripsi, kartu, dan batas section. Periksa agar teks atau komponen tidak bertumpuk, terpotong, atau menabrak kolom lain.
8. Periksa detail alignment: ikon harus benar-benar berada di tengah tombol, ukuran tombol konsisten, label dan kontrol sejajar, dan elemen floating tidak menutupi isi atau aksi penting.
9. Buat navigasi desktop dan ponsel yang berfungsi. Jika tautan disembunyikan pada layar kecil, sediakan menu pengganti yang jelas dan dapat digunakan dengan keyboard.
10. Gunakan prinsip aksesibilitas: kontras cukup, fokus keyboard terlihat, kontrol memiliki nama yang jelas, gambar informatif memiliki teks alternatif, dan status tidak dibedakan hanya dengan warna. Hormati prefers-reduced-motion.

KOMPONEN/FUNGSI INTI

Rujuk detail dan cakupan setiap komponen ke dokumen komponen bersama. Pastikan rancangan mengakomodasi:
- Identitas dan beranda desa.
- Sambutan kepala desa dan perangkat.
- Layanan desa.
- APBDes dan realisasi.
- Papan proyek dengan rincian pekerjaan yang terbuka sebagai overlay relatif ke kartu proyek dan tidak mengubah tinggi daftar.
- Indeks Desa/IDM dengan periode dan sumber jika kelak diisi.
- Kegiatan dan pengumuman.
- Profil/potensi desa.
- Lokasi, kontak, dan footer.
- Tombol usulan warga yang mengambang di kanan bawah, membuka alur seperti percakapan; satu pertanyaan per langkah, opsi Lewati untuk pertanyaan opsional, tombol Lanjut dan Batal bergaya inline button, ringkasan sebelum kirim, serta status berhasil/gagal.

COPY DAN ISI HALAMAN

- Gunakan Bahasa Indonesia yang lugas, pendek, dan berorientasi pada kebutuhan warga.
- Jangan menaruh penjelasan cara kerja komponen, alasan desain, catatan internal, atau status proses pengembangan ke dalam website.
- Jangan menambahkan paragraf disclaimer atau penjelasan metodologi panjang yang tidak diperlukan warga.
- Jika suatu data belum ada, cukup gunakan label singkat seperti "Belum tersedia". Jangan menjelaskan panjang lebar mengapa data kosong.
- Hindari sapaan generik, slogan yang tidak punya dasar, filler text berulang, dan paragraf promosi yang tidak memberi informasi atau tindakan.
- Pastikan placeholder tersebar pada komponen inti yang tepat sehingga rancangan tampak seperti situs yang siap diisi, bukan kumpulan penjelasan tentang placeholder.

BATASAN TEKNIS FILE TUNGGAL

- Gunakan HTML semantik, CSS responsif, dan JavaScript di dalam index.html.
- Untuk prototipe satu file, gunakan Tailwind CSS v4 Play CDN (`<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>`) dan CSS khusus di dalam `<style>`. Buat layout inti tetap terbaca jika CDN gagal dimuat.
- Play CDN ditujukan untuk pengembangan/prototipe. Jika halaman nanti dimasukkan ke Laravel, gunakan pipeline Tailwind Vite yang sudah tersedia.
- Jangan menggunakan framework atau build step yang memerlukan file tambahan.
- Jangan mengandalkan endpoint API yang belum tersedia. Gunakan placeholder lokal untuk demonstrasi.
- Form usulan tidak boleh mengirim data ke server yang tidak tersedia; tampilkan konfirmasi demo setelah proses selesai.

BATASAN TEKNIS JIKA NANTI DIINTEGRASIKAN KE APLIKASI

- Aplikasi ini menggunakan Laravel, Blade, SQLite, Vite, dan Tailwind CSS v4. Periksa versi dan pola repo yang aktual sebelum mengubahnya.
- Route halaman desa memakai /desa/{slug}; view berada di resources/views/desa/{slug}.blade.php.
- API per desa yang tersedia saat ini: GET /api/desa/{slug}/content, GET /api/desa/{slug}/budgets, dan POST /api/desa/{slug}/proposals. Endpoint tanpa slug adalah endpoint lama Curahsawo; jangan gunakan untuk desa lain.
- Data proyek, APBDes, dan usulan memiliki village_slug. Setiap query dan mutasi harus memvalidasi serta membatasi desa di sisi server.
- village_pages menyimpan konfigurasi halaman saat ini. Periksa skema sebelum mengandalkan tabel atau API untuk sambutan/perangkat, layanan, indeks, kegiatan, atau pengumuman; jangan menganggap semuanya sudah memiliki CRUD.
- Admin yang ada belum menjadi admin multi-desa sepenuhnya. Jangan membuka kemampuan edit lintas desa tanpa autentikasi, otorisasi, konteks desa yang jelas, dan pembatasan server-side.
- Gunakan Tailwind untuk struktur dan komponen. Gunakan CSS khusus secukupnya untuk identitas visual. Jangan menambah dependency tanpa kebutuhan yang jelas.
- Jangan memodifikasi data desa lain atau mengubah migrasi dengan cara yang menghilangkan data lama.
- Jangan menampilkan data pribadi usulan warga pada halaman publik.

Jika identitas atau aset lokal belum tersedia, tetap hasilkan halaman lengkap dengan placeholder yang terlihat jelas. Jangan menciptakan simbol atau fakta lokal.

KRITERIA SELESAI

- Fungsi inti dari dokumen komponen bersama terakomodasi.
- Arah visual berbeda secara nyata dari situs desa lain, bukan sekadar recolor.
- Situs terasa berisi dan berguna meskipun menggunakan placeholder.
- Copy di halaman ringkas, tanpa penjelasan yang tidak diperlukan warga.
- Tidak ada aset lokal atau fakta palsu yang disajikan seolah-olah benar.
- Layout, jarak, alignment ikon, navigasi ponsel, overlay proyek, dan tombol floating dapat digunakan tanpa saling menutupi.
- index.html dapat dibuka tanpa file lokal pendamping.
```

Tailwind v4 Play CDN mengikuti [dokumentasi resmi Tailwind](https://tailwindcss.com/docs/installation/play-cdn) dan dipakai di prompt ini hanya untuk output prototipe satu file.
