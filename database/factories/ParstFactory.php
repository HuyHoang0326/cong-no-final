<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ParstFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->bothify('PARST###??'),
            'name' => fake()->word(),
            'parst_category_id' => \App\Models\ParstsCategory::inRandomOrder()->first()->id,
            'item_condition' => rand(0, 1),
            'supplier_id' => \App\Models\Supplier::inRandomOrder()->first()->id,
            'quantity' => rand(1, 100),
            'unit' => fake() -> randomElement(['cai', 'chiec', 'doi']),
            'buy_price' => rand(1000, 50000),
            'buy_shipping_cost' => rand(100, 2000),
            'buy_date' => fake()->date(),
            'stock_in_date' => fake()->date(),
            'warehouse_id' => \App\Models\Warehouse::inRandomOrder()->first()->id,
            'sale_status' => rand(0, 1),
            'sale_date' => fake()->date(),
            'sale_price' => rand(2000, 60000),
            'sale_price_invoices' => rand(2000, 60000),
        ];
    }
}
