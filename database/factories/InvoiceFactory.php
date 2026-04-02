<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->bothify('MHD###??'),
            'customer_id' => \App\Models\Customer::inRandomOrder()->first()->id,
            'customer_name' => fake()->name(),
            'customer_phone' => fake()->phoneNumber(),
            'customer_address' => fake()->address(),
            'receiver_name' => fake()->name(),
            'sale_date' => fake()->date(),
            'invoicer' => fake()->name(),
            'delivery_date' => fake()->date(),
            'document_delivered' =>  ['hai_quan', 'hop_dong'],
            'shipping_cost' => rand(100, 1000),
            'sale_price_invoices' => rand(10000, 200000),
            'price' => rand(10000, 200000),
            'status' => rand(0, 1),
        ];
    }
}
