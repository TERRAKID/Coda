<?php

namespace Database\Factories;

use App\Models\CommunityMember;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommunityMemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CommunityMember::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomDigitNotNull,
            'community_id' => $this->faker->randomDigitNotNull,
        ];
    }
}
