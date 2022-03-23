<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class AnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Answer::class;

    /**
     * Define the model's default state.
     */
    #[ArrayShape(['user_id' => "\Illuminate\Support\HigherOrderCollectionProxy|mixed", 'question_id' => "\Illuminate\Support\HigherOrderCollectionProxy|mixed", 'body' => "string"])]
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'question_id' => Question::all()->random()->id,
            'body' => $this->faker->paragraph,
        ];
    }
}
