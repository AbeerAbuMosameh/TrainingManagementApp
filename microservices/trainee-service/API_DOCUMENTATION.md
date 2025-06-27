# Trainee Service API Documentation

## Base URL
```
http://localhost:8004/api/v1
```

## Authentication
All endpoints require a `Service-Key` header for inter-service communication.

## Endpoints

### 1. Get All Trainees
```http
GET /api/v1/trainees
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "first_name": "Ahmed",
            "last_name": "Ali",
            "email": "ahmed.ali@example.com",
            "phone": "+970594567890",
            "date_of_birth": "1995-03-15",
            "address": "321 Elm Street",
            "city": "Gaza",
            "education_level": "Bachelor's Degree",
            "field_of_study": "Computer Science",
            "university": "Islamic University of Gaza",
            "graduation_year": 2018
        },
        {
            "id": 2,
            "first_name": "Shatha",
            "last_name": "Khalil",
            "email": "shatha.khalil@example.com",
            "phone": "+970595678901",
            "date_of_birth": "1998-07-22",
            "address": "654 Maple Drive",
            "city": "Ramallah",
            "education_level": "Master's Degree",
            "field_of_study": "Software Engineering",
            "university": "Birzeit University",
            "graduation_year": 2021
        }
    ]
}
```

### 2. Create Trainee
```http
POST /api/v1/trainees
Content-Type: application/json

{
    "first_name": "Abeer",
    "last_name": "Saleh",
    "email": "abeer.saleh@example.com",
    "phone": "+970596789012",
    "date_of_birth": "1996-11-08",
    "address": "987 Cedar Lane",
    "city": "Nablus",
    "education_level": "Bachelor's Degree",
    "field_of_study": "Information Technology",
    "university": "An-Najah National University",
    "graduation_year": 2019
}
```

**Response:**
```json
{
    "success": true,
    "message": "Trainee created successfully",
    "data": {
        "id": 3,
        "first_name": "Abeer",
        "last_name": "Saleh",
        "email": "abeer.saleh@example.com",
        "phone": "+970596789012",
        "date_of_birth": "1996-11-08",
        "address": "987 Cedar Lane",
        "city": "Nablus",
        "education_level": "Bachelor's Degree",
        "field_of_study": "Information Technology",
        "university": "An-Najah National University",
        "graduation_year": 2019,
        "created_at": "2024-01-17T10:20:00Z",
        "updated_at": "2024-01-17T10:20:00Z"
    }
}
```

### 3. Get Trainee by ID
```http
GET /api/v1/trainees/1
```

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "first_name": "Ahmed",
        "last_name": "Ali",
        "email": "ahmed.ali@example.com",
        "phone": "+970594567890",
        "date_of_birth": "1995-03-15",
        "address": "321 Elm Street",
        "city": "Gaza",
        "education_level": "Bachelor's Degree",
        "field_of_study": "Computer Science",
        "university": "Islamic University of Gaza",
        "graduation_year": 2018,
        "created_at": "2024-01-15T08:30:00Z",
        "updated_at": "2024-01-15T08:30:00Z"
    }
}
```

### 4. Update Trainee
```http
PUT /api/v1/trainees/1
Content-Type: application/json

{
    "first_name": "Ahmed",
    "last_name": "Ali",
    "phone": "+970594567891",
    "address": "321 Elm Street, Apt 5",
    "education_level": "Master's Degree"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Trainee updated successfully",
    "data": {
        "id": 1,
        "first_name": "Ahmed",
        "last_name": "Ali",
        "email": "ahmed.ali@example.com",
        "phone": "+970594567891",
        "date_of_birth": "1995-03-15",
        "address": "321 Elm Street, Apt 5",
        "city": "Gaza",
        "education_level": "Master's Degree",
        "field_of_study": "Computer Science",
        "university": "Islamic University of Gaza",
        "graduation_year": 2018,
        "created_at": "2024-01-15T08:30:00Z",
        "updated_at": "2024-01-17T14:30:00Z"
    }
}
```

### 5. Delete Trainee
```http
DELETE /api/v1/trainees/3
```

**Response:**
```json
{
    "success": true,
    "message": "Trainee deleted successfully"
}
```

### 6. Get Trainees by City
```http
GET /api/v1/trainees/city/Gaza
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "first_name": "Ahmed",
            "last_name": "Ali",
            "email": "ahmed.ali@example.com",
            "city": "Gaza",
            "education_level": "Master's Degree",
            "field_of_study": "Computer Science"
        }
    ]
}
```

### 7. Get Trainees by Field
```http
GET /api/v1/trainees/field/Computer Science
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "first_name": "Ahmed",
            "last_name": "Ali",
            "email": "ahmed.ali@example.com",
            "field_of_study": "Computer Science",
            "university": "Islamic University of Gaza"
        }
    ]
}
```

### 8. Verify Trainee (Inter-Service)
```http
GET /api/v1/trainees/1/verify
Service-Key: {service_secret}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "first_name": "Ahmed",
        "last_name": "Ali",
        "email": "ahmed.ali@example.com"
    }
}
```

## Error Responses

### 404 - Trainee Not Found
```json
{
    "success": false,
    "message": "Trainee not found"
}
```

### 422 - Validation Error
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": ["The email field is required."],
        "phone": ["The phone field is required."],
        "date_of_birth": ["The date of birth field is required."]
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