<?php

namespace Database\Factories\PocketWise;

use App\Models\PocketWise\Categories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Categories>
 */
class CategoriesFactory extends Factory
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
            'name' => fake()->unique()->word(),
            'type' => fake()->randomElement(['income', 'expense', 'saving']),
            'is_fixed' => fake()->boolean(30), // 30% de probabilidad de ser true
            'monthly_budget' => fake()->randomFloat(2, 0, 10000),
            'icon' => fake()->randomElement(['💰', '🏠', '🚗', '🍔', '🎮', '📚', '💊', '🎓', '✈️', '👕']),
            'color' => fake()->hexColor(),
            'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
