<?php

namespace App\Models;

use Database\Factories\VillageIndexFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageIndex extends Model
{
    /** @use HasFactory<VillageIndexFactory> */
    use HasFactory;

    protected $fillable = [
        'village_slug', 'year', 'village_code', 'status', 'score', 'national_percentile',
        'district_average_score', 'basic_services_score', 'social_score', 'economy_score',
        'environment_score', 'accessibility_score', 'governance_score', 'area_km2',
        'topography', 'main_income_source', 'bumdes_exists', 'bumdes_status',
        'bumdes_legal_entity', 'flood_risk', 'drought_risk', 'landslide_risk',
        'tidal_wave_risk', 'disaster_risk_assessment', 'source_url', 'source_document_url',
        'source_checked_at',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'score' => 'decimal:2',
            'national_percentile' => 'decimal:1',
            'district_average_score' => 'decimal:2',
            'basic_services_score' => 'decimal:2',
            'social_score' => 'decimal:2',
            'economy_score' => 'decimal:2',
            'environment_score' => 'decimal:2',
            'accessibility_score' => 'decimal:2',
            'governance_score' => 'decimal:2',
            'area_km2' => 'decimal:4',
            'bumdes_exists' => 'boolean',
            'bumdes_legal_entity' => 'boolean',
            'flood_risk' => 'boolean',
            'drought_risk' => 'boolean',
            'landslide_risk' => 'boolean',
            'tidal_wave_risk' => 'boolean',
            'disaster_risk_assessment' => 'boolean',
            'source_checked_at' => 'date',
        ];
    }
}
