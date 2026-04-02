<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $countries = [
            ['name' => 'India', 'code' => 'IN', 'dial_code' => '+91'],
            ['name' => 'United States', 'code' => 'US', 'dial_code' => '+1'],
            ['name' => 'United Kingdom', 'code' => 'GB', 'dial_code' => '+44'],
            ['name' => 'Canada', 'code' => 'CA', 'dial_code' => '+1'],
            ['name' => 'Australia', 'code' => 'AU', 'dial_code' => '+61'],
            ['name' => 'Germany', 'code' => 'DE', 'dial_code' => '+49'],
            ['name' => 'France', 'code' => 'FR', 'dial_code' => '+33'],
            ['name' => 'Japan', 'code' => 'JP', 'dial_code' => '+81'],
            ['name' => 'China', 'code' => 'CN', 'dial_code' => '+86'],
            ['name' => 'Brazil', 'code' => 'BR', 'dial_code' => '+55'],
        ];

        foreach ($countries as $country) {
            Country::firstOrCreate(
                ['code' => $country['code']],
                $country
            );
        }
    }
}
