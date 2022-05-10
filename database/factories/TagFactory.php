<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     */
    #[ArrayShape(['name' => "string"])]
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word
        ];
    }
}
