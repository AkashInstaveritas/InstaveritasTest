<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    private $product;

    public function setUp() :void
    {
        parent::setUp();

        $this->product = Product::findorFail(1);

    }

    /**
     * Test for getting a product.
     *
     * @return void
     */
    public function test_to_get_a_single_product()
    {

        $response = $this->json('GET', '/api/product/'.$this->product->id)->assertStatus(200);

        $response = $response->json();

        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('reviews', $response['data']);
        $this->assertArrayHasKey('filterOptions', $response['data']);
        $this->assertEquals($response['data']['name'], $this->product->name);
        $this->assertEquals($response['data']['image'], $this->product->image);
        $this->assertEquals($response['data']['price'], $this->product->price);
        $this->assertEquals($response['data']['detail'], $this->product->detail);
        $this->assertEquals($response['data']['description'], $this->product->description);
        $this->assertEquals($response['data']['rating'], $this->product->averageRating());
        $this->assertEquals($response['data']['brand'], $this->product->brand->name);
        $this->assertEquals($response['data']['quantity'], $this->product->stock());

    }
}
