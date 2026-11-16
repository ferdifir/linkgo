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
        Schema::table('budgets', function (Blueprint $table): void {
            $table->integer('village_allocation')->default(0);
            $table->integer('tax_revenue_share')->default(0);
            $table->integer('retribution_share')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('budgets', function (Blueprint $table): void {
            $table->dropColumn(['village_allocation', 'tax_revenue_share', 'retribution_share']);
        });
    }
};
