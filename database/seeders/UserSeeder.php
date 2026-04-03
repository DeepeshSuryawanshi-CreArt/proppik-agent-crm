<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $india = Country::where('code', 'IN')->first();

        // Create admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'dev@proppik.com'],
            [
                'firstname' => 'Admin',
                'lastname' => 'Dev',
                'email' => 'dev@proppik.com',
                'mobile' => '8516815519',
                'base_mobile' => '8516815519',
                'country_code' => 'IN',
                'dial_code' => '+91',
                'country_id' => $india?->id,
                'password' => bcrypt('admin@2026'),
                'is_active' => true,
                'email_verified_at' => now(),
                'mobile_verify_at' => now(),
            ]
        );
        $adminUser->assignRole('admin');

        // Create editor user
        $editorUser = User::firstOrCreate(
            ['email' => 'dev@example.com'],
            [
                'firstname' => 'dev',
                'lastname' => 'User',
                'email' => 'dev@example.com',
                'mobile' => '9876543211',
                'base_mobile' => '9876543211',
                'country_code' => 'IN',
                'dial_code' => '+91',
                'country_id' => $india?->id,
                'password' => bcrypt('password'),
                'address' => 'Editor Address, India',
                'is_active' => true,
                'email_verified_at' => now(),
                'mobile_verify_at' => now(),
            ]
        );
        $editorUser->assignRole('agent');
    }
}
