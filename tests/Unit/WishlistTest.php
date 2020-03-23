<?php

namespace Tests\Unit;

use App\Models\Product;
use Tests\TestCase;
use App\User;

class WishlistTest extends TestCase
{
    private $user;

    public function setUp() :void
    {
        parent::setUp();

        $this->user = User::findorFail(1);
        $this->actingAs($this->user, 'api');

    }

    /**
     * A test for adding product to wishlist of authenticated user.
     *
     * @return void
     */
    public function test_add_a_product_to_user_wishlist()
    {
        $data = [
            'product_id' => 1,
        ];

        $response = $this->json('POST', '/api/wishlist/products', $data)->assertStatus(200);

        $response = $response->json();

        $this->assertEquals($response['message'], "Product added to wishlist.");
    }

    /**
     * A test to get wishlist of authenticated user.
     *
     * @return void
     */
    public function test_get_products_in_user_wishlist()
    {
        $response = $this->json('GET', '/api/wishlist')->assertStatus(200);

        $response = $response->json();
        $totalproducts = $this->user->wishlist()->count();
        $first = $this->user->wishlist()->first();

        $this->assertArrayHasKey('data', $response);
        $this->assertEquals($totalproducts, count($response['data']));
        $this->assertEquals($response['data'][0]['id'], $first->id);
        $this->assertEquals($response['data'][0]['name'], $first->name);
        $this->assertEquals($response['data'][0]['image'], $first->image);
        $this->assertEquals($response['data'][0]['price'], $first->price);
    }

    /**
     * A test for removing product from wishlist of authenticated user.
     *
     * @return void
     */
    public function test_remove_product_from_user_wishlist()
    {

        $product = Product::findorFail(1);

        $response = $this->deleteJson('/api/wishlist/product/'. $product->id)->assertStatus(200);

        $response = $response->json();

        $this->assertEquals($response['message'], "Selected product removed from wishlist.");
    }
}
