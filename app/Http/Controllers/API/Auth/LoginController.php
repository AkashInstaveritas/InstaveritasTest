<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Response;
use Illuminate\Support\Str;
use App\Http\Requests\UserLoginRequest;
use App\Http\Transformers\UserTransformer;
use App\Http\Controllers\API\ApiController;

class LoginController extends ApiController
{
    private $userTransformer;

    public function __construct(userTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;    
    }
    
    public function login(UserLoginRequest $request)
    {
        // Will return only validated data
        
        $validated = $request->validated();       

        
        $credentials = request(['email', 'password']);

        if(Auth::attempt($credentials))
        {
            $user = $request->user();
    
            return $this->respond([            
                'status' => 'success',
                'status_code' => $this->getStatusCode(),
                'message' => 'LogIn Successfull!',
                'data' => $this->userTransformer->transform($user, $includeExtras=false),
                'token' =>  $user->createToken('Laravel Password Grant Client')->accessToken,      
                ]); 
        } 
        
        //$error = 'Email or password is incorrect.';

        return response()->json(['error' => 'Email or password is incorrect.'], 401);    
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke(); 

        return $this->respond([            
                'status' => 'success',
                'status_code' => $this->getStatusCode(),
                'message' => 'LogOut Successfull!',    
                ]);
    }


}
