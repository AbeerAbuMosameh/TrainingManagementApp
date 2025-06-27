<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Advisor;
use Illuminate\Support\Facades\Hash;

class AdvisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $advisors = [
            [
                'image' => 'advisor1.jpg',
                'first_name' => 'Alice',
                'last_name' => 'Smith',
                'email' => 'alice.smith@advisors.com',
                'phone' => '+1234567890',
                'education' => 'PhD in Computer Science',
                'address' => '123 Main Street',
                'city' => 'New York',
                'language' => 'English',
                'cv' => 'alice_smith_cv.pdf',
                'certification' => 'AWS Certified Solutions Architect',
                'otherFile' => json_encode(['certificate1.pdf', 'certificate2.pdf']),
                'is_approved' => true,
                'password' => Hash::make('password123'),
                'notification_id' => null,
            ],
            [
                'image' => 'advisor2.jpg',
                'first_name' => 'Bob',
                'last_name' => 'Johnson',
                'email' => 'bob.johnson@advisors.com',
                'phone' => '+0987654321',
                'education' => 'MSc in Software Engineering',
                'address' => '456 Oak Avenue',
                'city' => 'Los Angeles',
                'language' => 'English',
                'cv' => 'bob_johnson_cv.pdf',
                'certification' => 'Microsoft Certified Developer',
                'otherFile' => json_encode(['certificate3.pdf']),
                'is_approved' => true,
                'password' => Hash::make('password123'),
                'notification_id' => null,
            ],
            [
                'image' => 'advisor3.jpg',
                'first_name' => 'Fatima',
                'last_name' => 'Al-Zahra',
                'email' => 'fatima.alzahra@advisors.com',
                'phone' => '+971501234567',
                'education' => 'PhD in Information Technology',
                'address' => '789 Sheikh Zayed Road',
                'city' => 'Dubai',
                'language' => 'Arabic',
                'cv' => 'fatima_alzahra_cv.pdf',
                'certification' => 'Oracle Certified Professional',
                'otherFile' => json_encode(['certificate4.pdf', 'certificate5.pdf']),
                'is_approved' => false,
                'password' => Hash::make('password123'),
                'notification_id' => null,
            ],
            [
                'image' => 'advisor4.jpg',
                'first_name' => 'Jean',
                'last_name' => 'Dubois',
                'email' => 'jean.dubois@advisors.com',
                'phone' => '+33123456789',
                'education' => 'MSc in Data Science',
                'address' => '321 Champs-Élysées',
                'city' => 'Paris',
                'language' => 'French',
                'cv' => 'jean_dubois_cv.pdf',
                'certification' => 'Google Cloud Professional',
                'otherFile' => json_encode(['certificate6.pdf']),
                'is_approved' => true,
                'password' => Hash::make('password123'),
                'notification_id' => null,
            ],
        ];

        foreach ($advisors as $advisorData) {
            Advisor::create($advisorData);
        }
    }
}
