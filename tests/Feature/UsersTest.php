<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UsersTest extends TestCase
{
    public function testGetUser (){
        $user = User::factory()->create();
        $this->actingAs($user, 'api')->get('/api/v1/users/' . $user->id)->assertStatus(200);        
    }

    public function testStoreApiUser(){
        $newData = [
            'name' => 'wollaa Doe',
            'email' => 'wollaaddoe@gmail.com',
            'role_id' =>2,
            'password' => 'Wolladoe1@',
            'password_confirmed' => 'Wolladoe1@'
        ];
        $user = User::create($newData);
        
        $response = $this->actingAs($user, 'api')->post('/api/v1/users/');
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $newData['name'],
            'email' => $newData['email'],
        ]); 
    }

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
    public function testThrowErrorIfAuthenticatedUserIsNotAnAdminWhenGettingUsers (){
        $user = User::factory()->create();
        $this->actingAs($user, 'api')->get('/api/v1/users/')->assertStatus(403);        
    }
    public function testThrowErrorIfAuthenticatedUserIsNotAnAdminDeletingUser(){
        $user = User::factory()->create();
        $this->actingAs($user, 'api')->delete('/api/v1/users/'. $user->id)->assertStatus(403);        
    }
}
