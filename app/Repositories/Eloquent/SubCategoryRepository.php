<?php 

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Models\SubCategory;
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

}