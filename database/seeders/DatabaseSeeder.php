<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\CarBrand::factory(30)->create();
        \App\Models\Warehouse::factory(30)->create();
        \App\Models\Supplier::factory(30)->create();
        \App\Models\Customer::factory(30)->create();

        \App\Models\ParstsCategory::factory(5)->create();

        \App\Models\Parst::factory(30)->create();

        \App\Models\Car::factory(30)->create();

        \App\Models\Invoice::factory(30)->create();

        \App\Models\InvoiceItem::factory(60)->create();

        \App\Models\Debt::factory(30)->create();
    }
}
