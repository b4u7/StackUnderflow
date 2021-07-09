<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Array with commentable models
     *
     * @var string[]
     */
    private $commentables = [
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
        $commentableType = $this->faker->randomElement($this->commentables);
        $commentableId = call_user_func($commentableType . '::all')->random()->id;

        return [
            'user_id' => User::all()->random()->id,
            'commentable_id' => $commentableId,
            'commentable_type' => $commentableType,
            'body' => $this->faker->paragraph,
        ];
    }
}
