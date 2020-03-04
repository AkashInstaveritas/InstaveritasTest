<?php

namespace App\Http\Transformers;

use Illuminate\Support\Collection;
use App\Transformers\Transformer;
use App\Http\Transformers\SubCategoryTransformer;

class CategoryTransformer extends Transformer
{
	private $subcategoryTransformer;

    public function __construct(SubCategoryTransformer $subcategoryTransformer)
    {
		$this->subcategoryTransformer = $subcategoryTransformer;
    }

	//Transform product along with its reviews collection and filteroptions and filters which are the acting properties.
	public function transform($category, $includeExtras=false)
	{
		$data = [
			'id'    => $category->id,
			'name' 	=> $category->name,
		];

		$extras = [
			'subCategories' => $this->subcategoryTransformer->transformCollection($category->subcategories),
		];

		if($includeExtras) {
			return  array_merge($data,$extras);
		}

		return $data;
	}

}
