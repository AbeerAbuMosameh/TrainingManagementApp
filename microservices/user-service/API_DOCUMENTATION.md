# User Service API Documentation

## Accessing the API
All endpoints should be accessed via the API Gateway:
- Base URL: `http://localhost:8080/users`

## Authentication
Uses Laravel Sanctum for token-based authentication.

## Endpoints

### Register User
- **POST** `/api/v1/auth/register`
- **Body:**
  ```json
  {
    "name": "Abeer Trainee",
    "email": "abeermosameh12333@gmail.com",
    "password": "password123",
    "password_confirmation": "password123",
    "level": 3
  }
  ```

### Login User
- **POST** `/api/v1/auth/login`
- **Body:**
  ```json
  {
    "email": "abeer@gmail.com",
    "password": "password123"
  }
  ```

### Logout User
```http
POST /api/v1/auth/logout
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "message": "Logged out successfully"
}
```

### Get User Profile
```http
GET /api/v1/auth/profile
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Ahmed Ali",
        "email": "ahmed.ali@example.com",
        "level": 3,
        "created_at": "2024-01-15T08:30:00Z",
        "updated_at": "2024-01-15T08:30:00Z"
    }
}
```

### Update User Profile
```http
PUT /api/v1/auth/profile
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "Ahmed Ali Updated",
    "email": "ahmed.updated@example.com",
    "level": 2
}
```

**Response:**
```json
{
    "success": true,
    "message": "Profile updated successfully",
    "data": {
        "id": 1,
        "name": "Ahmed Ali Updated",
        "email": "ahmed.updated@example.com",
        "level": 2
    }
}
```

### Change Password
```http
POST /api/v1/auth/change-password
Authorization: Bearer {token}
Content-Type: application/json

{
    "current_password": "password123",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Password changed successfully"
}
```

### Get User by ID (Inter-Service)
- **GET** `/api/v1/users/{id}`
- **Headers:**
  - `Service-Key: SERVICE_SECRET_KEY_2024`

### Get User by Email (Inter-Service)
- **GET** `/api/v1/users/email/{email}`
- **Headers:**
  - `Service-Key: SERVICE_SECRET_KEY_2024`

## Testing with Docker & Postman
- Make sure Docker Desktop is running and all services are up (`docker-compose up -d`).
- Use the provided Postman collection and set `gateway_url` to `http://localhost:8080`.
- All requests should go through the gateway, not direct service ports.

## Error Responses

### 401 - Unauthorized
```json
{
    "success": false,
    "message": "Unauthenticated"
}
```

### 422 - Validation Error
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": ["The email field is required."],
        "password": ["The password field is required."]
    }
}
```

### 404 - User Not Found
```json
{
    "success": false,
    "message": "User not found"
}
``` 