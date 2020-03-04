<?php

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Filter;
use App\Models\FilterOption;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
             $this->call([
            CategoriesTableSeeder::class,
            BrandsTableSeeder::class,
            FiltersTableSeeder::class,
            SubCategoriesRelationsTableSeeder::class,
            ProductsRelationsTableSeeder::class,
            UsersTableSeeder::class,
            ProductReviewSeeder::class,
        ]);

    }
}
