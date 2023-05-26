<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\boards>
 */
class BoardsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $data = $this->faker->dateTimeBetween('-1 years');
        return [
            'title' => $this->faker->realText(30)
            ,'content' => $this->faker->realText(2000)
            ,'hits' => $this->faker->randomNumber(3)
            ,'created_at' => $data
            ,'updated_at' => $data
            ,'deleted_at' => $this->faker->randomNumber(1) <= 5 ? $data : null
        ];
    }
}