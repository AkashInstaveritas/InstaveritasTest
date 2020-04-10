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
	//Transform reviews collection based on the selection of product.
	public function transform($review, $includeExtras)
	{
		return [
			'id'          => $review->id,
			'user'        => $review->user->name,
			'rating' 	  => $review->rating,
			'description' => $review->description,
			'date'        => $review->created_at
		];

	}

}