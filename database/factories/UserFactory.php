<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   
     public function definition()
     {
         return [
             'nik' => $this->faker->unique()->numberBetween(100, 999),
             'username' => $this->faker->userName,
             'email' => $this->faker->unique()->safeEmail,
             'password' => bcrypt('password'),
             'email_verified_at' => $this->faker->dateTimeThisDecade(),
             'avatar' => $this->faker->imageUrl(),
             'role_id' => $this->faker->numberBetween(2), // Misalnya role_id antara 1 hingga 3
         ];
     }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
