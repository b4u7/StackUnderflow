<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Mail;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        Mail::fake();

        $this->call([
            UsersTableSeeder::class,
            QuestionsTableSeeder::class,
            AnswersTableSeeder::class,
            CommentsTableSeeder::class,
            VotesTableSeeder::class,
            TagsTableSeeder::class
        ]);
    }
}
