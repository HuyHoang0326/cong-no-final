<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'customer_code' => fake()->bothify('CTM###??'),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'email' => fake()->email(),
            'is_potential' => rand(0, 1),
            'paid_orders_count' => 0,
            'unpaid_orders_count' => 0,
            'total_purchased_amount' => 0,
            'outstanding_amount' => 0,
        ];
    }
}
