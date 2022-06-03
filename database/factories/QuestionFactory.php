<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     * @throws Exception
     */
    #[ArrayShape(['user_id' => "\Illuminate\Support\HigherOrderCollectionProxy|mixed", 'title' => "string", 'body' => "string"])]
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'title' => $this->faker->sentence,
            'body' => implode(PHP_EOL, $this->faker->paragraphs(random_int(1, 15))),
        ];
    }
}
