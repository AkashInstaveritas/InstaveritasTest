<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductTest extends TestCase
{
    /**
     * Test for getting a product.
     *
     * @return void
     */
    public function test_get_a_product()
    {
        $product = Product::findorFail(1);

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
                        'reviews' => [
                            [
                                'id',
                                'user',
                                'rating',
                                'description'
                            ]
                        ],
                        'filterOptions' => [
                            [
                                'id',
                                'name',
                                'filter'
                            ]
                        ]
                    ]
        ]);
    }


    /**
     * Test for getting a product.
     *
     * @return void
     */
    public function test_for_a_product_not_found()
    {
        $this->expectException(ModelNotFoundException::class);

        $product = Product::findorFail(20000);

    }


}
