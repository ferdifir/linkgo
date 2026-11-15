<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('site_content')) {
            Schema::create('site_content', function (Blueprint $table): void {
                $table->integer('id')->primary();
                $table->text('body');
                $table->text('updated_at');
            });
        }

        if (! Schema::hasTable('projects')) {
            Schema::create('projects', function (Blueprint $table): void {
                $table->increments('id');
                $table->text('title');
                $table->text('location');
                $table->integer('year');
                $table->text('status');
                $table->text('summary')->default('');
                $table->text('details')->default('');
                $table->text('volume')->default('');
                $table->text('funding')->default('');
                $table->text('executor')->default('');
                $table->text('schedule')->default('');
                $table->integer('progress')->default(0);
                $table->integer('spent')->default(0);
                $table->text('source')->default('');
                $table->text('source_url')->default('');
                $table->boolean('published')->default(true);
                $table->text('created_at');
            });
        }

        if (! Schema::hasTable('budgets')) {
            Schema::create('budgets', function (Blueprint $table): void {
                $table->increments('id');
                $table->integer('year')->unique();
                $table->integer('revenue')->default(0);
                $table->integer('expenditure')->default(0);
                $table->integer('financing')->default(0);
                $table->integer('village_fund')->default(0);
                $table->integer('realized')->default(0);
                $table->text('notes')->default('');
                $table->text('source_url')->default('');
                $table->boolean('published')->default(false);
            });
        }

        if (! Schema::hasTable('proposals')) {
            Schema::create('proposals', function (Blueprint $table): void {
                $table->increments('id');
                $table->text('title');
                $table->text('location');
                $table->text('category');
                $table->text('description');
                $table->text('name')->default('');
                $table->text('contact')->default('');
                $table->text('status')->default('Masuk');
                $table->text('admin_note')->default('');
                $table->text('created_at');
            });
        }

        if (! Schema::hasTable('app_meta')) {
            Schema::create('app_meta', function (Blueprint $table): void {
                $table->string('key')->primary();
                $table->text('value');
            });
        }
    }

    public function down(): void
    {
        foreach (['app_meta', 'proposals', 'budgets', 'projects', 'site_content'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
