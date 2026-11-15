<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('village_pages')->insertOrIgnore([
            'slug' => 'klaseman',
            'name' => 'Klaseman',
            'body' => json_encode([
                'slug' => 'klaseman',
                'name' => 'Klaseman',
                'heroTitle' => 'Ruang tumbuh, dari pesisir.',
                'heroIntro' => 'Layanan warga, kabar desa, dan kisah Klaseman.',
                'profileTitle' => 'Desa Klaseman',
                'profileIntro' => 'Desa Klaseman, Kecamatan Gending, Kabupaten Probolinggo.',
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('village_pages')->where('slug', 'klaseman')->delete();
    }
};
