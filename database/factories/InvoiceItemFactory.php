<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Invoice;
use App\Models\Parst;

class InvoiceItemFactory extends Factory
{
    public function definition(): array
    {
        $type = fake()->randomElement(['car', 'parst']);

        // giá chung
        $quantity = rand(1, 5);
        $unitPrice = rand(5000, 15000);
        $salePrice = rand(15000, 30000);
        $salePriceInvoice = rand(15000, 30000);

        // base data
        $data = [
            'invoice_id' => Invoice::inRandomOrder()->value('id'),
            'product_type' => $type,
            'product_code' => function () {
                return collect([
                    Car::inRandomOrder()->value('code'),
                    Parst::inRandomOrder()->value('code'),
                ])->filter()->random();
            },
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'sale_price' => $salePrice,
            'sale_price_invoice' => $salePriceInvoice,
        ];

        // ===== CAR =====
        if ($type === 'car') {
            return array_merge($data, [
                'car_id' => 'CAR-' . fake()->bothify('###'),
                'car_name' => 'Xe nâng ' . fake()->randomElement(['Toyota', 'Komatsu', 'Mitsubishi']),
                'car_brand' => fake()->randomElement(['Toyota', 'Komatsu', 'Mitsubishi']),
                'car_engine_number' => strtoupper(fake()->bothify('EN###??')),
                'car_chassis_number' => strtoupper(fake()->bothify('CH###??')),
                'car_payload' => fake()->randomElement(['1 tấn', '2 tấn', '3 tấn']),

                // null parst
                'parst_id' => null,
                'parst_name' => null,
                'parst_category' => null,
                'parst_condition' => null,
                'parst_supplier' => null,
                'parst_quantity_sold' => null,
                'parst_unit' => null,
            ]);
        }

        // ===== PARST =====
        return array_merge($data, [
            'parst_id' => 'PRT-' . fake()->bothify('###'),
            'parst_name' => fake()->randomElement([
                'Lốp xe',
                'Ắc quy',
                'Càng nâng',
                'Bơm thủy lực'
            ]),
            'parst_category' => fake()->randomElement(['Phụ tùng', 'Thiết bị']),
            'parst_condition' => fake()->randomElement(['Mới', 'Cũ']),
            'parst_supplier' => fake()->company(),
            'parst_quantity_sold' => $quantity,
            'parst_unit' => fake()->randomElement(['Cái', 'Chiếc', 'Bộ']),

            // null car
            'car_id' => null,
            'car_name' => null,
            'car_brand' => null,
            'car_engine_number' => null,
            'car_chassis_number' => null,
            'car_payload' => null,
        ]);
    }
}
