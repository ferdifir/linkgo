# Panduan Agent Pengembangan Website Desa

Panduan untuk membuat website desa-desa di Kecamatan Gending di dalam aplikasi ini. Dokumen ini melengkapi [daftar komponen bersama](komponen-portal-desa-gending.md); gunakan dokumen tersebut untuk cakupan elemen dan fungsi setiap situs.

## Tujuan

- Semua desa memiliki fungsi inti yang setara.
- Setiap situs punya arah desain dan susunan halaman yang khas; hasilnya tidak boleh terasa seperti satu template yang hanya diganti warna dan nama.
- Website mudah dipahami warga dan dapat dikelola tanpa mengubah kode untuk pembaruan konten rutin.

## Alur kerja

1. Baca dokumen komponen bersama dan periksa implementasi, route, skema basis data, API, serta pola styling yang sudah ada.
2. Isi [template brief desa](template-brief-website-desa.md) secukupnya. Data boleh berupa placeholder.
3. Rumuskan satu arah visual yang khas untuk desa tersebut. Jika pengguna meminta ide lebih dulu, sampaikan konsep singkat sebelum coding. Jika arah sudah jelas atau pengguna meminta langsung implementasi, lanjutkan.
4. Buat halaman dan perilaku dengan komponen inti yang diperlukan. Susunan bagian boleh berbeda.
5. Pastikan data dan semua operasi server terikat ke slug desa yang benar.
6. Jalankan pemeriksaan yang relevan dan periksa tampilan desktop serta ponsel.

## Data dan placeholder

- Placeholder boleh digunakan untuk membangun layout, keadaan kosong, dan alur CRUD. Contoh: `Nama Kepala Desa`, `Judul pekerjaan`, `Alamat kantor`, atau `Belum tersedia`.
- Jangan mengarang fakta yang tampak nyata, seperti nama orang, nilai anggaran, capaian indeks, alamat rinci, nomor kontak, atau status proyek.
- Untuk memperlihatkan rancangan dengan isi, gunakan placeholder yang sesuai konteks atau nilai ilustratif. Jangan menambahkan label berulang seperti **Data contoh** atau paragraf yang menjelaskan bahwa isi akan diperbarui.
- Informasi yang belum ada dan tidak perlu diisi untuk memperlihatkan rancangan cukup memakai placeholder singkat, misalnya **Belum tersedia**.
- Bila data belum tersedia, pilih keadaan kosong yang ringkas. Tidak perlu menambahkan uraian panjang tentang mengapa datanya belum ada.
- Untuk fakta yang benar-benar dipublikasikan, simpan sumber dan tahun/tanggalnya bersama data. Tampilkan rujukan seperlunya.

## Copy dan informasi di halaman

- Tulis singkat, langsung, dan berorientasi pada kebutuhan warga.
- Jangan menjelaskan cara kerja komponen, alasan pemilihan layout, status proses pengembangan, atau catatan internal kepada pengunjung.
- Jangan menambahkan disclaimer panjang untuk mengantisipasi salah tafsir yang tidak muncul dari konteks halaman.
- Jika data kosong, gunakan label sederhana seperti **Belum tersedia**. Jika perlu, tambahkan tahun atau tautan sumber; hindari paragraf penjelas.
- Jangan tampilkan catatan metodologis tentang bobot dimensi, skor, atau arti indikator kecuali warga membutuhkannya untuk membaca angka. Jika skor belum ada, cukup tulis **Belum tersedia**.
- Jangan memenuhi halaman dengan sapaan generik, kalimat promosi berulang, atau penjelasan fitur yang sudah jelas dari label dan kontrolnya.

## Arah desain

- Mulai dari karakter dan kebutuhan warga desa tersebut, bukan dari palet warna. Tentukan konsep melalui tata letak, ritme halaman, tipografi, media, ilustrasi/pola, dan cara informasi disajikan.
- **Komponen bersama berarti kebutuhan informasi dan fungsi**—misalnya APBDes, layanan, papan proyek, usulan warga, profil, dan lokasi. Itu bukan instruksi untuk memakai komponen visual atau susunan halaman yang sama.
- Rancang identitas visual dan komposisi setiap desa secara mandiri. Jangan menyalin kerangka homepage desa lain lalu mengganti nama, warna, dan gambar. Variasikan bentuk hero, ritme dan kepadatan section, hierarki tipografi, pola navigasi, bentuk penyajian informasi, media, dan detail visual sesuai konsep desa.
- Hindari pola berulang yang sudah muncul di situs desa lain. Contohnya, hero dengan deretan empat kartu statistik/tautan tidak boleh otomatis dipakai lagi. Sebelum implementasi, bandingkan hasil yang sedang dibuat dengan halaman desa yang sudah ada dan ubah pendekatan bila pola utamanya terasa sama.
- Boleh mengubah urutan komponen, bentuk hero, navigasi sekunder, dan komposisi grid. Jangan menghilangkan fungsi inti dari dokumen komponen bersama.
- Gunakan motif lokal bila memiliki dasar atau arahan yang jelas. Hindari simbol budaya, lanskap, atau pekerjaan warga yang hanya diasumsikan dari nama desa.
- Gunakan foto, logo, peta, dan ikon dengan izin yang sesuai. Beri teks alternatif pada gambar informatif.
- Gunakan SVG atau sistem ikon proyek untuk ikon antarmuka. Jangan memakai emoji atau karakter Unicode sebagai pengganti ikon.
- Jaga kontras, ukuran teks, fokus keyboard, dan keadaan hover/focus. Jangan mengandalkan warna saja untuk menyampaikan status.
- Pertahankan navigasi yang dapat digunakan di layar kecil. Jangan biarkan tombol mengambang menutupi kontrol penting.
- Setiap halaman desa harus menyertakan `@include('desa.partials.responsive')` sebelum `</body>`. Gunakan kelas `portal-mobile-stack` atau `portal-mobile-two-col` pada grid yang perlu aturan kolom bersama; jangan menggandakan aturan tipografi minimum global di CSS halaman.
- Di layar sampai 700 px, teks isi minimal 15 px, navigasi dan kontrol minimal 14 px, serta label/rincian minimal 12–13 px. Komposisi kartu tetap mengikuti konsep desa, tetapi kolom harus menyusut tanpa memotong teks atau menimbulkan scroll horizontal.
- Hormati `prefers-reduced-motion`; animasi harus membantu orientasi atau umpan balik.

## Format footer tetap

Semua website desa memakai struktur footer yang sama, mengikuti referensi [kersik.desa.id](https://kersik.desa.id/):

1. Satu baris berisi empat kolom: identitas/alamat pemerintah desa, kontak dan kanal sosial, nomor telepon penting, serta tautan jelajah.
2. Bagian terbawah berisi copyright dan teks **Powered by @ferdifir** di tengah. Tautan `@ferdifir` menuju `https://wa.me/6285239110184`.
3. Ikuti warna footer dari identitas visual desa dan jaga kontras teks. Hijau pada referensi adalah contoh, bukan aturan warna. Susun menjadi dua kolom di tablet dan satu kolom di ponsel.
4. Isi alamat, nomor, email, kanal sosial, dan nomor penting dari data desa masing-masing. Jika belum tersedia, tampilkan **Belum tersedia**; jangan menyalin data Desa Kersik atau mengarang kontak.
5. Tautan jelajah menuju bagian yang memang ada di halaman desa tersebut. Kredit sumber dapat ditambahkan sebelum baris copyright tanpa mengubah susunan footer utama.

## Batasan teknis aplikasi saat ini

- Aplikasi memakai Laravel. Halaman desa berada di `resources/views/desa/{slug}.blade.php`; route publik menggunakan `/desa/{slug}` dan hanya tersedia bila view untuk slug tersebut ada.
- Route API publik memakai slug desa: `GET /api/desa/{slug}/content`, `GET /api/desa/{slug}/budgets`, dan `POST /api/desa/{slug}/proposals`.
- Jangan menambahkan endpoint publik tanpa slug desa. Konten tambahan pada `site_content` juga harus diambil dengan `village_slug` yang sama.
- Proyek, APBDes, dan usulan memiliki `village_slug`. Setiap query publik maupun operasi tulis harus membatasi slug di server. Jangan mengandalkan filter antarmuka sebagai pembatas akses.
- Data konfigurasi halaman saat ini disimpan di `village_pages`. Tambahkan desa baru melalui mekanisme migrasi/seed yang sesuai; jangan membuat halaman bergantung pada edit SQLite manual.
- Tabel dan CRUD khusus untuk sambutan/perangkat, layanan, Indeks Desa, kegiatan, dan pengumuman belum menjadi pola data bersama. Periksa implementasi terkini sebelum mengasumsikan API atau tabelnya sudah ada.
- Admin yang ada belum sepenuhnya menjadi admin multi-desa: proyek/APBDes masih berorientasi Curahsawo, sedangkan daftar usulan bersifat lintas desa. Sebelum memberi admin kemampuan mengelola beberapa desa, sediakan pemilihan konteks desa dan otorisasi server-side untuk setiap operasi.
- Gunakan Tailwind yang sudah tersedia serta konvensi styling di halaman terdekat. Jangan menambah dependency hanya untuk variasi visual sederhana.

## Batasan pengelolaan data

- Data publik satu desa tidak boleh muncul di situs desa lain.
- Validasi slug desa sebelum mengembalikan atau menyimpan data.
- Data usulan warga bersifat privat; jangan tampilkan nama, kontak, atau uraian usulan di halaman publik.
- Isian opsional harus tetap opsional di validasi server. Terapkan batas panjang dan pembatasan spam pada endpoint publik.
- Aksi admin harus memeriksa autentikasi, hak akses, dan cakupan desa di server.
- Jangan mengubah atau menghapus data desa lain saat migrasi. Sertakan nilai default yang mempertahankan data lama pada desa asalnya.

## Checklist sebelum selesai

- [ ] Route halaman dan API memakai slug desa yang tepat.
- [ ] Semua komponen inti dalam dokumen bersama tersedia atau mempunyai keadaan kosong yang jelas.
- [ ] Placeholder sesuai konteks dan tidak disertai label atau penjelasan berulang.
- [ ] Halaman punya konsep dan komposisi yang khas, bukan sekadar recolor.
- [ ] Copy ringkas; tidak ada penjelasan teknis atau disclaimer panjang yang tidak perlu.
- [ ] Data proyek/APBDes/usulan terisolasi di server.
- [ ] Form memiliki validasi, tombol batal yang berfungsi, pesan berhasil/gagal, dan kontrol keyboard.
- [ ] Header, konten, peta, dan tombol mengambang nyaman digunakan di desktop dan ponsel.
- [ ] Halaman menyertakan lapisan responsif bersama; screenshot diperiksa pada lebar desktop, 390 px, dan 360 px.
- [ ] Tidak ada scroll horizontal, teks terpotong, tombol mungil, atau footer yang kehilangan struktur pada lebar ponsel.
- [ ] Tidak ada nama, angka, layanan, atau kontak palsu yang disajikan sebagai data desa.
- [ ] Perubahan skema dan data awal aman untuk instalasi yang sudah berisi data.

## Rujukan

- [Komponen bersama portal desa](komponen-portal-desa-gending.md)
- [Template brief website desa](template-brief-website-desa.md)
- Contoh implementasi Curahsawo dan Pajurangan di `resources/views/desa/`
