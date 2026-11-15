<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('village_pages')->insertOrIgnore([
            'slug' => 'randupitu',
            'name' => 'Randupitu',
            'body' => json_encode([
                'slug' => 'randupitu',
                'name' => 'Randupitu',
                'heroTitle' => 'Dari lahan, tumbuh nilai baru.',
                'heroIntro' => 'Mengenal layanan, potensi, dan kabar Desa Randupitu, Kecamatan Gending.',
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('village_pages')->where('slug', 'randupitu')->delete();
    }
};
