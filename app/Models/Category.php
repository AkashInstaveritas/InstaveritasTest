<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SubCategory;

class Category extends Model
{
    protected $fillable = ['name'];


    public function subcategories()
    {
    	return $this->hasMany(SubCategory::class,'category_id');
    }
}
