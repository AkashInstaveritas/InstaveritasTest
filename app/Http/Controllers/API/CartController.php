<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Auth;
use App\Http\Requests\CartCreateRequest;
use App\Http\Controllers\API\ApiController;
use App\Http\Transformers\CartTransformer;
use App\Repositories\Eloquent\UserRepository;

class CartController extends ApiController
{
    private $cartTransformer;
    private $userRepository;

    public function __construct(UserRepository $userRepository,  CartTransformer $cartTransformer)
    {
        $this->cartTransformer = $cartTransformer;
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
     * @param  \Illuminate\Http\CartCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartCreateRequest $request)
    {
        // Will return only validated data
        
        $validated = $request->validated();

        $wishlist = Cart::create([
            'user_id'    => $this->userRepository->find()->id,
            'product_id' => $request->product_id,
            'quantity'   => $request->quantity,
        ]);

        return $this->respondCreated([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'message' => 'Product added to Cart.',       
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
        
        $transformer = $this->cartTransformer->transform($this->userRepository->find());

        return $this->respond([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'data' => $transformer       
            ]);
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
        $this->check($id)->update(['quantity' => $request->quantity]);
        
        return $this->respond([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'message' => 'Selected product quantity updated in cart.',  
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
            'message' => 'Selected product removed from cart.',       
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
        $object = Cart::where([
            ['user_id', $this->userRepository->find()->id],
            ['product_id', $id],
            ])->firstorFail();
        
        return $object;
    }
}
