<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event' => fake()->randomElement(['TaskCreated', 'TaskUpdated', 'TaskDeleted']),
            'task_id' => fake()->uuid(),
            'user_id' => fake()->uuid(),
        ];
    }
}
