# Task Service API Documentation

## Accessing the API
All endpoints should be accessed via the API Gateway:
- Base URL: `http://localhost:8080/tasks`

## Endpoints

### Get All Tasks
- **GET** `/api/v1/tasks`

### Create Task
- **POST** `/api/v1/tasks`
- **Body:**
  ```json
  {
    "program_id": 1,
    "advisor_id": 1,
    "start_date": "2024-01-20",
    "end_date": "2024-01-27",
    "mark": 10,
    "description": "Complete the final project",
    "related_file": ["file1.pdf", "file2.jpg"]
  }
  ```

### Get Task by ID
- **GET** `/api/v1/tasks/{id}`

### Update Task
- **PUT** `/api/v1/tasks/{id}`

### Delete Task
- **DELETE** `/api/v1/tasks/{id}`

## Testing with Docker & Postman
- Make sure Docker Desktop is running and all services are up (`docker-compose up -d`).
- Use the provided Postman collection and set `gateway_url` to `http://localhost:8080`.
- All requests should go through the gateway, not direct service ports.

### 1. Get All Tasks
```http
GET /api/v1/tasks
```

**Response:**
```