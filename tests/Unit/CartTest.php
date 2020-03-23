<?php

namespace Tests\Unit;

use App\Models\Product;
use Tests\TestCase;
use App\User;

class CartTest extends TestCase
{
    private $user;
    private $product;


    public function setUp() :void
    {
        parent::setUp();

        $this->user = User::findorFail(1);
        $this->actingAs($this->user, 'api');

        $this->product = Product::findorFail(1);

    }

    /**
     * A test for adding product to cart of authenticated user.
     *
     * @return void
     */
    public function test_add_a_product_to_user_cart()
    {
        $data = [
            'product_id' => 1,
            'quantity'   => 1,
        ];

        $response = $this->json('POST', '/api/cart/products', $data)->assertStatus(200);

        $response = $response->json();

        $this->assertEquals($response['message'], "Product added to Cart.");
    }

    /**
     * A test to get cart of authenticated user.
     *
     * @return void
     */
    public function test_get_products_in_user_cart()
    {
        $response = $this->json('GET', '/api/cart')->assertStatus(200);

        $response = $response->json();
        $totalproducts = $this->user->cart()->count();
        $first = $this->user->cart()->first();

        $this->assertArrayHasKey('data', $response);
        $this->assertEquals($totalproducts, count($response['data']));
        $this->assertEquals($response['data'][0]['id'], $first->id);
        $this->assertEquals($response['data'][0]['name'], $first->name);
        $this->assertEquals($response['data'][0]['image'], $first->image);
        $this->assertEquals($response['data'][0]['price'], $first->price);
        $this->assertEquals($response['data'][0]['quantity'], $first->pivot->quantity);
        $this->assertEquals($response['data'][0]['total'], $first->price * $first->pivot->quantity);
    }

    /**
     * A test for adding product to cart of authenticated user.
     *
     * @return void
     */
    public function test_update_a_product_quantity_to_user_cart()
    {
        $data = [
            'quantity'   => 3,
        ];

        $response = $this->patchJson('/api/cart/product/'.$this->product->id, $data)->assertStatus(200);

        $response = $response->json();

        $this->assertEquals($response['message'], "Selected product quantity updated in cart.");
    }

    /**
     * A test for removing product from wishlist of authenticated user.
     *
     * @return void
     */
    public function test_remove_product_from_user_cart()
    {

        $response = $this->deleteJson('/api/cart/product/'. $this->product->id)->assertStatus(200);

        $response = $response->json();

        $this->assertEquals($response['message'], "Selected product removed from cart.");
    }
}
