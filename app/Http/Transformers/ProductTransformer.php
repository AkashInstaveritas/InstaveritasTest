<?php

namespace App\Http\Transformers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Filter;
use App\Models\FilterOption;
use App\Models\SubCategory;
use Illuminate\Support\Collection;
use App\Transformers\Transformer;
use Illuminate\Database\Eloquent\Model;
use App\Http\Transformers\ReviewTransformer;
use App\Http\Transformers\FilterOptionTransformer;

class ProductTransformer extends Transformer
{
	public function callReview($id)
    {
		$instance = new ReviewTransformer();
		$instance->transform($id);

		return $instance;
    }
	
	public function transform($product)
	{
		return [
				'product' =>  [
					            	'id'    	  => $product->id,
					                'name'  	  => $product->name,
					                'image' 	  => $product->image,
					                'detail'	  => $product->detail,
					                'description' => $product->description,
					                'extra_image' => $product->extra_images,
									'rating'      => $product->averageRating(),
									'brand'       => $product->brand->name,
									'quantity'	  => $product->stock(),
									'reviews'	  => $this->callReview($product->id),
								],
				
				'options' => $product->filteroptions->transform(function($option) {
									return [
										'id'   => $option->id,
										'name' => $option->name,
										'filter' => $option->filter->name,
									];
								}),
				            	
				// 'reviews' => $product->reviews->transform(function($review) {
				// 	            return [
				// 					'id'   => $review->id,
				// 					'user' => $review->user->name,
				// 					'rating' => $review->rating,
				// 	                'description' => $review->description,
				// 	            ];
				// 	         }),
       			];
	}

}