<?php

namespace App\Http\Transformers;

use App\Models\SubCategory;
use Illuminate\Support\Collection;
use App\Transformers\Transformer;
use Illuminate\Database\Eloquent\Model;


class BrandTransformer extends Transformer
{
    //Transform brands collection based on the selection of subcategory.
	public function transform($brand, $includeExtras)
	{
        return [
            'id'   => $brand->id,
            'name' => $brand->name,
        ];                            
	}

}