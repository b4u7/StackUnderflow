<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Tag;
use Exception;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws Exception
     */
    public function run()
    {
        Tag::factory()->count(100)->create();

        $tags = Tag::all();

        Question::all()->each(function ($question) use ($tags) {
            $question->tags()->attach(
                $tags->random(random_int(0, 5))->pluck('id')->toArray()
            );
        });
    }
}
