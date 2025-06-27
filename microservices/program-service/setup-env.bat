@echo off
echo Setting up .env files for all services...
echo ========================================

echo.
echo Copying User Service .env...
copy user-service-env.txt user-service\.env

echo.
echo Copying Program Service .env...
copy program-service-env.txt program-service\.env

echo.
echo Copying Task Service .env...
copy task-service-env.txt task-service\.env

echo.
echo Copying Trainee Service .env...
copy trainee-service-env.txt trainee-service\.env

echo.
echo Generating application keys...
echo.

echo Generating User Service key...
cd user-service
php artisan key:generate
cd ..

echo Generating Program Service key...
cd program-service
php artisan key:generate
cd ..

echo Generating Task Service key...
cd task-service
php artisan key:generate
cd ..

echo Generating Trainee Service key...
cd trainee-service
php artisan key:generate
cd ..

echo.
echo Running migrations and seeders...
echo.

echo Setting up User Service database...
cd user-service
php artisan migrate --seed
cd ..

echo Setting up Program Service database...
cd program-service
php artisan migrate --seed
cd ..

echo Setting up Task Service database...
cd task-service
php artisan migrate --seed
cd ..

echo Setting up Trainee Service database...
cd trainee-service
php artisan migrate --seed
cd ..

echo.
echo ========================================
echo Environment setup completed!
echo ========================================
echo.
echo Next steps:
echo 1. Start all services: start-services.bat
echo 2. Check service health: php check-services.php
echo 3. Run inter-service tests: php test-inter-service.php
echo.
pause 