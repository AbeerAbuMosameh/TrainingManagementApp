# Field Service API Documentation

## Accessing the API
All endpoints should be accessed via the API Gateway:
- Base URL: `http://localhost:8080/fields`

## Endpoints

### 1. Get All Fields
```http
GET /api/v1/fields
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Software Development",
            "description": "Programming and software engineering",
            "category": "Technology",
            "created_at": "2024-01-15T10:30:00Z"
        },
        {
            "id": 2,
            "name": "Web Development",
            "description": "Frontend and backend web technologies",
            "category": "Technology",
            "created_at": "2024-01-16T14:20:00Z"
        },
        {
            "id": 3,
            "name": "Data Science",
            "description": "Machine learning and data analysis",
            "category": "Technology",
            "created_at": "2024-01-17T09:15:00Z"
        }
    ]
}
```

### 2. Create Field
```http
POST /api/v1/fields
Content-Type: application/json

{
    "name": "Web Development 2",
    "description": "Programming and web technologies",
    "is_active": true
}
```

**Response:**
```json
{
    "success": true,
    "message": "Field created successfully",
    "data": {
        "id": 4,
        "name": "Web Development 2",
        "description": "Programming and web technologies",
        "category": "Technology",
        "created_at": "2024-01-18T11:00:00Z"
    }
}
```

### 3. Get Field by ID
```http
GET /api/v1/fields/1
```

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Software Development",
        "description": "Programming and software engineering",
        "category": "Technology",
        "created_at": "2024-01-15T10:30:00Z"
    }
}
```

### 4. Update Field
```http
PUT /api/v1/fields/1
Content-Type: application/json

{
    "name": "Advanced Software Development",
    "description": "Advanced programming and software engineering concepts"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Field updated successfully",
    "data": {
        "id": 1,
        "name": "Advanced Software Development",
        "description": "Advanced programming and software engineering concepts",
        "category": "Technology",
        "created_at": "2024-01-15T10:30:00Z",
        "updated_at": "2024-01-18T12:30:00Z"
    }
}
```

### 5. Delete Field
```http
DELETE /api/v1/fields/4
```

**Response:**
```json
{
    "success": true,
    "message": "Field deleted successfully"
}
```

### 6. Get Fields by Category
```http
GET /api/v1/fields/category/Technology
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Advanced Software Development",
            "description": "Advanced programming and software engineering concepts",
            "category": "Technology"
        },
        {
            "id": 2,
            "name": "Web Development",
            "description": "Frontend and backend web technologies",
            "category": "Technology"
        },
        {
            "id": 3,
            "name": "Data Science",
            "description": "Machine learning and data analysis",
            "category": "Technology"
        }
    ]
}
```

### 7. Search Fields
```http
GET /api/v1/fields/search/development
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Advanced Software Development",
            "description": "Advanced programming and software engineering concepts",
            "category": "Technology"
        },
        {
            "id": 2,
            "name": "Web Development",
            "description": "Frontend and backend web technologies",
            "category": "Technology"
        }
    ]
}
```

### 8. Get Active Fields
```http
GET /api/v1/fields/active/list
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Software Development",
            "description": "Programming and software engineering",
            "category": "Technology"
        },
        {
            "id": 2,
            "name": "Web Development",
            "description": "Frontend and backend web technologies",
            "category": "Technology"
        },
        {
            "id": 3,
            "name": "Data Science",
            "description": "Machine learning and data analysis",
            "category": "Technology"
        }
    ]
}
```

### 9. Verify Field (Inter-Service)
```http
GET /api/v1/fields/1/verify
```

**Headers:**
```
Service-Key: SERVICE_SECRET_KEY_2024
```

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Software Development",
        "description": "Programming and software engineering",
        "category": "Technology"
    }
}
```

## Error Responses

### 404 - Field Not Found
```json
{
    "success": false,
    "message": "Field not found"
}
```

### 422 - Validation Error
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "name": ["The name field is required."],
        "category": ["The category field is required."]
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

## Testing with Docker & Postman
- Make sure Docker Desktop is running and all services are up (`docker-compose up -d`).
- Use the provided Postman collection and set `gateway_url` to `http://localhost:8080`.
- All requests should go through the gateway, not direct service ports. 