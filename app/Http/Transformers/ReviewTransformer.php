<?php

namespace App\Http\Transformers;

use App\User;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Collection;
use App\Transformers\Transformer;
use Illuminate\Database\Eloquent\Model;


class ReviewTransformer extends Transformer
{
	public function transform($product)
	{
        dd($product);
        
        $reviews = $product->reviews->transform(function($review) {
            	            return [
            					'id'   => $review->id,
            					'user' => $review->user->name,
            					'rating' => $review->rating,
            	                'description' => $review->description,
            	            ];
                         });

        return $reviews;      	
        
       			 
	}

}