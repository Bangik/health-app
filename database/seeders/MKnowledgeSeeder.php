<?php

namespace Database\Seeders;

use App\Models\MKnowledge;
use Illuminate\Database\Seeder;

class MKnowledgeSeeder extends Seeder
{
    public function run()
    {
        // Create 10 knowledge records
        MKnowledge::factory(10)->create();
    }
}
