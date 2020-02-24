<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FilterOption;
use App\Models\Review;
use App\Models\Brand;
use App\Models\SubCategory;
use App\Models\Cart;

class Product extends Model
{
    protected $fillable = [
        'name',             //varchar(191) Unique
        'detail',           //varchar(191) 
        'description',      //Text
        'image',            //varchar
        'extra_images',     //Json(nullable)
        'quantity',         //TinyInteger
        'brand_id',         //Integer(Foriegn key for brands id)
        'featured'          //Boolean(default 0)
    ];

    public function subcategories()
    {
    	return $this->belongsToMany(SubCategory::class);
    }

    public function filteroptions()
    {
    	return $this->belongsToMany(FilterOption::class);
    }

    public function reviews()
    {
    	return $this->hasMany(Review::class);
    }

    public function brand()
    {
    	return $this->belongsTo(Brand::class);
    }

    public function averageRating()
    {
        $count = $this->reviews()->count();

        if(empty($count))
        {
            return 0;
        }

        $starCountSum = $this->reviews()->sum('rating');
        $average = $starCountSum/$this->reviews()->count();

        $average = round($average, 1);

        return $average;
    }

    public function stock()
    {
        if($this->quantity <= 5)
        {
            return "Low Stock";
        }

        return "In Stock";

    }
}
