<?php

namespace Database\Seeders;

use App\Models\MHealthControlNote;
use Illuminate\Database\Seeder;

class MHealthControlNoteSeeder extends Seeder
{
    public function run()
    {
        // Create 10 health control note records
        MHealthControlNote::factory(30)->create();
    }
}
