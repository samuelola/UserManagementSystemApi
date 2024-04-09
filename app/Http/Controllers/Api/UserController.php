<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\ApiController as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Gate;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('create-Update-delete-users');
        $users = User::all();
        return $this->sendResponse(UserResource::collection($users), 'users retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        Gate::authorize('create-Update-delete-users');
        $user = User::create($input);
        return $this->sendResponse(new UserResource($user), 'user created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return $this->sendError('User not found.');
        }
        return $this->sendResponse(new UserResource($user), 'User retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {   
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
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = $input['password'];
        $user->save();
        return $this->sendResponse(new UserResource($user), 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('create-Update-delete-users');
        $user->delete();
        return $this->sendResponse([], 'User deleted successfully.');    
    }
}
