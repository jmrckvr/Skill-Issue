<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                'user_id' => 2,
                'name' => 'ACME Tech Solutions',
                'description' => 'Leading IT solutions provider in the Philippines specializing in cloud infrastructure and software development.',
                'website' => 'https://acmetech.com',
                'phone' => '+63-2-8123-4567',
                'email' => 'careers@acmetech.com',
                'city' => 'Manila',
                'state' => 'Metro Manila',
                'country' => 'Philippines',
                'employee_count' => 150,
                'industry' => 'Information Technology',
                'is_verified' => true,
            ],
            [
                'user_id' => 3,
                'name' => 'Global Finance PH',
                'description' => 'International financial services company offering banking and investment solutions.',
                'website' => 'https://globalfinanceph.com',
                'phone' => '+63-2-8765-4321',
                'email' => 'hr@globalfinanceph.com',
                'city' => 'Makati',
                'state' => 'Metro Manila',
                'country' => 'Philippines',
                'employee_count' => 500,
                'industry' => 'Finance & Banking',
                'is_verified' => true,
            ],
            [
                'user_id' => 4,
                'name' => 'PhilHealth Solutions',
                'description' => 'Healthcare provider committed to improving healthcare access in the Philippines.',
                'website' => 'https://philhealth.com.ph',
                'phone' => '+63-2-9876-5432',
                'email' => 'recruitment@philhealth.com.ph',
                'city' => 'Quezon City',
                'state' => 'Metro Manila',
                'country' => 'Philippines',
                'employee_count' => 800,
                'industry' => 'Healthcare',
                'is_verified' => true,
            ],
            [
                'user_id' => 5,
                'name' => 'RetailCo Philippines',
                'description' => 'Largest retail chain in Southeast Asia with presence in Philippines.',
                'website' => 'https://retailco.com.ph',
                'phone' => '+63-2-5555-1234',
                'email' => 'careers@retailco.com.ph',
                'city' => 'Cebu',
                'state' => 'Cebu',
                'country' => 'Philippines',
                'employee_count' => 1200,
                'industry' => 'Retail',
                'is_verified' => true,
            ],
            [
                'user_id' => 6,
                'name' => 'ConstructionPro Engineering',
                'description' => 'Premium construction and engineering firm building Philippines infrastructure.',
                'website' => 'https://constructionpro.com',
                'phone' => '+63-2-7777-8888',
                'email' => 'jobs@constructionpro.com',
                'city' => 'Davao',
                'state' => 'Davao del Sur',
                'country' => 'Philippines',
                'employee_count' => 350,
                'industry' => 'Engineering & Construction',
                'is_verified' => true,
            ],
            [
                'user_id' => 2,
                'name' => 'StartupHub Asia',
                'description' => 'Accelerator program supporting tech startups across the Philippines.',
                'website' => 'https://startuphub.asia',
                'phone' => '+63-2-3333-4444',
                'email' => 'apply@startuphub.asia',
                'city' => 'Manila',
                'state' => 'Metro Manila',
                'country' => 'Philippines',
                'employee_count' => 50,
                'industry' => 'Technology & Startups',
                'is_verified' => false,
            ],
            [
                'user_id' => 3,
                'name' => 'Infotech Innovations',
                'description' => 'Cutting-edge software and IT consulting services for enterprises.',
                'website' => 'https://infotechinnovations.com',
                'phone' => '+63-2-1111-2222',
                'email' => 'careers@infotechinnovations.com',
                'city' => 'Makati',
                'state' => 'Metro Manila',
                'country' => 'Philippines',
                'employee_count' => 200,
                'industry' => 'Information Technology',
                'is_verified' => true,
            ],
            [
                'user_id' => 4,
                'name' => 'MediCare Services',
                'description' => 'Leading healthcare service provider in Southeast Asia.',
                'website' => 'https://medicareservices.com',
                'phone' => '+63-2-6666-7777',
                'email' => 'hr@medicareservices.com',
                'city' => 'Manila',
                'state' => 'Metro Manila',
                'country' => 'Philippines',
                'employee_count' => 600,
                'industry' => 'Healthcare',
                'is_verified' => true,
            ],
            [
                'user_id' => 5,
                'name' => 'EduPlus Learning Systems',
                'description' => 'Educational technology company transforming learning in Philippines.',
                'website' => 'https://eduplus.com.ph',
                'phone' => '+63-2-9999-0000',
                'email' => 'careers@eduplus.com.ph',
                'city' => 'Pasig',
                'state' => 'Metro Manila',
                'country' => 'Philippines',
                'employee_count' => 100,
                'industry' => 'Education & Training',
                'is_verified' => true,
            ],
            [
                'user_id' => 6,
                'name' => 'Logistics Express PH',
                'description' => 'Fast and reliable logistics and supply chain solutions.',
                'website' => 'https://logisticsexpress.com.ph',
                'phone' => '+63-2-4444-5555',
                'email' => 'recruitment@logisticsexpress.com.ph',
                'city' => 'Port Area',
                'state' => 'Metro Manila',
                'country' => 'Philippines',
                'employee_count' => 450,
                'industry' => 'Logistics & Transportation',
                'is_verified' => true,
            ],
        ];

        foreach ($companies as $company) {
            \App\Models\Company::create($company);
        }
    }
}
