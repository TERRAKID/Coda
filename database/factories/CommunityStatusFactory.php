<?php

namespace Database\Factories;

use App\Models\CommunityStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommunityStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CommunityStatus::class;

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
            'muted' => $this->faker->numberBetween($min = 0, $max = 1),
            'blocked' => $this->faker->numberBetween($min = 0, $max = 1),
        ];
    }
}
