<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('village_media', function (Blueprint $table): void {
            $table->id();
            $table->string('village_slug')->index();
            $table->string('path', 500);
            $table->string('original_name', 255);
            $table->string('mime_type', 120);
            $table->unsignedBigInteger('size');
            $table->string('alt_text', 180)->default('');
            $table->timestamps();

            $table->unique(['village_slug', 'path']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('village_media');
    }
};
