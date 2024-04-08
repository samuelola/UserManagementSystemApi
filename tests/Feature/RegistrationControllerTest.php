<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RegistrationControllerTest extends TestCase
{
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
     public function testRegistrationThrowErrorIfNameIsLessThree(){
          $this->post('api/register',['name'=>'af'])
               ->assertStatus(422)
               ->assertJsonStructure(['name']);
       }
    
     public function testRegistrationThrowErrorIfPasswordContainNoMixedCharacters(){
          $this->post('api/register',['password'=>'12388383838'])
               ->assertStatus(422)
               ->assertJsonStructure(['password']);
     } 
     // public function testRegistrationThrowErrorIfPasswordContainMixedCharacters(){
     //      $this->post('api/register',['password'=>'Testersamuel1@'])
     //           ->assertStatus(422)
     //           ->assertJsonStructure(['password']);
     // }
     public function testRegistrationThrowErrorIfPasswordIsNotSameAsConfirmPassword(){
          $this->postJson('api/register', [
               'password' => 'Testersamuel2@',
               'password_confirmed' => 'Testersamuel1@'
               ])->assertStatus(422)
               ->assertJsonStructure(['password_confirmed']);    
     }
     // public function testUserRegistrationHasAlreadyBeenStored(){
     //      $registrationDetails = [
     //           'name' => 'Tester Test',
     //           'email' => 'tester@gmail.com',
     //           'role_id' => 2,
     //           'password' => 'Testerjohn1@',
     //           'password_confirmed' => 'Testerjohn1@'
     //       ];
     //      $this->post('api/register',$registrationDetails)
     //           ->assertStatus(200);
               
     // }
     
         

}
