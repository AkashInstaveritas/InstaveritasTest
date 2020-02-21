<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Wishlist;
use Auth;
use App\Http\Requests\WishlistCreateRequest; 
use App\Http\Controllers\API\ApiController;
use App\Http\Transformers\UserTransformer;
use App\Repositories\Eloquent\UserRepository;

class WishListController extends ApiController
{
    private $userTransformer;
    private $userRepository;

    public function __construct(UserRepository $userRepository, UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(WishlistCreateRequest $request)
    {
        // Will return only validated data
        
        $validated = $request->validated(); 

        $wishlist = Wishlist::create([
                        'user_id' => auth('api')->user()->id,
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
        
        $user =  $this->userRepository->find();

        $transformer = $this->userTransformer->transformWishlist($user);

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
