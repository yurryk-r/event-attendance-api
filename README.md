# Event Attendance API

REST API for managing events and participants, built with Laravel.

## Features

* User registration and login
* Token authentication with Laravel Sanctum
* CRUD operations for events
* CRUD operations for participants
* Event participant management
* User and role management
* JSON API responses
* Request validation
* OpenAPI / Swagger API documentation

## Roles & Permissions

The API uses role-based access control with four access levels: Guest, User, Manager and Admin.

See the complete [Roles & Permissions](docs/ROLES.md) documentation.

## Requirements

* PHP 8.4+
* Composer
* MySQL
* Laravel

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

## API Documentation

The API is documented using **OpenAPI / Swagger** with **L5-Swagger**.

After starting the development server, open:

**http://localhost:8000/api/documentation**

The Swagger documentation covers all available API endpoints, including:

* **Authentication**

  * Login
  * Registration
  * Logout
* **Events**

  * Create, read, update and delete events
  * Full and partial updates
* **Event Participants**

  * List participants assigned to an event
  * Assign participants to events
  * Remove participants from events
* **Participants**

  * Create, read, update and delete participants
  * Full and partial updates
* **Users**

  * List users
  * Change user roles
  * Delete users

The documentation includes:

* Request and response schemas
* Validation requirements
* HTTP response codes
* Laravel Sanctum Bearer token authentication
* Authorization requirements for protected endpoints

### Regenerating Swagger Documentation

After changing OpenAPI annotations, regenerate the API documentation with:

```bash
php artisan l5-swagger:generate
```

Normally, `php artisan optimize:clear` is not required before regenerating the documentation. It is only necessary if cached configuration or other Laravel caches cause problems.

## API Testing with Postman

The repository includes a ready-to-use Postman collection.

Import:

* `docs/postman/EventAttendance.postman_collection.json`
* `docs/postman/EventAttendance.postman_environment.json`

After importing:

1. Select the Postman environment.
2. Run the **Login** request.
3. The Sanctum token is automatically saved to the `token` environment variable.
4. All protected requests use the token automatically.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
