<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /**
     * Test Login for wrong email.
     */  
    public function testUserWrongEmail()
    {
        $credential = [
            'email' => 'oladelesamuel41@gmail.com',
            'password' => 'Oladelesamuel1@'
        ];
        $this->post('/api/login',$credential)->assertStatus(404);        
    }

    /**
     * Test Login for user with wrong password.
     */
    public function testUserWrongPassword()
    {
        $credential = [
            'email' => 'oladelesamuel48@gmail.com',
            'password' => 'Oladelesamuel2@'
        ];
        $this->post('/api/login',$credential)->assertStatus(404);        
    }
    /**
     * Test Login for user with correct credentials.
     */
    public function testUserLoginWithCorrectCredentials()
    {
        $credential = [
            'email' => 'john.doe@gmail.com',
            'password' => 'Oladelesamuel1@'
        ];
        $this->post('/api/login',$credential)->assertStatus(200);            
    }
    /**
     * Test Login for user with wrong credentials.
     */
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
