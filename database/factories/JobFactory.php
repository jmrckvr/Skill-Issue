<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->text(500),
            'location' => $this->faker->city() . ', Metro Manila',
            'job_type' => $this->faker->randomElement(['full-time', 'part-time', 'contract', 'temporary', 'freelance']),
            'experience_level' => $this->faker->randomElement(['entry', 'mid', 'senior', 'executive']),
            'salary_min' => $this->faker->numberBetween(30000, 80000),
            'salary_max' => $this->faker->numberBetween(80000, 200000),
            'currency' => 'PHP',
            'hide_salary' => false,
            'requirements' => $this->faker->text(300),
            'benefits' => $this->faker->text(300),
            'application_count' => 0,
            'status' => 'draft',
            'published_at' => null,
            'closed_at' => null,
        ];
    }
}
