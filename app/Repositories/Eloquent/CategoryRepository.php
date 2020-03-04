<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Models\SubCategory;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Model;


class CategoryRepository implements CategoryRepositoryInterface
{
	/**
     * @var Model
     */
     protected $category;

    /**
     * ProductRepository constructor.
     *
     * @param Product $model
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }



	/**
    * @param collection
    *
    * @return Model
    */
    public function all()
    {
    	return $this->category->all();
    }

    /**
    * @param $id
    * @return Model
    */
    public function find($id)
    {
        return $this->category->findorFail($id);
    }

}
