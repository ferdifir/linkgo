<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminPageNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_sees_login_and_not_admin_dashboard(): void
    {
        $response = $this->get('/admin/projects');

        $response->assertOk();
        $this->assertSectionIsVisible($response->getContent(), 'login');
        $this->assertSectionIsHidden($response->getContent(), 'dashboard');
    }

    public function test_authenticated_admin_receives_requested_menu_without_login_markup(): void
    {
        $admin = $this->createVillageAdmin();

        $response = $this->actingAs($admin)->get('/admin/projects');

        $response->assertOk()
            ->assertSee('<body class="dashboard-page" data-admin-page="projects">', false)
            ->assertSee('id="dashboard" class="dashboard-layout"', false)
            ->assertSee('Curahsawo', false);
        $this->assertSectionIsHidden($response->getContent(), 'login');
        $this->assertSectionIsVisible($response->getContent(), 'dashboard');
        $this->assertSectionIsVisible($response->getContent(), 'project-management');
        $this->assertMatchesRegularExpression('/data-admin-link="projects"[^>]*aria-current="page"/', $response->getContent());
    }

    public function test_authenticated_admin_receives_only_the_requested_menu_visible(): void
    {
        $admin = $this->createVillageAdmin();
        $pages = [
            'dashboard' => 'dashboard-overview',
            'projects' => 'project-management',
            'budgets' => 'budget-management',
            'proposals' => 'proposal-management',
            'requests' => 'request-management',
            'content' => 'content-management',
            'media' => 'media-management',
            'analytics' => 'analytics-management',
            'users' => 'user-management',
        ];

        foreach ($pages as $page => $activeSection) {
            $response = $this->actingAs($admin)->get('/admin/'.$page);

            $response->assertOk();
            $this->assertSectionIsVisible($response->getContent(), $activeSection);

            foreach ($pages as $otherPage => $otherSection) {
                if ($otherSection !== $activeSection) {
                    $this->assertSectionIsHidden($response->getContent(), $otherSection);
                }
            }
        }
    }

    public function test_editor_is_redirected_from_account_management_to_dashboard(): void
    {
        $admin = $this->createVillageAdmin(['admin_role' => 'editor']);

        $response = $this->actingAs($admin)->get('/admin/users')
            ->assertRedirect('/admin/dashboard');
    }

    public function test_inactive_admin_session_shows_login_instead_of_dashboard(): void
    {
        $admin = $this->createVillageAdmin(['is_active' => false]);

        $response = $this->actingAs($admin)->get('/admin/projects');

        $response->assertOk();

        $this->assertSectionIsVisible($response->getContent(), 'login');
        $this->assertSectionIsHidden($response->getContent(), 'dashboard');
    }

    public function test_admin_village_scope_comes_from_authenticated_user(): void
    {
        $admin = $this->createVillageAdmin();

        $response = $this->actingAs($admin)
            ->withSession(['admin_village_slug' => 'another-village'])
            ->get('/admin/projects');

        $response->assertOk();
        $this->assertSectionIsHidden($response->getContent(), 'login');
        $this->assertSectionIsVisible($response->getContent(), 'dashboard');
        $this->assertStringContainsString('Curahsawo', $response->getContent());
    }

    public function test_unknown_admin_menu_returns_not_found(): void
    {
        $this->get('/admin/not-a-menu')->assertNotFound();
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function createVillageAdmin(array $attributes = []): User
    {
        DB::table('village_pages')->insertOrIgnore([
            'slug' => 'curahsawo',
            'name' => 'Curahsawo',
            'body' => '{}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return User::factory()->create(array_merge([
            'name' => 'Admin Curahsawo',
            'email' => 'admin@curahsawo.test',
            'username' => 'admin.curahsawo',
            'village_slug' => 'curahsawo',
            'is_admin' => true,
            'is_active' => true,
            'admin_role' => 'owner',
        ], $attributes));
    }

    private function assertSectionIsVisible(string $html, string $id): void
    {
        $pattern = '/<section[^>]*id="'.preg_quote($id, '/').'"[^>]*>/';
        $this->assertMatchesRegularExpression($pattern, $html);
        preg_match($pattern, $html, $matches);
        $this->assertDoesNotMatchRegularExpression('/\shidden(?:\s|>)/', $matches[0]);
    }

    private function assertSectionIsHidden(string $html, string $id): void
    {
        $pattern = '/<section[^>]*id="'.preg_quote($id, '/').'"[^>]*>/';
        $this->assertMatchesRegularExpression($pattern, $html);
        preg_match($pattern, $html, $matches);
        $this->assertMatchesRegularExpression('/\shidden(?:\s|>)/', $matches[0]);
    }
}
