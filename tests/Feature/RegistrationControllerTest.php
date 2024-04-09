<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RegistrationControllerTest extends TestCase
{
     /**
     * Test Registration for all empty fields.
     */
     public function testRegistrationThrowErrorIfAllFieldsAreEmpty(){
          $this->postJson('api/register', [
               'name' => '',
               'email' => '',
               'role_id' => '',
               'password' => '',
               'password_confirmed' => ''
           ])->assertStatus(422)
             ->assertJsonStructure(['name','email','role_id','password','password_confirmed']);
     }
     /**
     * Test Registration for name field less than three.
     */
     public function testRegistrationThrowErrorIfNameIsLessThree(){
          $this->post('api/register',['name'=>'af'])
               ->assertStatus(422)
               ->assertJsonStructure(['name']);
       }
    
     /**
     * Test Registration for password that do not contain mixed characters .
     */  
     public function testRegistrationThrowErrorIfPasswordContainNoMixedCharacters(){
          $this->post('api/register',['password'=>'12388383838'])
               ->assertStatus(422)
               ->assertJsonStructure(['password']);
     } 
    /**
     * Test Registration for password that is the same with the confirm password.
     */  
     public function testRegistrationThrowErrorIfPasswordIsNotSameAsConfirmPassword(){
          $this->postJson('api/register', [
               'password' => 'Testersamuel2@',
               'password_confirmed' => 'Testersamuel1@'
               ])->assertStatus(422)
               ->assertJsonStructure(['password_confirmed']);    
     }
    
     /**
     * Test Registration for Admin (Role_id=1) with a unique email.
     */

     public function testRegisterSuccessfully()
    {
        $register = [
            'name' => 'Admin Test',
            'email' => 'testeradmin@gmail.com',
            'role_id' => 1,
            'password' => 'Testerjohn1@',
            'password_confirmed' => 'Testerjohn1@'
        ];
        $this->json('POST', 'api/register', $register)
            ->assertStatus(200);
    }
     
         

}
