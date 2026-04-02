<?php

namespace Database\Seeders;

use App\Models\User;
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
        // Seed roles and permissions
        $this->call(RolePermissionSeeder::class);
        
        // Seed countries
        $this->call(CountrySeeder::class);
        
        // Seed users with reports
        $this->call(UserSeeder::class);
    }
}
