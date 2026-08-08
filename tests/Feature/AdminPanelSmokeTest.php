<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminPanelSmokeTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsSuperAdmin(): User
    {
        $user = User::factory()->create(['role' => User::ROLE_SUPERADMIN]);
        $this->actingAs($user);

        return $user;
    }

    public function test_login_page_renders(): void
    {
        $this->get('http://admin.desapuraseda.test/login')->assertStatus(200);
    }

    public function test_dashboard_renders_for_superadmin(): void
    {
        $this->actingAsSuperAdmin();

        $this->get('http://admin.desapuraseda.test/')->assertStatus(200);
    }

    #[DataProvider('resourceIndexRoutes')]
    public function test_resource_index_pages_render(string $path): void
    {
        $this->actingAsSuperAdmin();

        $this->get("http://admin.desapuraseda.test/{$path}")->assertStatus(200);
    }

    public static function resourceIndexRoutes(): array
    {
        return [
            ['articles'],
            ['categories'],
            ['destinations'],
            ['economic-potentials'],
            ['missions'],
            ['officials'],
            ['hamlets'],
            ['contact-messages'],
            ['users'],
            ['manage-village-profile'],
            ['manage-village-head-message'],
            ['manage-site-settings'],
        ];
    }

    public function test_seeded_content_renders_on_articles_page(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->actingAsSuperAdmin();

        $this->get('http://admin.desapuraseda.test/articles')
            ->assertStatus(200)
            ->assertSee('Musyawarah Desa Bahas Rencana Pembangu');
    }

    public function test_editor_cannot_access_destinations(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_EDITOR]);
        $this->actingAs($user);

        $this->get('http://admin.desapuraseda.test/destinations')->assertStatus(403);
    }
}
