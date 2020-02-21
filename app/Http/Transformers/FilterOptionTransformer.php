<?php

namespace App\Http\Transformers;

use App\Models\Product;
use App\Models\FilterOption;
use App\Model\Filter;
use Illuminate\Support\Collection;
use App\Transformers\Transformer;
use Illuminate\Database\Eloquent\Model;


class FilterOptionTransformer extends Transformer
{
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