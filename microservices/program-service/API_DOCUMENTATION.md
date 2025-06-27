# Training Management System - API Documentation

## Overview

The Training Management System is built using a microservices architecture with the following services:

- **User Service** (Port 8003) - Authentication and user management
- **Advisor Service** (Port 8005) - Advisor management and profiles
- **Trainee Service** (Port 8004) - Trainee management and profiles
- **Program Service** (Port 8001) - Training programs and courses
- **Task Service** (Port 8002) - Task management and assignments
- **Field Service** (Port 8006) - Field/category management

## Service Communication

All services communicate with each other using HTTP requests with service authentication via the `Service-Key` header.

## Base URL Structure

```
http://localhost:{PORT}/api/v1/{RESOURCE}
```

## Authentication

### User Service Authentication
- Uses Laravel Sanctum for token-based authentication
- All user-related endpoints require authentication except registration and login

### Inter-Service Authentication
- Uses `Service-Key` header for service-to-service communication
- Each service has a unique secret key configured in environment variables

---

## User Service (Port 8003)

### Authentication Endpoints

#### Register User
```http
POST /api/v1/auth/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "level": 3
}
```

#### Login User
```http
POST /api/v1/auth/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123"
}
```

#### Logout User
```http
POST /api/v1/auth/logout
Authorization: Bearer {token}
```

#### Get User Profile
```http
GET /api/v1/auth/profile
Authorization: Bearer {token}
```

#### Update User Profile
```http
PUT /api/v1/auth/profile
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "John Updated",
    "email": "john.updated@example.com",
    "level": 2
}
```

#### Change Password
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

### Inter-Service Endpoints

#### Get User by Email
```http
GET /api/v1/users/email/{email}
Service-Key: {service_secret}
```

#### Get User by ID
```http
GET /api/v1/users/{id}
Service-Key: {service_secret}
```

---

## Advisor Service (Port 8005)

### Advisor Management Endpoints

#### Get All Advisors
```http
GET /api/v1/advisors
```

#### Create Advisor
```http
POST /api/v1/advisors
Content-Type: application/json

{
    "first_name": "Dr. Smith",
    "last_name": "Johnson",
    "email": "smith@example.com",
    "phone": "+1234567890",
    "education": "PhD in Computer Science",
    "address": "123 Main St",
    "city": "New York",
    "language": "English",
    "password": "password123",
    "is_approved": false
}
```

#### Get Advisor by ID
```http
GET /api/v1/advisors/{id}
```

#### Update Advisor
```http
PUT /api/v1/advisors/{id}
Content-Type: application/json

{
    "first_name": "Dr. Smith Updated",
    "is_approved": true
}
```

#### Delete Advisor
```http
DELETE /api/v1/advisors/{id}
```

#### Get Approved Advisors
```http
GET /api/v1/advisors/approved/list
```

#### Get Advisors by Language
```http
GET /api/v1/advisors/language/{language}
```

### Inter-Service Endpoints

#### Verify Advisor
```http
GET /api/v1/advisors/{id}/verify
Service-Key: {service_secret}
```

---

## Trainee Service (Port 8004)

### Trainee Management Endpoints

#### Get All Trainees
```http
GET /api/v1/trainees
```

#### Create Trainee
```http
POST /api/v1/trainees
Content-Type: application/json

{
    "first_name": "Jane",
    "last_name": "Doe",
    "email": "jane@example.com",
    "phone": "+1234567890",
    "education": "Bachelor's Degree",
    "address": "456 Oak St",
    "password": "password123",
    "gpa": "3.8",
    "city": "Los Angeles",
    "language": "English"
}
```

#### Get Trainee by ID
```http
GET /api/v1/trainees/{id}
```

#### Update Trainee
```http
PUT /api/v1/trainees/{id}
Content-Type: application/json

{
    "first_name": "Jane Updated",
    "is_approved": true
}
```

#### Delete Trainee
```http
DELETE /api/v1/trainees/{id}
```

#### Update Trainee Approval
```http
PUT /api/v1/trainees/{id}/approval
Content-Type: application/json

{
    "is_approved": true
}
```

### Inter-Service Endpoints

#### Get Trainee by Email
```http
GET /api/v1/trainees/email/{email}
Service-Key: {service_secret}
```

---

## Program Service (Port 8001)

### Program Management Endpoints

#### Get All Programs
```http
GET /api/v1/programs
```

#### Create Program
```http
POST /api/v1/programs
Content-Type: application/json

{
    "name": "Advanced Web Development",
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

#### Get Program by ID
```http
GET /api/v1/programs/{id}
```

#### Update Program
```http
PUT /api/v1/programs/{id}
Content-Type: application/json

{
    "name": "Updated Program Name",
    "price": 1299
}
```

#### Delete Program
```http
DELETE /api/v1/programs/{id}
```

### Field Management Endpoints

#### Get All Fields
```http
GET /api/v1/fields
```

#### Create Field
```http
POST /api/v1/fields
Content-Type: application/json

{
    "name": "Web Development",
    "description": "Programming and web technologies",
    "is_active": true
}
```

#### Get Field by ID
```http
GET /api/v1/fields/{id}
```

#### Update Field
```http
PUT /api/v1/fields/{id}
Content-Type: application/json

{
    "name": "Updated Field Name",
    "is_active": false
}
```

#### Delete Field
```http
DELETE /api/v1/fields/{id}
```

#### Get Active Fields
```http
GET /api/v1/fields/active/list
```

### Inter-Service Endpoints

#### Verify Field
```http
GET /api/v1/fields/{id}/verify
Service-Key: {service_secret}
```

---

## Task Service (Port 8002)

### Task Management Endpoints

#### Get All Tasks
```http
GET /api/v1/tasks
```

#### Create Task
```http
POST /api/v1/tasks
Content-Type: application/json

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

#### Get Task by ID
```http
GET /api/v1/tasks/{id}
```

#### Update Task
```http
PUT /api/v1/tasks/{id}
Content-Type: application/json

{
    "description": "Updated task description",
    "mark": 15
}
```

#### Delete Task
```http
DELETE /api/v1/tasks/{id}
```

---

## Field Service (Port 8006)

### Field Management Endpoints

#### Get All Fields
```http
GET /api/v1/fields
```

#### Create Field
```http
POST /api/v1/fields
Content-Type: application/json

{
    "name": "Data Science",
    "description": "Data analysis and machine learning",
    "is_active": true
}
```

#### Get Field by ID
```http
GET /api/v1/fields/{id}
```

#### Update Field
```http
PUT /api/v1/fields/{id}
Content-Type: application/json

{
    "name": "Updated Field Name",
    "is_active": false
}
```

#### Delete Field
```http
DELETE /api/v1/fields/{id}
```

#### Get Active Fields
```http
GET /api/v1/fields/active/list
```

### Inter-Service Endpoints

#### Verify Field
```http
GET /api/v1/fields/{id}/verify
Service-Key: {service_secret}
```

---

## Health Check Endpoints

All services provide health check endpoints:

```http
GET /api/health
```

Response:
```json
{
    "status": true,
    "message": "{Service Name} is running",
    "timestamp": "2024-01-15T10:30:00Z",
    "service": "{service-name}"
}
```

---

## Error Responses

All services follow a consistent error response format:

```json
{
    "status": false,
    "message": "Error description",
    "errors": {
        "field_name": ["Validation error message"]
    }
}
```

## Success Responses

All services follow a consistent success response format:

```json
{
    "status": true,
    "message": "Success message",
    "data": {
        // Response data
    }
}
```

---

## Environment Variables

Each service requires the following environment variables:

### User Service
```
USER_SERVICE_SECRET=SERVICE_SECRET
```

### Advisor Service
```
ADVISOR_SERVICE_SECRET=SERVICE_SECRET
```

### Trainee Service
```
TRAINEE_SERVICE_SECRET=SERVICE_SECRET
```

### Program Service
```
PROGRAM_SERVICE_SECRET=SERVICE_SECRET
ADVISOR_SERVICE_URL=http://advisor-service
ADVISOR_SERVICE_SECRET=SERVICE_SECRET
FIELD_SERVICE_URL=http://field-service
FIELD_SERVICE_SECRET=SERVICE_SECRET
```

### Task Service
```
TASK_SERVICE_SECRET=SERVICE_SECRET
PROGRAM_SERVICE_URL=http://program-service
PROGRAM_SERVICE_SECRET=SERVICE_SECRET
ADVISOR_SERVICE_URL=http://advisor-service
ADVISOR_SERVICE_SECRET=SERVICE_SECRET
```

### Field Service
```
FIELD_SERVICE_SECRET=SERVICE_SECRET
```

---

## Database Migrations

Each service includes its own database migrations and seeders. Run the following commands in each service directory:

```bash
php artisan migrate
php artisan db:seed
```

---

## Testing

Each service includes PHPUnit tests. Run tests with:

```bash
php artisan test
```

---

## Docker Support

The program service includes Docker configuration for containerized deployment. Use:

```bash
docker-compose up -d
```

---

## Service Dependencies

- **Program Service** depends on Advisor Service and Field Service
- **Task Service** depends on Program Service and Advisor Service
- **Advisor Service** has optional dependency on Notification Service
- All services can communicate with User Service for authentication

---

## Security Considerations

1. All inter-service communication uses service keys
2. User authentication uses Laravel Sanctum tokens
3. Input validation is implemented on all endpoints
4. Soft deletes are used where appropriate
5. Foreign key constraints ensure data integrity

---

## Rate Limiting

Consider implementing rate limiting for production environments:

```php
// In routes/api.php
Route::middleware(['throttle:60,1'])->group(function () {
    // API routes
});
```

---

## Monitoring and Logging

Each service includes:
- Laravel's built-in logging system
- Health check endpoints
- Error handling and reporting
- Database query logging (in debug mode)

---

## Deployment

1. Set up environment variables for each service
2. Run database migrations
3. Configure service URLs for inter-service communication
4. Set up reverse proxy (nginx) for load balancing
5. Configure SSL certificates for production
6. Set up monitoring and alerting

---

## Support

For issues and questions:
1. Check service logs
2. Verify environment variables
3. Test inter-service communication
4. Review database connections
5. Check service health endpoints
