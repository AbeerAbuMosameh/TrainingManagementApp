# TrainingManagementApp - Services

Training Management System (Microservices Architecture)

## Overview

This project is a training management system built on microservices architecture. Each service is responsible for a specific part of the system and can be developed and run independently.

## Microservices List

| Service             | Description                                                    | Port | Documentation |
|---------------------|----------------------------------------------------------------|------|---------------|
| User Service        | Manages users and authentication                              | 8003 | [user-service/API_DOCUMENTATION.md](user-service/API_DOCUMENTATION.md) |
| Trainee Service     | Manages trainee data                 | 8004 | [trainee-service/API_DOCUMENTATION.md](trainee-service/API_DOCUMENTATION.md) |
| Advisor Service     | Manages advisor data                    | 8005 | [advisor-service/API_DOCUMENTATION.md](advisor-service/API_DOCUMENTATION.md) |
| Field Service       | Manages training fields and specializations                   | 8006 | [field-service/API_DOCUMENTATION.md](field-service/API_DOCUMENTATION.md) |
| Program Service     | Manages training programs | 8001 | [program-service/API_DOCUMENTATION.md](program-service/API_DOCUMENTATION.md) |
| Task Service        | Manages tasks related to programs and trainees                | 8002 | [task-service/API_DOCUMENTATION.md](task-service/API_DOCUMENTATION.md) |

## Quick Start

1. **Prerequisites**: PHP, Composer, MySQL
2. **For each service**, navigate to its folder and run:
   ```bash
   composer install
   php artisan migrate --seed
   php artisan serve --port={PORT}
   ```

## API Request Example (Add Trainee)
```http
POST /api/v1/trainees
Content-Type: application/json

{
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
}
```

## Service Communication

All services communicate using HTTP requests with `Service-Key` header for authentication.

## Contributing

To contribute to the project, please open a Pull Request or contact the development team.

---

© 2025 TrainingManagementApp Team