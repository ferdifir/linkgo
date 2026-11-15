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
        Schema::create('village_content', function (Blueprint $table): void {
            $table->id();
            $table->string('village_slug')->index();
            $table->string('type', 20);
            $table->string('title', 180);
            $table->string('summary', 300)->default('');
            $table->text('body');
            $table->string('category', 80)->default('');
            $table->string('link', 500)->default('');
            $table->boolean('published')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->date('published_at')->nullable();
            $table->timestamps();

            $table->index(['village_slug', 'type', 'published', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('village_content');
    }
};
