<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\Eloquent\UserRepository;
use App\Http\Controllers\API\ApiController;
use App\Http\Transformers\UserTransformer;

class UserController extends ApiController
{
    private $userTransformer;
    private $userRepository;

    public function __construct(UserRepository $userRepository,  UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
        $this->userRepository = $userRepository;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(CreateUserRequest $request)
    {
        // Will return only validated data
        $validated = $request->validated();

        $this->userRepository->create($validated);

        return $this->respondCreated('Registration Successfull.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data = $this->userTransformer->transform($this->userRepository->currentUser(), $includeExtras=false);

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
    public function update(UpdateUserRequest $request)
    {
        // Will return only validated data
        $validated = $request->validated();

        $data = $this->userTransformer->transform($this->userRepository->update($validated), $includeExtras=false);

        return $this->respond([
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'message' => 'Profile updated successfully.',
            'data' => $data
            ]);
    }

}
