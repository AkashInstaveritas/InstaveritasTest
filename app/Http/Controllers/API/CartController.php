<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\AddCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Controllers\API\ApiController;
use App\Http\Transformers\CartTransformer;
use App\Repositories\Eloquent\CartRepository;

class CartController extends ApiController
{
    private $cartTransformer;
    private $cartRepository;

    public function __construct(CartRepository $cartRepository,  CartTransformer $cartTransformer)
    {
        $this->cartTransformer = $cartTransformer;
        $this->cartRepository = $cartRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\AddCartRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCartRequest $request)
    {
        // Will return only validated data

        $validated = $request->validated();

        $message = $this->cartRepository->create($validated);

        return $this->respondCreated($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  Auth user
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data = $this->cartTransformer->transformCollection($this->cartRepository->userCart(), $includeExtras=true);

        return $this->respond([
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'data' => $data
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCartRequest $request, $id)
    {
        // Will return only validated data

        $validated = $request->validated();

        $this->cartRepository->update($request->all(), $id);

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
        $this->cartRepository->delete($id);

        return $this->respond([
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'message' => 'Selected product removed from cart.',
            ]);
    }

}
