# Laravel-API Integration with JWT Authentication System

## Install laravel
Before creating this project, make sure that your local machine has PHP and Composer installed.

laravel new version 11 is just arrived. So I used here laravel 10. I will create a fresh laravel app.
````
composer create-project laravel/laravel:^10.0 laravel-api-jwt
````
Once the project has been created, start Laravel's local development server using Laravel Artisan's serve command:
````
laravel-api-jwt
 
php artisan serve
````
## Setup Database
By default, your application's `.env` configuration file specifies that Laravel will be interacting with a MySQL database and will access the database at `127.0.0.1`.
````
DB_DATABASE=laravel-api-jwt
````
Now you have to  create a database by this name `laravel-api-jwt` into your local machine `xampp` server. 
Once you have configured your `MySQL` database, you may run your application's database migrations, which will create your application's database tables.
````
php artisan migrate
````

Then Complete this project Step by Step in the Below:

## Project Step by Step

- [JWT Authentication Setup](./resources/txt_files/1__JWT_Authentication_Setup.txt)
- [Create Register API with full Validated](./resources/txt_files/2__Create_Register_API_with_full_Validated.txt)
- [Create a Register View with full Validated Form](./resources/txt_files/3__Create_Register_View_with_full_validated_form.txt)
- [Integrate Register API to Register Form](./resources/txt_files/4_Integrate_Register_API_to_register_form.txt)








