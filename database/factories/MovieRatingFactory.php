<?php

namespace Database\Factories;

use App\Models\MovieRating;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieRatingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MovieRating::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomDigitNotNull,
            'movie_id' => $this->faker->randomDigitNotNull,
            'watched' => $this->faker->randomDigitNotNull,
            'rating' => $this->faker->numberBetween($min = 0, $max = 5),
            'review' => $this->faker->text($maxNbChars = 200),
        ];
    }
}
