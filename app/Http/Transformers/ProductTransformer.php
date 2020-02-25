<?php

namespace App\Http\Transformers;

use App\Models\Product;
use Illuminate\Support\Collection;
use App\Transformers\Transformer;
use Illuminate\Database\Eloquent\Model;
use App\Http\Transformers\ReviewTransformer;
use App\Http\Transformers\FilterOptionTransformer;

class ProductTransformer extends Transformer
{
	private $reviewTransformer;
	private $optionTransformer;

    public function __construct(ReviewTransformer $reviewTransformer, FilterOptionTransformer $optionTransformer)
    {
		$this->reviewTransformer = $reviewTransformer;
		$this->optionTransformer = $optionTransformer;
    }
		
	//Transform product along with its reviews collection and filteroptions and filters which are the acting properties.
	public function transform($product, $includeExtras=false)
	{
		$data = [
			'id'    	  => $product->id,
			'name'  	  => $product->name,
			'image' 	  => $product->image,			            	
		];
				   
		$extras = [
			'detail'	  => $product->detail,
			'description' => $product->description,
			'extra_image' => $product->extra_images,
			'rating'      => $product->averageRating(),
			'brand'       => $product->brand->name,
			'quantity'	  => $product->stock(),
			'reviews'	  => $this->reviewTransformer->transformCollection($product->reviews),
			'filterOptions'	  => $this->optionTransformer->transformCollection($product->filteroptions()->get(), true),
		];

		if($includeExtras) {
			return  array_merge($data,$extras);
		}

		return $data;
	}

}