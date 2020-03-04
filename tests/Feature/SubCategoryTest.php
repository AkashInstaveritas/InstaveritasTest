<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\SubCategory;

class SubCategoryTest extends TestCase
{
    private $subcategory;

    public function setUp() :void
    {
        parent::setUp();

        $this->subcategory = SubCategory::findorFail(1);

    }

    /**
     * Test for gettting the details about a subcategory and all collections associated with it.
     *
     * @return void
     */
    public function test_to_get_a_subcategory()
    {
        $response = $this->json('GET', '/api/subcategory/'.$this->subcategory->id);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    'data' => [
                        'id',
                        'name',
                        'products' => [
                            [
                                'id',
                                'name',
                                'image',
                                'price'
                            ]
                        ],
                        'brands' => [
                            [
                                'id',
                                'name',
                            ]
                        ],
                        'filters' => [
                            [
                                'id',
                                'name',
                                'filterOptions' => [
                                    [
                                        'id',
                                        'name',
                                    ]
                                ],
                            ]
                        ],
                    ]
                ]);
    }
}
