<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('village_pages')->insertOrIgnore([
            'slug' => 'pesisir',
            'name' => 'Pesisir',
            'body' => json_encode([
                'slug' => 'pesisir',
                'name' => 'Pesisir',
                'heroTitle' => 'Pesisir, ruang air dan warga.',
                'heroIntro' => 'Informasi layanan, kehidupan pesisir, dan pembangunan Desa Pesisir.',
                'profileTitle' => 'Desa Pesisir',
                'profileIntro' => 'Desa Pesisir, Kecamatan Gending, Kabupaten Probolinggo.',
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('village_pages')->where('slug', 'pesisir')->delete();
    }
};
