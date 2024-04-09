<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UsersTest extends TestCase
{
    /**
     * Test for retrieving a user details after authentication.
     */
    public function testGetUser (){
        $user = User::factory()->create();
        $this->actingAs($user, 'api')->get('/api/v1/users/' . $user->id)->assertStatus(200);        
    }
    /**
     * Test for user to see if it has permission to create users.
     */
    public function testThrowErrorIfAuthenticatedUserIsNotAnAdminCreatingUser(){
        $user = User::factory()->create();
        $this->actingAs($user, 'api')->get('/api/v1/users/')->assertStatus(403); 
       
    }
     /**
     * Test for User that has already been updated.
     */
    public function testThrowErrorIfAuthenticatedUserIsAlreadyUpdated(){
        $user = User::factory()->create();
        $newData = [
            'name' => 'wolla Doe',
            'email' => 'wolladoe@gmail.com',
            'role_id' =>2,
            'password' => 'Wolladoe1@',
            'password_confirmed' => 'Wolladoe1@'
        ];
        $response = $this->actingAs($user, 'api')->put('/api/v1/users/' . $user->id, $newData);
        $response->assertStatus(422);
        
    }
    /**
     * Test for User that is not Admin have permission to retrieve users.
     */
    public function testThrowErrorIfAuthenticatedUserIsNotAnAdminWhenGettingUsers (){
        $user = User::factory()->create();
        $this->actingAs($user, 'api')->get('/api/v1/users/')->assertStatus(403);        
    }

    /**
     * Test for User that is not Admin have permission to retrieve users.
     */
    public function testThrowErrorIfAuthenticatedUserIsNotAnAdminDeletingUser(){
        $user = User::factory()->create();
        $this->actingAs($user, 'api')->delete('/api/v1/users/'. $user->id)->assertStatus(403);        
    }
}
