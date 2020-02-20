<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Validator;
use Response;
use Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public $successStatus = 200;

    public function login(Request $request)
    {
        $rules = array (            
                        'email' => 'required|string|email|max:255',
                        'password'=> 'required'       
                    );

        $validator = Validator::make($request->all(), $rules);        

        if ($validator-> fails())
        {               
            return response()->json(['success' => true, 'data' => $validator->errors()], $this->successStatus);     
        }

        
        $user = User::where('email', $request->get('email'))->first();
          
        $auth = Hash::check($request->get('password'), $user->password);

        if($user && $auth)
        {
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            
            return response()->json(['success' => true, 'message'=> 'Login Successfull', 'token' => $token, 'data' => $user], $this->successStatus); 
        } 

            
        return response()->json(['success' => false, 'message'=>'Incorrect Email Or Password!'], $this->successStatus); 
    }
}
