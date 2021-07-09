<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * List of tag colours
     *
     * @var string[]
     */
    private $colours = [
        '#8cc63f',
        '#d4145a',
        '#fbb03b',
        '#22b573',
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'colour' => rand(1, 3) === 1 ? $this->faker->randomElement($this->colours) : null,
        ];
    }
}
