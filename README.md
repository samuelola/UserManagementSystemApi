# Management System API - Step by Step
A User Management System API using Laravel. This API will be responsible for handling user profiles within an application, including operations such as creating, updating, viewing, and deleting users.

### Prerequisites
* Apache
* PHP
* Composer
* New Laravel App Installed
* Laravel Passport

### Initial notes
The project in this repository contains all the steps finalized

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
php artisan db:seed
```
### Step 3 - Create Laravel Personal Access Client
Run in terminal to generate client secret and client ID
```
php artisan passport:client --personal
```
### Step 4 - Run in terminal to start the application
```
php artisan serve
```
### Tests Cases

 #### Tests for Registration:
1. Test Registration for all empty fields.
2. Test Registration for name field less than three.
3. Test Registration for password that do not contain mixed characters.
4. Test Registration for password that is the same with the confirm password.
5. Test Registration for Admin with a unique email.
6. Test Registration for empty password field.
7. Test Registration for empty name field.

 #### Tests for Login:
1. Test Login with Invalid Email.
2. Test Login with Invalid Password.
3. Test Login with Invalid Email and Password.

 #### Tests for Users:
1. Test for retrieving users details as an Admin.
2. Test for an Authenticated user to create users.
3. Test for an Admin to create users.
4. Test for retrieving users as an authenticated user.
5. Test for User that is not Admin have permission to delete users.


### Step 6 - Run tests
In the terminal run
```
php artisan test
```
