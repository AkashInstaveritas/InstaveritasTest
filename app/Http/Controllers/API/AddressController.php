<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AddressCreateRequest;
use App\Http\Requests\AddressRequest;
use App\Models\Address;
use App\Repositories\Eloquent\UserRepository;
use App\Http\Controllers\API\ApiController;
use App\Http\Transformers\AddressTransformer;

class AddressController extends ApiController
{
    private $addressTransformer;
    private $userRepository;

    public function __construct(UserRepository $userRepository,  AddressTransformer $addressTransformer)
    {
        $this->addressTransformer = $addressTransformer;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user =  $this->userRepository->find();

        $transformer = $this->addressTransformer->transformCollection($user);

        return $this->respond([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'data' => $transformer       
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressRequest $request)
    {
        // Will return only validated data
        $validated = $request->validated();

        $user =  $this->userRepository->find();

        $address = Address::create([
            'user_id'    => $user->id,
            'name' => $request->name,
            'landmark'   => $request->landmark,
            'city' => $request->city,
            'pincode' => $request->pincode,
            'state' => $request->state,
            'country' => $request->country
        ]);
        
        return $this->respondCreated([            
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
        $transformer = $this->addressTransformer->transform($this->check($id));

        return $this->respond([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'data' => $transformer,       
        ]); 
        
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddressRequest $request, $id)
    {
        // Will return only validated data
        $validated = $request->validated();

        $this->check($id)->update([
            'name'     => $request->name,
            'landmark' => $request->landmark,
            'city'     => $request->city,
            'pincode'  => $request->pincode,
            'state'    => $request->state,
            'country'  => $request->country 
            ]);
        
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
        $this->check($id)->delete();
        
        return $this->respond([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'message' => 'Selected addres removed.'       
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
        $obj = Address::where([
            ['user_id', $this->userRepository->find()->id],
            ['id', $id],
            ])->firstorFail();
        
        return $obj;
    }
}
