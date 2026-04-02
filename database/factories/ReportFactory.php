<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Report::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paymentTypes = ['cash', 'upi', 'net_banking', 'card'];

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'person_name' => $this->faker->name(),
            'bill' => 'BILL-' . date('Y') . '-' . rand(1000, 9999),
            'amount' => $this->faker->randomFloat(2, 100, 10000),
            'package' => $this->faker->word(),
            'payment_type' => $paymentTypes[array_rand($paymentTypes)],
            'gst_no' => 'GST' . rand(100000000000, 999999999999),
            'address' => $this->faker->address(),
            'created_by' => User::where('email', 'admin@example.com')->first()?->id,
        ];
    }
}
