<?php

namespace Database\Factories;

use App\Models\FormAnswer;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormAnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FormAnswer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'form_question_id' => $this->faker->randomDigitNotNull,
            'answer' => $this->faker->text($maxNbChars = 200),
        ];
    }
}
