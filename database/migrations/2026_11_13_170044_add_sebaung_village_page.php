<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('village_pages')->insertOrIgnore([
            'slug' => 'sebaung',
            'name' => 'Sebaung',
            'body' => json_encode([
                'slug' => 'sebaung',
                'name' => 'Sebaung',
                'heroTitle' => 'Sebaung, tumbuh bersama.',
                'heroIntro' => 'Ruang informasi layanan, pembangunan, dan kehidupan warga Desa Sebaung.',
                'profileTitle' => 'Desa Sebaung',
                'profileIntro' => 'Desa Sebaung, Kecamatan Gending, Kabupaten Probolinggo.',
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('village_pages')->where('slug', 'sebaung')->delete();
    }
};
