<?php

namespace Tests\Feature;

use App\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WishlistTest extends TestCase
{
    use DatabaseTransactions;
    
    private $user;

    public function setUp() :void 
    {
        parent::setUp();

        $this->user = User::findorFail(1);

        $this->actingAs($this->user, 'api');

    }

    /**
     * A test to get wishlist of authenticated user.
     *
     * @return void
     */
    public function test_wishlist_of_user()
    {
        $response = $this->actingAs($this->user, 'api')
                         ->json('GET', '/api/wishlist');
                    

        $response->assertStatus(200);
        $response->assertJsonStructure([
                'data' => [
                   [
                    'id',
                    'name',
                    'image',
                    'price',
                   ] 
                ]
        ]);
    }

    /**
     * A test for adding product to wishlist of authenticated user.
     *
     * @return void
     */
    public function test_add_product_to_wishlist()
    {
        $data = [
            'product_id' => 9,
        ];

        $response = $this->actingAs($this->user, 'api')
                         ->json('POST', '/api/wishlist/products', $data);
                    

        $response->assertStatus(200);
        $response->assertJson(['message' => "Product added to wishlist."]);
    }


    /**
     * A test for removing product from wishlist of authenticated user.
     *
     * @return void
     */
    public function test_remove_product_from_wishlist()
    {

        $product = Product::findorFail(9);

        $response = $this->actingAs($this->user, 'api')
                         ->deleteJson('/api/wishlist/product/'. $product->id);
                    

        $response->assertStatus(200);
        $response->assertJson(['message' => "Selected product removed from wishlist."]);
    }


    /**
     * Test for validation error for when adding product to wishlist.
     *
     * @return void
     */
    public function test_validation_for_adding_product_to_wishlist()
    {

        $data = [
            'product_id' => "Product", //Use incorrect data for testing
        ];

        $response = $this->actingAs($this->user, 'api')
                         ->json('POST', '/api/wishlist/products', $data);
                    

        $response->assertStatus(422);
        $response->assertJson(['message' => "The given data was invalid."]);
        $response->assertJsonStructure([
                'message',
                'errors' =>  [
                    'product_id'
                ]
            ]);
    }
}
