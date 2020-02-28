<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;

class CategoryTest extends TestCase
{
    /**
     * Test for getting collection of all categories.
     *
     * @return void
     */
    public function test_to_get_all_categories()
    {
        $this->getJson('api/categories')
                    ->assertStatus(200)
                    ->assertJsonStructure([
                        'data' => [
                            [
                                'id',
                                'name',
                            ]   
                        ]
                    ]);
    }

    /**
     * Test for getting data about a single category and collection associated with it.
     *
     * @return void
     */
    public function test_to_get_a_category()
    {
        $category = Category::findorFail(1);

        $this->getJson('api/category/'. $category->id)
                    ->assertStatus(200)
                    ->assertJsonStructure([
                        'data' => [
                            [
                                'id',
                                'name',
                            ]   
                        ]
                    ]);
    }
}
