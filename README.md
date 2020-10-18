# Web Push Notifications Demo

Powered by Laravel, Livewire and Tailwind

## Requirements

PHP 7.3, Composer

Check out 
[Laravel docs](https://laravel.com/docs/8.x/installation#server-requirements)
and  (optional) npm

## Installation

In project folder run:
- `cp .env.example .env`
- `composer install`
- `php artisan key:generate`
- `php artisan webpush:vapid` - Generates the VAPID keys required for browser authentication.
- update .env file with your DB connection credentials ([help](https://laravel.com/docs/8.x/installation))
    
    if u use sqlite it's as easy as setting
    ```
      DB_CONNECTION=sqlite
      DB_DATABASE=/absolute/path/to/database.sqlite
    ```
- `php artisan migrate --seed`
- (optional) `npm install` and `npm run dev`

## Running

Laravel comes with PHP's built-in development server. 

So all you need is to run `php artisan serve` (use `--port` option if u have port 8000 busy).

This command will start a development server at http://localhost:8000

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://github.com/c00p3r/webpush-demo/blob/main/LICENSE).
