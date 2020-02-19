<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\SubCategory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(SubCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
    ];
});
