<?php

namespace Database\Factories;

use App\Models\FormAnswerUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormAnswerUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FormAnswerUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'question_id' => $this->faker->randomDigitNotNull,
            'user_id' => $this->faker->randomDigitNotNull,
        ];
    }
}
