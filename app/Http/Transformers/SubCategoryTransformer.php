<?php

namespace App\Http\Transformers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Filter;
use App\Models\SubCategory;
use Illuminate\Support\Collection;
use App\Transformers\Transformer;
use Illuminate\Database\Eloquent\Model;
use App\Http\Transformers\ProductTransformer;
use App\Http\Transformers\FilterTransformer;
use App\Http\Transformers\BrandTransformer;

class SubCategoryTransformer extends Transformer
{
	private $productTransformer;
	private $brandTransformer;
	private $filterTransformer;

    public function __construct(ProductTransformer $productTransformer, BrandTransformer $brandTransformer, FilterTransformer $filterTransformer)
    {
		$this->productTransformer = $productTransformer;
		$this->brandTransformer = $brandTransformer;
		$this->filterTransformer = $filterTransformer;
    }
	
	
	public function transform($subCategory)
	{
		return [
			'products' =>  $this->productTransformer->transformSubCategory($subCategory),
			'brands'    => $this->brandTransformer->transform($subCategory),
			'filters'    => $this->filterTransformer->transform($subCategory),
            
        ];
	}

}