<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Information Technology', 'slug' => 'information-technology', 'description' => 'Software, Web Development, IT Support', 'icon' => '💻'],
            ['name' => 'Healthcare', 'slug' => 'healthcare', 'description' => 'Doctors, Nurses, Medical Professionals', 'icon' => '⚕️'],
            ['name' => 'Finance & Accounting', 'slug' => 'finance-accounting', 'description' => 'Accountants, Financial Analysts, CFOs', 'icon' => '💰'],
            ['name' => 'Marketing & Sales', 'slug' => 'marketing-sales', 'description' => 'Marketing Manager, Sales Executive', 'icon' => '📊'],
            ['name' => 'Human Resources', 'slug' => 'human-resources', 'description' => 'HR Manager, Recruiter, Training Specialist', 'icon' => '👥'],
            ['name' => 'Engineering', 'slug' => 'engineering', 'description' => 'Civil, Mechanical, Electrical Engineers', 'icon' => '🔧'],
            ['name' => 'Education', 'slug' => 'education', 'description' => 'Teachers, Instructors, Professors', 'icon' => '📚'],
            ['name' => 'Hospitality & Tourism', 'slug' => 'hospitality-tourism', 'description' => 'Hotel Staff, Chefs, Tour Guides', 'icon' => '🏨'],
            ['name' => 'Logistics & Supply Chain', 'slug' => 'logistics-supply-chain', 'description' => 'Warehouse Manager, Logistics Coordinator', 'icon' => '🚚'],
            ['name' => 'Retail & Customer Service', 'slug' => 'retail-customer-service', 'description' => 'Sales Associate, Customer Service Rep', 'icon' => '🛍️'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
