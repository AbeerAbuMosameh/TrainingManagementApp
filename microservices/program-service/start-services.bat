@echo off
echo Starting Training Management System Microservices...
echo ================================================

echo.
echo Starting User Service on port 8003...
start "User Service" cmd /k "cd user-service && php artisan serve --port=8003"

echo.
echo Starting Program Service on port 8001...
start "Program Service" cmd /k "cd program-service && php artisan serve --port=8001"

echo.
echo Starting Task Service on port 8002...
start "Task Service" cmd /k "cd task-service && php artisan serve --port=8002"

echo.
echo Starting Trainee Service on port 8004...
start "Trainee Service" cmd /k "cd trainee-service && php artisan serve --port=8004"

echo.
echo All services are starting...
echo.
echo Service URLs:
echo - User Service: http://localhost:8003
echo - Program Service: http://localhost:8001
echo - Task Service: http://localhost:8002
echo - Trainee Service: http://localhost:8004
echo.
echo Wait for all services to start, then run: php test-inter-service.php
echo.
pause 