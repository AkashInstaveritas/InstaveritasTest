<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Wishlist;
use App\Models\Product;
use Auth;
use App\Http\Requests\WishlistCreateRequest; 
use App\Http\Controllers\API\ApiController;
use App\Http\Transformers\WishlistTransformer;
use App\Repositories\Eloquent\UserRepository;


class WishListController extends ApiController
{
    private $wishlistTransformer;
    private $userRepository;

    public function __construct(UserRepository $userRepository, WishlistTransformer $wishlistTransformer)
    {
        $this->wishlistTransformer = $wishlistTransformer;
        $this->userRepository = $userRepository;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\WishlistCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WishlistCreateRequest $request)
    {
        // Will return only validated data
        
        $validated = $request->validated(); 

        $wishlist = Wishlist::create([
                        'user_id' => $this->userRepository->find()->id,
                        'product_id' => $request->product_id,
        ]);


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
        $transformer = $this->wishlistTransformer->transform($this->userRepository->find());

        return $this->respond([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'data' => $transformer       
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
        $this->check($id)->delete();
        
        return $this->respond([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'message' => 'Selected product removed from wishlist.'       
            ]); 
    }

    /**
     * Check the specified resource from storage exists or not.
     *
     * @param  int  $id
     * @return \$object
     */
    private function check($id)
    {
        $object = Wishlist::where([
            ['user_id', $this->userRepository->find()->id],
            ['product_id', $id],
            ])->firstorFail();
        
        return $object;
    }
}
