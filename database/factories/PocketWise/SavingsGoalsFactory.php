<?php

namespace Database\Factories\PocketWise;

use App\Models\PocketWise\SavingsGoals;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SavingsGoals>
 */
class SavingsGoalsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::pluck('id')->toArray();

        return [
            'user_id' => fake()->randomElement($userIds),
            'name' => fake()->word(),
            'target_amount' => fake()->randomFloat(2, 1, 10000),
            'current_amount' => fake()->randomFloat(2, 1, 100000),
            'deadline' => fake()->dateTimeBetween('now', '+10 years'),
            'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
