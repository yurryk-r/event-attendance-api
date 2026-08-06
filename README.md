# Event Attendance API

REST API for managing events and participants, built with Laravel.

## Features

- User registration and login
- Token authentication with Laravel Sanctum
- CRUD operations for events
- CRUD operations for participants
- Event participant management
- JSON API responses
- Request validation

## Requirements

- PHP 8.4+
- Composer
- MySQL
- Laravel

## Installation

```bash
git clone https://github.com/yurryk-r/event-attendance-api.git
cd event-attendance-api

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate

php artisan serve
```

## API Testing with Postman

The repository includes a ready-to-use Postman collection.

Import:

- `docs/postman/EventAttendance.postman_collection.json`
- `docs/postman/EventAttendance.postman_environment.json`

After importing:

1. Select the Postman environment.
2. Run the **Login** request.
3. The JWT token is automatically saved to the `token` environment variable.
4. All protected requests use the token automatically.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
