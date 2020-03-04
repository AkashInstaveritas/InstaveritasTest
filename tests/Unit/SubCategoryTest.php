<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\SubCategory;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubCategoryTest extends TestCase
{
    use DatabaseTransactions;

    private $subCategory;

    public function setUp() :void
    {
        parent::setUp();

        $this->subCategory = SubCategory::findorFail(1);

    }

    /**
     * Test for getting a subCategory.
     *
     * @return void
     */
    public function test_to_get_a_single_subCategory()
    {
        $response = $this->json('GET', '/api/subcategory/'.$this->subCategory->id)->assertStatus(200);

        $response = $response->json();

        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('products', $response['data']);
        $this->assertArrayHasKey('brands', $response['data']);
        $this->assertArrayHasKey('filters', $response['data']);
        $this->assertEquals($response['data']['name'], $this->subCategory->name);

    }


}
