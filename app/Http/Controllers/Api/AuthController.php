<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Libraries\Utilities;

class AuthController extends Controller
{
    /**
    * Register api
    *
    * @return \Illuminate\Http\Response
    */
    public function register(RegisterRequest $RegisterRequest){
        $usercreate = User::create($RegisterRequest->validated());
        return Utilities::sendResponse($usercreate, 'User register successfully.');
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
            return Utilities::sendError('Login failed, please try again.', ['error'=>'Email or Password does not match with our record.']);
        }
        // successfull authentication
        $user = User::find(Auth::user()->id);
        $success['token'] =  $user->createToken('appToken')->accessToken;
        $success['user'] =  $user;
        return Utilities::sendResponse($success, 'User login successfully.');
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
            return Utilities::sendResponse([], 'User logout successfully.');
        }
    }
}
