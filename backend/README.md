## Installation Process

This is the backend project made in Laravel, it serves the frontend via API, some key features are:

- Authenticate user by receiving the user information and returning a JWT token.
- Handle all posts creation.
- Handle all comments creation.
- Handle all search queries through posts.

## Steps

- Make sure you have installed [Artisan](https://getcomposer.org/) and [MySQL](https://www.mysql.com/)
- Run `composer install`
- Make sure to copy the .env file
``` 
cp .env.example .env 
```
- Put your `MySQL` information in .env file. Example:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```
- Run migrations
```
php artisan migrate
```
- Generate secret for JWT token
```
php artisan jwt:secret
```

## Communication with the Frontend

In order to make work the project you need to communicate both projects.

- Run the server
```
php artisan serve
```
