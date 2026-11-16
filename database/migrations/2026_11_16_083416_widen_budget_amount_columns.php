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
        Schema::table('budgets', function (Blueprint $table): void {
            foreach (['revenue', 'expenditure', 'financing', 'village_fund', 'realized'] as $column) {
                $table->bigInteger($column)->default(0)->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $maximumInteger = 2_147_483_647;

        foreach (['revenue', 'expenditure', 'financing', 'village_fund', 'realized'] as $column) {
            if (DB::table('budgets')->max($column) > $maximumInteger) {
                throw new RuntimeException('Budget amounts exceed the integer range and cannot be safely narrowed.');
            }
        }

        Schema::table('budgets', function (Blueprint $table): void {
            foreach (['revenue', 'expenditure', 'financing', 'village_fund', 'realized'] as $column) {
                $table->integer($column)->default(0)->change();
            }
        });
    }
};
