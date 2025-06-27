# Advisor Service API Documentation

## Base URL
```
http://localhost:8005/api/v1
```

## Authentication
All endpoints require a `Service-Key` header for inter-service communication.

## Endpoints

### 1. Get All Advisors
```http
GET /api/v1/advisors
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "first_name": "Osama",
            "last_name": "Ahmed",
            "email": "osama.ahmed@example.com",
            "phone": "+970591234567",
            "education": "PhD in Computer Science",
            "address": "123 Main Street",
            "city": "Gaza",
            "language": "English",
            "is_approved": true,
            "created_at": "2024-01-15T10:30:00Z",
            "updated_at": "2024-01-15T10:30:00Z"
        },
        {
            "id": 2,
            "first_name": "Shatha",
            "last_name": "Mohammed",
            "email": "shatha.mohammed@example.com",
            "phone": "+970592345678",
            "education": "MSc in Software Engineering",
            "address": "456 Oak Avenue",
            "city": "Ramallah",
            "language": "English",
            "is_approved": true,
            "created_at": "2024-01-16T14:20:00Z",
            "updated_at": "2024-01-16T14:20:00Z"
        }
    ]
}
```

### 2. Create Advisor
```http
POST /api/v1/advisors
Content-Type: application/json

{
    "first_name": "Abeer",
    "last_name": "Hassan",
    "email": "abeer.hassan@example.com",
    "phone": "+970593456789",
    "education": "PhD in Information Technology",
    "address": "789 Pine Street",
    "city": "Nablus",
    "language": "English",
    "password": "securepassword123",
    "is_approved": false
}
```

**Response:**
```json
{
    "success": true,
    "message": "Advisor created successfully",
    "data": {
        "id": 3,
        "first_name": "Abeer",
        "last_name": "Hassan",
        "email": "abeer.hassan@example.com",
        "phone": "+970593456789",
        "education": "PhD in Information Technology",
        "address": "789 Pine Street",
        "city": "Nablus",
        "language": "English",
        "is_approved": false,
        "created_at": "2024-01-17T09:15:00Z",
        "updated_at": "2024-01-17T09:15:00Z"
    }
}
```

### 3. Get Advisor by ID
```http
GET /api/v1/advisors/1
```

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "first_name": "Osama",
        "last_name": "Ahmed",
        "email": "osama.ahmed@example.com",
        "phone": "+970591234567",
        "education": "PhD in Computer Science",
        "address": "123 Main Street",
        "city": "Gaza",
        "language": "English",
        "is_approved": true,
        "created_at": "2024-01-15T10:30:00Z",
        "updated_at": "2024-01-15T10:30:00Z"
    }
}
```

### 4. Update Advisor
```http
PUT /api/v1/advisors/1
Content-Type: application/json

{
    "first_name": "Osama",
    "last_name": "Ahmed",
    "phone": "+970591234568",
    "education": "PhD in Computer Science and Engineering",
    "is_approved": true
}
```

**Response:**
```json
{
    "success": true,
    "message": "Advisor updated successfully",
    "data": {
        "id": 1,
        "first_name": "Osama",
        "last_name": "Ahmed",
        "email": "osama.ahmed@example.com",
        "phone": "+970591234568",
        "education": "PhD in Computer Science and Engineering",
        "address": "123 Main Street",
        "city": "Gaza",
        "language": "English",
        "is_approved": true,
        "created_at": "2024-01-15T10:30:00Z",
        "updated_at": "2024-01-17T11:45:00Z"
    }
}
```

### 5. Delete Advisor
```http
DELETE /api/v1/advisors/3
```

**Response:**
```json
{
    "success": true,
    "message": "Advisor deleted successfully"
}
```

### 6. Get Approved Advisors
```http
GET /api/v1/advisors/approved/list
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "first_name": "Osama",
            "last_name": "Ahmed",
            "email": "osama.ahmed@example.com",
            "phone": "+970591234568",
            "education": "PhD in Computer Science and Engineering",
            "address": "123 Main Street",
            "city": "Gaza",
            "language": "English",
            "is_approved": true
        },
        {
            "id": 2,
            "first_name": "Shatha",
            "last_name": "Mohammed",
            "email": "shatha.mohammed@example.com",
            "phone": "+970592345678",
            "education": "MSc in Software Engineering",
            "address": "456 Oak Avenue",
            "city": "Ramallah",
            "language": "English",
            "is_approved": true
        }
    ]
}
```

### 7. Get Advisors by Language
```http
GET /api/v1/advisors/language/English
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "first_name": "Osama",
            "last_name": "Ahmed",
            "email": "osama.ahmed@example.com",
            "language": "English",
            "is_approved": true
        },
        {
            "id": 2,
            "first_name": "Shatha",
            "last_name": "Mohammed",
            "email": "shatha.mohammed@example.com",
            "language": "English",
            "is_approved": true
        }
    ]
}
```

### 8. Verify Advisor (Inter-Service)
```http
GET /api/v1/advisors/1/verify
Service-Key: {service_secret}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "first_name": "Osama",
        "last_name": "Ahmed",
        "email": "osama.ahmed@example.com",
        "is_approved": true
    }
}
```

## Error Responses

### 404 - Advisor Not Found
```json
{
    "success": false,
    "message": "Advisor not found"
}
```

### 422 - Validation Error
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": ["The email field is required."],
        "phone": ["The phone field is required."]
    }
}
```

### 500 - Server Error
```json
{
    "success": false,
    "message": "Internal server error"
}
``` 