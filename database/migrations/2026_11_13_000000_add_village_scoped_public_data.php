<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('projects', 'village_slug')) {
            Schema::table('projects', function (Blueprint $table): void {
                $table->string('village_slug')->default('curahsawo')->index();
            });
        }

        if (! Schema::hasColumn('proposals', 'village_slug')) {
            Schema::table('proposals', function (Blueprint $table): void {
                $table->string('village_slug')->default('curahsawo')->index();
            });
        }

        if (! Schema::hasColumn('budgets', 'village_slug')) {
            DB::statement('CREATE TABLE budgets_village_scoped (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                village_slug TEXT NOT NULL DEFAULT \'curahsawo\',
                year INTEGER NOT NULL,
                revenue INTEGER NOT NULL DEFAULT 0,
                expenditure INTEGER NOT NULL DEFAULT 0,
                financing INTEGER NOT NULL DEFAULT 0,
                village_fund INTEGER NOT NULL DEFAULT 0,
                realized INTEGER NOT NULL DEFAULT 0,
                notes TEXT NOT NULL DEFAULT \'\',
                source_url TEXT NOT NULL DEFAULT \'\',
                published INTEGER NOT NULL DEFAULT 0,
                UNIQUE(village_slug, year)
            )');
            DB::statement("INSERT INTO budgets_village_scoped (id, village_slug, year, revenue, expenditure, financing, village_fund, realized, notes, source_url, published)
                SELECT id, 'curahsawo', year, revenue, expenditure, financing, village_fund, realized, notes, source_url, published FROM budgets");
            Schema::drop('budgets');
            Schema::rename('budgets_village_scoped', 'budgets');
        }

        if (! Schema::hasTable('village_pages')) {
            Schema::create('village_pages', function (Blueprint $table): void {
                $table->string('slug')->primary();
                $table->string('name');
                $table->text('body');
                $table->timestamps();
            });
        }

        $legacyCurahsawo = DB::table('site_content')->where('id', 1)->value('body');
        if ($legacyCurahsawo) {
            DB::table('village_pages')->insertOrIgnore([
                'slug' => 'curahsawo',
                'name' => 'Curahsawo',
                'body' => $legacyCurahsawo,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('village_pages')->insertOrIgnore([
            'slug' => 'pajurangan',
            'name' => 'Pajurangan',
            'body' => json_encode([
                'slug' => 'pajurangan',
                'heroTitle' => 'Pajurangan dalam satu peta',
                'heroIntro' => 'Ruang warga di antara permukiman, sawah, tambak, dan pesisir.',
                'profileNote' => 'Konteks bentang lahan bersumber dari interpretasi citra tahun 2021 dan perlu diperbarui bersama pemerintah desa.',
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('village_pages');
        if (Schema::hasColumn('projects', 'village_slug')) {
            Schema::table('projects', fn (Blueprint $table) => $table->dropColumn('village_slug'));
        }
        if (Schema::hasColumn('proposals', 'village_slug')) {
            Schema::table('proposals', fn (Blueprint $table) => $table->dropColumn('village_slug'));
        }
        if (Schema::hasColumn('budgets', 'village_slug')) {
            DB::statement('CREATE TABLE budgets_legacy (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                year INTEGER NOT NULL UNIQUE,
                revenue INTEGER NOT NULL DEFAULT 0,
                expenditure INTEGER NOT NULL DEFAULT 0,
                financing INTEGER NOT NULL DEFAULT 0,
                village_fund INTEGER NOT NULL DEFAULT 0,
                realized INTEGER NOT NULL DEFAULT 0,
                notes TEXT NOT NULL DEFAULT \'\',
                source_url TEXT NOT NULL DEFAULT \'\',
                published INTEGER NOT NULL DEFAULT 0
            )');
            DB::statement("INSERT INTO budgets_legacy (id, year, revenue, expenditure, financing, village_fund, realized, notes, source_url, published)
                SELECT id, year, revenue, expenditure, financing, village_fund, realized, notes, source_url, published FROM budgets WHERE village_slug = 'curahsawo'");
            Schema::drop('budgets');
            Schema::rename('budgets_legacy', 'budgets');
        }
    }
};
