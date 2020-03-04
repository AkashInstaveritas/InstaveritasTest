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

	//Transform the selected subcategory along with all collections of products, brands, filters.
	public function transform($subCategory, $includeExtras)
	{
        $data = [
			'id'     => $subCategory->id,
			'name'	 => $subCategory->name,
		];

		$extras = [
			'products' => $this->productTransformer->transformCollection($subCategory->products()->get()),
			'brands'   => $this->brandTransformer->transformCollection($subCategory->brands()->get()),
			'filters'  => $this->filterTransformer->transformCollection($subCategory->filters()->get()),
		];

		if($includeExtras) {
			return  array_merge($data,$extras);
		}

		return $data;
	}

}
