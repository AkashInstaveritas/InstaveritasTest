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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data =  $this->productRepository->all();
        
        return response()->json(['success' => true, 'data' => $data], $this->successStatus); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

        $transformer =$this->productTransformer->transform($product);

        return $this->respond([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'data' => $transformer       
            ]); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
