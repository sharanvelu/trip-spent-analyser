<?php

namespace Database\Factories;

use App\Models\Expense;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Expense::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount' => $this->faker->randomNumber(2),
            'description' => $this->faker->sentence(15),
            'type' => $this->faker->word,
            'trip_id' => \App\Models\Trip::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
