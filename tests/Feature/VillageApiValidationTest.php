<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class VillageApiValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_endpoint_rejects_invalid_coordinates(): void
    {
        $admin = $this->createVillageAdmin('curahsawo');

        $this->actingAsAdmin($admin)->postJson('/api/admin/projects', [
            'title' => 'Perbaikan jalan',
            'location' => 'Dusun Krajan',
            'year' => 2026,
            'latitude' => 91,
            'status' => 'Direncanakan',
            'published' => true,
        ])->assertUnprocessable();

        $this->assertDatabaseCount('projects', 0);
    }

    public function test_project_endpoint_persists_only_validated_project_data(): void
    {
        $admin = $this->createVillageAdmin('curahsawo');

        $this->actingAsAdmin($admin)->postJson('/api/admin/projects', [
            'title' => 'Perbaikan jalan',
            'location' => 'Dusun Krajan',
            'year' => 2026,
            'latitude' => '-7.1',
            'longitude' => '113.2',
            'published' => true,
            'village_slug' => 'pajurangan',
        ])->assertCreated();

        $this->assertDatabaseHas('projects', [
            'title' => 'Perbaikan jalan',
            'village_slug' => 'curahsawo',
            'year' => 2026,
            'latitude' => -7.1,
            'longitude' => 113.2,
        ]);
    }

    public function test_public_proposal_requires_validated_required_fields(): void
    {
        $this->createVillagePage('curahsawo');

        $this->withSameOriginHeaders()
            ->postJson('/api/desa/curahsawo/proposals', [
                'title' => 'Usulan lampu jalan',
                'location' => 'Dusun Krajan',
            ])
            ->assertUnprocessable();

        $this->assertDatabaseCount('proposals', 0);
    }

    public function test_public_proposal_stores_validated_content(): void
    {
        $this->createVillagePage('curahsawo');

        $this->withSameOriginHeaders()->postJson('/api/desa/curahsawo/proposals', [
            'title' => 'Usulan lampu jalan',
            'location' => 'Dusun Krajan',
            'description' => 'Penerangan jalan dibutuhkan di sekitar balai desa.',
            'village_slug' => 'pajurangan',
        ])->assertCreated();

        $this->assertDatabaseHas('proposals', [
            'title' => 'Usulan lampu jalan',
            'village_slug' => 'curahsawo',
            'status' => 'Masuk',
        ]);
    }

    public function test_admin_proposal_update_rejects_unknown_status(): void
    {
        $admin = $this->createVillageAdmin('curahsawo');
        $proposalId = DB::table('proposals')->insertGetId([
            'village_slug' => 'curahsawo',
            'title' => 'Perbaikan drainase',
            'location' => 'Dusun Krajan',
            'category' => '',
            'description' => 'Saluran perlu diperbaiki.',
            'name' => '',
            'contact' => '',
            'status' => 'Masuk',
            'admin_note' => '',
            'created_at' => now()->toIso8601String(),
        ]);

        $this->actingAsAdmin($admin)->putJson('/api/admin/proposals/'.$proposalId, [
            'status' => 'Invalid',
        ])->assertUnprocessable();

        $this->assertDatabaseHas('proposals', [
            'id' => $proposalId,
            'status' => 'Masuk',
        ]);
    }

    public function test_admin_cannot_update_a_proposal_from_another_village(): void
    {
        $admin = $this->createVillageAdmin('curahsawo');
        $proposalId = DB::table('proposals')->insertGetId([
            'village_slug' => 'pajurangan',
            'title' => 'Perbaikan drainase',
            'location' => 'Dusun Pesisir',
            'category' => '',
            'description' => 'Saluran perlu diperbaiki.',
            'name' => '',
            'contact' => '',
            'status' => 'Masuk',
            'admin_note' => '',
            'created_at' => now()->toIso8601String(),
        ]);

        $this->actingAsAdmin($admin)->putJson('/api/admin/proposals/'.$proposalId, [
            'status' => 'Selesai',
            'adminNote' => 'Sudah dikerjakan',
        ])->assertNotFound();

        $this->assertDatabaseHas('proposals', [
            'id' => $proposalId,
            'village_slug' => 'pajurangan',
            'status' => 'Masuk',
        ]);
    }

    private function createVillageAdmin(string $villageSlug): User
    {
        $this->createVillagePage($villageSlug);

        return User::factory()->create([
            'name' => 'Admin Desa',
            'email' => $villageSlug.'@example.test',
            'username' => 'admin.'.$villageSlug,
            'village_slug' => $villageSlug,
            'is_admin' => true,
            'admin_role' => 'owner',
            'is_active' => true,
        ]);
    }

    private function createVillagePage(string $villageSlug): void
    {
        DB::table('village_pages')->insertOrIgnore([
            'slug' => $villageSlug,
            'name' => ucfirst($villageSlug),
            'body' => '{}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function actingAsAdmin(User $admin): static
    {
        return $this->actingAs($admin)->withSameOriginHeaders();
    }

    private function withSameOriginHeaders(): static
    {
        $applicationUrl = parse_url((string) config('app.url'));
        $scheme = $applicationUrl['scheme'] ?? 'http';
        $host = $applicationUrl['host'] ?? 'localhost';
        $port = $applicationUrl['port'] ?? null;
        $origin = $scheme.'://'.$host.($port ? ':'.$port : '');

        return $this->withServerVariables([
            'HTTP_HOST' => $host.($port ? ':'.$port : ''),
            'SERVER_PORT' => $port ?? ($scheme === 'https' ? 443 : 80),
            'HTTPS' => $scheme === 'https' ? 'on' : 'off',
        ])->withHeader('Origin', $origin);
    }
}
