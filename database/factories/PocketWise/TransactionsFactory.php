<?php

namespace Database\Factories\PocketWise;

use App\Models\PocketWise\Categories;
use App\Models\PocketWise\Envelopes;
use App\Models\PocketWise\Transactions;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transactions>
 */
class TransactionsFactory extends Factory
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
        $envelopesIds = Envelopes::pluck('id')->toArray();

        return [
            'user_id' => fake()->randomElement($userIds),
            'category_id' => fake()->randomElement($categoriesIds),
            'envelope_id' => fake()->randomElement($envelopesIds),
            'amount' => fake()->randomFloat(2, 1, 10000),
            'type' => fake()->randomElement(['income', 'expense']),
            'description' => fake()->text(),
            'date' => fake()->dateTimeBetween('-4 months', 'now'),
            'tags' => [
                'comidas fuera' => fake()->word(),
                'emergencia' => fake()->word(),
                'gustos' => fake()->word(),
            ],
            'receipt_path' => fake()->word(),
            'is_recurring' => fake()->boolean(30),
            'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
