#!/bin/bash

echo "Setting up Training Management System - Microservices Architecture"
echo "=================================================================="

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if Docker is installed
print_status "Checking Docker installation..."
if ! command -v docker &> /dev/null; then
    print_error "Docker is not installed. Please install Docker first."
    exit 1
fi

if ! command -v docker-compose &> /dev/null; then
    print_error "Docker Compose is not installed. Please install Docker Compose first."
    exit 1
fi

print_success "Docker and Docker Compose are installed"

# Create Dockerfiles for all services
print_status "Creating Dockerfiles for all services..."
chmod +x create_dockerfiles.sh
./create_dockerfiles.sh

# Setup environment files
print_status "Setting up environment files..."
chmod +x setup_environment.sh
./setup_environment.sh

# Build and start services
print_status "Building and starting all services..."
docker-compose build

print_status "Starting services in detached mode..."
docker-compose up -d

# Wait for services to be ready
print_status "Waiting for services to be ready..."
sleep 30

# Run migrations
print_status "Running database migrations..."
services=("user-service" "trainee-service" "advisor-service" "field-service" "program-service" "task-service" "registry-service" "config-service")

for service in "${services[@]}"; do
    print_status "Running migrations for $service..."
    docker-compose exec -T $service php artisan migrate --force
    if [ $? -eq 0 ]; then
        print_success "Migrations completed for $service"
    else
        print_warning "Migrations failed for $service (this might be normal if tables already exist)"
    fi
done

# Generate application keys
print_status "Generating application keys..."
for service in "${services[@]}"; do
    print_status "Generating key for $service..."
    docker-compose exec -T $service php artisan key:generate --force
done

# Check service health
print_status "Checking service health..."
sleep 10

echo ""
echo "🏥 Health Check Results:"
echo "========================"

# Check gateway
if curl -s http://localhost:8080/health > /dev/null; then
    print_success "Gateway Service: HEALTHY"
else
    print_error "Gateway Service: UNHEALTHY"
fi

# Check individual services
services_with_ports=(
    "user-service:8003"
    "trainee-service:8004"
    "advisor-service:8005"
    "field-service:8006"
    "program-service:8001"
    "task-service:8002"
    "registry-service:8500"
    "config-service:8501"
)

for service_port in "${services_with_ports[@]}"; do
    IFS=':' read -r service port <<< "$service_port"
    if curl -s http://localhost:$port/api/health > /dev/null; then
        print_success "$service: HEALTHY"
    else
        print_warning "$service: UNHEALTHY (might still be starting)"
    fi
done

echo ""
echo "Setup Complete!"
echo "=================="
echo ""
echo "📋 Next Steps:"
echo "1. Import the Postman collection: 'Training Management System - Gateway Collection.postman_collection.json'"
echo "2. Set environment variables in Postman:"
echo "   - gateway_url: http://localhost:8080"
echo "   - service_secret: SERVICE_SECRET_KEY_2024"
echo ""
echo "🌐 Service URLs:"
echo "   - API Gateway: http://localhost:8080"
echo "   - User Service: http://localhost:8003"
echo "   - Trainee Service: http://localhost:8004"
echo "   - Advisor Service: http://localhost:8005"
echo "   - Field Service: http://localhost:8006"
echo "   - Program Service: http://localhost:8001"
echo "   - Task Service: http://localhost:8002"
echo "   - Registry Service: http://localhost:8500"
echo "   - Config Service: http://localhost:8501"
echo ""
echo "🔧 Useful Commands:"
echo "   - View logs: docker-compose logs [service-name]"
echo "   - Stop services: docker-compose down"
echo "   - Restart services: docker-compose restart"
echo "   - Rebuild services: docker-compose up --build"
echo ""
echo "📚 Documentation: See README.md for detailed information"
echo ""
print_success "Training Management System is ready to use! "