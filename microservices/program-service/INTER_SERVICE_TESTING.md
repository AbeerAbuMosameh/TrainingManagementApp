# Inter-Service Communication Testing Guide

This guide demonstrates how to test inter-service communication between the microservices in the Training Management System.

## 🚀 Quick Start

### 1. Setup Services

First, ensure all services are properly configured:

```bash
# Copy configuration to each service
cp services-config.env user-service/.env
cp services-config.env program-service/.env  
cp services-config.env task-service/.env
cp services-config.env trainee-service/.env

# Run migrations and seeders for each service
cd user-service && php artisan migrate --seed
cd ../program-service && php artisan migrate --seed
cd ../task-service && php artisan migrate --seed
cd ../trainee-service && php artisan migrate --seed
```

### 2. Start All Services

**Option A: Use the batch script (Windows)**
```bash
start-services.bat
```

**Option B: Manual startup**
```bash
# Terminal 1 - User Service
cd user-service
php artisan serve --port=8003

# Terminal 2 - Program Service  
cd program-service
php artisan serve --port=8001

# Terminal 3 - Task Service
cd task-service
php artisan serve --port=8002

# Terminal 4 - Trainee Service
cd trainee-service
php artisan serve --port=8004
```

### 3. Run Tests

**Option A: Automated PHP Test**
```bash
php test-inter-service.php
```

**Option B: Manual cURL Test**
```bash
test-with-curl.bat
```

## 📋 Testing Scenarios

### Scenario 1: Task Service → Program Service Communication

**What it tests**: When creating a task, the Task Service verifies the program exists in the Program Service.

**Expected Flow**:
1. Create a program in Program Service
2. Create a task in Task Service (should succeed)
3. Try to create a task with non-existent program (should fail)

**Test Commands**:
```bash
# 1. Create program
curl -X POST http://localhost:8001/v1/api/programs \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Web Development",
    "type": "paid",
    "hours": "80",
    "start_date": "2025-07-01",
    "end_date": "2025-08-01",
    "field_id": 1,
    "advisor_id": 1,
    "duration": "weeks",
    "level": "intermediate",
    "language": "English",
    "description": "Learn modern web development",
    "number": 20
  }'

# 2. Create task (should succeed)
curl -X POST http://localhost:8002/v1/api/tasks \
  -H "Content-Type: application/json" \
  -d '{
    "program_id": 1,
    "advisor_id": 1,
    "start_date": "2025-07-10",
    "end_date": "2025-07-15",
    "mark": 50,
    "description": "Create a responsive portfolio page"
  }'

# 3. Create task with invalid program (should fail)
curl -X POST http://localhost:8002/v1/api/tasks \
  -H "Content-Type: application/json" \
  -d '{
    "program_id": 999,
    "advisor_id": 1,
    "start_date": "2025-07-10",
    "end_date": "2025-07-15",
    "mark": 50,
    "description": "This should fail"
  }'
```

### Scenario 2: Task Service → User Service Communication

**What it tests**: When retrieving a task, the Task Service fetches user details from the User Service.

**Expected Flow**:
1. Create a user in User Service
2. Create a task in Task Service
3. Retrieve the task and verify it includes user details

**Test Commands**:
```bash
# 1. Create user
curl -X POST http://localhost:8003/v1/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test Advisor",
    "email": "advisor@test.com",
    "password": "password123",
    "password_confirmation": "password123",
    "level": 2
  }'

# 2. Get task with details
curl -X GET http://localhost:8002/v1/api/tasks/1 \
  -H "Service-Key: test_service_secret_key_123"
```

### Scenario 3: Program Service → User Service Communication

**What it tests**: When creating a program, the Program Service verifies the advisor exists in the User Service.

**Expected Flow**:
1. Create a user (advisor) in User Service
2. Create a program with valid advisor (should succeed)
3. Try to create a program with non-existent advisor (should fail)

**Test Commands**:
```bash
# 1. Create program with valid advisor
curl -X POST http://localhost:8001/v1/api/programs \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Data Science",
    "type": "free",
    "hours": "60",
    "start_date": "2025-09-01",
    "end_date": "2025-10-01",
    "field_id": 1,
    "advisor_id": 1,
    "duration": "weeks",
    "level": "advanced",
    "language": "English",
    "description": "Learn data science fundamentals",
    "number": 15
  }'

# 2. Create program with invalid advisor
curl -X POST http://localhost:8001/v1/api/programs \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Invalid Program",
    "type": "free",
    "hours": "60",
    "start_date": "2025-09-01",
    "end_date": "2025-10-01",
    "field_id": 1,
    "advisor_id": 999,
    "duration": "weeks",
    "level": "advanced",
    "language": "English",
    "description": "This should fail",
    "number": 15
  }'
```

## 🔧 Configuration

### Environment Variables

Each service needs these environment variables for inter-service communication:

**User Service (.env)**:
```env
SERVICE_SECRET=test_service_secret_key_123
```

**Program Service (.env)**:
```env
USER_SERVICE_URL=http://localhost:8003
SERVICE_SECRET=test_service_secret_key_123
```

**Task Service (.env)**:
```env
USER_SERVICE_URL=http://localhost:8003
PROGRAM_SERVICE_URL=http://localhost:8001
SERVICE_SECRET=test_service_secret_key_123
```

**Trainee Service (.env)**:
```env
USER_SERVICE_URL=http://localhost:8003
SERVICE_SECRET=test_service_secret_key_123
```

### Service Authentication

All inter-service communication uses the `Service-Key` header:

```bash
curl -H "Service-Key: test_service_secret_key_123" \
  http://localhost:8003/v1/api/users/email/test@example.com
```

## 📊 Expected Results

### Successful Communication

When services communicate successfully, you should see:

1. **Task Creation Success**:
```json
{
  "status": true,
  "message": "Task created successfully",
  "data": {
    "id": 1
  }
}
```

2. **Task Retrieval with Details**:
```json
{
  "status": true,
  "message": "Task retrieved successfully",
  "data": {
    "id": 1,
    "program_id": 1,
    "advisor_id": 1,
    "start_date": "2025-07-10",
    "end_date": "2025-07-15",
    "mark": 50,
    "description": "Create a responsive portfolio page",
    "program": {
      "id": 1,
      "name": "Web Development",
      "type": "paid",
      "price": 500
    },
    "advisor": {
      "id": 1,
      "name": "Test Advisor",
      "email": "advisor@test.com"
    }
  }
}
```

### Error Handling

When services fail to communicate, you should see:

1. **Program Not Found**:
```json
{
  "status": false,
  "message": "Program not found"
}
```

2. **Advisor Not Found**:
```json
{
  "status": false,
  "message": "Advisor not found"
}
```

3. **Service Authentication Failed**:
```json
{
  "status": false,
  "message": "Unauthorized service access"
}
```

## 🐛 Troubleshooting

### Common Issues

1. **Service Not Found**
   - Check if all services are running on correct ports
   - Verify service URLs in environment variables
   - Check firewall settings

2. **Authentication Failed**
   - Verify SERVICE_SECRET is set correctly in all services
   - Check Service-Key header is being sent
   - Ensure ServiceAuthentication middleware is registered

3. **Database Connection Issues**
   - Check database credentials
   - Ensure databases are created
   - Run migrations and seeders

4. **CORS Issues**
   - Configure CORS in each service
   - Add appropriate headers for inter-service communication

### Debug Steps

1. **Check Service Status**:
```bash
curl -I http://localhost:8001
curl -I http://localhost:8002
curl -I http://localhost:8003
curl -I http://localhost:8004
```

2. **Check Service Logs**:
```bash
# Check Laravel logs in each service
tail -f user-service/storage/logs/laravel.log
tail -f program-service/storage/logs/laravel.log
tail -f task-service/storage/logs/laravel.log
tail -f trainee-service/storage/logs/laravel.log
```

3. **Test Individual Services**:
```bash
# Test User Service
curl http://localhost:8003/v1/api/users/email/admin@training.com

# Test Program Service
curl http://localhost:8001/v1/api/fields

# Test Task Service
curl http://localhost:8002/v1/api/tasks

# Test Trainee Service
curl http://localhost:8004/v1/api/trainees
```

## 📈 Performance Testing

### Load Testing Inter-Service Communication

```bash
# Test multiple concurrent requests
for i in {1..10}; do
  curl -X GET http://localhost:8002/v1/api/tasks/1 &
done
wait
```

### Monitoring Response Times

```bash
# Test response time
time curl -X GET http://localhost:8002/v1/api/tasks/1
```

## 🎯 Success Criteria

A successful inter-service communication test should demonstrate:

✅ **Service Discovery**: Services can find and communicate with each other  
✅ **Data Validation**: Services verify data exists in other services before creating relationships  
✅ **Error Handling**: Services handle communication failures gracefully  
✅ **Data Consistency**: Information retrieved from multiple services is consistent  
✅ **Authentication**: Service-to-service communication is properly secured  
✅ **Performance**: Communication happens within acceptable time limits  

## 📝 Next Steps

After successful testing:

1. **Production Configuration**: Update service URLs and secrets for production
2. **Monitoring**: Set up alerts for service communication failures
3. **Load Balancing**: Implement load balancing for high availability
4. **Caching**: Add caching to reduce inter-service calls
5. **Documentation**: Update API documentation with inter-service examples
