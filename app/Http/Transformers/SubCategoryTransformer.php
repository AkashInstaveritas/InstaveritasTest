<?php

namespace App\Http\Transformers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Filter;
use App\Models\SubCategory;
use Illuminate\Support\Collection;
use App\Transformers\Transformer;
use Illuminate\Database\Eloquent\Model;

class SubCategoryTransformer extends Transformer
{
	
	public function transform($subCategory)
	{
		return [
			'products' =>  $subCategory->products->transform(function($product) {
					            return [
					            	'id'   => $product->id,
					                'name' => $product->name,
					                'image' => $product->image,
					            ];
					        }),
			'brands'    => $subCategory->brands->transform(function($brand) {
					            return [
					            	'id'   => $brand->id,
					                'name' => $brand->name,
					            ];
					        }),
			'filters'    => $subCategory->filters->transform(function($filter) {
					            return [
					            	'id'   => $filter->id,
					                'name' => $filter->name,
					            ];
					        }),
            
        ];
	}

}