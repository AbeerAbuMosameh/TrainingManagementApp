# Training Management System - Project Structure

## Overview
This document describes the complete structure of the Training Management System microservices architecture.

## Root Directory Structure
```
TrainingManagementApp-Services/
├── docker-compose.yml                    # Main Docker Compose configuration
├── setup_project.sh                      # Complete project setup script
├── create_dockerfiles.sh                 # Script to create Dockerfiles
├── setup_environment.sh                  # Script to setup environment files
├── README.md                             # Main project documentation
├── PROJECT_STRUCTURE.md                  
├── Training Management System - Gateway Collection.postman_collection.json
└── microservices/                        # All microservices
    ├── gateway-service/                   # API Gateway
    ├── user-service/                      # User authentication service
    ├── trainee-service/                   # Trainee management service
    ├── advisor-service/                   # Advisor management service
    ├── field-service/                     # Field management service
    ├── program-service/                   # Program management service
    ├── task-service/                      # Task management service
    └── README.md                          # Microservices documentation
```

## Microservices Architecture

### 1. API Gateway Service (`gateway-service/`)
**Purpose**: Single entry point for all client requests
**Port**: 8080
**Key Components**:
- `app/Http/Middleware/GatewayMiddleware.php` - Routes requests to appropriate services
- `app/Http/Middleware/ServiceAuthenticationMiddleware.php` - Authenticates inter-service calls
- `app/Services/ServiceCommunicationService.php` - Helper for service communication
- `routes/web.php` - Gateway routes

**Flow**:
```
Client Request → Gateway (8080) → Target Service (Docker DNS)
```

### 2. User Service (`user-service/`)
**Purpose**: Authentication and user management
**Port**: 8081
**Database**: `users_db`
**Key Features**:
- User registration and login
- JWT token management
- Role-based access control (admin, advisor, trainee)
- Inter-service user verification

**API Endpoints**:
- `POST /api/v1/auth/register` - Register user
- `POST /api/v1/auth/login` - User login
- `GET /api/v1/users/{id}` - Get user by ID (inter-service)
- `GET /api/v1/users/email/{email}` - Get user by email (inter-service)

### 3. Trainee Service (`trainee-service/`)
**Purpose**: Trainee profile and management
**Port**: 8082
**Database**: `trainees_db`
**Key Features**:
- Trainee profile management
- Education and certification tracking
- Approval workflow
- File uploads (CV, certifications)

**API Endpoints**:
- `GET /api/v1/trainees` - Get all trainees
- `POST /api/v1/trainees` - Create trainee
- `GET /api/v1/trainees/{id}` - Get trainee by ID
- `PUT /api/v1/trainees/{id}` - Update trainee
- `PATCH /api/v1/trainees/{id}/approval` - Update approval status

### 4. Advisor Service (`advisor-service/`)
**Purpose**: Advisor profile and management
**Port**: 8083
**Database**: `advisors_db`
**Key Features**:
- Advisor profile management
- Education and certification tracking
- Approval workflow
- Notification system

**API Endpoints**:
- `GET /api/v1/advisors` - Get all advisors
- `POST /api/v1/advisors` - Create advisor
- `GET /api/v1/advisors/{id}` - Get advisor by ID
- `PUT /api/v1/advisors/{id}` - Update advisor
- `GET /api/v1/advisors/approved/list` - Get approved advisors
- `GET /api/v1/advisors/language/{language}` - Get advisors by language

### 5. Field Service (`field-service/`)
**Purpose**: Training fields management
**Port**: 8086
**Database**: `fields_db`
**Key Features**:
- Training field categories
- Active/inactive field management
- Field verification for programs

**API Endpoints**:
- `GET /api/v1/fields` - Get all fields
- `POST /api/v1/fields` - Create field
- `GET /api/v1/fields/{id}` - Get field by ID
- `PUT /api/v1/fields/{id}` - Update field
- `GET /api/v1/fields/active/list` - Get active fields

### 6. Program Service (`program-service/`)
**Purpose**: Training programs management
**Port**: 8084
**Database**: `programs_db`
**Key Features**:
- Training program creation and management
- Program scheduling and pricing
- Advisor assignments
- Field associations

**API Endpoints**:
- `GET /api/v1/programs` - Get all programs
- `POST /api/v1/programs` - Create program
- `GET /api/v1/programs/{id}` - Get program by ID
- `PUT /api/v1/programs/{id}` - Update program
- `DELETE /api/v1/programs/{id}` - Delete program

### 7. Task Service (`task-service/`)
**Purpose**: Task management and submissions
**Port**: 8085
**Database**: `tasks_db`
**Key Features**:
- Task creation and assignment
- Task submissions and grading
- File attachments
- Inter-service communication with Program and Advisor services

**API Endpoints**:
- `GET /api/v1/tasks` - Get all tasks
- `POST /api/v1/tasks` - Create task
- `GET /api/v1/tasks/{id}` - Get task by ID
- `PUT /api/v1/tasks/{id}` - Update task
- `DELETE /api/v1/tasks/{id}` - Delete task

## Service Communication Flow

### 1. Client to Service Communication
```
Client → API Gateway (8080) → Target Service
```

### 2. Inter-Service Communication
```
Service A → Docker DNS → Service B
Example: task-service → http://program-service:80/api/v1/programs/1
```

### 3. Authentication Flow
```
Client Request → Gateway → Service (with Service-Key header)
```

## Database Design

### Shared Data Principles
- Each service has its own database
- No foreign keys between services
- Shared identifiers (IDs, emails) for relationships
- Communication via REST APIs, not direct DB joins

### Database Per Service
- `user-service` → `users_db`
- `trainee-service` → `trainees_db`
- `advisor-service` → `advisors_db`
- `field-service` → `fields_db`
- `program-service` → `programs_db`
- `task-service` → `tasks_db`

## Docker Configuration

### Docker Compose Services
- **API Gateway**: Port 8080
- **User Service**: Port 8081
- **Trainee Service**: Port 8082
- **Advisor Service**: Port 8083
- **Field Service**: Port 8086
- **Program Service**: Port 8084
- **Task Service**: Port 8085

### Database Services
- Each service has its own MySQL database
- Persistent volumes for data storage
- Isolated network for security

## Security Implementation

### 1. Service Authentication
- `Service-Key` header for inter-service communication
- Shared secret: `SERVICE_SECRET_KEY_2024`
- Middleware validation in each service

### 2. User Authentication
- JWT tokens for user sessions
- Role-based access control
- Secure password hashing

### 3. API Security
- Input validation and sanitization
- Rate limiting (can be implemented)
- CORS configuration

## Testing Strategy

### 1. Postman Collections
- **Direct Service Testing**: `Training Management System - Microservices.postman_collection.json`
- **Gateway Testing**: `Training Management System - Gateway Collection.postman_collection.json`

### 2. Health Checks
- Each service provides `/api/health` endpoint
- Gateway provides `/health` endpoint
- Automated health monitoring

### 3. Integration Testing
- Service-to-service communication testing
- End-to-end workflow testing
- Error handling and edge cases

## Deployment and Operations

### 1. Development Setup
```bash
# Complete setup
./setup_project.sh

# Manual setup
docker-compose up -d
docker-compose exec [service] php artisan migrate
```

### 2. Production Considerations
- Environment-specific configurations
- SSL/TLS certificates
- Load balancing
- Monitoring and logging
- Backup strategies
- Scaling strategies

### 3. Monitoring
- Service health checks
- Performance metrics
- Error tracking
- Log aggregation

## Development Workflow

### 1. Adding New Features
1. Identify affected services
2. Update database schemas
3. Implement API endpoints
4. Update service communication
5. Test integration
6. Update documentation

### 2. Service Communication Patterns
```php
// Example: Task Service calling Program Service
$serviceComm = new ServiceCommunicationService();
$program = $serviceComm->getProgramDetails($programId);
```

### 3. Error Handling
- Graceful degradation
- Circuit breaker patterns
- Retry mechanisms
- Fallback responses

## File Structure Details

### Each Service Contains
```
service-name/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   │   
│   ├── Models/
│   ├── Services/
│   └── Providers/
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/
│   └── api.php
├── config/
├── .env
├── Dockerfile
└── composer.json
```

This structure ensures:
- **Independence**: Each service can be developed, deployed, and scaled independently
- **Scalability**: Services can be scaled horizontally based on demand
- **Maintainability**: Clear separation of concerns and responsibilities
- **Reliability**: Isolated failures don't affect the entire system 