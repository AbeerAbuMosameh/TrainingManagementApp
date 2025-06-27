# Training Management System - Microservices

This repository contains four microservices for the Training Management System:

1. **User Service** - Manages user authentication, registration, and roles
2. **Program Service** - Manages training programs and fields
3. **Task Service** - Handles task creation, submissions, and grading
4. **Trainee Service** - Manages trainee profiles and information

## Architecture Overview

The system follows a microservices architecture with:
- **API Gateway**: Single entry point for all client requests
- **Service Discovery**: Docker internal DNS for service discovery
- **Configuration Server**: Environment-based configuration management
- **Database per Service**: Each microservice maintains its own database

## Services

### 1. User Service

**Responsibility**: Manages user authentication, registration, roles (admin, advisor, trainee), and basic login info.

**Database Tables**:
- `users` - User accounts with authentication and role information

**API Endpoints**:

#### Authentication
- `POST /v1/api/register` - Register new user
- `POST /v1/api/login` - User login
- `POST /v1/api/logout` - User logout (authenticated)
- `GET /v1/api/profile` - Get user profile (authenticated)
- `PUT /v1/api/profile` - Update user profile (authenticated)
- `POST /v1/api/change-password` - Change password (authenticated)

#### User Management (Admin Only)
- `GET /v1/api/users` - List all users
- `DELETE /v1/api/users/{id}` - Delete user

#### Inter-Service Communication
- `GET /v1/api/users/email/{email}` - Get user by email
- `GET /v1/api/users/{id}` - Get user by ID

**Example User Registration**:
```json
POST /v1/api/register
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "level": 3
}
```

### 2. Program Service

**Responsibility**: Manages training programs, fields of study, program schedules, pricing, and advisor assignments.

**Database Tables**:
- `fields` - Training fields/categories
- `programs` - Training programs with metadata

**API Endpoints**:

#### Fields
- `GET /v1/api/fields` - List all fields
- `POST /v1/api/fields` - Create a new field
- `GET /v1/api/fields/{id}` - Get field by ID
- `PUT /v1/api/fields/{id}` - Update field
- `DELETE /v1/api/fields/{id}` - Delete field

#### Programs
- `GET /v1/api/programs` - List all programs
- `POST /v1/api/programs` - Create a new program
- `GET /v1/api/programs/{id}` - Get program by ID
- `PUT /v1/api/programs/{id}` - Update program
- `DELETE /v1/api/programs/{id}` - Delete program

**Example Program Creation**:
```json
POST /v1/api/programs
{
  "name": "Data Analysis with Python",
  "type": "free",
  "hours": "40",
  "start_date": "2025-09-01",
  "end_date": "2025-09-30",
  "field_id": 2,
  "advisor_id": 4,
  "duration": "weeks",
  "level": "intermediate",
  "language": "English",
  "description": "Analyze datasets using pandas and matplotlib"
}
```

### 3. Task Service

**Responsibility**: Handles creation of tasks, task submissions by trainees, grading, feedback, and related files.

**Database Tables**:
- `tasks` - Training tasks with metadata

**API Endpoints**:

#### Tasks
- `GET /v1/api/tasks` - List all tasks
- `POST /v1/api/tasks` - Create a new task
- `GET /v1/api/tasks/{id}` - Get task by ID
- `PUT /v1/api/tasks/{id}` - Update task
- `DELETE /v1/api/tasks/{id}` - Delete task

**Example Task Creation**:
```json
POST /v1/api/tasks
{
  "program_id": 1,
  "advisor_id": 2,
  "start_date": "2025-07-10",
  "end_date": "2025-07-15",
  "mark": 50,
  "description": "Create a responsive portfolio page.",
  "related_file": null
}
```

### 4. Trainee Service

**Responsibility**: Manages trainee profiles, personal info, education, GPA, certifications, CVs, approvals, and related trainee data.

**Database Tables**:
- `trainees` - Trainee profiles and information

**API Endpoints**:

#### Trainees
- `GET /v1/api/trainees` - List all trainees
- `POST /v1/api/trainees` - Create a new trainee
- `GET /v1/api/trainees/{id}` - Get trainee by ID
- `PUT /v1/api/trainees/{id}` - Update trainee
- `DELETE /v1/api/trainees/{id}` - Delete trainee
- `GET /v1/api/trainees/email/{email}` - Get trainee by email
- `PATCH /v1/api/trainees/{id}/approval` - Update approval status

**Example Trainee Creation**:
```json
POST /v1/api/trainees
{
  "first_name": "Shatha",
  "last_name": "ISA",
  "email": "shatha@email.com",
  "phone": "123456789",
  "education": "IT",
  "address": "Gaza",
  "password": "secret123"
}
```

## Inter-Service Communication

### Service-to-Service API Calls

Services communicate using RESTful APIs with service authentication:

#### Task Service → Program Service
```
GET /v1/api/programs/{id}
Headers:
  Service-Key: SERVICE_SECRET
```

#### Task Service → Advisor Service
```
GET /v1/api/advisors/{id}
Headers:
  Service-Key: SERVICE_SECRET
```

#### Program Service → Advisor Service
```
GET /v1/api/advisors/{id}
Headers:
  Service-Key: SERVICE_SECRET
```

#### Other Services → User Service
```
GET /v1/api/users/email/{email}
Headers:
  Service-Key: SERVICE_SECRET
```

### Shared Data Between Services

| Service | Shared Fields | Used By | Purpose |
|---------|---------------|---------|---------|
| User | email, id | All Services | Authentication and user identification |
| Trainee | email | User Service | Link to Auth |
| Advisor | email | User Service | Link to Auth |
| Program | advisor_id, field_id | Advisor, Field | Advisor of program and field |
| Task | advisor_id, program_id | Advisor, Program | Who assigned "advisor", for which program |

## Setup Instructions

### Prerequisites
- Docker and Docker Compose
- PHP 8.1+
- Composer
- MySQL/PostgreSQL

### Installation

1. **Clone the repository**
```bash
git clone <repository-url>
cd TrainingManagementApp-Services
```

2. **Set up each service**
```bash
# User Service
cd user-service
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed

# Program Service
cd ../program-service
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed

# Task Service
cd ../task-service
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed

# Trainee Service
cd ../trainee-service
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
```

3. **Configure environment variables**
   - Set database connections for each service
   - Configure service URLs and secrets for inter-service communication
   - Set up API Gateway configuration

4. **Run with Docker**
```bash
docker-compose up -d
```

## API Response Format

All services implement standardized response formats:

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

## Testing

### User Service
```bash
cd user-service
php artisan test
```

### Program Service
```bash
cd program-service
php artisan test
```

### Task Service
```bash
cd task-service
php artisan test
```

### Trainee Service
```bash
cd trainee-service
php artisan test
```

## Database Schema

### User Service
- `users` table: id, name, email, google_id, unique_id, level, password, email_verified_at, remember_token, timestamps

### Program Service
- `fields` table: id, name, timestamps, soft deletes
- `programs` table: id, image, name, hours, start_date, end_date, type, price, number, duration, level, language, field_id, description, advisor_id, timestamps, soft deletes

### Task Service
- `tasks` table: id, program_id, advisor_id, start_date, end_date, mark, description, related_file, timestamps, soft deletes

### Trainee Service
- `trainees` table: id, image, first_name, last_name, email, phone, education, gpa, address, city, payment, language, cv, certification, otherFile, is_approved, password, notification_id, timestamps, soft deletes

## Security

- **Service Authentication**: Service-Key headers for inter-service communication
- **JWT Authentication**: Laravel Sanctum for API authentication
- **Password Hashing**: Laravel Hash facade for secure password storage
- **Input Validation**: Comprehensive validation on all endpoints
- **Soft Deletes**: Data integrity through soft delete functionality
- **CORS Protection**: Cross-origin request protection
- **Rate Limiting**: API rate limiting to prevent abuse

## Sample Users

The User Service comes with pre-seeded users for testing:

### Admin Users
- **Email**: admin@training.com
- **Password**: admin123
- **Role**: Admin (Level 1)

### Advisor Users
- **Email**: osama@training.com
- **Password**: advisor123
- **Role**: Advisor (Level 2)

### Trainee Users
- **Email**: shatha@training.com
- **Password**: trainee123
- **Role**: Trainee (Level 3)

## Contributing

1. Follow Laravel coding standards
2. Write tests for new features
3. Update documentation for API changes
4. Use conventional commit messages

## License

This project is part of the Advanced Software Engineering course at the Islamic University of Gaza.
