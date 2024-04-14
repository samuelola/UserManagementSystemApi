<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class LoginTest extends TestCase
{
    /** @test */
    public function testUserLoginInValidEmail()
    {
        $user = User::factory()->make();
        $data = [
            'email' =>'invalid email',
            'password' => $user->password
        ];
        $response = $this->postJson('api/login', $data);   
        $response->assertStatus(422);
                 
    }

    /** @test */
    public function testUserLoginInValidPassword()
    {
        $user = User::factory()->make();
        $data = [
            'email' =>$user->email,
            'password' => ''
        ];
        $response = $this->postJson('api/login', $data);   
        $response->assertStatus(422);
                 
    }

    /** @test */
    public function testUserLoginWithInvalidCredentials()
    {
        $data = [
            'email'=>'invalid email',
            'password' => 'invalid passwword'
        ];
        $response = $this->postJson('api/login', $data);   
        $response->assertStatus(422);         
    }
    
}
