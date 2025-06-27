<?php

/**
 * Inter-Service Communication Test Script
 * 
 * This script tests how services communicate with each other
 * Run this after starting all services
 */

class InterServiceTest
{
    private $baseUrls = [
        'user' => 'http://localhost:8003',
        'program' => 'http://localhost:8001',
        'task' => 'http://localhost:8002',
        'trainee' => 'http://localhost:8004'
    ];

    private $serviceKey = 'test_service_secret_key';
    private $results = [];

    public function runAllTests()
    {
        echo "🚀 Starting Inter-Service Communication Tests...\n\n";
        
        // Test 1: User Service
        $userId = $this->testUserService();
        
        // Test 2: Program Service with User verification
        $programId = $this->testProgramService($userId);
        
        // Test 3: Task Service with Program and User verification
        $taskId = $this->testTaskService($programId, $userId);
        
        // Test 4: Trainee Service
        $traineeId = $this->testTraineeService();
        
        // Test 5: Get task with full details
        $this->testGetTaskWithDetails($taskId);
        
        // Test 6: Error handling
        $this->testErrorHandling();
        
        $this->printResults();
    }

    private function testUserService()
    {
        echo "📋 Testing User Service...\n";
        
        // Test user registration
        $response = $this->makeRequest('user', 'POST', '/v1/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'level' => 2
        ]);
        
        if ($response && $response['status']) {
            echo "✅ User registration: PASS\n";
            $this->results['user_registration'] = 'PASS';
            return $response['data']['user']['id'];
        } else {
            echo "❌ User registration: FAIL\n";
            $this->results['user_registration'] = 'FAIL';
            return null;
        }
    }

    private function testProgramService($userId)
    {
        echo "📚 Testing Program Service...\n";
        
        if (!$userId) {
            echo "⚠️  Skipping program test - no user ID\n";
            $this->results['program_creation'] = 'SKIP';
            return null;
        }
        
        // Test program creation with user verification
        $response = $this->makeRequest('program', 'POST', '/v1/api/programs', [
            'name' => 'Test Program',
            'type' => 'free',
            'hours' => '40',
            'start_date' => '2025-07-01',
            'end_date' => '2025-08-01',
            'field_id' => 1,
            'advisor_id' => $userId,
            'duration' => 'weeks',
            'level' => 'intermediate',
            'language' => 'English',
            'description' => 'Test program for inter-service communication',
            'number' => 10
        ]);
        
        if ($response && $response['status']) {
            echo "✅ Program creation: PASS\n";
            $this->results['program_creation'] = 'PASS';
            return $response['data']['id'];
        } else {
            echo "❌ Program creation: FAIL\n";
            $this->results['program_creation'] = 'FAIL';
            return null;
        }
    }

    private function testTaskService($programId, $userId)
    {
        echo "📝 Testing Task Service...\n";
        
        if (!$programId || !$userId) {
            echo "⚠️  Skipping task test - missing program or user ID\n";
            $this->results['task_creation'] = 'SKIP';
            return null;
        }
        
        // Test task creation with program verification
        $response = $this->makeRequest('task', 'POST', '/v1/api/tasks', [
            'program_id' => $programId,
            'advisor_id' => $userId,
            'start_date' => '2025-07-10',
            'end_date' => '2025-07-15',
            'mark' => 50,
            'description' => 'Test task for inter-service communication'
        ]);
        
        if ($response && $response['status']) {
            echo "✅ Task creation: PASS\n";
            $this->results['task_creation'] = 'PASS';
            return $response['data']['id'];
        } else {
            echo "❌ Task creation: FAIL\n";
            $this->results['task_creation'] = 'FAIL';
            return null;
        }
    }

    private function testTraineeService()
    {
        echo "👤 Testing Trainee Service...\n";
        
        // Test trainee creation
        $response = $this->makeRequest('trainee', 'POST', '/v1/api/trainees', [
            'first_name' => 'Test',
            'last_name' => 'Trainee',
            'email' => 'trainee@example.com',
            'phone' => '123456789',
            'education' => 'Computer Science',
            'address' => 'Gaza',
            'password' => 'password123'
        ]);
        
        if ($response && $response['status']) {
            echo "✅ Trainee creation: PASS\n";
            $this->results['trainee_creation'] = 'PASS';
            return $response['data']['id'];
        } else {
            echo "❌ Trainee creation: FAIL\n";
            $this->results['trainee_creation'] = 'FAIL';
            return null;
        }
    }

    private function testGetTaskWithDetails($taskId)
    {
        echo "🔍 Testing Task Retrieval with Details...\n";
        
        if (!$taskId) {
            echo "⚠️  Skipping task retrieval test - no task ID\n";
            $this->results['task_retrieval'] = 'SKIP';
            return;
        }
        
        // Test getting task with program and advisor details
        $response = $this->makeRequest('task', 'GET', "/v1/api/tasks/{$taskId}");
        
        if ($response && $response['status']) {
            echo "✅ Task retrieval: PASS\n";
            echo "   - Task ID: {$response['data']['id']}\n";
            echo "   - Program: {$response['data']['program']['name']}\n";
            echo "   - Advisor: {$response['data']['advisor']['name']}\n";
            $this->results['task_retrieval'] = 'PASS';
        } else {
            echo "❌ Task retrieval: FAIL\n";
            $this->results['task_retrieval'] = 'FAIL';
        }
    }

    private function testErrorHandling()
    {
        echo "⚠️  Testing Error Handling...\n";
        
        // Test creating task with non-existent program
        $response = $this->makeRequest('task', 'POST', '/v1/api/tasks', [
            'program_id' => 999,
            'advisor_id' => 1,
            'start_date' => '2025-07-10',
            'end_date' => '2025-07-15',
            'mark' => 50,
            'description' => 'This should fail'
        ]);
        
        if ($response && !$response['status']) {
            echo "✅ Error handling: PASS (correctly rejected invalid program)\n";
            $this->results['error_handling'] = 'PASS';
        } else {
            echo "❌ Error handling: FAIL (should have rejected invalid program)\n";
            $this->results['error_handling'] = 'FAIL';
        }
    }

    private function makeRequest($service, $method, $endpoint, $data = null)
    {
        $url = $this->baseUrls[$service] . $endpoint;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Service-Key: ' . $this->serviceKey
        ]);
        
        if ($data && in_array($method, ['POST', 'PUT', 'PATCH'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            echo "   Network error: $error\n";
            return null;
        }
        
        $decoded = json_decode($response, true);
        
        if (!$decoded) {
            echo "   Invalid JSON response: $response\n";
            return null;
        }
        
        return $decoded;
    }

    private function printResults()
    {
        echo "\n📊 Test Results Summary:\n";
        echo "========================\n";
        
        foreach ($this->results as $test => $result) {
            $icon = $result === 'PASS' ? '✅' : ($result === 'SKIP' ? '⚠️' : '❌');
            echo "{$icon} {$test}: {$result}\n";
        }
        
        $passed = count(array_filter($this->results, fn($r) => $r === 'PASS'));
        $total = count($this->results);
        
        echo "\n🎯 Overall: {$passed}/{$total} tests passed\n";
        
        if ($passed === $total) {
            echo "🎉 All tests passed! Inter-service communication is working correctly.\n";
        } else {
            echo "⚠️  Some tests failed. Check service configuration and connectivity.\n";
        }
    }
}

// Check if services are running
function checkServices() {
    $services = [
        'User Service' => 'http://localhost:8003',
        'Program Service' => 'http://localhost:8001',
        'Task Service' => 'http://localhost:8002',
        'Trainee Service' => 'http://localhost:8004'
    ];
    
    echo "🔍 Checking if services are running...\n";
    
    foreach ($services as $name => $url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode > 0) {
            echo "✅ {$name}: Running (HTTP {$httpCode})\n";
        } else {
            echo "❌ {$name}: Not running\n";
        }
    }
    echo "\n";
}

// Run the tests
echo "🧪 Inter-Service Communication Test Suite\n";
echo "==========================================\n\n";

checkServices();

$test = new InterServiceTest();
$test->runAllTests(); 