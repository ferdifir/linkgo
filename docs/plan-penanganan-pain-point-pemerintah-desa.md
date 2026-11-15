# Rencana Pengembangan Linkgo untuk Pain Point Pemerintah Desa

**Tujuan:** Mengembangkan Linkgo secara bertahap dari portal informasi dan kanal warga menjadi alat bantu kerja desa yang praktis, dengan batas yang jelas terhadap sistem resmi keuangan dan kependudukan.

**Konteks saat ini:** Linkgo memakai satu aplikasi dan skema database bersama. Data operasional dipisahkan menggunakan `village_slug`; akun admin terikat pada desa. Fitur yang sudah tersedia meliputi pengelolaan konten, proyek, ringkasan anggaran, usulan warga, layanan/pengaduan, media, manajemen akun admin, dan analitik kunjungan.

**Prinsip:** Setiap fitur baru harus menjaga isolasi antar-desa, mudah digunakan di ponsel dan koneksi terbatas, mencatat perubahan penting, dan tidak mengklaim menggantikan aplikasi pemerintah yang berwenang.

---

## Ringkasan kemampuan dan batas

| Area | Bisa dikembangkan di Linkgo | Batas yang perlu dijaga |
|---|---|---|
| Kapasitas SDM | Panduan langkah kerja, pusat materi, daftar tugas dan pengingat, riwayat perubahan | Pelatihan langsung dan pemutakhiran pemahaman regulasi tetap membutuhkan fasilitator serta sumber resmi |
| Keuangan | Publikasi APBDes/anggaran ringkas, realisasi, dokumen pendukung publik, jadwal dan status kelengkapan pelaporan | Bukan sistem pembukuan, penganggaran resmi, atau pengganti Siskeudes dan prosedur audit |
| Administrasi layanan | Penerimaan permintaan, disposisi sederhana, status, tenggat, arsip keluaran, dan pelacakan warga | Penerbitan surat resmi perlu mengikuti format, verifikasi, tanda tangan, dan kewenangan desa |
| Data penduduk | Statistik agregat dan daftar perubahan yang perlu ditindaklanjuti; impor terbatas bila ada dasar dan persetujuan | Jangan membangun basis data kependudukan lengkap atau mengklaim sinkronisasi Dukcapil tanpa integrasi resmi |
| Aspirasi dan transparansi | Formulir, pelacakan status, tanggapan admin, publikasi informasi dan proyek | Tetap memerlukan petugas yang merespons dan kebijakan moderasi |
| Perencanaan | Pemetaan usulan, lokasi, kategori, kelompok terdampak, prioritas, dan keterkaitan dengan proyek | Keputusan RKPDes tetap melalui musyawarah dan proses formal |
| BUMDes | Profil unit usaha, katalog layanan/produk, agenda, dan indikator ringkas yang disepakati | Tidak mencakup pembukuan atau pendampingan kewirausahaan penuh pada tahap awal |
| Infrastruktur | Pendataan kendala dan kanal informasi yang ringan | Aplikasi tidak dapat menyediakan listrik, jaringan, jalan, atau perangkat |

## Urutan implementasi

### Tahap 0 — Fondasi operasional dan kepercayaan

**Tujuan:** Mengurangi ketergantungan pada satu operator dan memastikan pekerjaan dapat ditelusuri serta dipulihkan.

1. Tambahkan peran admin per desa dengan hak akses yang jelas, misalnya pengelola konten, petugas layanan, dan penanggung jawab desa. Pertahankan satu batas tenant berdasarkan desa untuk seluruh baca/tulis.
2. Buat audit trail untuk tindakan penting: akun, desa, waktu, jenis tindakan, dan perubahan sebelum/sesudah yang aman dicatat. Jangan menyimpan kata sandi, kode OTP, atau data rahasia dalam log.
3. Sediakan ekspor dan pencadangan data per desa, serta dokumentasikan prosedur pemulihan.
4. Buat status operasional yang terlihat oleh admin: data terakhir diperbarui, konten belum diterbitkan, permintaan belum ditangani, dan jadwal mendatang.
5. Pastikan alur penting tetap ringan pada ponsel dan tidak mengandalkan aset besar atau koneksi cepat.

**Selesai bila:** akses tiap peran dibatasi dan diuji terhadap desa lain; tindakan penting tercatat; admin dapat mengunduh data desanya; prosedur pencadangan dan pemulihan terdokumentasi.

### Tahap 1 — Layanan dan persuratan yang dapat dilacak

**Tujuan:** Mempercepat penerimaan dan tindak lanjut permintaan warga tanpa memindahkan arsip kependudukan sensitif ke Linkgo.

1. Perluas modul permintaan yang sudah ada dengan kategori layanan desa, persyaratan, estimasi waktu, dan petugas penanggung jawab.
2. Tambahkan penugasan/disposisi, status yang konsisten, tenggat, catatan internal, dan riwayat perubahan status.
3. Sediakan daftar persyaratan dan formulir awal yang dapat diisi warga, dengan nomor pelacakan dan notifikasi perubahan status.
4. Tambahkan pembuatan draf surat dari data permintaan hanya setelah desa menetapkan format. Surat final tetap melalui verifikasi dan tanda tangan pejabat berwenang.
5. Terapkan pembatasan akses dan masa simpan untuk informasi kontak/dokumen warga; hindari meminta data yang tidak diperlukan.

**Selesai bila:** satu permintaan dapat ditelusuri dari pengajuan hingga selesai; admin dapat menemukan pekerjaan terlambat; warga dapat melihat status; akses data pribadi hanya diberikan kepada petugas berwenang.

### Tahap 2 — Aspirasi dan perencanaan pembangunan berbasis data

**Tujuan:** Menghubungkan masukan warga, kebutuhan wilayah, dan progres proyek.

1. Tingkatkan usulan warga yang sudah ada dengan lokasi/peta opsional, kategori baku, kelompok penerima manfaat, urgensi, dan lampiran yang dibatasi.
2. Tambahkan proses moderasi dan tahapan keputusan: masuk, diverifikasi, dibahas, diprioritaskan, direncanakan, ditolak, atau selesai.
3. Buat tampilan rekap per kategori/wilayah/tahun dan ekspor untuk bahan musyawarah.
4. Hubungkan usulan yang disetujui ke data proyek desa yang telah memiliki tahun, lokasi, progres, dan koordinat opsional.
5. Simpan alasan prioritas dan keputusan agar proses dapat dijelaskan kepada warga.

**Selesai bila:** admin dapat menyiapkan rekap usulan untuk musyawarah; usulan yang diprioritaskan dapat ditautkan ke proyek; warga dapat melihat status dan alasan publik yang layak dibagikan.

### Tahap 3 — Transparansi keuangan dan kesiapan pelaporan

**Tujuan:** Membuat informasi anggaran desa lebih mudah dipahami dan membantu perangkat memantau kelengkapan dokumen, tanpa membangun buku besar keuangan.

1. Pertahankan publikasi ringkasan anggaran yang sudah ada dan pecah rincian publik berdasarkan program/kegiatan bila data sumber tersedia.
2. Tampilkan perbandingan rencana dan realisasi, periode pembaruan, sumber dokumen, serta catatan penjelas.
3. Tambahkan checklist kelengkapan dokumen dan kalender tenggat internal untuk persiapan pelaporan.
4. Pisahkan data publik dari dokumen internal; tetapkan jenis dokumen, hak akses, dan masa simpan sebelum unggah.
5. Rancang impor/ekspor terlebih dahulu dari format yang digunakan desa. Jangan membuat input transaksi atau perhitungan resmi sebelum kebutuhan, format, dan tanggung jawab validasinya disepakati.

**Selesai bila:** warga dapat membedakan rencana dan realisasi serta melihat sumber/tanggal pembaruan; admin dapat memantau checklist dan tenggat; nilai publik cocok dengan sumber yang diverifikasi.

### Tahap 4 — Kapasitas perangkat dan panduan regulasi

**Tujuan:** Membantu lebih banyak perangkat menjalankan tugas rutin dengan prosedur yang konsisten.

1. Buat pusat panduan berdasarkan tugas: memperbarui profil, menerbitkan informasi, memproses permintaan, memoderasi usulan, dan memperbarui proyek/anggaran.
2. Setiap panduan memiliki pemilik, tanggal peninjauan, versi, dan tautan ke sumber resmi; tandai panduan yang perlu ditinjau ulang.
3. Tambahkan panduan kontekstual pada formulir dan pesan validasi yang menjelaskan langkah berikutnya dengan bahasa sederhana.
4. Sediakan materi onboarding admin baru dan riwayat penyelesaian materi untuk kebutuhan internal desa.
5. Siapkan materi fasilitator agar pelatihan berkala dapat dilakukan bersama kecamatan/pendamping desa.

**Selesai bila:** admin baru dapat menyelesaikan alur umum dengan panduan; materi memiliki sumber dan tanggal tinjau; perubahan materi tercatat.

### Tahap 5 — Data penduduk agregat dan integrasi resmi (opsional)

**Tujuan:** Mendukung perencanaan tanpa menciptakan salinan data kependudukan yang berisiko.

1. Mulai dari indikator agregat yang diperlukan untuk perencanaan, bukan biodata per orang.
2. Jika dibutuhkan, sediakan impor berkas terkontrol dengan pemetaan kolom, validasi, pratinjau, catatan asal data, dan penghapusan berkas sementara.
3. Batasi akses, catat impor/ekspor, tetapkan retensi, dan hindari menampilkan kelompok statistik kecil yang dapat mengidentifikasi seseorang.
4. Lakukan integrasi dengan Dukcapil atau sistem resmi hanya setelah ada API/format yang diizinkan, dasar pemrosesan, persetujuan pihak berwenang, dan penilaian keamanan.

**Selesai bila:** data agregat memiliki sumber dan tanggal pembaruan; impor dapat ditelusuri; data pribadi tidak tampil ke publik; integrasi eksternal hanya berjalan melalui izin resmi.

### Tahap 6 — Modul informasi BUMDes

**Tujuan:** Membantu warga menemukan layanan ekonomi desa dan memberi pengelola kanal publik yang sederhana.

1. Tambahkan profil BUMDes/unit usaha, kontak, jam layanan, produk/jasa, lokasi, dan informasi peluang kerja sama.
2. Sediakan pengelolaan konten oleh akun yang ditunjuk desa serta status publikasi.
3. Tambahkan indikator non-akuntansi yang disepakati, misalnya jumlah produk aktif atau agenda, tanpa menampilkan data keuangan internal.
4. Validasi manfaat dengan pengelola BUMDes sebelum mengembangkan pemesanan, pembayaran, inventaris, atau pembukuan.

**Selesai bila:** unit usaha dapat memperbarui informasi secara mandiri dan warga dapat menemukan cara menghubunginya.

## Kebutuhan lintas tahap

- **Tenant:** semua tabel, unggahan, ekspor, pencarian, analitik, dan antrean pekerjaan harus dibatasi ke desa dari sesi admin; jangan mempercayai slug desa yang dikirim browser sebagai otorisasi.
- **Keamanan dan privasi:** minimalkan data warga, batasi akses berbasis peran, validasi unggahan, lindungi sesi, tetapkan retensi, dan sediakan mekanisme koreksi/penghapusan sesuai kebijakan.
- **Audit dan pemulihan:** perubahan penting dapat dilacak; backup terenkripsi diuji pemulihannya; sediakan ekspor yang dapat dibaca manusia.
- **Aksesibilitas dan kondisi lapangan:** desain ponsel dahulu, bahasa sederhana, formulir singkat, indikator koneksi/error yang jelas, serta alur yang tidak kehilangan isian saat koneksi terputus.
- **Kebenaran informasi:** setiap angka atau panduan publik memiliki sumber, tanggal pembaruan, dan penanggung jawab desa.
- **Evaluasi:** ukur waktu penyelesaian layanan, jumlah permintaan melewati tenggat, kelengkapan pembaruan informasi, jumlah usulan yang mendapat status, dan penggunaan panduan. Jangan mengukur keberhasilan hanya dari jumlah fitur atau akun.

## Prioritas yang disarankan

1. **Mulai:** Tahap 0 dan Tahap 1. Keduanya paling dekat dengan fitur yang telah tersedia dan langsung mengurangi pekerjaan yang tercecer.
2. **Berikutnya:** Tahap 2 untuk menghubungkan aspirasi warga dengan perencanaan serta progres proyek.
3. **Setelah proses desa dipetakan:** Tahap 3. Pertahankan sebagai transparansi dan checklist sampai kebutuhan resmi serta sumber data keuangan jelas.
4. **Dijalankan bersama pendampingan:** Tahap 4. Materi aplikasi membantu pekerjaan, tetapi tidak menggantikan pelatihan dan pembaruan regulasi.
5. **Berdasarkan izin dan kebutuhan nyata:** Tahap 5 dan Tahap 6. Mulai dengan data agregat dan publikasi BUMDes; hindari integrasi sensitif atau pembukuan sebelum tata kelolanya siap.

## Hal yang tidak menjadi klaim Linkgo

- Linkgo bukan pengganti Siskeudes, sistem pengadaan, sistem audit, atau proses pertanggungjawaban resmi.
- Linkgo bukan sumber hukum dan tidak menjamin kepatuhan regulasi secara otomatis.
- Linkgo bukan sistem administrasi kependudukan dan tidak menggantikan Dukcapil.
- Linkgo tidak menggantikan musyawarah desa, kewenangan pejabat, pendampingan manusia, maupun investasi infrastruktur.

## Kriteria sebelum memulai setiap tahap

Sebelum implementasi tahap, lakukan pemetaan proses dengan perangkat desa yang akan menggunakannya. Catat formulir/dokumen saat ini, pihak yang menyetujui, data minimum, kondisi internet, keluaran yang dibutuhkan, dan ukuran keberhasilan. Implementasi dimulai setelah batas data publik dan internal, penanggung jawab operasional, serta kebutuhan tenant desa disepakati.
