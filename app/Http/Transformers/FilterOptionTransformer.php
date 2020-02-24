<?php

namespace App\Http\Transformers;

use App\Models\FilterOption;
use App\Model\Filter;
use Illuminate\Support\Collection;
use App\Transformers\Transformer;
use Illuminate\Database\Eloquent\Model;


class FilterOptionTransformer extends Transformer
{
    //Transform all the filter options based on the product selected along with filter it belongs to.
	public function transform($product)
	{
		$options = $product->filteroptions->transform(function($option) {
                        return [
                            'id'   => $option->id,
                            'name' => $option->name,
                            'filter' => $option->filter->name,
                        ];
                    });
           
        
        return $options->all();
       			 
    }
    
    //Transform filter options based on the filter.
    public function transformFilter($filter)
    {
        $options = $filter->filteroptions->transform(function($option) {
            return [
                'id'   => $option->id,
                'name' => $option->name,
            ];
        });


        return $options->all();
    }

}