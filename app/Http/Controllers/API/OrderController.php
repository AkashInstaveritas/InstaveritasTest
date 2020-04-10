<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\CreateOrderRequest;
use App\Repositories\Eloquent\OrderRepository;
use App\Http\Controllers\API\ApiController;
use App\Http\Transformers\OrderTransformer;

class OrderController extends ApiController
{
    private $orderTransformer;
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository,  OrderTransformer $orderTransformer)
    {
        $this->orderTransformer = $orderTransformer;
        $this->orderRepository = $orderRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->orderTransformer->transformCollection($this->orderRepository->userOrders(), $includeExtras=false);

        return $this->respond([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'data' => $data,       
        ]); 
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderRequest $request)
    {
        if($this->orderRepository->productsNoLongerAvailable())
        {
            return $this->respondWithError([            
                'message' => 'Sorry! One of the products in your cart is no longer available.',       
                ]);
        }

        $validated = $request->validated();

        $this->orderRepository->create($validated);

        return $this->respond([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'message' => 'Order placed successfully.',       
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
        $data = $this->orderTransformer->transform($this->orderRepository->find($id), $includeExtras=true);

        return $this->respond([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'data' => $data,       
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
    public function cancelOrder($id)
    {
        $this->orderRepository->cancel($id);

        return $this->respond([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'message' => 'Order cancelled successfully!',       
        ]);
    }
}
