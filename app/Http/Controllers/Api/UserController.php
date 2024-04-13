<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Libraries\Utilities;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return Utilities::sendResponse(UserResource::collection($users), 'users retrieved successfully.');
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
        $createuser = User::create($UserRequest->validated());
        return Utilities::sendResponse(new UserResource($createuser), 'user created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return Utilities::sendError('User not found.');
        }
        return Utilities::sendResponse(new UserResource($user), 'User retrieved successfully.');
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
        return Utilities::sendResponse([], 'User updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return Utilities::sendResponse([], 'User deleted successfully.');    
    }
}
