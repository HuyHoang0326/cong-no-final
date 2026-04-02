<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DebtFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoices_id' => \App\Models\Invoice::inRandomOrder()->first()->id,
            'customer_id' => \App\Models\Customer::inRandomOrder()->first()->id,
            'debt_amount' => rand(1000, 50000),
            'debt_date' => function () {
                return fake()->dateTimeBetween('-1 year', 'now');
            },

            'debt_due_date' => function (array $attributes) {
                // có thể null
                if (rand(0, 1)) {
                    return null;
                }

                return Carbon::parse($attributes['debt_date'])
                    ->addDays(rand(0, 30));
            },

            'payment_date' => function (array $attributes) {
                // 50% có thanh toán
                if (rand(0, 1)) {
                    return Carbon::parse($attributes['debt_date'])
                        ->addDays(rand(1, 40));
                }

                return null;
            },

            'status' => function (array $attributes) {
                $due = $attributes['debt_due_date'];
                $payment = $attributes['payment_date'];

                // ✅ Có payment => đã trả
                if ($payment) {
                    return 2;
                }

                // ✅ Không có payment + quá hạn
                if ($due && $due < now()) {
                    return 1;
                }

                // ✅ còn lại
                return 0;
            },
        ];
    }
}
