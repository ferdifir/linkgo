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
        Schema::create('village_requests', function (Blueprint $table): void {
            $table->id();
            $table->string('village_slug')->index();
            $table->string('kind', 20);
            $table->string('tracking_code', 16)->unique();
            $table->string('title', 180);
            $table->string('category', 120)->default('');
            $table->string('name', 120)->default('');
            $table->string('contact', 180);
            $table->text('description');
            $table->string('status', 20)->default('Masuk');
            $table->text('admin_note')->default('');
            $table->date('target_at')->nullable();
            $table->timestamps();

            $table->index(['village_slug', 'status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('village_requests');
    }
};
