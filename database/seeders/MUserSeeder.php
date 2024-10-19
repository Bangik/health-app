<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class MUserSeeder extends Seeder
{
    public function run()
    {
        // Create 1 admin
        User::factory()->admin()->create([
            'username' => 'admin', // Set a specific username for the admin
            'password' => bcrypt('admin123'), // Set a specific password for the admin
        ]);

        // Create 10 users
        User::factory(10)->create();
    }
}
