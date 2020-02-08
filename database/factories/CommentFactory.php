<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use App\Answer;
use App\Comment;
use App\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    $commentables = [
        Question::class,
        Answer::class,
    ];

    $commentableType = $faker->randomElement($commentables);
    $commentableId = call_user_func($commentableType . '::all')->random()->id;

    return [
        'user_id' => User::all()->random()->id,
        'commentable_id' => $commentableId,
        'commentable_type' => $commentableType,
        'body' => $faker->paragraph,
    ];
});
