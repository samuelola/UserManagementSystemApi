<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\ApiController as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('create-delete-users');
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
    public function store(UserRequest $UserRequest)
    {
        Gate::authorize('create-delete-users');
        $createuser = User::create($UserRequest->validated());
        return $this->sendResponse(new UserResource($createuser), 'user created successfully.');
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
    public function update(UpdateUserRequest $UpdateUserRequest, User $user)
    {   
        $user->update($UpdateUserRequest->validated());
        return $this->sendResponse([], 'User updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('create-delete-users');
        $user->delete();
        return $this->sendResponse([], 'User deleted successfully.');    
    }
}
