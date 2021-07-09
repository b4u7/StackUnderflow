<?php

namespace Database\Seeders;

use App\Models\Vote;
use Illuminate\Database\Seeder;

class VotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vote::factory()->count(1000)->create();
    }
}
