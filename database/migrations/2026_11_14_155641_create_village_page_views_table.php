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
        Schema::create('village_page_views', function (Blueprint $table): void {
            $table->id();
            $table->string('village_slug')->index();
            $table->string('path', 255);
            $table->date('view_date');
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();

            $table->unique(['village_slug', 'path', 'view_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('village_page_views');
    }
};
