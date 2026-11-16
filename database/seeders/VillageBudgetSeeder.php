<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VillageBudgetSeeder extends Seeder
{
    public function run(): void
    {
        $allocations = [
            'banyuanyar-lor' => [884259000, 384487017, 56060705, 13482225],
            'brumbungan-lor' => [856563000, 373616266, 56011124, 13470301],
            'bulang' => [886445000, 433673191, 50443245, 12131263],
            'curahsawo' => [729438000, 378789514, 48115732, 11571512],
            'gending' => [909803000, 348535467, 53012674, 12749194],
            'jatiadi' => [986219000, 407224008, 70142348, 16868766],
            'klaseman' => [1039935000, 342925911, 56307882, 13541669],
            'pajurangan' => [871211000, 417976019, 69826217, 16792738],
            'pesisir' => [703205000, 313201498, 40779502, 9807198],
            'pikatan' => [834297000, 307619771, 51194196, 12311862],
            'randupitu' => [736293000, 329283803, 49877422, 11995186],
            'sebaung' => [1376446000, 338509675, 55725616, 13401638],
            'sumberkerang' => [1142641000, 468878494, 32755737, 7877536],
        ];

        foreach ($allocations as $villageSlug => [$villageFund, $villageAllocation, $taxRevenueShare, $retributionShare]) {
            DB::table('budgets')->updateOrInsert(
                ['village_slug' => $villageSlug, 'year' => 2025],
                [
                    'revenue' => 0,
                    'expenditure' => 0,
                    'financing' => 0,
                    'village_fund' => $villageFund,
                    'village_allocation' => $villageAllocation,
                    'tax_revenue_share' => $taxRevenueShare,
                    'retribution_share' => $retributionShare,
                    'realized' => 0,
                    'notes' => '',
                    'source_url' => '',
                    'published' => true,
                ],
            );

            DB::table('budgets')->where('village_slug', $villageSlug)->where('year', 2026)->delete();
        }
    }
}
