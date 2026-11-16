<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShowcaseVillageDataSeeder extends Seeder
{
    /**
     * Seed project records used by the village website showcase.
     *
     * @var array<string, array{projects: list<array{title: string, location: string, year: int, status: string, summary: string, details: string, volume: string, amount: int, funding: string, executor: string, schedule: string, progress: int, matchLocation?: string}>}>
     */
    private array $villages = [
        'banyuanyar-lor' => [
            'projects' => [
                ['title' => 'Peningkatan jalan usaha tani', 'location' => 'Dusun Krajan · jalur area persawahan', 'year' => 2026, 'status' => 'Berjalan', 'summary' => 'Perkerasan jalan untuk memperlancar akses warga dan hasil panen.', 'details' => 'Peningkatan permukaan jalan usaha tani pada titik yang membutuhkan perbaikan.', 'volume' => 'Jalan lingkungan · 240 meter', 'amount' => 185000000, 'funding' => 'Dana Desa', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Maret–Juni 2026', 'progress' => 65],
                ['title' => 'Perbaikan saluran irigasi', 'location' => 'Dusun Tengah · saluran persawahan', 'year' => 2026, 'status' => 'Perencanaan', 'summary' => 'Perbaikan saluran untuk mendukung distribusi air ke lahan pertanian.', 'details' => 'Pembersihan dan perbaikan beberapa bagian saluran irigasi lingkungan.', 'volume' => 'Saluran irigasi · 180 meter', 'amount' => 125000000, 'funding' => 'APBDes', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Juli–September 2026', 'progress' => 10],
                ['title' => 'Rehabilitasi posyandu', 'location' => 'Dusun Krajan · area balai warga', 'year' => 2025, 'status' => 'Selesai', 'summary' => 'Perbaikan ruang pelayanan kesehatan ibu dan anak.', 'details' => 'Pengecatan, perbaikan lantai, dan pembenahan ruang pelayanan.', 'volume' => '1 unit posyandu', 'amount' => 85000000, 'funding' => 'Dana Desa', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'April–Juni 2025', 'progress' => 100],
            ],
        ],
        'brumbungan-lor' => [
            'projects' => [
                ['title' => 'Peningkatan jalan lingkungan', 'location' => 'Dusun Brumbungan · RT 02/RW 01', 'year' => 2026, 'status' => 'Berjalan', 'summary' => 'Perbaikan akses lingkungan untuk mendukung mobilitas warga.', 'details' => 'Peningkatan permukaan jalan dan perapian bahu jalan di lingkungan permukiman.', 'volume' => 'Jalan lingkungan · 210 meter', 'amount' => 195000000, 'funding' => 'Dana Desa', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Maret–Juni 2026', 'progress' => 58],
                ['title' => 'Perbaikan saluran drainase', 'location' => 'Dusun Lor · kawasan permukiman', 'year' => 2026, 'status' => 'Perencanaan', 'summary' => 'Penataan saluran untuk membantu aliran air saat musim hujan.', 'details' => 'Perbaikan saluran lingkungan pada titik yang memerlukan penanganan.', 'volume' => 'Drainase · 160 meter', 'amount' => 142000000, 'funding' => 'APBDes', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Juli–September 2026', 'progress' => 15],
                ['title' => 'Rehabilitasi balai warga', 'location' => 'Dusun Brumbungan · balai warga', 'year' => 2025, 'status' => 'Selesai', 'summary' => 'Pembenahan ruang pertemuan dan pelayanan masyarakat.', 'details' => 'Perbaikan atap, pengecatan, dan penataan ruang balai warga.', 'volume' => '1 unit balai warga', 'amount' => 118000000, 'funding' => 'APBDes', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Mei–Agustus 2025', 'progress' => 100],
            ],
        ],
        'bulang' => [
            'projects' => [
                ['title' => 'Paving jalan permukiman', 'location' => 'Dusun Bulang · RT 03/RW 02', 'year' => 2026, 'status' => 'Berjalan', 'summary' => 'Penataan jalan lingkungan untuk akses harian warga.', 'details' => 'Pemasangan paving dan perapian sisi jalan di area permukiman.', 'volume' => 'Jalan lingkungan · 225 meter', 'amount' => 178000000, 'funding' => 'Dana Desa', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Februari–Mei 2026', 'progress' => 72],
                ['title' => 'Pembangunan saluran lingkungan', 'location' => 'Dusun Krajan · sisi jalan utama', 'year' => 2026, 'status' => 'Perencanaan', 'summary' => 'Penambahan saluran untuk mengurangi genangan di lingkungan.', 'details' => 'Pembangunan saluran terbuka pada jalur permukiman.', 'volume' => 'Saluran · 145 meter', 'amount' => 132000000, 'funding' => 'APBDes', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Juni–Agustus 2026', 'progress' => 5],
                ['title' => 'Pengadaan perlengkapan posyandu', 'location' => 'Balai Desa Bulang', 'year' => 2025, 'status' => 'Selesai', 'summary' => 'Dukungan perlengkapan untuk kegiatan pelayanan kesehatan warga.', 'details' => 'Pengadaan meja pemeriksaan, alat ukur, dan perlengkapan administrasi.', 'volume' => '1 paket perlengkapan', 'amount' => 48000000, 'funding' => 'Dana Desa', 'executor' => 'Pemerintah Desa Bulang', 'schedule' => 'Januari–Maret 2025', 'progress' => 100],
            ],
        ],
        'curahsawo' => [
            'projects' => [
                ['title' => 'Pengaspalan jalan', 'location' => 'Dusun Krajan · RT 02/RW 01', 'year' => 2025, 'status' => 'Selesai', 'summary' => 'Peningkatan jalan lingkungan untuk memperlancar akses warga.', 'details' => 'Pengaspalan jalan pada ruas lingkungan Dusun Krajan.', 'volume' => 'Jalan · 260 meter', 'amount' => 225000000, 'funding' => 'Dana Desa', 'executor' => 'Tim Pelaksana Kegiatan Desa Curahsawo', 'schedule' => 'Maret–Juni 2025', 'progress' => 100],
                ['title' => 'Pembangunan pagar kantor desa', 'location' => 'Kantor Desa Curahsawo', 'year' => 2025, 'status' => 'Selesai', 'summary' => 'Penataan batas dan akses lingkungan kantor desa.', 'details' => 'Pembangunan pagar pada sisi depan dan samping kantor desa.', 'volume' => 'Pagar · 86 meter', 'amount' => 118000000, 'funding' => 'APBDes', 'executor' => 'Tim Pelaksana Kegiatan Desa Curahsawo', 'schedule' => 'April–Juli 2025', 'progress' => 100],
                ['title' => 'Rehabilitasi rumah', 'location' => 'Dusun Taman · RT 04/RW 01', 'year' => 2025, 'status' => 'Selesai', 'summary' => 'Dukungan perbaikan rumah bagi warga penerima manfaat.', 'details' => 'Perbaikan komponen rumah sesuai kebutuhan penerima manfaat.', 'volume' => '1 unit rumah', 'amount' => 20000000, 'funding' => 'Program bantuan perumahan', 'executor' => 'Pemerintah Desa Curahsawo', 'schedule' => 'Mei–Juli 2025', 'progress' => 100],
                ['title' => 'Rehabilitasi rumah', 'location' => 'Dusun Karanganyar · RT 05/RW 01', 'year' => 2025, 'status' => 'Selesai', 'summary' => 'Dukungan perbaikan rumah bagi warga penerima manfaat.', 'details' => 'Perbaikan komponen rumah sesuai kebutuhan penerima manfaat.', 'volume' => '1 unit rumah', 'amount' => 20000000, 'funding' => 'Program bantuan perumahan', 'executor' => 'Pemerintah Desa Curahsawo', 'schedule' => 'Juni–Agustus 2025', 'progress' => 100],
                ['title' => 'Rehabilitasi rumah', 'location' => 'Dusun Wedian · RT 01/RW 01', 'year' => 2025, 'status' => 'Selesai', 'summary' => 'Dukungan perbaikan rumah bagi warga penerima manfaat.', 'details' => 'Perbaikan komponen rumah sesuai kebutuhan penerima manfaat.', 'volume' => '1 unit rumah', 'amount' => 20000000, 'funding' => 'Program bantuan perumahan', 'executor' => 'Pemerintah Desa Curahsawo', 'schedule' => 'Juli–September 2025', 'progress' => 100],
                ['title' => 'Usulan fasilitas olahraga', 'location' => 'Area kegiatan warga Curahsawo', 'matchLocation' => 'Lokasi belum ditetapkan', 'year' => 2026, 'status' => 'Perencanaan', 'summary' => 'Penyiapan sarana olahraga untuk kegiatan bersama warga.', 'details' => 'Penyusunan kebutuhan dan rencana lokasi fasilitas olahraga.', 'volume' => '1 lokasi kegiatan', 'amount' => 165000000, 'funding' => 'APBDes', 'executor' => 'Pemerintah Desa Curahsawo', 'schedule' => 'Juli–Desember 2026', 'progress' => 10],
            ],
        ],
        'gending' => [
            'projects' => [
                ['title' => 'Perbaikan jalan penghubung dusun', 'location' => 'Dusun Gending · ruas penghubung permukiman', 'year' => 2026, 'status' => 'Berjalan', 'summary' => 'Perbaikan ruas penghubung untuk akses layanan dan kegiatan warga.', 'details' => 'Peningkatan permukaan jalan pada titik yang mengalami kerusakan.', 'volume' => 'Jalan · 280 meter', 'amount' => 235000000, 'funding' => 'Dana Desa', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Maret–Juli 2026', 'progress' => 62],
                ['title' => 'Peningkatan saluran pertanian', 'location' => 'Area persawahan Desa Gending', 'year' => 2026, 'status' => 'Perencanaan', 'summary' => 'Pembenahan saluran air untuk mendukung kegiatan pertanian.', 'details' => 'Pembersihan dan perbaikan dinding saluran pada beberapa titik.', 'volume' => 'Saluran · 210 meter', 'amount' => 174000000, 'funding' => 'APBDes', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Agustus–Oktober 2026', 'progress' => 8],
                ['title' => 'Pengembangan sarana usaha warga', 'location' => 'Area kegiatan ekonomi Desa Gending', 'year' => 2025, 'status' => 'Selesai', 'summary' => 'Pengadaan sarana pendukung kegiatan usaha produktif warga.', 'details' => 'Dukungan perlengkapan untuk kegiatan usaha skala desa.', 'volume' => '1 paket sarana usaha', 'amount' => 92000000, 'funding' => 'APBDes', 'executor' => 'Pemerintah Desa Gending', 'schedule' => 'April–September 2025', 'progress' => 100],
            ],
        ],
        'jatiadi' => [
            'projects' => [
                ['title' => 'Peningkatan jalan lingkungan', 'location' => 'Dusun Jatiadi · RT 01/RW 01', 'year' => 2026, 'status' => 'Berjalan', 'summary' => 'Peningkatan jalan untuk kenyamanan akses lingkungan.', 'details' => 'Perkerasan dan perapian ruas jalan di kawasan permukiman.', 'volume' => 'Jalan · 230 meter', 'amount' => 205000000, 'funding' => 'Dana Desa', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Maret–Juni 2026', 'progress' => 55],
                ['title' => 'Pembangunan drainase permukiman', 'location' => 'Dusun Krajan · sisi jalan desa', 'year' => 2026, 'status' => 'Perencanaan', 'summary' => 'Pembangunan saluran untuk memperbaiki aliran air lingkungan.', 'details' => 'Pembangunan drainase pada kawasan permukiman yang membutuhkan.', 'volume' => 'Drainase · 175 meter', 'amount' => 158000000, 'funding' => 'APBDes', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Juli–September 2026', 'progress' => 12],
                ['title' => 'Rehabilitasi ruang pelayanan desa', 'location' => 'Kantor Desa Jatiadi', 'year' => 2025, 'status' => 'Selesai', 'summary' => 'Pembenahan ruang untuk mendukung pelayanan administrasi warga.', 'details' => 'Perbaikan ruang pelayanan dan penataan sarana pendukung.', 'volume' => '1 ruang pelayanan', 'amount' => 96000000, 'funding' => 'APBDes', 'executor' => 'Pemerintah Desa Jatiadi', 'schedule' => 'Mei–Agustus 2025', 'progress' => 100],
            ],
        ],
        'klaseman' => [
            'projects' => [
                ['title' => 'Perbaikan akses jalan desa', 'location' => 'Dusun Klaseman · jalan lingkungan', 'year' => 2026, 'status' => 'Berjalan', 'summary' => 'Perbaikan jalan untuk memudahkan akses warga dan layanan desa.', 'details' => 'Peningkatan permukaan pada ruas jalan lingkungan.', 'volume' => 'Jalan · 215 meter', 'amount' => 188000000, 'funding' => 'Dana Desa', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Februari–Mei 2026', 'progress' => 68],
                ['title' => 'Peningkatan penerangan jalan', 'location' => 'Jalur permukiman Desa Klaseman', 'year' => 2026, 'status' => 'Perencanaan', 'summary' => 'Penambahan titik penerangan untuk mendukung aktivitas malam warga.', 'details' => 'Pengadaan dan pemasangan lampu jalan pada titik prioritas.', 'volume' => '6 titik penerangan', 'amount' => 74000000, 'funding' => 'APBDes', 'executor' => 'Pemerintah Desa Klaseman', 'schedule' => 'Juni–Agustus 2026', 'progress' => 5],
                ['title' => 'Pembenahan sarana layanan warga', 'location' => 'Balai Desa Klaseman', 'year' => 2025, 'status' => 'Selesai', 'summary' => 'Perawatan sarana untuk kegiatan pelayanan dan pertemuan warga.', 'details' => 'Perbaikan fasilitas dan penataan ruang layanan.', 'volume' => '1 paket sarana', 'amount' => 68000000, 'funding' => 'APBDes', 'executor' => 'Pemerintah Desa Klaseman', 'schedule' => 'April–Juli 2025', 'progress' => 100],
            ],
        ],
        'pajurangan' => [
            'projects' => [
                ['title' => 'Peningkatan jalan lingkungan', 'location' => 'Dusun Pajurangan · RT 02/RW 01', 'year' => 2026, 'status' => 'Berjalan', 'summary' => 'Perbaikan akses jalan di kawasan permukiman warga.', 'details' => 'Perkerasan dan penataan permukaan jalan lingkungan.', 'volume' => 'Jalan · 220 meter', 'amount' => 182000000, 'funding' => 'Dana Desa', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Maret–Juni 2026', 'progress' => 61],
                ['title' => 'Perbaikan saluran air', 'location' => 'Dusun Krajan · kawasan permukiman', 'year' => 2026, 'status' => 'Perencanaan', 'summary' => 'Perbaikan saluran untuk mendukung aliran air di lingkungan warga.', 'details' => 'Pembersihan dan perbaikan saluran pada titik prioritas.', 'volume' => 'Saluran · 155 meter', 'amount' => 128000000, 'funding' => 'APBDes', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Juli–September 2026', 'progress' => 10],
                ['title' => 'Perlengkapan kegiatan posyandu', 'location' => 'Balai Desa Pajurangan', 'year' => 2025, 'status' => 'Selesai', 'summary' => 'Pengadaan perlengkapan untuk mendukung pelayanan kesehatan warga.', 'details' => 'Pengadaan alat ukur dan perlengkapan administrasi kegiatan.', 'volume' => '1 paket perlengkapan', 'amount' => 52000000, 'funding' => 'Dana Desa', 'executor' => 'Pemerintah Desa Pajurangan', 'schedule' => 'Januari–April 2025', 'progress' => 100],
            ],
        ],
        'pesisir' => [
            'projects' => [
                ['title' => 'Perbaikan jalan akses pesisir', 'location' => 'Dusun Pesisir · jalur permukiman', 'year' => 2026, 'status' => 'Berjalan', 'summary' => 'Peningkatan akses lingkungan untuk mendukung mobilitas warga pesisir.', 'details' => 'Perbaikan permukaan jalan pada jalur penghubung permukiman.', 'volume' => 'Jalan · 245 meter', 'amount' => 215000000, 'funding' => 'Dana Desa', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Maret–Juli 2026', 'progress' => 57],
                ['title' => 'Penataan saluran lingkungan', 'location' => 'Dusun Pesisir · sisi jalan utama', 'year' => 2026, 'status' => 'Perencanaan', 'summary' => 'Penataan saluran air pada kawasan permukiman.', 'details' => 'Pembangunan dan perapian saluran di sepanjang jalur lingkungan.', 'volume' => 'Drainase · 190 meter', 'amount' => 165000000, 'funding' => 'APBDes', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Agustus–Oktober 2026', 'progress' => 8],
                ['title' => 'Perbaikan fasilitas umum', 'location' => 'Area balai warga Desa Pesisir', 'year' => 2025, 'status' => 'Selesai', 'summary' => 'Perawatan fasilitas umum untuk kegiatan bersama warga.', 'details' => 'Perbaikan sarana dan penataan area kegiatan masyarakat.', 'volume' => '1 lokasi fasilitas umum', 'amount' => 105000000, 'funding' => 'APBDes', 'executor' => 'Pemerintah Desa Pesisir', 'schedule' => 'Mei–Agustus 2025', 'progress' => 100],
            ],
        ],
        'pikatan' => [
            'projects' => [
                ['title' => 'Pengerasan jalan usaha tani', 'location' => 'Dusun Pikatan · area pertanian', 'year' => 2026, 'status' => 'Berjalan', 'summary' => 'Peningkatan jalur untuk memudahkan akses menuju lahan pertanian.', 'details' => 'Pengerasan jalan dan perapian bahu pada jalur usaha tani.', 'volume' => 'Jalan usaha tani · 250 meter', 'amount' => 192000000, 'funding' => 'Dana Desa', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Februari–Juni 2026', 'progress' => 70],
                ['title' => 'Perbaikan saluran irigasi', 'location' => 'Area persawahan Desa Pikatan', 'year' => 2026, 'status' => 'Perencanaan', 'summary' => 'Pembenahan saluran untuk menunjang pengairan lahan.', 'details' => 'Perbaikan bagian saluran dan pembersihan sedimentasi.', 'volume' => 'Saluran irigasi · 170 meter', 'amount' => 138000000, 'funding' => 'APBDes', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Juli–September 2026', 'progress' => 10],
                ['title' => 'Rehabilitasi ruang belajar warga', 'location' => 'Dusun Krajan · fasilitas pendidikan warga', 'year' => 2025, 'status' => 'Selesai', 'summary' => 'Perbaikan ruang untuk mendukung kegiatan belajar masyarakat.', 'details' => 'Pengecatan dan perbaikan fasilitas ruang belajar.', 'volume' => '1 ruang belajar', 'amount' => 78000000, 'funding' => 'APBDes', 'executor' => 'Pemerintah Desa Pikatan', 'schedule' => 'April–Juli 2025', 'progress' => 100],
            ],
        ],
        'randupitu' => [
            'projects' => [
                ['title' => 'Peningkatan jalan lingkungan', 'location' => 'Dusun Randupitu · RT 03/RW 02', 'year' => 2026, 'status' => 'Berjalan', 'summary' => 'Perbaikan akses jalan untuk mendukung mobilitas masyarakat.', 'details' => 'Peningkatan jalan lingkungan pada jalur permukiman.', 'volume' => 'Jalan · 270 meter', 'amount' => 228000000, 'funding' => 'Dana Desa', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Maret–Juli 2026', 'progress' => 64],
                ['title' => 'Pembangunan saluran drainase', 'location' => 'Dusun Krajan · jalur permukiman', 'year' => 2026, 'status' => 'Perencanaan', 'summary' => 'Penataan aliran air untuk mengurangi genangan lingkungan.', 'details' => 'Pembangunan drainase pada beberapa titik prioritas.', 'volume' => 'Drainase · 185 meter', 'amount' => 158000000, 'funding' => 'APBDes', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Agustus–Oktober 2026', 'progress' => 8],
                ['title' => 'Penguatan sarana usaha lokal', 'location' => 'Area kegiatan ekonomi Desa Randupitu', 'year' => 2025, 'status' => 'Selesai', 'summary' => 'Dukungan sarana bagi kegiatan usaha produktif masyarakat.', 'details' => 'Pengadaan perlengkapan pendukung kegiatan usaha warga.', 'volume' => '1 paket sarana', 'amount' => 97000000, 'funding' => 'APBDes', 'executor' => 'Pemerintah Desa Randupitu', 'schedule' => 'April–Agustus 2025', 'progress' => 100],
            ],
        ],
        'sebaung' => [
            'projects' => [
                ['title' => 'Peningkatan jalan lingkungan', 'location' => 'Dusun Sebaung · RT 02/RW 01', 'year' => 2026, 'status' => 'Berjalan', 'summary' => 'Peningkatan akses jalan untuk mendukung kegiatan harian warga.', 'details' => 'Perbaikan permukaan jalan pada jalur permukiman.', 'volume' => 'Jalan · 230 meter', 'amount' => 188000000, 'funding' => 'Dana Desa', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Maret–Juni 2026', 'progress' => 59],
                ['title' => 'Perawatan ruang terbuka desa', 'location' => 'Area kegiatan warga Desa Sebaung', 'year' => 2026, 'status' => 'Perencanaan', 'summary' => 'Penataan area terbuka untuk mendukung aktivitas masyarakat.', 'details' => 'Pembersihan, perapian, dan penambahan sarana pendukung.', 'volume' => '1 area kegiatan', 'amount' => 92000000, 'funding' => 'APBDes', 'executor' => 'Pemerintah Desa Sebaung', 'schedule' => 'Juli–September 2026', 'progress' => 10],
                ['title' => 'Pengadaan bibit tanaman', 'location' => 'Kegiatan lingkungan Desa Sebaung', 'year' => 2025, 'status' => 'Selesai', 'summary' => 'Penyediaan bibit untuk kegiatan penghijauan lingkungan.', 'details' => 'Pengadaan bibit dan perlengkapan penanaman warga.', 'volume' => '1 paket bibit tanaman', 'amount' => 46000000, 'funding' => 'Dana Desa', 'executor' => 'Pemerintah Desa Sebaung', 'schedule' => 'Januari–Mei 2025', 'progress' => 100],
            ],
        ],
        'sumberkerang' => [
            'projects' => [
                ['title' => 'Peningkatan jalan antarlingkungan', 'location' => 'Dusun Sumberkerang · ruas penghubung warga', 'year' => 2026, 'status' => 'Berjalan', 'summary' => 'Perbaikan akses jalan untuk menghubungkan area permukiman.', 'details' => 'Peningkatan permukaan jalan dan perapian sisi ruas.', 'volume' => 'Jalan · 295 meter', 'amount' => 245000000, 'funding' => 'Dana Desa', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Maret–Juli 2026', 'progress' => 66],
                ['title' => 'Perbaikan saluran pertanian', 'location' => 'Area pertanian Desa Sumberkerang', 'year' => 2026, 'status' => 'Perencanaan', 'summary' => 'Pembenahan saluran untuk menunjang kebutuhan pengairan.', 'details' => 'Perbaikan dinding saluran dan pembersihan pada titik terpilih.', 'volume' => 'Saluran · 205 meter', 'amount' => 168000000, 'funding' => 'APBDes', 'executor' => 'Tim Pelaksana Kegiatan Desa', 'schedule' => 'Agustus–Oktober 2026', 'progress' => 7],
                ['title' => 'Rehabilitasi fasilitas pelayanan', 'location' => 'Balai Desa Sumberkerang', 'year' => 2025, 'status' => 'Selesai', 'summary' => 'Perbaikan fasilitas untuk mendukung pelayanan masyarakat.', 'details' => 'Pembenahan ruang pelayanan dan sarana pendukung.', 'volume' => '1 paket rehabilitasi', 'amount' => 112000000, 'funding' => 'APBDes', 'executor' => 'Pemerintah Desa Sumberkerang', 'schedule' => 'Mei–September 2025', 'progress' => 100],
            ],
        ],
    ];

    public function run(): void
    {
        $now = now()->utc()->toIso8601String();

        foreach ($this->villages as $villageSlug => $village) {
            foreach ($village['projects'] as $project) {
                $existingLocation = $project['matchLocation'] ?? null;

                if ($existingLocation !== null) {
                    DB::table('projects')
                        ->where('village_slug', $villageSlug)
                        ->where('year', $project['year'])
                        ->where('title', $project['title'])
                        ->where('location', $existingLocation)
                        ->update(['location' => $project['location']]);
                }

                DB::table('projects')->updateOrInsert(
                    [
                        'village_slug' => $villageSlug,
                        'year' => $project['year'],
                        'title' => $project['title'],
                        'location' => $project['location'],
                    ],
                    [
                        'status' => $project['status'],
                        'summary' => $project['summary'],
                        'details' => $project['details'],
                        'volume' => $project['volume'],
                        'executor' => $project['executor'],
                        'schedule' => $project['schedule'],
                        'progress' => $project['progress'],
                        'spent' => (int) round($project['amount'] * $project['progress'] / 100),
                        'funding' => $project['funding'].' · Rp '.number_format($project['amount'], 0, ',', '.'),
                        'source' => '',
                        'source_url' => '',
                        'published' => true,
                        'created_at' => $now,
                    ],
                );
            }

        }
    }
}
