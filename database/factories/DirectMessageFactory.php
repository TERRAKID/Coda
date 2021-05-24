<?php

namespace Database\Factories;

use App\Models\DirectMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

class DirectMessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DirectMessage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id_1' => $this->faker->randomDigitNotNull,
            'user_id_2' => $this->faker->randomDigitNotNull,
            'message' => $this->faker->text($maxNbChars = 200),
        ];
    }
}
