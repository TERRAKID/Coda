<?php

namespace Database\Factories;

use App\Models\UserStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserStatus::class;

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
            'muted' => $this->faker->boolean,
            'blocked' => $this->faker->boolean,
        ];
    }
}
