<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Filter;

class FilterOption extends Model
{
    protected $fillable = [
        'name',        //varchar(191) unique
        'filter_id'    //integer(Foreign ket for filters id)
    ];

    public function products()
    {
    	return $this->belongsToMany(Product::class);
    }

    public function filter()
    {
        return $this->belongsTo(Filter::class);
    }

}
