<?php

namespace Database\Factories;

use App\Models\UserFollow;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFollowFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserFollow::class;

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
        ];
    }
}
