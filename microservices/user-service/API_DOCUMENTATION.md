# User Service - API Documentation

This document provides detailed API specifications for the User Service in the Training Management System.

## API Response Format

All APIs follow a standardized response format:

### Success Response
```json
{
  "status": true,
  "message": "Operation completed successfully",
  "data": {
    // Response data
  }
}
```

### Error Response
```json
{
  "status": false,
  "message": "Error description",
  "errors": {
    // Validation errors (if any)
  }
}
```

---

## Authentication API

### 1. User Registration

**Request**
```
POST /v1/api/register HTTP/1.1
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "level": 3
}
```

**Response**
```
HTTP/1.1 201 Created
Content-Type: application/json

{
  "status": true,
  "message": "User registered successfully",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "level": 3,
      "role": "trainee"
    },
    "token": "1|abc123def456...",
    "token_type": "Bearer"
  }
}
```

### 2. User Login

**Request**
```
POST /v1/api/login HTTP/1.1
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response**
```
HTTP/1.1 200 OK
Content-Type: application/json

{
  "status": true,
  "message": "User logged in successfully",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "level": 3,
      "role": "trainee"
    },
    "token": "1|abc123def456...",
    "token_type": "Bearer"
  }
}
```

### 3. User Logout

**Request**
```
POST /v1/api/logout HTTP/1.1
Authorization: Bearer {token}
```

**Response**
```
HTTP/1.1 200 OK
Content-Type: application/json

{
  "status": true,
  "message": "User logged out successfully"
}
```

### 4. Get User Profile

**Request**
```
GET /v1/api/profile HTTP/1.1
Authorization: Bearer {token}
```

**Response**
```
HTTP/1.1 200 OK
Content-Type: application/json

{
  "status": true,
  "message": "User profile retrieved successfully",
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "level": 3,
    "role": "trainee",
    "email_verified_at": "2025-01-15T10:30:00.000000Z",
    "created_at": "2025-01-15T10:30:00.000000Z"
  }
}
```

### 5. Update User Profile

**Request**
```
PUT /v1/api/profile HTTP/1.1
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "John Smith",
  "email": "johnsmith@example.com"
}
```

**Response**
```
HTTP/1.1 200 OK
Content-Type: application/json

{
  "status": true,
  "message": "User profile updated successfully",
  "data": {
    "id": 1,
    "name": "John Smith",
    "email": "johnsmith@example.com",
    "level": 3,
    "role": "trainee"
  }
}
```

### 6. Change Password

**Request**
```
POST /v1/api/change-password HTTP/1.1
Authorization: Bearer {token}
Content-Type: application/json

{
  "current_password": "password123",
  "password": "newpassword123",
  "password_confirmation": "newpassword123"
}
```

**Response**
```
HTTP/1.1 200 OK
Content-Type: application/json

{
  "status": true,
  "message": "Password changed successfully"
}
```

---

## User Management API (Admin Only)

### 1. List All Users

**Request**
```
GET /v1/api/users HTTP/1.1
Authorization: Bearer {admin_token}
```

**Response**
```
HTTP/1.1 200 OK
Content-Type: application/json

{
  "status": true,
  "message": "Users retrieved successfully",
  "data": [
    {
      "id": 1,
      "name": "Tasneem Admin",
      "email": "admin@training.com",
      "level": 1,
      "created_at": "2025-01-15T10:30:00.000000Z"
    },
    {
      "id": 2,
      "name": "Osama Advisor",
      "email": "osama@training.com",
      "level": 2,
      "created_at": "2025-01-15T11:00:00.000000Z"
    },
    {
      "id": 3,
      "name": "Shatha Trainee",
      "email": "shatha@training.com",
      "level": 3,
      "created_at": "2025-01-15T11:30:00.000000Z"
    }
  ]
}
```

### 2. Delete User

**Request**
```
DELETE /v1/api/users/{id} HTTP/1.1
Authorization: Bearer {admin_token}
```

**Response**
```
HTTP/1.1 200 OK
Content-Type: application/json

{
  "status": true,
  "message": "User deleted successfully"
}
```

---

## Inter-Service Communication API

### 1. Get User by Email

**Request**
```
GET /v1/api/users/email/{email} HTTP/1.1
Service-Key: SERVICE_SECRET
```

**Response**
```
HTTP/1.1 200 OK
Content-Type: application/json

{
  "status": true,
  "message": "User found",
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "level": 3,
    "role": "trainee"
  }
}
```

### 2. Get User by ID

**Request**
```
GET /v1/api/users/{id} HTTP/1.1
Service-Key: SERVICE_SECRET
```

**Response**
```
HTTP/1.1 200 OK
Content-Type: application/json

{
  "status": true,
  "message": "User found",
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "level": 3,
    "role": "trainee"
  }
}
```

---

## User Levels and Roles

The system supports three user levels:

| Level | Role | Description |
|-------|------|-------------|
| 1 | admin | System administrator with full access |
| 2 | advisor | Training advisor with program management access |
| 3 | trainee | Training participant with limited access |

---

## Error Handling

### Validation Error Example
```
HTTP/1.1 422 Unprocessable Entity
Content-Type: application/json

{
  "status": false,
  "message": "Validation Error.",
  "errors": {
    "email": [
      "The email field is required."
    ],
    "password": [
      "The password must be at least 8 characters."
    ]
  }
}
```

### Authentication Error Example
```
HTTP/1.1 401 Unauthorized
Content-Type: application/json

{
  "status": false,
  "message": "Invalid credentials"
}
```

### Authorization Error Example
```
HTTP/1.1 403 Forbidden
Content-Type: application/json

{
  "status": false,
  "message": "Unauthorized"
}
```

### Not Found Error Example
```
HTTP/1.1 404 Not Found
Content-Type: application/json

{
  "status": false,
  "message": "User not found"
}
```

---

## Authentication

### Public Endpoints
- `POST /v1/api/register` - User registration
- `POST /v1/api/login` - User login

### Protected Endpoints
All other endpoints require authentication using Bearer tokens:

```
Authorization: Bearer {your-jwt-token}
```

### Service Authentication
Inter-service communication requires the Service-Key header:

```
Service-Key: {service-secret-key}
```

---

## Sample Users

The system comes with pre-seeded users for testing:

### Admin Users
- **Email**: admin@training.com
- **Password**: admin123
- **Role**: Admin (Level 1)

### Advisor Users
- **Email**: osama@training.com
- **Password**: advisor123
- **Role**: Advisor (Level 2)
- **Email**: ahmed.advisor@training.com
- **Password**: advisor123
- **Role**: Advisor (Level 2)

### Trainee Users
- **Email**: shatha@training.com
- **Password**: trainee123
- **Role**: Trainee (Level 3)
- **Email**: fatima@training.com
- **Password**: trainee123
- **Role**: Trainee (Level 3)
- **Email**: mohammed@training.com
- **Password**: trainee123
- **Role**: Trainee (Level 3)

---

## Rate Limiting

API endpoints are rate-limited to prevent abuse:
- 60 requests per minute per IP address
- 1000 requests per hour per authenticated user

---

## Versioning

All APIs are versioned using the `/v1/api/` prefix. Future versions will use `/v2/api/`, `/v3/api/`, etc.

---

## Support

For API support and questions, please contact the development team or refer to the main README.md file for setup instructions. 