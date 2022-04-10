<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, string>
     */
    #[ArrayShape(['name' => "string", 'email' => "string", 'email_verified_at' => "\Illuminate\Support\Carbon", 'biography' => "array|string", 'password' => "string", 'remember_token' => "string"])]
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'username' => Str::limit($this->faker->unique()->userName, 15, ''),
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'biography' => $this->faker->sentence,
            'company' => $this->faker->company,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }
}
