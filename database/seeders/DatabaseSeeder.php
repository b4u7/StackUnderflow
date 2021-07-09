<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
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
