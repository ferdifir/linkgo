<?php

namespace Database\Factories;

use App\Models\VillageIndex;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VillageIndex>
 */
class VillageIndexFactory extends Factory
{
    /**
     * Define the factory's default official record.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'village_slug' => 'curahsawo',
            'year' => 2025,
            'village_code' => '3513182011',
            'status' => 'MANDIRI',
            'score' => 85.35,
            'national_percentile' => 91.5,
            'district_average_score' => 83.47,
            'area_km2' => 5.5543,
            'topography' => 'Dataran Rendah',
            'main_income_source' => 'Pertanian (termasuk Perkebunan, Peternakan, Perikanan)',
            'bumdes_exists' => true,
            'bumdes_status' => 'Aktif',
            'bumdes_legal_entity' => true,
            'flood_risk' => false,
            'drought_risk' => false,
            'landslide_risk' => false,
            'tidal_wave_risk' => false,
            'disaster_risk_assessment' => true,
            'source_url' => 'https://sid.kemendesa.go.id/indeks-desa?tahun=2025&kode=3513182011',
            'source_document_url' => 'https://jdih.kemendesa.go.id/public/documents/a72ca269-9ca6-41ee-b306-c4bee4db2a8dKepmenDesPDT_343_Tahun_2025_ttg_Status_Kemajuan_dan_Kemandirian_Desa_2025.pdf',
            'source_checked_at' => '2026-11-16',
        ];
    }
}
