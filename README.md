# Training Management System - Microservices Architecture

A comprehensive Training Management System built with Laravel microservices, Docker, and RESTful APIs.

## 🏗️ Architecture Overview

This system implements a microservices architecture with the following components:

- **API Gateway**: Single entry point for all client requests
- **Service Discovery**: Docker Internal DNS for service discovery
- **Configuration Management**: Environment-based configuration (.env files)
- **Microservices**: 8 specialized services with their own databases

## 📦 Services

1. **Gateway Service** (`gateway-service/`) - API Gateway and routing
2. **User Service** (`user-service/`) - Authentication and user management
3. **Trainee Service** (`trainee-service/`) - Trainee profiles and data
4. **Advisor Service** (`advisor-service/`) - Advisor profiles and data
5. **Program Service** (`program-service/`) - Training programs management
6. **Task Service** (`task-service/`) - Task creation and submissions
7. **Field Service** (`field-service/`) - Training fields management

## 🚀 Quick Start

### Prerequisites
- Docker Desktop
- Git

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd TrainingManagementApp-Services
   ```

2. **Build and start all services**
   ```bash
   docker-compose up --build -d
   ```

3. **Run migrations for all services**
   ```bash
   # User Service
   docker-compose exec user-service php artisan migrate
   
   # Trainee Service
   docker-compose exec trainee-service php artisan migrate
   
   # Advisor Service
   docker-compose exec advisor-service php artisan migrate
   
   # Program Service
   docker-compose exec program-service php artisan migrate
   
   # Task Service
   docker-compose exec task-service php artisan migrate
   
   # Field Service
   docker-compose exec field-service php artisan migrate
   ```

4. **Test the system**
   ```bash
   # Test Gateway
   curl http://localhost:8080/health
   
   # Test individual services
   curl http://localhost:8081/health  # User Service
   curl http://localhost:8082/health  # Trainee Service
   curl http://localhost:8083/health  # Advisor Service
   curl http://localhost:8084/health  # Program Service
   curl http://localhost:8085/health  # Task Service
   curl http://localhost:8086/health  # Field Service
   ```

## 🔧 Configuration

### Environment Variables
Each service has its own `.env` file with service-specific configuration:
- Database connections
- Service ports
- Authentication settings
- External service URLs

### Service Communication
- **Inter-service communication**: Uses HTTP with `Service-Key` header for authentication
- **Service discovery**: Docker Internal DNS resolves service names
- **API Gateway**: Routes all external requests to appropriate services

## 📚 API Documentation

Each service includes comprehensive API documentation:
- `microservices/user-service/API_DOCUMENTATION.md`
- `microservices/trainee-service/API_DOCUMENTATION.md`
- `microservices/advisor-service/API_DOCUMENTATION.md`
- `microservices/program-service/API_DOCUMENTATION.md`
- `microservices/task-service/API_DOCUMENTATION.md`
- `microservices/field-service/API_DOCUMENTATION.md`

## 🧪 Testing

### Postman Collection
Import the provided Postman collection to test all APIs through the gateway:
- All requests go through `http://localhost:8080`
- Gateway routes to appropriate services
- Includes authentication and service communication examples

### Health Checks
All services provide health check endpoints:
- `GET /health` - Returns service status and version

## 🏛️ Architecture Benefits

1. **Scalability**: Each service can be scaled independently
2. **Maintainability**: Services are isolated and can be developed/deployed separately
3. **Technology Flexibility**: Each service can use different technologies if needed
4. **Fault Isolation**: Failure in one service doesn't affect others
5. **Database Independence**: Each service manages its own data

## 🔒 Security

- **Service Authentication**: Inter-service communication uses shared secrets
- **JWT Tokens**: User authentication with Laravel Sanctum
- **Input Validation**: All API endpoints validate input data
- **CORS Configuration**: Proper cross-origin resource sharing setup

## 📊 Monitoring

- **Health Checks**: All services provide health status endpoints
- **Logging**: Centralized logging through Docker
- **Service Discovery**: Automatic service registration and discovery

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

This project is licensed under the MIT License.

---

**Note**: This system uses environment-based configuration instead of a centralized configuration server, as it's simpler and more suitable for this scale of application. 