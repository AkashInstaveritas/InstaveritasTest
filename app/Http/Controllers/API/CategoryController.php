<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Http\Controllers\API\ApiController;

class CategoryController extends ApiController
{

    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data =  $this->categoryRepository->all();

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
        $data =  $this->categoryRepository->find($id);

        return $this->respond([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'data' => $data,       
            ]);
    }

}
