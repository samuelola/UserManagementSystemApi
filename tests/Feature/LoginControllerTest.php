<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    
    public function testUserWrongEmail()
    {
        $credential = [
            'email' => 'oladelesamuel41@gmail.com',
            'password' => 'Oladelesamuel1@'
        ];
        $this->post('/api/login',$credential)->assertStatus(404);        
    }
    public function testUserWrongPassword()
    {
        $credential = [
            'email' => 'oladelesamuel48@gmail.com',
            'password' => 'Oladelesamuel2@'
        ];
        $this->post('/api/login',$credential)->assertStatus(404);        
    }
    public function testUserLogin()
    {
        $credential = [
            'email' => 'john.doe@gmail.com',
            'password' => 'Oladelesamuel1@'
        ];
        $this->post('/api/login',$credential)->assertStatus(200);            
    }

    public function testUserLoginWithWrongCredentials()
    {
        $user = User::factory()->create();
        $credential = [
            'email' => $user->email,
            'password' => 'Oladelesamuel@'
        ];
        $this->post('/api/login',$credential)->assertStatus(404);           
    }
}
