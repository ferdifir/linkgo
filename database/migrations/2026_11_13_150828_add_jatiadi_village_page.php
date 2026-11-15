<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('village_pages')->insertOrIgnore([
            'slug' => 'jatiadi',
            'name' => 'Jatiadi',
            'body' => json_encode([
                'slug' => 'jatiadi',
                'name' => 'Jatiadi',
                'heroTitle' => 'Jatiadi tumbuh bersama.',
                'heroIntro' => 'Informasi layanan, pembangunan, dan kegiatan Desa Jatiadi.',
                'profileTitle' => 'Desa Jatiadi',
                'profileIntro' => 'Desa Jatiadi, Kecamatan Gending, Kabupaten Probolinggo.',
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('village_pages')->where('slug', 'jatiadi')->delete();
    }
};
