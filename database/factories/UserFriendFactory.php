<?php

namespace Database\Factories;

use App\Models\UserFriend;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFriendFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserFriend::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomDigitNotNull,
            'friend_id' => $this->faker->randomDigitNotNull,
            'accepted' => $this->faker->boolean,
        ];
    }
}
