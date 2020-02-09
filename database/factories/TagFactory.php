<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tag;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    $colours = [
        '#8cc63f',
        '#d4145a',
        '#fbb03b',
        '#22b573',
    ];

    return [
        'name' => $faker->word,
        'colour' => rand(1, 3) === 1 ? $faker->randomElement($colours) : null,
    ];
});
