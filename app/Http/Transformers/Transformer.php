<?php 

namespace App\Transformers;

use Illuminate\Support\Collection;

abstract class Transformer 
{   
    /**
    * Transform collection
    *
    * @param Collection $items
    * @param array $relations
    * @param $includeExtras
    * @return array
    */
    public function transformCollection(Collection $items, $includeExtras = false)
    {
        return $items->transform(function ($item, $key) use($includeExtras) {
            return $this->transform($item, $includeExtras);
        });
    } 

    public abstract function transform($item, $includeExtras);

}