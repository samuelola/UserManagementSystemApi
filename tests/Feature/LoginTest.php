<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Enum\UserStatus;
use App\Libraries\Response;

class LoginTest extends TestCase
{
    /** @test */
    public function testUserLoginWithInValidEmail()
    {
        $user = User::factory()->make();
        $data = [
            'email' =>'invalid email',
            'password' => $user->password
        ];
        $response = $this->postJson('api/login', $data);   
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);    
    }

    /** @test */
    public function testUserLoginWithInValidPassword()
    {
        $user = User::factory()->make();
        $data = [
            'email' =>$user->email,
            'password' => ''
        ];
        $response = $this->postJson('api/login', $data);   
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);  
    }

    /** @test */
    public function testUserLoginWithInvalidCredentials()
    {
        $data = [
            'email'=>'invalid email',
            'password' => 'invalid passwword'
        ];
        $response = $this->postJson('api/login', $data);   
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);         
    }

    /** @test */
    public function testUserLoginWithValidCredentials()
    {
        $user = User::factory()->make();
        $credentials = [
            'name'=>$user->name,
            'email'=>$user->email,
            'role_id'=>UserStatus::USER,
            'password'=>$user->password
        ];
        $data = User::create($credentials);
        $userdetails = [
            'email' => $data->email,
            'password' => $user->password
        ];
        $this->json('POST', 'api/login', $userdetails)->assertStatus(Response::HTTP_OK);  
        
    }

    
}
