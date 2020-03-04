<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;

    private $category;
    private $categories;

    public function setUp() :void
    {
        parent::setUp();

        $this->category = Category::findorFail(1);
        $this->categories = Category::all();

    }

    /**
     * Test for getting all categories.
     *
     */
    public function test_get_all_categories()
    {

        $response = $this->getJson('api/categories')->assertStatus(200);

        $response = $response->json();

        $this->assertArrayHasKey('data', $response);
        $this->assertEquals($this->categories->count(), count($response));
    }


    /**
     * Test for getting data about a single category and collection associated with it.
     *
     */
    public function test_to_get_a_single_category()
    {
        $response = $this->getJson('api/category/'. $this->category->id)->assertStatus(200);

        $response = $response->json();

        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('subCategories', $response['data']);
        $this->assertEquals($response['data']['name'], $this->category->name);
    }

    /**
     * Test for creating categories with factory.
     *
     */
    public function test_to_create_categories()
    {
        $response = factory(Category::class)->create();

        $this->assertNotEmpty($response->name);
        $this->assertEquals(4, $response->count());

    }


}
