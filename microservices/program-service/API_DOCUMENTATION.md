# Program Service API Documentation

## Accessing the API
All endpoints should be accessed via the API Gateway:
- Base URL: `http://localhost:8080/programs`

## Authentication
All endpoints require a `Service-Key` header for inter-service communication.

## Endpoints

### 1. Get All Programs
- **GET** `/api/v1/programs`

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Ahmed's Development Program",
            "type": "paid",
            "hours": "120",
            "start_date": "2024-02-01",
            "end_date": "2024-05-01",
            "field_id": 1,
            "advisor_id": 1,
            "duration": "months",
            "level": "intermediate",
            "language": "English",
            "description": "Comprehensive software development training program",
            "price": 500,
            "number": 25,
            "image": "program_image.jpg",
            "created_at": "2024-01-15T10:30:00Z"
        },
        {
            "id": 2,
            "name": "Shatha's Web Development Bootcamp",
            "type": "free",
            "hours": "80",
            "start_date": "2024-02-15",
            "end_date": "2024-04-10",
            "field_id": 2,
            "advisor_id": 2,
            "duration": "weeks",
            "level": "beginner",
            "language": "English",
            "description": "Intensive web development training for beginners",
            "price": 0,
            "number": 15,
            "image": "web_bootcamp.jpg",
            "created_at": "2024-01-16T14:20:00Z"
        }
    ]
}
```

### 2. Create Program
- **POST** `/api/v1/programs`
- **Body:**
  ```json
  {
    "name": "Advanced Web Development 2",
    "type": "paid",
    "hours": "120",
    "start_date": "2024-01-15",
    "end_date": "2024-04-15",
    "field_id": 1,
    "advisor_id": 1,
    "duration": "months",
    "level": "intermediate",
    "language": "English",
    "description": "Comprehensive web development course",
    "price": 999,
    "number": 25,
    "image": "program-image.jpg"
  }
  ```

**Response:**
```json
{
    "success": true,
    "message": "Program created successfully",
    "data": {
        "id": 3,
        "name": "Abeer's Data Science Program",
        "type": "paid",
        "hours": "160",
        "start_date": "2024-03-01",
        "end_date": "2024-06-20",
        "field_id": 3,
        "advisor_id": 3,
        "duration": "months",
        "level": "advanced",
        "language": "English",
        "description": "Advanced data science and machine learning training",
        "price": 800,
        "number": 20,
        "image": "data_science.jpg",
        "created_at": "2024-01-17T09:15:00Z"
    }
}
```

### 3. Get Program by ID
- **GET** `/api/v1/programs/{id}`

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Ahmed's Development Program",
        "type": "paid",
        "hours": "120",
        "start_date": "2024-02-01",
        "end_date": "2024-05-01",
        "field_id": 1,
        "advisor_id": 1,
        "duration": "months",
        "level": "intermediate",
        "language": "English",
        "description": "Comprehensive software development training program",
        "price": 500,
        "number": 25,
        "image": "program_image.jpg",
        "field": {
            "id": 1,
            "name": "Software Development",
            "description": "Programming and software engineering"
        },
        "advisor": {
            "id": 1,
            "first_name": "Osama",
            "last_name": "Ahmed",
            "full_name": "Osama Ahmed"
        },
        "created_at": "2024-01-15T10:30:00Z"
    }
}
```

### 4. Update Program
- **PUT** `/api/v1/programs/{id}`

**Response:**
```json
{
    "success": true,
    "message": "Program updated successfully",
    "data": {
        "id": 1,
        "name": "Ahmed's Advanced Development Program",
        "type": "paid",
        "hours": "140",
        "start_date": "2024-02-01",
        "end_date": "2024-05-01",
        "field_id": 1,
        "advisor_id": 1,
        "duration": "months",
        "level": "intermediate",
        "language": "English",
        "description": "Updated comprehensive software development training program",
        "price": 750,
        "number": 25,
        "image": "program_image.jpg",
        "created_at": "2024-01-15T10:30:00Z",
        "updated_at": "2024-01-17T11:45:00Z"
    }
}
```

### 5. Delete Program
- **DELETE** `/api/v1/programs/{id}`

**Response:**
```json
{
    "success": true,
    "message": "Program deleted successfully"
}
```

### 6. Get Programs by Advisor
```http
GET /api/v1/programs/advisor/1
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Ahmed's Advanced Development Program",
            "type": "paid",
            "level": "intermediate",
            "language": "English",
            "price": 750,
            "advisor": {
                "id": 1,
                "full_name": "Osama Ahmed"
            }
        }
    ]
}
```

### 7. Get Programs by Field
```http
GET /api/v1/programs/field/1
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Ahmed's Advanced Development Program",
            "type": "paid",
            "level": "intermediate",
            "language": "English",
            "price": 750,
            "field": {
                "id": 1,
                "name": "Software Development"
            }
        }
    ]
}
```

### 8. Get Programs by Language
```http
GET /api/v1/programs/language/English
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Ahmed's Advanced Development Program",
            "language": "English",
            "level": "intermediate"
        },
        {
            "id": 2,
            "name": "Shatha's Web Development Bootcamp",
            "language": "English",
            "level": "beginner"
        },
        {
            "id": 3,
            "name": "Abeer's Data Science Program",
            "language": "English",
            "level": "advanced"
        }
    ]
}
```

### 9. Get Programs by Level
```http
GET /api/v1/programs/level/intermediate
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Ahmed's Advanced Development Program",
            "level": "intermediate",
            "language": "English",
            "price": 750
        }
    ]
}
```

### 10. Get Programs by Type
```http
GET /api/v1/programs/type/paid
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Ahmed's Advanced Development Program",
            "type": "paid",
            "price": 750
        },
        {
            "id": 3,
            "name": "Abeer's Data Science Program",
            "type": "paid",
            "price": 800
        }
    ]
}
```

### 11. Verify Program (Inter-Service)
```http
GET /api/v1/programs/1/verify
Service-Key: {service_secret}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Ahmed's Advanced Development Program",
        "advisor_id": 1,
        "field_id": 1,
        "status": "active"
    }
}
```

## Error Responses

### 404 - Program Not Found
```json
{
    "success": false,
    "message": "Program not found"
}
```

### 422 - Validation Error
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "name": ["The name field is required."],
        "advisor_id": ["The advisor id field is required."],
        "field_id": ["The field id field is required."],
        "end_date": ["The end date must be a date after start date."]
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

## Program Types
- `paid` - Programs with a price
- `free` - Free programs

## Program Levels
- `beginner` - For beginners
- `intermediate` - For intermediate learners
- `advanced` - For advanced learners

## Program Languages
- `English` - English language programs
- `Arabic` - Arabic language programs
- `French` - French language programs

## Duration Types
- `weeks` - Duration in weeks
- `months` - Duration in months

## Testing with Docker & Postman
- Make sure Docker Desktop is running and all services are up (`docker-compose up -d`).
- Use the provided Postman collection and set `gateway_url` to `http://localhost:8080`.
- All requests should go through the gateway, not direct service ports. 