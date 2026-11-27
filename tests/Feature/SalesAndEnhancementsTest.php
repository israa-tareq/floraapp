<?php

namespace Tests\Feature;

use App\Models\Flower;
use App\Models\PreMadeBouquet;
use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesAndEnhancementsTest extends TestCase
{
    use RefreshDatabase;

    private array $adminSession = [
        'admin_authenticated' => true,
        'admin_username' => 'admin_test',
    ];

    public function test_login_page_shows_larger_logo_glass_card_and_auth_placeholders(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertStatus(200);
        $response->assertSee('h-24 sm:h-28', false);
        $response->assertSee('flora-login-card', false);
        $response->assertSee("I'm not a robot", false);
        $response->assertSee('Continue with Google', false);
        $response->assertSee("Don't have an account?", false);
        $response->assertSee('Sign up', false);
    }

    public function test_admin_pages_have_single_header_title_single_logout_and_main_background(): void
    {
        $pages = [
            route('admin.dashboard') => 'Dashboard',
            route('admin.sales.index') => 'Sales',
            route('admin.flowers.index') => 'Flowers',
            route('admin.bouquets.index') => 'Pre-Made Bouquets',
            route('admin.packaging.index') => 'Packaging Options',
        ];

        foreach ($pages as $url => $title) {
            $response = $this->withSession($this->adminSession)->get($url);
            $response->assertStatus(200);

            $html = $response->getContent();

            // Exactly one <h1> (in the header)
            $this->assertSame(1, substr_count($html, '<h1 '), "Expected exactly one <h1> on {$url}");
            $response->assertSee($title);

            // Collapsible sidebar toggle, main content background, and toast container
            $response->assertSee('id="sidebarToggleBtn"', false);
            $response->assertSee('flora-main-bg-wrapper', false);
            $response->assertSee('id="flora-toast-container"', false);

            // Single logout form (only in header, removed from sidebar)
            $this->assertSame(1, substr_count($html, route('admin.logout')), "Expected exactly one logout form on {$url}");
        }
    }

    public function test_recording_sales_updates_inventory_and_computes_real_analytics(): void
    {
        $rose = Flower::create([
            'name' => 'Crimson Rose',
            'color' => 'Red',
            'price_per_stem' => 4.00,
            'stock_quantity' => 30,
            'is_available' => true,
        ]);

        $lily = Flower::create([
            'name' => 'White Lily',
            'color' => 'White',
            'price_per_stem' => 5.00,
            'stock_quantity' => 20,
            'is_available' => true,
        ]);

        $bouquet = PreMadeBouquet::create([
            'name' => 'Botanical Harmony',
            'description' => 'Seasonal bouquet',
            'price' => 40.00,
            'stock_quantity' => 10,
            'is_featured' => true,
        ]);

        // Completed sale: 5 Crimson Roses ($20) + 2 Botanical Harmony ($80) = $100
        $storeResponse = $this->withSession($this->adminSession)
            ->post(route('admin.sales.store'), [
                'customer_name' => 'Layla',
                'status' => 'completed',
                'sold_at' => now()->format('Y-m-d\TH:i'),
                'items' => [
                    ['product' => 'flower:' . $rose->id, 'quantity' => 5],
                    ['product' => 'bouquet:' . $bouquet->id, 'quantity' => 2],
                ],
            ]);

        $storeResponse->assertRedirect(route('admin.sales.index'));
        $storeResponse->assertSessionHas('success', 'Sale recorded successfully!');

        // Pending sale (must NOT count toward completed revenue/best-sellers, but DOES reserve stock)
        $this->withSession($this->adminSession)
            ->post(route('admin.sales.store'), [
                'customer_name' => 'Pending Order',
                'status' => 'pending',
                'sold_at' => now()->format('Y-m-d\TH:i'),
                'items' => [
                    ['product' => 'flower:' . $lily->id, 'quantity' => 3],
                ],
            ])->assertRedirect(route('admin.sales.index'));

        // Verify inventory quantities are distinct and accurately decremented
        $this->assertSame(25, $rose->fresh()->stock_quantity);
        $this->assertSame(17, $lily->fresh()->stock_quantity);
        $this->assertSame(8, $bouquet->fresh()->stock_quantity);

        // Verify sales & dashboard show real computed figures ($100.00, 1 completed sale, 7 units sold)
        $salesPage = $this->withSession($this->adminSession)->get(route('admin.sales.index'));
        $salesPage->assertStatus(200);
        $salesPage->assertSee('$100.00');
        $salesPage->assertSee('Crimson Rose');
        $salesPage->assertSee('Botanical Harmony');
        $salesPage->assertSee('Layla');

        $dashboard = $this->withSession($this->adminSession)->get(route('admin.dashboard'));
        $dashboard->assertStatus(200);
        $dashboard->assertSee('$100.00');
        $dashboard->assertSee('Crimson Rose');
        $dashboard->assertSee('Botanical Harmony');

        // Reject overselling beyond stock_quantity
        $oversell = $this->withSession($this->adminSession)
            ->from(route('admin.sales.create'))
            ->post(route('admin.sales.store'), [
                'status' => 'completed',
                'sold_at' => now()->format('Y-m-d\TH:i'),
                'items' => [
                    ['product' => 'bouquet:' . $bouquet->id, 'quantity' => 99],
                ],
            ]);

        $oversell->assertRedirect(route('admin.sales.create'));
        $oversell->assertSessionHasErrors('items');
        $this->assertSame(8, $bouquet->fresh()->stock_quantity);

        // Cancelling the completed sale restores stock and removes it from completed revenue
        $completedSale = Sale::where('customer_name', 'Layla')->firstOrFail();

        $this->withSession($this->adminSession)
            ->patch(route('admin.sales.status', $completedSale), [
                'status' => 'cancelled',
            ])->assertSessionHas('success', 'Sale status updated successfully!');

        $this->assertSame(30, $rose->fresh()->stock_quantity);
        $this->assertSame(10, $bouquet->fresh()->stock_quantity);

        $afterCancel = $this->withSession($this->adminSession)->get(route('admin.sales.index'));
        $afterCancel->assertSee('$0.00');

        // Deleting pending sale restores its stock
        $pendingSale = Sale::where('customer_name', 'Pending Order')->firstOrFail();
        $this->withSession($this->adminSession)
            ->delete(route('admin.sales.destroy', $pendingSale))
            ->assertRedirect(route('admin.sales.index'));

        $this->assertSame(20, $lily->fresh()->stock_quantity);
    }
}
