<?php 

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Model;  


class ProductRepository implements ProductRepositoryInterface
{
	/**      
     * @var Model      
     */     
     protected $product;       

    /**      
     * ProductRepository constructor.      
     *      
     * @param Product $model      
     */     
    public function __construct(Product $product)     
    {         
        $this->product = $product;
    }

	

	/**
    * @param collection
    *
    * @return Model
    */
    public function all()
    {
    	return $this->product->all();
    }

    /**
    * @param $id
    * @return Model
    */
    public function find($id)
    {
        return $this->product->findorFail($id);
    }

    /**
    * @param collection
    *
    * @return Model
    */
    public function featured()
    {
        return $this->product->where('featured', 1)->get();
    }

}