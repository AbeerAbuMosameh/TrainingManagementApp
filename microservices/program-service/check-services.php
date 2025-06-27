<?php

/**
 * Service Health Check Script
 *
 * This script checks if all microservices are running and accessible
 */

class ServiceHealthCheck
{
    private $services = [
        'User Service' => 'http://localhost:8003/api/health',
        'Program Service' => 'http://localhost:8001/api/health',
        'Task Service' => 'http://localhost:8002/api/health',
        'Trainee Service' => 'http://localhost:8004/api/health'
    ];

    public function checkAllServices()
    {

        $allHealthy = true;

        foreach ($this->services as $name => $url) {
            $status = $this->checkService($name, $url);
            if (!$status) {
                $allHealthy = false;
            }
        }


        if ($allHealthy) {
            echo "✅ All services are running and healthy!\n";
            echo "🚀 Ready to test inter-service communication.\n";
        } else {
            echo "❌ Some services are not running.\n";
            echo "⚠️  Please start all services before testing.\n";
        }

        return $allHealthy;
    }

    private function checkService($name, $url)
    {
        echo "Checking {$name}... ";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_NOBODY, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            echo "❌ Connection failed: {$error}\n";
            return false;
        }

        if ($httpCode !== 200) {
            echo "❌ HTTP {$httpCode}\n";
            return false;
        }

        $data = json_decode($response, true);
        if (!$data || !isset($data['status']) || !$data['status']) {
            echo "❌ Invalid response\n";
            return false;
        }

        echo "✅ Running ({$data['service']})\n";
        return true;
    }

    public function testInterServiceCommunication()
    {
        echo "\n🧪 Testing Inter-Service Communication...\n";
        echo "=======================================\n\n";

        // Test 1: User Service → Get user by email
        echo "1. Testing User Service (get user by email)... ";
        $response = $this->makeServiceRequest('http://localhost:8003/v1/api/users/email/admin@training.com');
        if ($response && $response['status']) {
            echo "✅ PASS\n";
        } else {
            echo "❌ FAIL\n";
        }

        // Test 2: Program Service → Get fields
        echo "2. Testing Program Service (get fields)... ";
        $response = $this->makeServiceRequest('http://localhost:8001/v1/api/fields');
        if ($response && isset($response['data'])) {
            echo "✅ PASS\n";
        } else {
            echo "❌ FAIL\n";
        }

        // Test 3: Task Service → Get tasks
        echo "3. Testing Task Service (get tasks)... ";
        $response = $this->makeServiceRequest('http://localhost:8002/v1/api/tasks');
        if ($response && isset($response['data'])) {
            echo "✅ PASS\n";
        } else {
            echo "❌ FAIL\n";
        }

        // Test 4: Trainee Service → Get trainees
        echo "4. Testing Trainee Service (get trainees)... ";
        $response = $this->makeServiceRequest('http://localhost:8004/v1/api/trainees');
        if ($response && isset($response['data'])) {
            echo "✅ PASS\n";
        } else {
            echo "❌ FAIL\n";
        }
    }

    private function makeServiceRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Service-Key: test_service_secret_key_123'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}

// Run the health check
$checker = new ServiceHealthCheck();

if ($checker->checkAllServices()) {
    echo "\n";
    $checker->testInterServiceCommunication();

    echo "\n🎉 All checks completed!\n";
    echo "You can now run the full inter-service communication test:\n";
    echo "php test-inter-service.php\n";
} else {
    echo "\n❌ Please start all services first:\n";
    echo "start-services.bat\n";
    echo "\nOr manually start each service:\n";
    echo "- User Service: cd user-service && php artisan serve --port=8003\n";
    echo "- Program Service: cd program-service && php artisan serve --port=8001\n";
    echo "- Task Service: cd task-service && php artisan serve --port=8002\n";
    echo "- Trainee Service: cd trainee-service && php artisan serve --port=8004\n";
}
