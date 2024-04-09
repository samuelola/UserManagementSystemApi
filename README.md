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
1.Test Registration for all empty fields.
2.Test Registration for name field less than three.
 -Test Registration for password that do not contain mixed characters.
 -Test Registration for password that is the same with the confirm password.
 -Test Registration for Admin (Role_id=1) with a unique email.

 #### For Ubuntu:

1. Update your existing list of packages:
   sudo apt update
2. Install required dependencies:
   sudo apt install apt-transport-https ca-certificates curl software-properties-common
3. Add the Docker repository to APT sources:
   curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
   sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"
4. Update your package database with the Docker packages from the newly added repo:
   sudo apt update
5. Install Docker:
   sudo apt install docker-ce
6. Verify that Docker is installed correctly:
   sudo systemctl status docker

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
