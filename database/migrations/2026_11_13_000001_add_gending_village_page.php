<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('village_pages')->insertOrIgnore([
            'slug' => 'gending',
            'name' => 'Gending',
            'body' => json_encode([
                'slug' => 'gending',
                'name' => 'Gending',
                'heroTitle' => 'Pangan tumbuh, usaha desa bergerak',
                'heroIntro' => 'Portal informasi dan layanan Pemerintah Desa Gending, Kecamatan Gending, Kabupaten Probolinggo.',
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('village_pages')->where('slug', 'gending')->delete();
    }
};
