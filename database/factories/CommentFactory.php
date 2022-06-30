<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

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
    private array $commentables = [
        Question::class,
        Answer::class,
    ];

    /**
     * Define the model's default state.
     */
    #[ArrayShape(['user_id' => "\Illuminate\Support\HigherOrderCollectionProxy|int|mixed", 'commentable_id' => "mixed", 'commentable_type' => "mixed", 'body' => "string"])]
    public function definition(): array
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
