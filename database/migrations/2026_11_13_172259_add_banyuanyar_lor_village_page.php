<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('village_pages')->insertOrIgnore([
            'slug' => 'banyuanyar-lor',
            'name' => 'Banyuanyar Lor',
            'body' => json_encode([
                'slug' => 'banyuanyar-lor',
                'name' => 'Banyuanyar Lor',
                'heroTitle' => 'Banyuanyar Lor, ruang yang menyambung.',
                'heroIntro' => 'Informasi layanan, pembangunan, dan kegiatan warga dalam satu ruang yang mudah dijangkau.',
                'profileTitle' => 'Desa Banyuanyar Lor',
                'profileIntro' => 'Desa Banyuanyar Lor, Kecamatan Gending, Kabupaten Probolinggo.',
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('village_pages')->where('slug', 'banyuanyar-lor')->delete();
    }
};
