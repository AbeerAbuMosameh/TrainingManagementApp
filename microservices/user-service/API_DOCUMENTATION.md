# User Service API Documentation

## Base URL
```
http://localhost:8003/api/v1
```

## Authentication
Uses Laravel Sanctum for token-based authentication.

## Endpoints

### 1. Register User
```http
POST /api/v1/auth/register
Content-Type: application/json

{
    "name": "Ahmed Ali",
    "email": "ahmed.ali@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "level": 3
}
```

**Response:**
```json
{
    "success": true,
    "message": "User registered successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "Ahmed Ali",
            "email": "ahmed.ali@example.com",
            "level": 3
        },
        "token": "1|abc123def456..."
    }
}
```

### 2. Login User
```http
POST /api/v1/auth/login
Content-Type: application/json

{
    "email": "ahmed.ali@example.com",
    "password": "password123"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "Ahmed Ali",
            "email": "ahmed.ali@example.com",
            "level": 3
        },
        "token": "2|xyz789uvw012..."
    }
}
```

### 3. Logout User
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

### 4. Get User Profile
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

### 5. Update User Profile
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

### 6. Change Password
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

### 7. Get User by Email (Inter-Service)
```http
GET /api/v1/users/email/ahmed.ali@example.com
Service-Key: {service_secret}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Ahmed Ali",
        "email": "ahmed.ali@example.com",
        "level": 3
    }
}
```

### 8. Get User by ID (Inter-Service)
```http
GET /api/v1/users/1
Service-Key: {service_secret}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Ahmed Ali",
        "email": "ahmed.ali@example.com",
        "level": 3
    }
}
```

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