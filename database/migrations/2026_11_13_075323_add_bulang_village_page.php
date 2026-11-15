<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('village_pages')->insertOrIgnore([
            'slug' => 'bulang',
            'name' => 'Bulang',
            'body' => json_encode([
                'slug' => 'bulang',
                'name' => 'Bulang',
                'heroTitle' => 'Ruang informasi warga Bulang',
                'heroIntro' => 'Layanan, pembangunan, dan kabar desa dalam satu tempat.',
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('village_pages')->where('slug', 'bulang')->delete();
    }
};
