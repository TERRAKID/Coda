<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'community_id' => $this->faker->randomDigitNotNull,
            'event_type_id' => $this->faker->randomDigitNotNull,
            'name' => $this->faker->text($maxNbChars = 50),
        ];
    }
}
