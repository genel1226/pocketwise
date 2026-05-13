<?php

namespace Database\Factories\PocketWise;

use App\Models\PocketWise\Debts;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Debts>
 */
class DebtsFactory extends Factory
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
            'total_amount' => fake()->randomFloat(2, 1, 10000),
            'remaining_amount' => fake()->randomFloat(2, 1, 10000),
            'interest_rate' => fake()->randomFloat(2, 1, 15),
            'minimum_payment' => fake()->randomFloat(2, 1, 1000),
            'due_date' => fake()->dateTimeBetween('now', '+50 years'),
            'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
