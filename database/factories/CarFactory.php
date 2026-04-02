<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->bothify('CAR###??'),
            'name' => fake()->word(),
            'brand_id' => \App\Models\CarBrand::inRandomOrder()->first()->id,
            'chassis_number' => fake()->uuid(),
            'engine_number' => fake()->uuid(),
            'payload' => rand(500, 3000),
            'supplier_id' =>  \App\Models\Supplier::inRandomOrder()->first()->id,
            'buy_price' => rand(100000, 500000),
            'buy_shipping_cost' => rand(1000, 10000),
            'buy_date' => fake()->date(),
            'stock_in_date' => fake()->date(),
            'warehouse_id' =>  \App\Models\Warehouse::inRandomOrder()->first()->id,
            'document_in_stock' => ['hai_quan', 'hop_dong'],
            'sale_status' => rand(0, 2),
            'sale_date' => fake()->date(),
            'sale_price' => rand(120000, 600000),
            'sale_price_invoices' => rand(120000, 600000),
        ];
    }
}
