# Laravel API Integration with JWT Authentication Token Using Jquery

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
- [Create validated Login API and generate JWT Token with response](./resources/txt_files/4__Create_Validated_Login_API_and_JWT_Token_.txt)
- [Integrate Login API in view, Store token in Local Storage](./resources/txt_files/5__Integrate_login_api_store_token_Local_storage.txt)
- [Create Log out API and send response](./resources/txt_files/6__create_logout_api.txt)
- [Integrate Log out API in Blade file](./resources/txt_files/7__Integrate_logout_API_in_view.txt)
- [Create Profile API and Integrate in Blade File](./resources/txt_files/8__Create_Profile_API_and_Integrate_in_View.txt)
- [Create Profile-Update API and Integrate in Blade File](./resources/txt_files/9__Create_Profile-update_API_and_Integrate_in_View.txt)
- [Create API for Email Verification, Use SMTP for send Mail, Routes setup for Mail Verification and Integrate in blade file](./resources/txt_files/10__Create_Email_verify_API_Use_SMTP_Mail_Verify.txt)
- [Create Refresh Token API and Integrate in Frontend](./resources/txt_files/11__Create_refresh_token_and_Integrate_in_blade.txt)
- [Create Forget-password API, send password reset token via mail](./resources/txt_files/12__Create_forget_pass_and_reset_pass_by_Mail.txt)
- [Integrate Forget-password API in Frontend](./resources/txt_files/13__Integrate_forget_password_api_in_frontend.txt)
- [Set Custom JWT Token Expiration Times in different way](./resources/txt_files/14__Set_Custom_JWT_Token_Time.txt)
- [Token expiration code, and auth redirect code](./resources/txt_files/15__Footer_Configuratin_for_auth_token_expires.txt)








