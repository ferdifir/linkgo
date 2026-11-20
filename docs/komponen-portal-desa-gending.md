# Komponen Bersama Portal Desa Kecamatan Gending

Dokumen ini menjadi acuan isi dan perilaku untuk situs masing-masing desa di Kecamatan Gending. Semua situs memakai susunan komponen dan pola interaksi yang konsisten, sementara identitas visual, profil, informasi, foto, dan data tetap milik desa masing-masing.

## Cakupan desa

Per 2025, Kecamatan Gending memiliki 13 desa. Daftar nama di bawah mengikuti tabel BPS Kabupaten Probolinggo tentang jumlah RT, RW, dan dusun per desa (data 2023); ejaan nama perlu dikonfirmasi kembali kepada pemerintah desa saat pengisian profil.

| Desa | Slug route |
| --- | --- |
| Banyuanyar Lor | `/gending/banyuanyar-lor` |
| Sumberkerang | `/gending/sumberkerang` |
| Sebaung | `/gending/sebaung` |
| Pikatan | `/gending/pikatan` |
| Bulang | `/gending/bulang` |
| Brumbungan Lor | `/gending/brumbungan-lor` |
| Jatiadi | `/gending/jatiadi` |
| Klaseman | `/gending/klaseman` |
| Pesisir | `/gending/pesisir` |
| Randupitu | `/gending/randupitu` |
| Gending | `/gending/gending` |
| Pajurangan | `/gending/pajurangan` |
| Curahsawo | `/gending/curahsawo` |

## Prinsip bersama

- Setiap situs memiliki komponen inti, istilah yang mudah dipahami warga, dan pola interaksi yang seragam. Urutan komponen boleh berbeda sesuai cerita dan kebutuhan warga desa.
- Masing-masing desa memiliki arah desain yang khas. Perbedaan tidak cukup hanya dengan mengganti warna; tata letak, tipografi, ilustrasi/foto, pola, dan cara menonjolkan informasi dapat dirancang khusus selama fungsi inti tetap konsisten.
- Informasi yang ditampilkan sebagai fakta publik harus bersumber, memiliki tahun atau tanggal yang jelas, dan membedakan data resmi dari pemberitaan atau usulan.
- Placeholder boleh digunakan untuk mengisi rancangan dan memperlihatkan bentuk komponen. Jangan menambahkan label berulang seperti **Data contoh**; bila informasi belum tersedia, gunakan placeholder singkat.
- Setiap komponen harus nyaman dipakai di ponsel, dapat diakses dengan keyboard, dan tetap terbaca tanpa animasi.
- Data proyek, APBDes, usulan, pengumuman, profil, dan konfigurasi tema harus terikat ke desa pemiliknya. Pengelola satu desa tidak boleh melihat atau mengubah data desa lain tanpa hak yang sesuai.

## Navigasi dan susunan halaman

Urutan navigasi berikut adalah contoh, bukan urutan wajib. Agent boleh menyusun ulang atau mengelompokkan bagian berdasarkan identitas desa, selama komponen inti tetap mudah ditemukan:

1. Beranda
2. Sambutan
3. Layanan
4. Transparansi: APBDes dan papan proyek
5. Indeks Desa
6. Kegiatan dan usulan warga
7. Profil dan potensi
8. Lokasi dan kontak

Header menampilkan nama dan logo desa, konteks wilayah (Kecamatan Gending, Kabupaten Probolinggo), navigasi, serta satu tautan tindakan utama. Di layar kecil, navigasi berubah menjadi menu yang tetap dapat digunakan dengan keyboard dan pembaca layar.

## Komponen inti

### 1. Beranda dan identitas desa

**Tujuan:** mengenalkan desa dan membantu warga langsung menemukan informasi penting.

**Elemen:**

- Nama desa, kecamatan, kabupaten, logo atau lambang yang sah digunakan.
- Judul dan pengantar singkat yang khusus menggambarkan desa.
- Foto utama yang mewakili desa, dilengkapi teks alternatif dan kredit foto.
- Tautan cepat ke layanan, APBDes, proyek, lokasi kantor, dan usulan warga.
- Pengumuman penting yang memiliki tanggal berlaku dan tanggal kedaluwarsa bila relevan.

### 2. Sambutan kepala desa dan perangkat

**Tujuan:** memberi konteks kepemimpinan dan mengenalkan aparatur yang melayani warga.

**Elemen:**

- Foto (opsional), nama, gelar bila digunakan secara resmi, dan jabatan kepala desa.
- Naskah sambutan singkat, tanggal terakhir diperbarui, dan atribusi.
- Daftar perangkat desa berupa nama dan jabatan; foto setiap perangkat bersifat opsional.
- Penanda jelas untuk data yang belum dikonfirmasi. Placeholder tidak boleh tampil sebagai nama atau jabatan faktual.

### 3. Layanan desa

**Tujuan:** menjelaskan langkah praktis untuk mengurus layanan administrasi dan layanan lain yang benar-benar tersedia.

Setiap kartu layanan memuat:

- Nama layanan dan ringkasan siapa yang dapat mengajukan.
- Persyaratan atau dokumen yang perlu dibawa.
- Langkah pengajuan, lokasi atau kanal pengajuan, dan kontak yang relevan.
- Biaya resmi (termasuk keterangan gratis jika sudah dikonfirmasi), serta estimasi waktu hanya bila ada dasar.
- Tanggal pembaruan dan tautan sumber atau aturan yang berlaku.

Jika detail belum tersedia, tampilkan cara warga meminta informasi ke kantor desa; jangan mengarang syarat atau durasi.

### 4. Transparansi APBDes dan realisasi

**Tujuan:** menyediakan ringkasan anggaran yang dapat ditelusuri sumber dan tahunnya.

**Elemen:**

- Pemilih tahun anggaran.
- Pendapatan, belanja, pembiayaan, dan realisasi dengan satuan Rupiah.
- Pagu atau alokasi Dana Desa sebagai kategori terpisah agar tidak tertukar dengan total APBDes.
- Catatan penjelas, tanggal pembaruan, dan tautan dokumen sumber bila tersedia.
- Keadaan kosong yang menyebut data atau dokumen apa yang belum tersedia.

Nilai rencana dan realisasi harus dibedakan secara visual dan tekstual. Angka hanya boleh dipublikasikan setelah diverifikasi terhadap dokumen resmi.

### 5. Papan proyek dan kegiatan pembangunan

**Tujuan:** menampilkan pekerjaan yang sedang direncanakan atau dilaksanakan, beserta sumber informasinya.

**Kontrol daftar:**

- Filter tahun, lokasi dusun/RT/RW, dan status.
- Jumlah hasil dan pesan ketika tidak ada proyek yang cocok.

**Informasi setiap kartu:**

- Nama pekerjaan, lokasi, tahun, status, dan ringkasan nilai anggaran.
- Rincian pekerjaan: volume, sumber dana, pelaksana, jadwal, progres fisik, serta realisasi belanja jika diketahui.
- Sumber dan tanggal informasi; bedakan catatan resmi pemerintah desa dari laporan media atau usulan warga.
- Rincian dibuka sebagai overlay/popover relatif terhadap kartu, agar kartu lain dan tinggi daftar tidak berubah.

Usulan yang belum menjadi kegiatan anggaran harus diberi label **usulan**, tidak digabung sebagai proyek yang sudah disetujui.

### 6. Indeks Desa / IDM

**Tujuan:** membantu warga memahami kondisi dan perkembangan desa berdasarkan indikator yang dapat dipertanggungjawabkan.

**Elemen:**

- Nama indeks yang digunakan, periode/tahun data, nilai, status atau kategori, dan sumber resmi.
- Dimensi yang ditampilkan konsisten di semua desa. Untuk tampilan yang sekarang dirintis: layanan dasar, sosial, ekonomi, lingkungan, aksesibilitas, dan tata kelola pemerintahan desa.
- Penjelasan singkat metode, arti nilai/kategori, dan keterbatasan data.
- Rujukan dokumen atau dasbor sumber.

Jangan menyamakan indeks berbeda atau memindahkan nilai dari satu tahun ke tahun lain. Jika nilai per dimensi tidak diterbitkan sumber, tampilkan hanya nilai agregat dan jelaskan batas datanya.

### 7. Kegiatan, pengumuman, dan berita desa

**Tujuan:** membagikan informasi yang masih relevan bagi warga.

**Elemen:**

- Judul, tanggal terbit, ringkasan, kategori, dan isi atau tautan detail.
- Foto dengan teks alternatif dan kredit.
- Status pengumuman dan masa berlaku untuk informasi sementara.
- Tautan sumber bila informasi berasal dari lembaga atau media lain.
- Keadaan kosong ketika belum ada kabar yang dipublikasikan.

### 8. Usulan warga

**Tujuan:** memberi kanal untuk menyampaikan kebutuhan warga dan membuat prosesnya mudah dipahami.

**Elemen dan perilaku:**

- Tombol mengambang di kanan bawah yang membuka percakapan seperti live chat.
- Pertanyaan diajukan satu per satu; setiap isian opsional menyediakan **Lewati**.
- Tombol **Lanjut** dan **Batal** ditata sebagai inline action yang jelas. Batal mengakhiri proses dan membersihkan draf.
- Ringkasan jawaban sebelum pengiriman, konfirmasi berhasil, dan pesan kesalahan yang mudah dimengerti.
- Formulir meminta data minimum yang diperlukan; nama dan kontak tidak wajib kecuali ada kebutuhan yang jelas.
- Privasi dan tujuan pengumpulan data dijelaskan sebelum pengiriman.
- Honeypot atau pembatasan kiriman untuk mengurangi spam.
- Admin dapat melihat, mengubah status tindak lanjut, menulis catatan, dan menghapus usulan sesuai kebijakan retensi.

### 9. Profil dan potensi desa

**Tujuan:** menampilkan karakter dan potensi lokal secara spesifik, bukan mengulang teks generik.

**Elemen:**

- Narasi singkat sejarah, geografis, demografis, budaya, ekonomi, atau potensi lokal sesuai data yang tersedia.
- Foto, peta, atau media dengan sumber dan keterangan.
- Angka profil mencantumkan tahun serta sumber.
- Bagian yang belum memiliki data tidak ditampilkan sebagai fakta.

### 10. Lokasi, kontak, dan footer

**Elemen:**

- Alamat kantor desa dan peta sematan bila koordinat telah diverifikasi.
- Jam layanan, nomor telepon/WhatsApp, surel, dan kanal resmi hanya jika aktif dan disetujui untuk publikasi.
- Tautan ke situs atau kanal resmi desa, kecamatan, dan kabupaten.
- Identitas pemerintah desa, tahun hak cipta, tanggal pembaruan situs, dan tautan kebijakan privasi.

## Identitas visual tiap desa

Setiap desa memiliki paket identitas yang dapat dikelola tanpa mengubah komponen inti:

- Logo/lambang dan aturan penggunaannya.
- Warna utama, pendamping, aksen, warna teks, dan warna status dengan kontras yang memadai.
- Tipografi judul dan isi yang mudah dibaca.
- Foto utama, foto pendukung, ilustrasi, pola, serta kredit dan izin penggunaan.
- Motif atau simbol lokal yang telah disepakati pemerintah desa/masyarakat.
- Gaya ikon dan bentuk kartu/tombol dalam batas sistem komponen bersama.

Identitas tidak boleh mengurangi keterbacaan, menghilangkan label status, mengubah struktur navigasi, atau membuat kontrol yang sama bekerja secara berbeda antar desa.

## Kebutuhan data dan pengelolaan

Data yang perlu dipisahkan per desa:

- Profil dan identitas visual.
- Kepala desa dan daftar perangkat.
- Layanan beserta persyaratannya.
- APBDes per tahun.
- Proyek/kegiatan dan dokumen sumber.
- Indeks dan nilai per periode.
- Pengumuman, kegiatan, dan berita.
- Usulan warga dan riwayat tindak lanjut.
- Alamat, peta, jam layanan, serta kontak publik.

Admin harus memiliki konteks desa yang terlihat jelas ketika bekerja. Semua operasi baca/tulis dibatasi ke desa terpilih dan diperiksa di server, bukan hanya disembunyikan di antarmuka. Perubahan publikasi dan status usulan sebaiknya menyimpan waktu perubahan dan akun pengelola.

## Kriteria selesai untuk setiap situs desa

- Seluruh komponen inti dan keadaan kosong tersedia; placeholder sesuai konteks dan tidak diberi label penjelas berulang.
- Situs mempunyai tema, foto, dan narasi yang mewakili identitas lokal tanpa mengubah struktur bersama.
- Data APBDes, proyek, dan indeks mencantumkan periode dan sumber; data yang tidak ada ditampilkan sebagai belum tersedia.
- Filter proyek, rincian proyek, formulir usulan, navigasi, dan tautan kontak berfungsi pada ponsel serta desktop.
- Seluruh form memiliki validasi, keadaan kosong, keadaan memuat, pesan berhasil, dan pesan gagal.
- Isi dapat digunakan dengan keyboard, label form terbaca pembaca layar, kontras memadai, dan gambar informatif memiliki teks alternatif.
- Admin hanya dapat mengelola data desa yang menjadi wewenangnya.
- Nama desa, alamat, pejabat, layanan, nomor kontak, dan dokumen yang disajikan sebagai fakta sudah mendapat verifikasi dari sumber/pihak yang berwenang sebelum dipublikasikan.

## Sumber daftar desa

- [BPS Kabupaten Probolinggo — jumlah desa di Kecamatan Gending, 2025](https://probolinggokab.bps.go.id/en/statistics-table/3/YkVWWFUyNTJTVTloVGpCeFdFVTNaMk5wUzFaUFFUMDkjMw%3D%3D/jumlah-desa-sup-1--sup--kelurahan-menurut-kecamatan-di-kabupaten-probolinggo--2017.html)
- [BPS Kabupaten Probolinggo — jumlah RT, RW, dan dusun menurut desa di Kecamatan Gending, 2023](https://probolinggokab.bps.go.id/id/statistics-table/2/MTk4IzI%3D/number-of-rt--rw--dusun-by-village-in-district-gending.html)
