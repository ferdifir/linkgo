<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('village_pages')->insertOrIgnore([
            'slug' => 'sumberkerang',
            'name' => 'Sumberkerang',
            'body' => json_encode([
                'slug' => 'sumberkerang',
                'name' => 'Sumberkerang',
                'heroTitle' => 'Sumberkerang, jejak dari sumber.',
                'heroIntro' => 'Ruang informasi layanan, pembangunan, dan cerita warga Desa Sumberkerang.',
                'profileTitle' => 'Desa Sumberkerang',
                'profileIntro' => 'Desa Sumberkerang, Kecamatan Gending, Kabupaten Probolinggo.',
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('village_pages')->where('slug', 'sumberkerang')->delete();
    }
};
