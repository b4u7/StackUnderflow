<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vote::class;

    /**
     * List of votable models
     *
     * @var string[]
     */
    private $votables = [
        Question::class,
        Answer::class,
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $votableType = $this->faker->randomElement($this->votables);
        $votableId = call_user_func($votableType . '::all')->random()->id;

        return [
            'user_id' => User::all()->random()->id,
            'vote' => $this->faker->randomElement([-1, 1]),
            'votable_id' => $votableId,
            'votable_type' => $votableType,
        ];
    }
}
