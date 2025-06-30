# Gateway Service

Acts as the API Gateway for all microservices.

## Setup
```bash
composer install
php artisan serve --port=8080
```

## Purpose
- Single entry point for all client requests
- Routes requests to the correct microservice

## How to Use

**Send all requests to the gateway instead of directly to each service.**

### Example Requests

- Get all users:
  ```http
  GET http://localhost:8080/api/v1/users
  ```
- Create a new trainee:
  ```http
  POST http://localhost:8080/api/v1/trainees
  Content-Type: application/json
  {
    "first_name": "Jane",
    "last_name": "Doe",
    ...
  }
  ```
- Get all programs:
  ```http
  GET http://localhost:8080/api/v1/programs
  ```

**The gateway will automatically route your request to the correct service using service discovery.**
