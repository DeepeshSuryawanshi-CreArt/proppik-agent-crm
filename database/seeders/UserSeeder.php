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
            ['email' => 'admin@example.com'],
            [
                'firstname' => 'Admin',
                'lastname' => 'User',
                'email' => 'admin@example.com',
                'mobile' => '9876543210',
                'base_mobile' => '9876543210',
                'country_code' => 'IN',
                'dial_code' => '+91',
                'country_id' => $india?->id,
                'password' => bcrypt('admin@2026'),
                'company_name' => 'Admin Company',
                'package' => 'Premium',
                'amount' => 5000,
                'payment_type' => 'credit_card',
                'address' => 'Admin Address, India',
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
                'company_name' => 'Editor Company',
                'package' => 'Standard',
                'amount' => 2500,
                'payment_type' => 'online_transfer',
                'address' => 'Editor Address, India',
                'is_active' => true,
                'email_verified_at' => now(),
                'mobile_verify_at' => now(),
            ]
        );
        $editorUser->assignRole('editor');

        // Create viewer user
        $viewerUser = User::firstOrCreate(
            ['email' => 'viewer@example.com'],
            [
                'firstname' => 'Viewer',
                'lastname' => 'User',
                'email' => 'viewer@example.com',
                'mobile' => '9876543212',
                'base_mobile' => '9876543212',
                'country_code' => 'IN',
                'dial_code' => '+91',
                'country_id' => $india?->id,
                'password' => bcrypt('password'),
                'company_name' => 'Viewer Company',
                'package' => 'Starter',
                'amount' => 1000,
                'payment_type' => 'bank_transfer',
                'address' => 'Viewer Address, India',
                'is_active' => true,
                'email_verified_at' => now(),
                'mobile_verify_at' => now(),
            ]
        );
        $viewerUser->assignRole('viewer');

        // Create sample reports for admin user
        Report::firstOrCreate(
            ['user_id' => $adminUser->id, 'bill' => 'BILL-001'],
            [
                'user_id' => $adminUser->id,
                'bill' => 'BILL-001',
                'amount' => 5000,
                'package' => 'Premium',
                'payment_type' => 'credit_card',
                'gst_no' => '18AABCU1234N1Z0',
                'address' => 'Admin Address, India',
            ]
        );

        // Create sample reports for editor user
        Report::firstOrCreate(
            ['user_id' => $editorUser->id, 'bill' => 'BILL-002'],
            [
                'user_id' => $editorUser->id,
                'bill' => 'BILL-002',
                'amount' => 2500,
                'package' => 'Standard',
                'payment_type' => 'online_transfer',
                'gst_no' => '27AABCE5055K2Z5',
                'address' => 'Editor Address, India',
            ]
        );
    }
}
