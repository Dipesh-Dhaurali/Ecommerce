<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Inventory;
use App\Models\Order;

class EcommerceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed the standard database before running tests
        $this->seed();
    }

    /** @test */
    public function storefront_homepage_loads_successfully()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('e-mart');
    }

    /** @test */
    public function storefront_shop_page_loads_successfully()
    {
        $response = $this->get('/shop');
        $response->assertStatus(200);
        $response->assertSee('Shop All Products');
    }

    /** @test */
    public function guest_cannot_checkout_directly()
    {
        $response = $this->get('/checkout');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_customer_can_place_an_order_which_decrements_stock()
    {
        $customer = User::where('role', 'customer')->first();
        $product = Inventory::first();
        $initialStock = $product->stock;
        
        $response = $this->actingAs($customer)
            ->post('/checkout', [
                'customer_name' => 'John Doe',
                'customer_phone' => '9801234567',
                'customer_address' => 'Kathmandu, Nepal',
                'payment_method' => 'cash',
                'items' => json_encode([
                    [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => 2
                    ]
                ])
            ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('success');
        
        // Verify stock is decremented
        $this->assertEquals($initialStock - 2, $product->fresh()->stock);

        // Verify order was stored
        $this->assertDatabaseHas('orders', [
            'customer_name' => 'John Doe',
            'order_type' => 'online',
            'total' => $product->price * 2
        ]);
    }

    /** @test */
    public function guest_cannot_access_admin_dashboard()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function admin_can_access_dashboard()
    {
        $admin = User::where('role', 'admin')->first();
        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    /** @test */
    public function admin_can_perform_category_crud()
    {
        $admin = User::where('role', 'admin')->first();
        
        // Create
        $response = $this->actingAs($admin)->post('/admin/categories', [
            'name' => 'New Test Category',
            'image' => 'https://picsum.photos/400/400'
        ]);
        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', ['name' => 'New Test Category']);

        $category = Category::where('name', 'New Test Category')->first();

        // Edit View
        $response = $this->actingAs($admin)->get("/admin/categories/{$category->id}/edit");
        $response->assertStatus(200);

        // Update
        $response = $this->actingAs($admin)->put("/admin/categories/{$category->id}", [
            'name' => 'Updated Test Category',
            'image' => 'https://picsum.photos/400/400'
        ]);
        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', ['name' => 'Updated Test Category']);

        // Delete
        $response = $this->actingAs($admin)->delete("/admin/categories/{$category->id}");
        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    /** @test */
    public function admin_can_perform_brand_crud()
    {
        $admin = User::where('role', 'admin')->first();
        
        // Create
        $response = $this->actingAs($admin)->post('/admin/brands', [
            'name' => 'New Test Brand',
        ]);
        $response->assertRedirect('/admin/brands');
        $this->assertDatabaseHas('brands', ['name' => 'New Test Brand']);

        $brand = Brand::where('name', 'New Test Brand')->first();

        // Edit View
        $response = $this->actingAs($admin)->get("/admin/brands/{$brand->id}/edit");
        $response->assertStatus(200);

        // Update
        $response = $this->actingAs($admin)->put("/admin/brands/{$brand->id}", [
            'name' => 'Updated Test Brand',
        ]);
        $response->assertRedirect('/admin/brands');
        $this->assertDatabaseHas('brands', ['name' => 'Updated Test Brand']);

        // Delete
        $response = $this->actingAs($admin)->delete("/admin/brands/{$brand->id}");
        $response->assertRedirect('/admin/brands');
        $this->assertDatabaseMissing('brands', ['id' => $brand->id]);
    }

    /** @test */
    public function admin_can_perform_product_crud()
    {
        $admin = User::where('role', 'admin')->first();
        $category = Category::first();
        $brand = Brand::first();

        // Create
        $response = $this->actingAs($admin)->post('/admin/products', [
            'name' => 'New Test Product',
            'price' => 250.50,
            'stock' => 15,
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'image' => 'https://picsum.photos/400/400'
        ]);
        $response->assertRedirect('/admin/products');
        $this->assertDatabaseHas('inventories', ['name' => 'New Test Product']);

        $product = Inventory::where('name', 'New Test Product')->first();

        // Edit View
        $response = $this->actingAs($admin)->get("/admin/products/{$product->id}/edit");
        $response->assertStatus(200);

        // Update
        $response = $this->actingAs($admin)->put("/admin/products/{$product->id}", [
            'name' => 'Updated Test Product',
            'price' => 300.00,
            'stock' => 10,
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'image' => 'https://picsum.photos/400/400'
        ]);
        $response->assertRedirect('/admin/products');
        $this->assertDatabaseHas('inventories', ['name' => 'Updated Test Product', 'price' => 300.00]);

        // Delete
        $response = $this->actingAs($admin)->delete("/admin/products/{$product->id}");
        $response->assertRedirect('/admin/products');
        $this->assertDatabaseMissing('inventories', ['id' => $product->id]);
    }

    /** @test */
    public function admin_can_checkout_via_pos()
    {
        $admin = User::where('role', 'admin')->first();
        $product = Inventory::first();
        $initialStock = $product->stock;

        $response = $this->actingAs($admin)
            ->postJson('/admin/pos/checkout', [
                'items' => [
                    [
                        'id' => $product->id,
                        'quantity' => 1
                    ]
                ],
                'payment_method' => 'card',
                'customer_name' => 'POS Customer',
                'customer_phone' => '9801234568'
            ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // Verify stock is decremented
        $this->assertEquals($initialStock - 1, $product->fresh()->stock);

        // Verify counter order was stored
        $this->assertDatabaseHas('orders', [
            'customer_name' => 'POS Customer',
            'order_type' => 'counter',
            'status' => 'delivered',
            'payment_status' => 'paid',
        ]);
    }

    /** @test */
    public function admin_can_access_reports_and_export_excel()
    {
        $admin = User::where('role', 'admin')->first();

        // Access reports page
        $response = $this->actingAs($admin)->get('/admin/reports');
        $response->assertStatus(200);
        $response->assertSee('Reports');

        // Export report
        $response = $this->actingAs($admin)->get('/admin/reports/export');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    /** @test */
    public function user_can_submit_review_and_admin_can_approve_it()
    {
        $customer = User::where('role', 'customer')->first();
        $admin = User::where('role', 'admin')->first();
        $product = Inventory::first();

        // Submit review
        $response = $this->actingAs($customer)->post("/products/{$product->id}/reviews", [
            'rating' => 5,
            'comment' => 'Excellent quality!'
        ]);
        $response->assertRedirect();
        
        $this->assertDatabaseHas('reviews', [
            'user_id' => $customer->id,
            'inventory_id' => $product->id,
            'rating' => 5,
            'comment' => 'Excellent quality!',
            'approved' => false
        ]);

        $review = \App\Models\Review::where('comment', 'Excellent quality!')->first();

        // Admin approve review
        $response = $this->actingAs($admin)->post("/admin/reviews/{$review->id}/approve");
        $response->assertRedirect();
        
        $this->assertTrue((bool)$review->fresh()->approved);
    }
}
