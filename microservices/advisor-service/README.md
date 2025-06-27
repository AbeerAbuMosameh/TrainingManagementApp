# Advisor Service

Manages advisor data.

## Setup
```bash
composer install
php artisan migrate --seed
php artisan serve
```

## API
Access endpoints via `/api/v1/advisors`

## Features

- ✅ Complete CRUD operations for advisors
- ✅ Input validation and error handling
- ✅ Service-to-service authentication
- ✅ Approval status management
- ✅ Language filtering capabilities
- ✅ Soft delete functionality
- ✅ Notification system integration
- ✅ Health check endpoint

## Usage
- Access API endpoints via `/api/advisors`.
- Example: Add an advisor using a POST request to `/api/advisors`.

## License
© 2025 TrainingManagementApp Team

## API Endpoints

### Public Endpoints

#### Health Check
```http
GET /api/health
```

#### Get All Advisors
```http
GET /api/v1/advisors
```

#### Create Advisor
```http
POST /api/v1/advisors
Content-Type: application/json

{
    "first_name": "أسامة",
    "last_name": "أحمد",
    "email": "osama@example.com",
    "phone": "+970591234567",
    "education": "دكتوراه في علوم الحاسوب",
    "address": "غزة، فلسطين",
    "language": "Arabic",
    "password": "password123"
}
```

#### Get Approved Advisors
```http
GET /api/v1/advisors/approved/list
```

#### Get Advisors by Language
```http
GET /api/v1/advisors/language/Arabic
```

### Inter-Service Endpoints

#### Verify Advisor (Protected)
```http
GET /api/v1/advisors/{id}/verify
Service-Key: {service_secret}
```

## Installation

1. **Install dependencies**
```bash
composer install
```

2. **Environment setup**
```bash
cp .env.example .env
```

3. **Configure environment variables**
```env
APP_URL=http://localhost:8005
DB_DATABASE=advisor_service
ADVISOR_SERVICE_SECRET=SERVICE_SECRET
```

4. **Run migrations and seeders**
```bash
php artisan migrate
php artisan db:seed
```

5. **Start the service**
```bash
php artisan serve --port=8005
```

## Example Response

```json
{
    "success": true,
    "data": {
        "id": 1,
        "first_name": "أسامة",
        "last_name": "أحمد",
        "full_name": "أسامة أحمد",
        "email": "osama@example.com",
        "phone": "+970591234567",
        "education": "دكتوراه في علوم الحاسوب",
        "language": "Arabic",
        "is_approved": true,
        "created_at": "2025-01-15T10:30:00Z"
    },
    "message": "Advisor created successfully"
}
```

## Models

### Advisor Model
- **Relationships**: belongsTo Notification
- **Scopes**: approved(), byLanguage()
- **Accessors**: full_name

### Notification Model
- **Relationships**: belongsTo User, hasMany Advisors
- **Scopes**: unread(), read(), byType()

## Testing

```bash
php artisan test
```

## Service Dependencies

- **Program Service**: For advisor verification
- **Task Service**: For advisor verification
- **Notification System**: Optional integration

## Security

- Service-to-service authentication using secret keys
- Input validation on all endpoints
- Password hashing
- Soft deletes for data integrity

## Health Check

```http
GET /api/health
```

Response:
```json
{
    "status": true,
    "message": "Advisor Service is running",
    "timestamp": "2025-01-15T10:30:00Z",
    "service": "advisor-service"
}
```

## Dependencies

- **Laravel 10.x**: PHP framework
- **MySQL**: Database
- **Laravel Sanctum**: API authentication (for future use)

## Monitoring

- Health check endpoint at `/api/health`
- Laravel's built-in logging system
- Error handling and reporting

## Deployment

1. Set up environment variables
2. Run database migrations
3. Configure service URLs for inter-service communication
4. Set up reverse proxy (nginx) for load balancing
5. Configure SSL certificates for production
6. Set up monitoring and alerting

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests
5. Submit a pull request 