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
        Schema::table('village_requests', function (Blueprint $table): void {
            $table->string('email', 180)->nullable();
            $table->boolean('notify_by_email')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('village_requests', function (Blueprint $table): void {
            $table->dropColumn(['email', 'notify_by_email']);
        });
    }
};
