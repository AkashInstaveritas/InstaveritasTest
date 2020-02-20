<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FilterOption;
use App\Models\SubCategory;

class Filter extends Model
{
    protected $fillable = ['name'];

    public function filteroptions()
    {
    	return $this->hasMany(FilterOption::class);
    }

    public function subcategories()
    {
    	return $this->belongsToMany(SubCategory::class);
    }
}
