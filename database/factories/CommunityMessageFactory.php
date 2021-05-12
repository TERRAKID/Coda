<?php

namespace Database\Factories;

use App\Models\CommunityMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommunityMessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CommunityMessage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'community_id' => $this->faker->randomDigitNotNull,
            'user_id' => $this->faker->randomDigitNotNull,
            'message' => $this->faker->text($maxNbChars = 200),
        ];
    }
}
