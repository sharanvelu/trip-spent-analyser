<?php

namespace Database\Factories;

use App\Models\Trip;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trip::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(15),
            'from_date' => $this->faker->date,
            'to_date' => $this->faker->date,
            'space_id' => \App\Models\Space::factory(),
            'created_by' => \App\Models\User::factory(),
        ];
    }
}
