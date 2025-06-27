@echo off
echo Testing Inter-Service Communication with cURL
echo =============================================

echo.
echo Step 1: Testing User Service Registration
echo -----------------------------------------
curl -X POST http://localhost:8003/v1/api/register ^
  -H "Content-Type: application/json" ^
  -d "{\"name\":\"Test User\",\"email\":\"test@example.com\",\"password\":\"password123\",\"password_confirmation\":\"password123\",\"level\":2}"

echo.
echo.
echo Step 2: Testing User Service Login
echo ----------------------------------
curl -X POST http://localhost:8003/v1/api/login ^
  -H "Content-Type: application/json" ^
  -d "{\"email\":\"test@example.com\",\"password\":\"password123\"}"

echo.
echo.
echo Step 3: Testing Program Service (Create Field)
echo ----------------------------------------------
curl -X POST http://localhost:8001/v1/api/fields ^
  -H "Content-Type: application/json" ^
  -d "{\"name\":\"Test Field\"}"

echo.
echo.
echo Step 4: Testing Program Service (Create Program)
echo ------------------------------------------------
curl -X POST http://localhost:8001/v1/api/programs ^
  -H "Content-Type: application/json" ^
  -d "{\"name\":\"Test Program\",\"type\":\"free\",\"hours\":\"40\",\"start_date\":\"2025-07-01\",\"end_date\":\"2025-08-01\",\"field_id\":1,\"advisor_id\":1,\"duration\":\"weeks\",\"level\":\"intermediate\",\"language\":\"English\",\"description\":\"Test program\",\"number\":10}"

echo.
echo.
echo Step 5: Testing Task Service (Create Task)
echo ------------------------------------------
curl -X POST http://localhost:8002/v1/api/tasks ^
  -H "Content-Type: application/json" ^
  -d "{\"program_id\":1,\"advisor_id\":1,\"start_date\":\"2025-07-10\",\"end_date\":\"2025-07-15\",\"mark\":50,\"description\":\"Test task\"}"

echo.
echo.
echo Step 6: Testing Task Service (Get Task with Details)
echo ----------------------------------------------------
curl -X GET http://localhost:8002/v1/api/tasks/1 ^
  -H "Service-Key: test_service_secret_key_123"

echo.
echo.
echo Step 7: Testing Trainee Service (Create Trainee)
echo ------------------------------------------------
curl -X POST http://localhost:8004/v1/api/trainees ^
  -H "Content-Type: application/json" ^
  -d "{\"first_name\":\"Test\",\"last_name\":\"Trainee\",\"email\":\"trainee@example.com\",\"phone\":\"123456789\",\"education\":\"Computer Science\",\"address\":\"Gaza\",\"password\":\"password123\"}"

echo.
echo.
echo Step 8: Testing Error Handling (Invalid Program ID)
echo ---------------------------------------------------
curl -X POST http://localhost:8002/v1/api/tasks ^
  -H "Content-Type: application/json" ^
  -d "{\"program_id\":999,\"advisor_id\":1,\"start_date\":\"2025-07-10\",\"end_date\":\"2025-07-15\",\"mark\":50,\"description\":\"This should fail\"}"

echo.
echo.
echo Testing completed!
echo Check the responses above to verify inter-service communication.
pause 