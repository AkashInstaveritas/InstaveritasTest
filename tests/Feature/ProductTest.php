<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Response;

class ProductTest extends TestCase
{
    /**
     * A basic feature test for getting a product.
     *
     * @return void
     */
    public function test_get_a_product()
    {
        $product = Product::findorFail(9);

        $response = $this->json('GET', '/api/product/'.$product->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
                    'data' => [
                        'id',
                        'name',
                        'image',
                        'price',
                        'detail',
                        'description',
                        'extra_image',
                        'rating',
                        'brand',
                        'quantity',
                        'reviews',
                        'filterOptions'
                    ]
        ]);
    }


}
