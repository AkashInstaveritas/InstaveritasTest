<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\SubCategory;

class Brand extends Model
{
    protected $fillable = ['name'];

    public function products()
    {
    	return $this->hasMany(Product::class, 'brand_id');
    }

    public function subcategories()
    {
    	return $this->belongsToMany(SubCategory::class);
    }
}
