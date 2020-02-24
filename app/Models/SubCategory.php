<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Brand;
use App\Models\Filter;
use App\Models\Category;

class SubCategory extends Model
{
    protected $fillable = [
        'name',         //varchar(191)
        'category_id'   //integer(Foreign key for categories id)
    ];

    public function products()
    {
    	return $this->belongsToMany(Product::class);
    }

    public function brands()
    {
    	return $this->belongsToMany(Brand::class);
    }

    public function filters()
    {
    	return $this->belongsToMany(Filter::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
