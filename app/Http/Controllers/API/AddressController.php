<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Repositories\Eloquent\AddressRepository;
use App\Http\Controllers\API\ApiController;
use App\Http\Transformers\AddressTransformer;

class AddressController extends ApiController
{
    private $addressTransformer;
    private $addressRepository;

    public function __construct(AddressRepository $addressRepository,  AddressTransformer $addressTransformer)
    {
        $this->addressTransformer = $addressTransformer;
        $this->addressRepository = $addressRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->addressTransformer->transformCollection($this->addressRepository->addresses());

        return $this->respond([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'data' => $data       
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAddressRequest $request)
    {
        // Will return only validated data
        $validated = $request->validated();

        $this->addressRepository->create($validated);
        
        return $this->respond([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'message' => 'Address added.',       
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
        $data = $this->addressTransformer->transform($this->addressRepository->find($id), $includeExtras=false);

        return $this->respond([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'data' => $data,       
        ]); 
        
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAddressRequest $request, $id)
    {
        // Will return only validated data
        $validated = $request->validated();

        $this->addressRepository->update($validated, $id);
        
        return $this->respond([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'message' => 'Selected addres updated successfully.'       
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
        $this->addressRepository->delete($id);
        
        return $this->respond([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'message' => 'Selected address removed!'       
            ]); 
    }

}
