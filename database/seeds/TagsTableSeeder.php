<?php

use App\Question;
use App\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Tag::class, 100)->create();

        $tags = Tag::all();

        Question::all()->each(function ($question) use ($tags) {
            $question->tags()->attach(
                $tags->random(rand(0, 5))->pluck('id')->toArray()
            );
        });
    }
}
