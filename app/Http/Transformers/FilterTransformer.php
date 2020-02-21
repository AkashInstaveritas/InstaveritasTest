<?php

namespace App\Http\Transformers;

use App\User;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Support\Collection;
use App\Transformers\Transformer;
use Illuminate\Database\Eloquent\Model;
use App\Http\Transformers\FilterOptionTransformer;


class FilterTransformer extends Transformer
{
    private $optionTransformer;

    public function __construct(FilterOptionTransformer $optionTransformer)
    {
        $this->optionTransformer = $optionTransformer;
    }
	public function transform($subCategory)
	{
		
        $filters = $subCategory->filters->transform(function($filter) {
                        return [
                            'id'   => $filter->id,
                            'name' => $filter->name,
                            'filterOptions' => $this->optionTransformer->transformFilter($filter),
                        ];
                    });
		
		return $filters->all();
    
       			 
	}

}