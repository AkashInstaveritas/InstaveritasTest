<?php

namespace App\Http\Transformers;

use App\Models\FilterOption;
use App\Models\Filter;
use Illuminate\Support\Collection;
use App\Transformers\Transformer;
use Illuminate\Database\Eloquent\Model;


class FilterOptionTransformer extends Transformer
{
    //Transform all the filter options based on the product selected along with filter it belongs to.
	public function transform($filteroption, $includeExtras)
	{	
        $data = [
            'id'   => $filteroption->id,
            'name' => $filteroption->name,
        ];

        $extras = [
			'filter' => $filteroption->filter->name,
		];

		if($includeExtras) {
			return  array_merge($data,$extras);
		}

		return $data;
      			 
    }

}