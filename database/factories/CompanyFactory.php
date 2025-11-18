<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'description' => $this->faker->text(200),
            'website' => $this->faker->url(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->companyEmail(),
            'city' => $this->faker->city(),
            'state' => 'Metro Manila',
            'country' => 'Philippines',
            'logo_path' => null,
            'employee_count' => $this->faker->numberBetween(10, 5000),
            'industry' => $this->faker->word(),
            'is_verified' => true,
        ];
    }
}
