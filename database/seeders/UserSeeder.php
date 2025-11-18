<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@jobstreet.local',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Create employer users
        $employers = [
            ['name' => 'Juan Dela Cruz', 'email' => 'juan@acmetech.com'],
            ['name' => 'Maria Santos', 'email' => 'maria@globalfinance.com'],
            ['name' => 'Carlos Reyes', 'email' => 'carlos@philhealth.com'],
            ['name' => 'Ana Garcia', 'email' => 'ana@retailco.com'],
            ['name' => 'Pedro Martinez', 'email' => 'pedro@constructionpro.com'],
        ];

        foreach ($employers as $employer) {
            \App\Models\User::create([
                'name' => $employer['name'],
                'email' => $employer['email'],
                'password' => bcrypt('password'),
                'role' => 'employer',
                'email_verified_at' => now(),
                'is_active' => true,
            ]);
        }

        // Create jobseeker users
        $jobseekers = [
            ['name' => 'Rosa Fernandez', 'email' => 'rosa.fernandez@email.com'],
            ['name' => 'Miguel Torres', 'email' => 'miguel.torres@email.com'],
            ['name' => 'Elena Ramos', 'email' => 'elena.ramos@email.com'],
            ['name' => 'Luis Villanueva', 'email' => 'luis.villanueva@email.com'],
            ['name' => 'Sofia Mendoza', 'email' => 'sofia.mendoza@email.com'],
            ['name' => 'Diego Castillo', 'email' => 'diego.castillo@email.com'],
            ['name' => 'Angela Gonzales', 'email' => 'angela.gonzales@email.com'],
            ['name' => 'Roberto Flores', 'email' => 'roberto.flores@email.com'],
            ['name' => 'Patricia Moreno', 'email' => 'patricia.moreno@email.com'],
            ['name' => 'Francisco Ruiz', 'email' => 'francisco.ruiz@email.com'],
            ['name' => 'Isabella Valdez', 'email' => 'isabella.valdez@email.com'],
            ['name' => 'Antonio Navarro', 'email' => 'antonio.navarro@email.com'],
            ['name' => 'Valentina Cruz', 'email' => 'valentina.cruz@email.com'],
            ['name' => 'Raul Gutierrez', 'email' => 'raul.gutierrez@email.com'],
            ['name' => 'Catalina Romero', 'email' => 'catalina.romero@email.com'],
        ];

        foreach ($jobseekers as $jobseeker) {
            \App\Models\User::create([
                'name' => $jobseeker['name'],
                'email' => $jobseeker['email'],
                'password' => bcrypt('password'),
                'role' => 'jobseeker',
                'email_verified_at' => now(),
                'is_active' => true,
            ]);
        }
    }
}
