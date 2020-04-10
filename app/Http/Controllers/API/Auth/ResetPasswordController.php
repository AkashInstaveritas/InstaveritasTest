<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Http\Response;
use Notification;
use App\Notifications\PasswordResetNotification;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Controllers\API\ApiController;


class ResetPasswordController extends ApiController
{

    public function sendEmail(Request $request)
    {
        if(!$this->validateEmail($request->email))
        {
            return $this->failedResponse();
        }

        $this->send($request->email);
        return $this->successResponse();
    }

    public function send($email)
    {
        $token = $this->createToken($email);

        $user = User::where('email', $email)->first();

        Notification::send($user, new PasswordResetNotification($token));

    }

    public function createToken($email)
    {
        $oldToken = DB::table('password_resets')->where('email', $email)->first();

        if ($oldToken) {
            return $oldToken->token;
        }

        $token = Str::random(60);
        $this->saveToken($token, $email);
        return $token;
    }

    public function saveToken($token, $email)
    {
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }

    public function validateEmail($email)
    {
        return !!User::where('email', $email)->first();
    }


    public function failedResponse()
    {
        return $this->respondNotFound('This email does not exists!');
    }

    public function successResponse()
    {
        return $this->respond([            
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'message' => 'Reset Email is send successfully, please check your inbox.',       
        ]); 
    }




}
