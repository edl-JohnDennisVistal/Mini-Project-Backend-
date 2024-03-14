<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Default state (ROLE_ADMIN)
        return [
            'role' => 'ROLE_ADMIN',
        ];
    }

    /**
     * Define the model's 'supervisor' state.
     *
     * @return Factory
     */
    public function supervisor(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'ROLE_SUPERVISOR',
            ];
        });
    }

    /**
     * Define the model's 'basic' state.
     *
     * @return Factory
     */
    public function basic(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'ROLE_BASIC',
            ];
        });
    }
}
