<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Get admin user as creator
        $admin = User::where('email', 'admin@example.com')->first();

        // Create sample reports for dev and viewer users
        $users = User::whereIn('email', ['dev@example.com', 'viewer@example.com'])->get();

        foreach ($users as $user) {
            Report::factory(5)->create([
                'user_id' => $user->id,
                'created_by' => $admin->id,
            ]);
        }

        // Create some reports for admin user as well
        if ($admin) {
            Report::factory(3)->create([
                'user_id' => $admin->id,
                'created_by' => $admin->id,
            ]);
        }
    }
}
