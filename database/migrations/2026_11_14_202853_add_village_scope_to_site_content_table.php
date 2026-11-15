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
        Schema::table('site_content', function (Blueprint $table): void {
            $table->string('village_slug')->default('curahsawo');
        });

        Schema::table('site_content', function (Blueprint $table): void {
            $table->unique('village_slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::table('site_content')->where('village_slug', '<>', 'curahsawo')->exists()) {
            throw new RuntimeException('Cannot roll back while site content exists for villages other than Curahsawo.');
        }

        Schema::table('site_content', function (Blueprint $table): void {
            $table->dropUnique(['village_slug']);
            $table->dropColumn('village_slug');
        });
    }
};
