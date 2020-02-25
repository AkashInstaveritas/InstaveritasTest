<?php

namespace App\Http\Transformers;

use App\Models\Filter;
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
    
    //Transform all the filters based on the subcategory along the transformed collection of all the filter options.
	public function transform($filter, $includeExtras)
	{
        return [
            'id'            => $filter->id,
            'name'          => $filter->name,
            'filterOptions' => $this->optionTransformer->transformCollection($filter->filteroptions),
        ];
       			 
	}

}