<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\ApiController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AuthController extends BaseController
{
    /**
    * Register api
    *
    * @return \Illuminate\Http\Response
    */
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users|email:rfc,dns',
            'role_id' => 'required',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$#!%*?&])[A-Za-z\d@$!%*?&#]+$/',
            'password_confirmed'=> 'required|same:password'
        ], [
            'name.required' => 'Name is required',
            'name.min' => 'Name must not be less than 3 characters.',
            "email.required" => "Email is required",
            "email.unique" => "Email is already taken",
            "password.min" => "Password must not be less than 8 characters.",
            "password" => "Password must contain one capital letter and special character",
            "password_confirmed.required" => "Confirm your password"
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user=User::create($input);
        $success['info'] =  $user;
        return $this->sendResponse($success, 'User register successfully.');
    }

   /**
    * Login api
    *
    * @return \Illuminate\Http\Response
    */

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            // successfull authentication
            $user = User::find(Auth::user()->id);
            $success['token'] =  $user->createToken('appToken')->accessToken;
            $success['user'] =  $user;
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else {
            // failure to authenticate
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    /**
   * Destroy an authenticated session.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */

   public function destroy(Request $request)
    {
        if (Auth::user()) {
            $request->user()->token()->revoke();
            return $this->sendResponse([], 'User logout successfully.');
        }
    }
}
