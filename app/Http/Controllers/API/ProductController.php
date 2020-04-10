<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Http\Transformers\ProductTransformer;
use App\Http\Controllers\API\ApiController;

class ProductController extends ApiController
{

    private $productRepository;
    private $productTransformer;

    public function __construct(ProductRepositoryInterface $productRepository, ProductTransformer $productTransformer)
    {
        $this->productRepository = $productRepository;
        $this->productTransformer = $productTransformer;
    }
    
    
    /**
     * Display the specified resource.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function featured()
    {
        $products =  $this->productRepository->featured();

        $data = $this->productTransformer->transformCollection($products, $includeExtras=false);

        return $this->respond([
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'data' => $data
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
        $product =  $this->productRepository->find($id);

        $data =$this->productTransformer->transform($product, $includeExtras=true);

        return $this->respond([
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'data' => $data
            ]);
    }

    
}
