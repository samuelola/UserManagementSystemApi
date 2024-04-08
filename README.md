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
Rename the env.example file to .env

To Start the application run in the terminal
```
php artisan serve
```

### Step 2 - Call new seeder
Adjust seeds/DatabaseSeeder.php to call users seed
```php
    public function run()
    {
        $this->call(UsersTableSeeder::class);
    }
```

### Step 3 - Configure SQLite for tests
In the config/database.php configure sqlite to work in memory
```
[...]
'connections' => [

    'sqlite' => [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
    ],
    
    ...
]
[...]
```

### Step 4 - Configure phpunit.xml
In the root dir of the project adjust phpunit.xml adding DB_CONNECTION
```
    <php>
        <env name="APP_ENV" value="testing"/>
        <env name="CACHE_DRIVER" value="array"/>
        <env name="SESSION_DRIVER" value="array"/>
        <env name="QUEUE_DRIVER" value="sync"/>
        <env name="DB_CONNECTION" value="sqlite"/>
    </php>
```

### Step 5 - Alter TestCase to prepare project to tests
In the tests/TestCase.php add commands necessary to prepare database for tests
```php
<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        Artisan::call('db:seed');
        Artisan::call('passport:install');        
    }
}

```

### Step 6 - Add script to run tests
In the composer.json, add script to run tests
```
   "scripts": {
        "test" : [
            "vendor/bin/phpunit"
        ]
    ... 
    },  
```

### Step 7 - Generate Feature Test for LoginController
In the terminal run
```
php artisan make:test Auth/LoginControllerTest
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
