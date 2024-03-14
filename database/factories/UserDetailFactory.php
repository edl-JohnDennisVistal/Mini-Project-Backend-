<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserDetail>
 */
class UserDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => fake()->unique()->safeEmail(),
            'age' => $this->faker->numberBetween(18, 60),
            'date_of_birth' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
