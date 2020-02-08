<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use App\Answer;
use App\User;
use App\Vote;
use Faker\Generator as Faker;

$factory->define(Vote::class, function (Faker $faker) {
    $votables = [
        Question::class,
        Answer::class,
    ];

    $votableType = $faker->randomElement($votables);
    $votableId = call_user_func($votableType, '::all')->random()->id;

    return [
        'user_id' => User::all()->random()->id,
        'votable_id' => $votableId,
        'votable_type' => $votableType,
    ];
});
