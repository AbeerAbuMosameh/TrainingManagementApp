# Environment Configuration Setup Guide

This guide explains how to set up the `.env` files for all microservices to enable inter-service communication.

## 🚀 Quick Setup

### Option 1: Automated Setup (Recommended)

Run the automated setup script:
```bash
setup-env.bat
```

This script will:
- Copy `.env` templates to each service
- Generate application keys
- Run migrations and seeders
- Set up all databases

### Option 2: Manual Setup

If you prefer to set up manually, follow these steps:

## 📋 Manual Setup Steps

### Step 1: Copy .env Files

Copy the template files to each service:

```bash
# User Service
copy user-service-env.txt user-service\.env

# Program Service
copy program-service-env.txt program-service\.env

# Task Service
copy task-service-env.txt task-service\.env

# Trainee Service
copy trainee-service-env.txt trainee-service\.env
```

### Step 2: Generate Application Keys

Generate unique application keys for each service:

```bash
# User Service
cd user-service
php artisan key:generate
cd ..

# Program Service
cd program-service
php artisan key:generate
cd ..

# Task Service
cd task-service
php artisan key:generate
cd ..

# Trainee Service
cd trainee-service
php artisan key:generate
cd ..
```

### Step 3: Run Migrations and Seeders

Set up the databases for each service:

```bash
# User Service
cd user-service
php artisan migrate --seed
cd ..

# Program Service
cd program-service
php artisan migrate --seed
cd ..

# Task Service
cd task-service
php artisan migrate --seed
cd ..

# Trainee Service
cd trainee-service
php artisan migrate --seed
cd ..
```

## 🔧 Configuration Details

### User Service Configuration

**File**: `user-service/.env`

**Key Settings**:
```env
APP_NAME="Training Management System - User Service"
APP_URL=http://localhost:8003
DB_DATABASE=user_service

# Inter-Service Communication
SERVICE_SECRET=test_service_secret_key_123
PROGRAM_SERVICE_URL=http://localhost:8001
TASK_SERVICE_URL=http://localhost:8002
TRAINEE_SERVICE_URL=http://localhost:8004
```

### Program Service Configuration

**File**: `program-service/.env`

**Key Settings**:
```env
APP_NAME="Training Management System - Program Service"
APP_URL=http://localhost:8001
DB_DATABASE=program_service

# Inter-Service Communication
SERVICE_SECRET=test_service_secret_key_123
USER_SERVICE_URL=http://localhost:8003
ADVISOR_SERVICE_URL=http://localhost:8005
```

### Task Service Configuration

**File**: `task-service/.env`

**Key Settings**:
```env
APP_NAME="Training Management System - Task Service"
APP_URL=http://localhost:8002
DB_DATABASE=task_service

# Inter-Service Communication
SERVICE_SECRET=test_service_secret_key_123
USER_SERVICE_URL=http://localhost:8003
PROGRAM_SERVICE_URL=http://localhost:8001
ADVISOR_SERVICE_URL=http://localhost:8005
```

### Trainee Service Configuration

**File**: `trainee-service/.env`

**Key Settings**:
```env
APP_NAME="Training Management System - Trainee Service"
APP_URL=http://localhost:8004
DB_DATABASE=trainee_service

# Inter-Service Communication
SERVICE_SECRET=test_service_secret_key_123
USER_SERVICE_URL=http://localhost:8003
```

## 🔐 Service Authentication

All services use the same `SERVICE_SECRET` for inter-service communication:

```env
SERVICE_SECRET=test_service_secret_key_123
```

This secret is used in the `Service-Key` header for all inter-service API calls:

```bash
curl -H "Service-Key: test_service_secret_key_123" \
  http://localhost:8003/v1/api/users/email/test@example.com
```

## 🌐 Service URLs

Each service is configured to run on a specific port:

| Service | Port | URL |
|---------|------|-----|
| User Service | 8003 | http://localhost:8003 |
| Program Service | 8001 | http://localhost:8001 |
| Task Service | 8002 | http://localhost:8002 |
| Trainee Service | 8004 | http://localhost:8004 |

## 🗄️ Database Configuration

Each service has its own database:

| Service | Database Name |
|---------|---------------|
| User Service | `user_service` |
| Program Service | `program_service` |
| Task Service | `task_service` |
| Trainee Service | `trainee_service` |

**Database Settings**:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_USERNAME=root
DB_PASSWORD=
```

## 🔍 Verification Steps

After setup, verify the configuration:

### 1. Check Service Health
```bash
php check-services.php
```

### 2. Test Individual Services
```bash
# User Service
curl http://localhost:8003/health

# Program Service
curl http://localhost:8001/health

# Task Service
curl http://localhost:8002/health

# Trainee Service
curl http://localhost:8004/health
```

### 3. Test Inter-Service Communication
```bash
php test-inter-service.php
```

## 🐛 Troubleshooting

### Common Issues

1. **Port Already in Use**
   - Check if another service is running on the same port
   - Change the port in the `.env` file if needed

2. **Database Connection Failed**
   - Verify MySQL is running
   - Check database credentials
   - Ensure databases exist

3. **Application Key Issues**
   - Run `php artisan key:generate` for each service
   - Clear config cache: `php artisan config:clear`

4. **Service Authentication Failed**
   - Verify `SERVICE_SECRET` is set correctly in all services
   - Check that the secret matches in all `.env` files

### Debug Commands

```bash
# Clear Laravel caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# Check Laravel configuration
php artisan config:show

# Test database connection
php artisan tinker
DB::connection()->getPdo();
```

## 📝 Customization

### Changing Service URLs

If you need to change service URLs (e.g., for production), update the URLs in each service's `.env`:

```env
# For production
USER_SERVICE_URL=https://user-service.yourdomain.com
PROGRAM_SERVICE_URL=https://program-service.yourdomain.com
TASK_SERVICE_URL=https://task-service.yourdomain.com
TRAINEE_SERVICE_URL=https://trainee-service.yourdomain.com
```

### Changing Service Secret

For production, use a strong, unique secret:

```env
SERVICE_SECRET=your-production-secret-key-here
```

### Database Configuration

For production databases, update the database settings:

```env
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## ✅ Success Criteria

After setup, you should be able to:

1. ✅ Start all services without errors
2. ✅ Access health endpoints for all services
3. ✅ Run migrations and seeders successfully
4. ✅ Test inter-service communication
5. ✅ Create and retrieve data across services

## 🎯 Next Steps

After successful environment setup:

1. **Start Services**: Run `start-services.bat`
2. **Verify Health**: Run `php check-services.php`
3. **Test Communication**: Run `php test-inter-service.php`
4. **Review Documentation**: Check `INTER_SERVICE_TESTING.md`

---

**Environment setup is now complete! 🚀**

Your microservices are configured for inter-service communication and ready for testing. 