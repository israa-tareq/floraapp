<?php

namespace Tests\Feature;

use App\Models\Flower;
use App\Models\PackagingOption;
use App\Models\PreMadeBouquet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminRedesignTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'admin.username' => 'admin_test',
            'admin.password' => 'secret123',
            'admin.password_hash' => null,
        ]);
    }

    public function test_login_page_loads_without_intro_or_unsolicited_error_messages(): void
    {
        $response = $this->followingRedirects()->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('Please enter your administrator credentials to continue.');
        $response->assertDontSee('Please log in to access the administration dashboard.');
        $response->assertSee('flora-theme.css');
        $response->assertSee('Lora');
        $response->assertSee('flora-login-bg-wrapper');
    }

    public function test_empty_login_submission_shows_validation_errors_and_clears_on_refresh(): void
    {
        $response = $this->from(route('admin.login'))
            ->followingRedirects()
            ->post(route('admin.login.submit'), [
                'username' => '',
                'password' => '',
            ]);

        $response->assertStatus(200);
        $response->assertSee('The username field is required.');
        $response->assertSee('The password field is required.');

        // Refresh login page: old validation errors must not reappear
        $refreshed = $this->get(route('admin.login'));
        $refreshed->assertStatus(200);
        $refreshed->assertDontSee('The username field is required.');
        $refreshed->assertDontSee('The password field is required.');
    }

    public function test_invalid_credentials_show_error_and_clear_on_refresh(): void
    {
        $response = $this->from(route('admin.login'))
            ->followingRedirects()
            ->post(route('admin.login.submit'), [
                'username' => 'wrong_user',
                'password' => 'wrong_pass',
            ]);

        $response->assertStatus(200);
        $response->assertSee('The provided credentials do not match our records.');

        $refreshed = $this->get(route('admin.login'));
        $refreshed->assertStatus(200);
        $refreshed->assertDontSee('The provided credentials do not match our records.');
    }

    public function test_valid_login_and_logout_flow_without_welcome_back_message(): void
    {
        $loginResponse = $this->post(route('admin.login.submit'), [
            'username' => 'admin_test',
            'password' => 'secret123',
        ]);

        $loginResponse->assertRedirect(route('admin.dashboard'));
        $loginResponse->assertSessionHas('admin_authenticated', true);
        $loginResponse->assertSessionMissing('success');

        $dashboard = $this->get(route('admin.dashboard'));
        $dashboard->assertStatus(200);
        $dashboard->assertSee('Dashboard');
        $dashboard->assertDontSee('Welcome Back');
        $dashboard->assertDontSee('Welcome back');
        $dashboard->assertDontSee("Here's what's happening");
        $dashboard->assertDontSee('Welcome to Flora administration');

        $logoutResponse = $this->post(route('admin.logout'));
        $logoutResponse->assertRedirect(route('admin.login'));
        $logoutResponse->assertSessionMissing('admin_authenticated');
    }

    public function test_admin_modules_render_clean_titles_and_crud_with_image_uploads_work(): void
    {
        Storage::fake('public');

        $session = [
            'admin_authenticated' => true,
            'admin_username' => 'admin_test',
        ];

        // Pages render cleanly
        $this->withSession($session)->get(route('admin.flowers.index'))
            ->assertStatus(200)
            ->assertSee('Flowers')
            ->assertDontSee('Manage your individual flower');

        $this->withSession($session)->get(route('admin.bouquets.index'))
            ->assertStatus(200)
            ->assertSee('Pre-Made Bouquets')
            ->assertDontSee('Manage your arranged');

        $this->withSession($session)->get(route('admin.packaging.index'))
            ->assertStatus(200)
            ->assertSee('Packaging Options')
            ->assertDontSee('Manage wrapping paper');

        // Flower CRUD + Image upload
        $flowerImg = UploadedFile::fake()->image('rose.jpg');
        $this->withSession($session)->post(route('admin.flowers.store'), [
            'name' => 'Garden Rose',
            'color' => 'Blush',
            'price_per_stem' => 4.50,
            'stock_quantity' => 25,
            'is_available' => '1',
            'image' => $flowerImg,
        ])->assertRedirect(route('admin.flowers.index'));

        $flower = Flower::firstOrFail();
        $this->assertNotNull($flower->image_path);
        Storage::disk('public')->assertExists($flower->image_path);

        $this->withSession($session)->get(route('admin.flowers.edit', $flower))
            ->assertStatus(200)
            ->assertSee('Edit Flower: Garden Rose');

        $this->withSession($session)->put(route('admin.flowers.update', $flower), [
            'name' => 'Garden Rose Updated',
            'color' => 'Cream',
            'price_per_stem' => 5.00,
            'stock_quantity' => 5,
            'is_available' => '1',
        ])->assertRedirect(route('admin.flowers.index'));

        $this->assertDatabaseHas('flowers', ['id' => $flower->id, 'name' => 'Garden Rose Updated']);

        // Bouquet CRUD + Image upload
        $bouquetImg = UploadedFile::fake()->image('bouquet.png');
        $this->withSession($session)->post(route('admin.bouquets.store'), [
            'name' => 'Meadow Mist',
            'description' => 'Soft botanical bouquet',
            'price' => 45.00,
            'stock_quantity' => 8,
            'is_featured' => '1',
            'image' => $bouquetImg,
        ])->assertRedirect(route('admin.bouquets.index'));

        $bouquet = PreMadeBouquet::firstOrFail();
        Storage::disk('public')->assertExists($bouquet->image_path);

        // Packaging CRUD + Image upload
        $packImg = UploadedFile::fake()->image('ribbon.webp');
        $this->withSession($session)->post(route('admin.packaging.store'), [
            'type' => 'ribbon',
            'name' => 'Silk Ribbon',
            'color' => 'Sage',
            'price' => 3.00,
            'stock_quantity' => 12,
            'image' => $packImg,
        ])->assertRedirect(route('admin.packaging.index'));

        $packaging = PackagingOption::firstOrFail();
        Storage::disk('public')->assertExists($packaging->image_path);

        // Dashboard reflects low-stock items (flower=5, bouquet=8)
        $this->withSession($session)->get(route('admin.dashboard'))
            ->assertStatus(200)
            ->assertSee('Garden Rose Updated')
            ->assertSee('Meadow Mist');

        // Delete records
        $this->withSession($session)->delete(route('admin.flowers.destroy', $flower))
            ->assertRedirect(route('admin.flowers.index'));
        $this->withSession($session)->delete(route('admin.bouquets.destroy', $bouquet))
            ->assertRedirect(route('admin.bouquets.index'));
        $this->withSession($session)->delete(route('admin.packaging.destroy', $packaging))
            ->assertRedirect(route('admin.packaging.index'));

        $this->assertDatabaseCount('flowers', 0);
        $this->assertDatabaseCount('pre_made_bouquets', 0);
        $this->assertDatabaseCount('packaging_options', 0);
    }
}
