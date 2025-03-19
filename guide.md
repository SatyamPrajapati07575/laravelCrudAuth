## installation command 
composer create-project --prefer-dist laravel/laravel laravel11 "11.*"

## Generate Application Key
php artisan key:generate


## Install Authentication (Register & Login)
composer require laravel/breeze

php artisan breeze:install blade

## Install Laravel UI (for authentication):
composer require laravel/ui

## Generate auth scaffolding (login, register, etc.):
php artisan ui bootstrap --auth

##  Set Correct Permissions for the Storage Directory
sudo chown -R www-data:www-data /var/www/html/laravel11/storage
sudo chmod -R 775 /var/www/html/laravel11/storage

## Create a model and migration for the user data:
php artisan make:model UserProfile -m

php artisan migrate

## Create the Controller
php artisan make:controller UserProfileController

## Create Migration for Adding Fields
php artisan make:migration add_fields_to_users_table --table=users

## Create a Custom Controller for Authentication
php artisan make:controller AuthController

## Update the User Model


## Create a Symbolic Link
php artisan storage:link
