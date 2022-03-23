<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Tag::factory()->count(100)->create();

        $tags = Tag::all();

        Question::all()->each(function ($question) use ($tags) {
            $question->tags()->attach(
                $tags->random(rand(0, 5))->pluck('id')->toArray()
            );
        });
    }
}
