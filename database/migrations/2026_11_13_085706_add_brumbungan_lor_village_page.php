<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('village_pages')->insertOrIgnore([
            'slug' => 'brumbungan-lor',
            'name' => 'Brumbungan Lor',
            'body' => json_encode([
                'slug' => 'brumbungan-lor',
                'name' => 'Brumbungan Lor',
                'heroTitle' => 'Desa Brumbungan Lor',
                'heroIntro' => 'Ruang informasi layanan, pembangunan, dan kegiatan warga Brumbungan Lor.',
                'servicesTitle' => 'Layanan Desa Brumbungan Lor',
                'servicesIntro' => 'Informasi layanan administrasi dan kegiatan warga.',
                'transparencyTitle' => 'Transparansi Desa',
                'transparencyIntro' => 'Ringkasan APBDes dan pembangunan Desa Brumbungan Lor.',
                'projectsTitle' => 'Papan Pekerjaan Desa',
                'projectsIntro' => 'Proyek, kegiatan, dan rencana pembangunan di Brumbungan Lor.',
                'communityTitle' => 'Kegiatan dan Usulan Warga',
                'locationTitle' => 'Balai Desa Brumbungan Lor',
                'locationAddress' => 'Kecamatan Gending, Kabupaten Probolinggo, Jawa Timur',
                'profileTitle' => 'Profil Desa Brumbungan Lor',
                'profileIntro' => 'Ruang untuk mengenal wilayah, pemerintahan, dan potensi lokal Desa Brumbungan Lor.',
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('village_pages')->where('slug', 'brumbungan-lor')->delete();
    }
};
