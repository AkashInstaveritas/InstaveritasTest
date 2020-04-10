<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\Product;
use App\Http\Transformers\SubCategoryTransformer;
use App\Http\Transformers\ProductTransformer;
use App\Repositories\Interfaces\SubCategoryRepositoryInterface;
use App\Http\Controllers\API\ApiController;

class SubCategoryController extends ApiController
{

    private $subCategoryRepository;
    private $subCategoryTransformer;
    private $productTransformer;

    public function __construct(SubCategoryRepositoryInterface $subCategoryRepository, 
        SubCategoryTransformer $subCategoryTransformer, ProductTransformer $productTransformer)
    {
        $this->subCategoryRepository = $subCategoryRepository;
        $this->subCategoryTransformer = $subCategoryTransformer;
        $this->productTransformer = $productTransformer;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subCategory = $this->subCategoryRepository->find($id);

        $data  =$this->subCategoryTransformer->transform($subCategory, $includeExtras=true);

        return $this->respond([
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'data' => $data
            ]);
    }

    public function filter(Request $request, $id)
    {
        $products = $this->subCategoryRepository->filter($request, $id);
          
        $data = $this->productTransformer->transformCollection($products, $includeExtras=false);

        return $this->respond([
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'data' => $data
            ]);
    }

    


}
