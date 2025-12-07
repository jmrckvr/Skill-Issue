<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * This seeder creates an admin user for the application.
     * You can customize the admin email and password by modifying this file.
     */
    public function run(): void
    {
        // Create or update admin user
        $adminEmail = env('ADMIN_EMAIL', 'jmrckvr@gmail.com');
        $adminPassword = env('ADMIN_PASSWORD', 'admin123');
        $adminName = env('ADMIN_NAME', 'Admin User');

        $admin = User::where('email', $adminEmail)->first();

        if ($admin) {
            // Update existing user to be admin
            $admin->update([
                'role' => 'admin',
                'email_verified_at' => now(),
                'is_active' => true,
            ]);
            echo "\n✓ Updated existing user '{$adminEmail}' to admin role\n";
        } else {
            // Create new admin user
            User::create([
                'name' => $adminName,
                'email' => $adminEmail,
                'password' => bcrypt($adminPassword),
                'role' => 'admin',
                'email_verified_at' => now(),
                'is_active' => true,
            ]);
            echo "\n✓ Created new admin user: {$adminEmail}\n";
        }
    }
}
