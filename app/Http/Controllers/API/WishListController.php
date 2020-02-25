<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateWishlistRequest; 
use App\Http\Controllers\API\ApiController;
use App\Http\Transformers\WishlistTransformer;
use App\Repositories\Eloquent\WishlistRepository;


class WishListController extends ApiController
{
    private $wishlistTransformer;
    private $wishlistRepository;

    public function __construct(WishlistRepository $wishlistRepository, WishlistTransformer $wishlistTransformer)
    {
        $this->wishlistTransformer = $wishlistTransformer;
        $this->wishlistRepository = $wishlistRepository;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\WishlistCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateWishlistRequest $request)
    {
        // Will return only validated data
        
        $validated = $request->validated(); 

        $this->wishlistRepository->create($validated);

        return $this->respondCreated([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'message' => 'Product added to wishlist.',       
            ]);   
    }

    /**
     * Display the specified resource.
     *
     * @param  Auth user
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data = $this->wishlistTransformer->transformCollection($this->wishlistRepository->userWishlist());

        return $this->respond([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'data' => $data       
            ]); 
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->wishlistRepository->delete($id);

        return $this->respond([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'message' => 'Selected product removed from wishlist.'       
            ]); 
    }

}
