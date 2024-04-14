<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Enum\UserStatus;

class UsersTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function testGetUserAsAnAdmin (){
        $user = User::factory()->make();
        $credentials = [
             'name'=>$user->name,
             'email'=>$user->email,
             'role_id' => UserStatus::ADMIN,
             'password' => $user->password
        ];
        $userdetails = User::create($credentials);
        $this->actingAs($userdetails, 'api')->getJson('/api/v1/users/' . $userdetails->id)->assertStatus(200);        
    }
     /** @test */
    public function testAuthenticatedUserCanCreateAUser(){
        $user = User::factory()->make();
        $credentials = [
             'name'=>$user->name,
             'email'=>$user->email,
             'role_id' => UserStatus::ADMIN,
             'password' => $user->password
        ];
        $userdetails = User::create($credentials);
        $newUser = [

             'name'=>$user->name='updated user',
             'email'=>$this->faker->email,
             'role_id' => UserStatus::USER,
             'password' => 'Password1@',
             'password_confirmed' => 'Password1@'
        ];
        $this->actingAs($userdetails, 'api')->Json('POST','/api/v1/users/',$newUser)->assertStatus(200);

    }

    /** @test */
    public function testAdminCanUpdateAUser(){
        $user = User::factory()->make();
        $credentials = [
             'name'=>$user->name,
             'email'=>$user->email,
             'role_id' => UserStatus::ADMIN,
             'password' => $user->password
        ];
        $userdetails = User::create($credentials);
        $newUser = [

             'name'=>$user->name='updated user',
             'email'=>$this->faker->email,
             'role_id' => UserStatus::USER,
             'password' => 'Password1@',
             'password_confirmed' => 'Password1@'
        ];
        $this->actingAs($userdetails, 'api')->Json('POST','/api/v1/users/',$newUser)->assertStatus(200);

    }
     
    /** @test */
    public function testUserGettingAllAuthenticatedUsers (){
        $user = User::factory()->make();
        $credentials = [
             'name'=>$user->name,
             'email'=>$user->email,
             'role_id' => UserStatus::USER,
             'password' => $user->password
        ];
        $userdetails = User::create($credentials); 
        $this->actingAs($userdetails, 'api')->get('/api/v1/users/')->assertStatus(200);        
    }

    
    /** @test */
    public function testAdminGettingAllAuthenticatedUsers (){
        $user = User::factory()->make();
        $credentials = [
             'name'=>$user->name,
             'email'=>$user->email,
             'role_id' => UserStatus::ADMIN,
             'password' => $user->password
        ];
        $userdetails = User::create($credentials); 
        $this->actingAs($userdetails, 'api')->get('/api/v1/users/')->assertStatus(200);        
    }

    /** @test */
    public function testThrowErrorIfAuthenticatedUserIsNotAnAdminDeletingUser(){

        $user = User::factory()->make();
        $credentials = [
             'name'=>$user->name,
             'email'=>$user->email,
             'role_id' => UserStatus::USER,
             'password' => $user->password
        ];
        $userdetails = User::create($credentials);        
        $this->actingAs($userdetails, 'api')->delete('/api/v1/users/'. $userdetails->id)->assertStatus(403);        
    }

    
}
