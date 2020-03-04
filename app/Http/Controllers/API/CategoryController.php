<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Http\Controllers\API\ApiController;
use App\Http\Transformers\CategoryTransformer;

class CategoryController extends ApiController
{

    private $categoryRepository;
    private $categoryTransformer;

    public function __construct(CategoryRepositoryInterface $categoryRepository, CategoryTransformer $categoryTransformer)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryTransformer = $categoryTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->all();

        $data = $this->categoryTransformer->transformCollection($categories, $includeExtras=false);

        return $this->respond([
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'data' => $data,
            ]);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->categoryRepository->find($id);

        $data = $this->categoryTransformer->transform($category, $includeExtras=true);

        return $this->respond([
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'data' => $data,
            ]);
    }

}
