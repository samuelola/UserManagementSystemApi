<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\ApiController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class AuthController extends BaseController
{
    /**
    * Register api
    *
    * @return \Illuminate\Http\Response
    */
    public function register(RegisterRequest $RegisterRequest){
        $usercreate = User::create($RegisterRequest->validated());
        $success['info'] =  $usercreate;
        return $this->sendResponse($success, 'User register successfully.');
    }

   /**
    * Login api
    *
    * @return \Illuminate\Http\Response
    */

    public function login(LoginRequest $LoginRequest)
    {
        // failure to authenticate
        if(!Auth::attempt($LoginRequest->only('email','password'))){
            return $this->sendError('Login failed, please try again.', ['error'=>'Email or Password does not match with our record.']);
        }
        // successfull authentication
        $user = User::find(Auth::user()->id);
        $success['token'] =  $user->createToken('appToken')->accessToken;
        $success['user'] =  $user;
        return $this->sendResponse($success, 'User login successfully.');
    }

    /**
   * Destroy an authenticated session.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */

   public function destroy()
    {
        if (Auth::user()) {
            auth()->user()->token()->revoke();
            return $this->sendResponse([], 'User logout successfully.');
        }
    }
}
