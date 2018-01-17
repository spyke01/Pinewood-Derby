### Overview
This app was created to allow us to run a Pinewood Derby using our track setup and migrate away from Excel sheets. THis app was put together very quickly and as such there is a lot of room for improvements.

### Features
* Contestant Management
* Den Management
* Group Management
* Heat Management
* Run Management
* User Management
* Permission and Role Management
* Leaderboard and Leaderboard by Group
* Gravatar for Users
* Picture upload for contestants, cars, roups, and dens
* Public Account Registration

### Notes About This System
At our pack we have been using a DOS application to generate heats and this app was designed to work with an import of that heat list. The app has an example import template that you can use but in future versions we would like to get the algorithm into the app itself.

### Attributions
This app was created using ideas from [https://github.com/nilbus/pinewood-derby](PinewoodDerby) by nilbus. We simply needed a PHP version and some additional features as well as less track integration. 

### Requirements
* PHP 7.1  
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension 

### Installation
* save the .env.example to .env
* update the .env file with your db credentials

```bash
composer install
php artisan key:generate
php artisan storage:link
php artisan migrate
php artisan db:seed
```

You can now log into the app using the gollowing login:  

**Username**: admin  
**Password**: admin