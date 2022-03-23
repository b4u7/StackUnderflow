<?php

namespace Database\Seeders;

use App\Models\Answer;
use Illuminate\Database\Seeder;

class AnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Answer::factory()->count(100)->create();
    }
}
