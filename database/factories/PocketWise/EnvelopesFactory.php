<?php

namespace Database\Factories\PocketWise;

use App\Models\PocketWise\Categories;
use App\Models\PocketWise\Envelopes;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Envelopes>
 */
class EnvelopesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::pluck('id')->toArray();
        $categoriesIds = Categories::pluck('id')->toArray();

        return [
            'user_id' => fake()->randomElement($userIds),
            'category_id' => fake()->randomElement($categoriesIds),
            'allocated_amount' => fake()->randomFloat(2, 0, 10000),
            'spent_amount' => fake()->randomFloat(2, 0, 10000),
            'month_year' => sprintf('%04d-%02d',fake()->numberBetween(2020,2026),fake()->numberBetween(1,12)),
            'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
