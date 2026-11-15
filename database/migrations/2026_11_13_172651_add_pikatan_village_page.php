<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('village_pages')->insertOrIgnore([
            'slug' => 'pikatan',
            'name' => 'Pikatan',
            'body' => json_encode([
                'slug' => 'pikatan',
                'name' => 'Pikatan',
                'heroTitle' => 'Pikatan, aliran yang menghidupi.',
                'heroIntro' => 'Informasi layanan, pertanian, dan pembangunan Desa Pikatan.',
                'profileTitle' => 'Desa Pikatan',
                'profileIntro' => 'Desa Pikatan, Kecamatan Gending, Kabupaten Probolinggo.',
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('village_pages')->where('slug', 'pikatan')->delete();
    }
};
