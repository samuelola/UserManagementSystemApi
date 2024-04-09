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

### Step 1 - Setup instructions for the project.
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

## Tests

 ## Tests for registration:
1. Test Registration for all empty fields.
2. Test Registration for name field less than three.
3. Test Registration for password that do not contain mixed characters.
4. Test Registration for password that is the same with the confirm password.
5. Test Registration for Admin (Role_id=1) with a unique email.


### Step 10 - Add tests to RegisterController
In the tests/Feature/Auth/RegisterControllerTest.php add tests
for validations and success register
```
```

### Step 11 - Run tests
In the terminal run
```
php artisan test
```
