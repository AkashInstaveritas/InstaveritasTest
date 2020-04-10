<?php

namespace App\Http\Transformers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Collection;
use App\Transformers\Transformer;
use App\Http\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\Model;

class OrderTransformer extends Transformer
{
    private $productTransformer;

    public function __construct(ProductTransformer $productTransformer)
    {
		$this->productTransformer = $productTransformer;
    }

    //Transform order based on the selection of order.
    public function transform($order, $includeExtras=false)
    {
      $data = [
            'id'   => $order->id,
            'products' => $this->productTransformer->transformCollection($order->products()->get(), false),
            'total' => $order->total,
            'status' => $order->status,
            'placedOn' => $order->created_at            	
      ];
				   
      $extras = [
              'address' => $order->address->name,
              'tax'  => $order->tax."%",
              'subTotal' => $order->subtotal,
      ];

      if($includeExtras) 
      {
        return  array_merge($data,$extras);
      }

		  return $data;
    }
    

}