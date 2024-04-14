<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use App\Enum\UserStatus;

class RegistrationTest extends TestCase
{
     use WithFaker;

    /** @test */
    public function testAllEmptyFieldsForRegistration()
    {
        $register = [];
        $this->json('POST', 'api/register', $register)
            ->assertStatus(422);
    
    } 
     /** @test */
    public function testNameIsEmptyForRegistration()
    {
        $user = User::factory()->make();
        $register = [
            'name' => '',
            'email' => $user->email,
            'role_id' => UserStatus::USER,
            'password' => 'Password1@',
            'password_confirmed' => 'Password1@'
        ];
        $this->json('POST', 'api/register', $register)
            ->assertStatus(422);
    
    }
    /** @test */
    public function testNameIsLessThanThreeForRegistration()
    {
        $user = User::factory()->make();
        $register = [
            'name' => 'we',
            'email' => $user->email,
            'role_id' => UserStatus::USER,
            'password' => 'Password1@',
            'password_confirmed' => 'Password1@'
        ];
        $this->json('POST', 'api/register', $register)
            ->assertStatus(422);
    
    }
    /** @test */
    public function testIfPasswordContainNoMixedCharactersAndaCapitalLetterForRegistration()
    {
        $user = User::factory()->make();
        $register = [
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => UserStatus::USER,
            'password' => 'password',
            'password_confirmed' => 'password'
        ];
        $this->json('POST', 'api/register', $register)
            ->assertStatus(422);
    
    }
     
   /** @test */
    public function testIfPasswordIsNotTheSameAsConfirmPasswordForRegistration()
    {
        $user = User::factory()->make();
        $register = [
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => UserStatus::USER,
            'password' => 'Password1@',
            'password_confirmed' => 'password2@'
        ];
        $this->json('POST', 'api/register', $register)
            ->assertStatus(422);
    
    }
    
    /** @test */
     public function testRegisterSuccessfullyForAdmin()
    {
        $user = User::factory()->make();
        $register = [
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => UserStatus::ADMIN,
            'password' => 'Password1@',
            'password_confirmed' => 'Password1@'
        ];
        $this->json('POST', 'api/register', $register)
            ->assertStatus(200);
    
    }
    /** @test */
    public function testRegisterSuccessfullyForUser()
    {
        $user = User::factory()->make();
        $register = [
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => UserStatus::USER,
            'password' => 'Password1@',
            'password_confirmed' => 'Password1@'
        ];
        $this->json('POST', 'api/register', $register)
            ->assertStatus(200);
    
    }
    

}
