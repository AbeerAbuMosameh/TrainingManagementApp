# Task Service API Documentation

## Base URL
```
http://localhost:8002/api/v1
```

## Endpoints

### 1. Get All Tasks
```http
GET /api/v1/tasks
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "title": "Complete React Fundamentals",
            "description": "Learn React basics and build a simple app",
            "program_id": 1,
            "program_title": "Ahmed's Development Program",
            "trainee_id": 1,
            "trainee_name": "Ahmed Ali",
            "advisor_id": 1,
            "advisor_name": "Osama Ahmed",
            "status": "in_progress",
            "priority": "high",
            "due_date": "2024-02-15",
            "created_at": "2024-01-15T10:30:00Z"
        },
        {
            "id": 2,
            "title": "Database Design Project",
            "description": "Design and implement a database schema",
            "program_id": 2,
            "program_title": "Shatha's Web Development Bootcamp",
            "trainee_id": 2,
            "trainee_name": "Shatha Khalil",
            "advisor_id": 2,
            "advisor_name": "Shatha Mohammed",
            "status": "completed",
            "priority": "medium",
            "due_date": "2024-02-10",
            "created_at": "2024-01-16T14:20:00Z"
        }
    ]
}
```

### 2. Create Task
```http
POST /api/v1/tasks
Content-Type: application/json

{
    "title": "Machine Learning Assignment",
    "description": "Implement a simple ML algorithm",
    "program_id": 3,
    "trainee_id": 3,
    "advisor_id": 3,
    "priority": "high",
    "due_date": "2024-03-15"
}
```

### 3. Get Task by ID
```http
GET /api/v1/tasks/1
```

### 4. Update Task
```http
PUT /api/v1/tasks/1
Content-Type: application/json

{
    "title": "Complete React Fundamentals",
    "status": "completed",
    "priority": "medium"
}
```

### 5. Delete Task
```http
DELETE /api/v1/tasks/3
```

### 6. Get Tasks by Program
```http
GET /api/v1/tasks/program/1
```

### 7. Get Tasks by Trainee
```http
GET /api/v1/tasks/trainee/1
```

### 8. Get Tasks by Status
```http
GET /api/v1/tasks/status/in_progress
``` 