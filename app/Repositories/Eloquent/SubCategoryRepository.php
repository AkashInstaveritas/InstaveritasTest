<?php 

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Repositories\Interfaces\SubCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Model;  


class SubCategoryRepository implements SubCategoryRepositoryInterface
{
	/**      
     * @var Model      
     */     
     protected $subCategory;       

    /**      
     * ProductRepository constructor.      
     *      
     * @param Product $model      
     */     
    public function __construct(SubCategory $subCategory)     
    {         
        $this->subCategory = $subCategory;
    }

	

	/**
    * @param collection
    *
    * @return Model
    */
    public function all()
    {
    	return $this->subCategory->all();
    }

    /**
    * @param $id
    * @return Model
    */
    public function find($id)
    {
        return $this->subCategory->find($id);
    }

    /**
    * @param $id
    * @return Model
    */
    public function filter($request, $id)
    {
        if(!empty($request->brand) && !empty($request->filter))
        {
            return  Product::whereIn('brand_id', $request->brand)
                    ->join('product_sub_category', 'products.id', '=', 'product_sub_category.product_id')
                    ->join('filter_option_product', 'products.id', '=', 'filter_option_product.product_id')
                    ->where('sub_category_id', $id)
                    ->whereIn('filter_option_id', $request->filter)->get();
        }

        if(!empty($request->brand) && empty($request->filter))
        {
            return SubCategory::find($id)->products()->whereIn('brand_id', $request->brand)->get();
        }

        if(empty($request->brand) && !empty($request->filter))
        {
            return  Product::whereIn('filter_option_id', $request->filter)
                        ->join('product_sub_category', 'products.id', '=', 'product_sub_category.product_id')
                        ->join('filter_option_product', 'products.id', '=', 'filter_option_product.product_id')
                        ->where('sub_category_id', $id)->get();
        }  
    }

}