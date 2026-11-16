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
        Schema::create('village_indices', function (Blueprint $table): void {
            $table->id();
            $table->string('village_slug');
            $table->unsignedSmallInteger('year');
            $table->string('village_code', 20);
            $table->string('status')->nullable();
            $table->decimal('score', 5, 2)->nullable();
            $table->decimal('national_percentile', 5, 1)->nullable();
            $table->decimal('district_average_score', 5, 2)->nullable();
            $table->decimal('basic_services_score', 5, 2)->nullable();
            $table->decimal('social_score', 5, 2)->nullable();
            $table->decimal('economy_score', 5, 2)->nullable();
            $table->decimal('environment_score', 5, 2)->nullable();
            $table->decimal('accessibility_score', 5, 2)->nullable();
            $table->decimal('governance_score', 5, 2)->nullable();
            $table->decimal('area_km2', 10, 4)->nullable();
            $table->string('topography')->nullable();
            $table->text('main_income_source')->nullable();
            $table->boolean('bumdes_exists')->nullable();
            $table->string('bumdes_status')->nullable();
            $table->boolean('bumdes_legal_entity')->nullable();
            $table->boolean('flood_risk')->nullable();
            $table->boolean('drought_risk')->nullable();
            $table->boolean('landslide_risk')->nullable();
            $table->boolean('tidal_wave_risk')->nullable();
            $table->boolean('disaster_risk_assessment')->nullable();
            $table->text('source_url');
            $table->text('source_document_url');
            $table->date('source_checked_at');
            $table->timestamps();

            $table->foreign('village_slug')
                ->references('slug')
                ->on('village_pages')
                ->cascadeOnDelete();
            $table->unique(['village_slug', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('village_indices');
    }
};
