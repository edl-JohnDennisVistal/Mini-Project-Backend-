<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skill>
 */
class SkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'skill' => 'C++',
        ];
    }
    public function c(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
            'skill' => 'C',
            ];
        });
    }
    public function chash(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
            'skill' => 'C#',
            ];
        });
    }
    public function php(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
            'skill' => 'PHP',
            ];  
        });
    }
    public function swift(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
            'skill' => 'Swift',
            ];
        });
    }
    public function python(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
            'skill' => 'Python',
        ];
    });
    }
    public function java(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
            'skill' => 'Java',
        ];
    });
    }
    public function javascript(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
            'skill' => 'JavaScript',
        ];
    });
    }
    public function ruby(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
            'skill' => 'Ruby',
        ];
    });
    }
}
