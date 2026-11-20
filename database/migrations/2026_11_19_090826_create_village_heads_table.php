<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('village_heads', function (Blueprint $table) {
            $table->string('village_slug')->primary();
            $table->string('name', 180);
            $table->timestamps();
        });

        $now = now()->utc()->toDateTimeString();
        DB::table('village_heads')->insert([
            'village_slug' => 'curahsawo',
            'name' => 'Hj. Nikmatul Iza, S.Pd.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('village_heads');
    }
};
