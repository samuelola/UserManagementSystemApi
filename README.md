# Management System API - Step by Step
A User Management System API using Laravel. This API will be responsible for handling user profiles within an application, including operations such as creating, updating, viewing, and deleting users.

### Prerequisites
* Apache
* PHP
* Composer
* Laravel new app created
* Laravel api auth with passport done

### Initial notes
The project in this repo contains all the steps finalized

###  Setup instructions for the project.
To clone the Application run in terminal
```
git clone 
```
To Install the vendor folder run in the terminal
```
composer install
```
Rename the env.example file to .env and update you database connections.

### Step 2 - Run Migrations
With all the migrations created in the database/migrations folder.Run in terminal
```
php artisan migrate
```
Run in terminal to run the RoleSeeder in the seeders folder
```
php artisan db:seeder
```
### Step 3 - Run in terminal to start the application
```
php artisan serve
```
### Step 4 - Generate Feature Test for RegisterController
In the terminal run
```
php artisan make:test LoginControllerTest
```
```
php artisan make:test RegisterControllerTest
```
```
php artisan make:test UserTest
```

### Step 8 - Add tests to LoginController
In the tests/Feature/Auth/LoginControllerTest.php add tests
for validations, success login and logout
```php
<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class LoginControllerTest extends TestCase
{
    public function testRequireEmailAndLogin()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422)                
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.']
                ]
            ]);
                        
    }

    public function testUserLoginSuccessfully()
    {
        $user = ['email' => 'user@email.com', 'password' => 'userpass'];
        $this->json('POST', 'api/login', $user)
            ->assertStatus(200)
            ->assertJsonStructure([
                'token',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    public function testLogoutSuccessfully()
    {
        $user = ['email' => 'user@email.com',
            'password' => 'userpass'
        ];
        
        Auth::attempt($user);
        $token = Auth::user()->createToken('nfce_client')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];
        $this->json('GET', 'api/logout', [], $headers)
            ->assertStatus(204);
    }
}
```

### Step 9 - Generate Feature Test for RegisterController
In the terminal run
```
php artisan make:test Auth/RegisterControllerTest
```

### Step 10 - Add tests to RegisterController
In the tests/Feature/Auth/RegisterControllerTest.php add tests
for validations and success register
```php
class RegisterControllerTest extends TestCase
{    
    public function testRegisterSuccessfully()
    {
        $register = [
            'name' => 'UserTest',
            'email' => 'user@test.com',
            'password' => 'testpass',
            'password_confirmation' => 'testpass'
        ];

        $this->json('POST', 'api/register', $register)
            ->assertStatus(201)
            ->assertJsonStructure([
                'token',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
                ]                
            ]);
    }

    public function testRequireNameEmailAndPassword()
    {
        $this->json('POST', 'api/register')
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => ['The name field is required.'],
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],                
                ]
            ]);
    }

    public function testRequirePasswordConfirmation()
    {
        $register = [
            'name' => 'User',
            'email' => 'user@test.com',
            'password' => 'userpass'
        ];

        $this->json('POST', 'api/register', $register)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' => ['The password confirmation does not match.']
                ]
            ]);
    }
}
```

### Step 11 - Run tests
In the terminal run
```
php artisan test
```
