<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WarehouseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Kho ' . fake()->city(), // ví dụ: Kho Hà Nội
        ];
    }
}