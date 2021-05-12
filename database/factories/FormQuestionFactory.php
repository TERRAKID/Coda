<?php

namespace Database\Factories;

use App\Models\FormQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormQuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FormQuestion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'form_id' => $this->faker->randomDigitNotNull,
            'question' => $this->faker->text($maxNbChars = 200),
            'point_value' => $this->faker->randomDigitNotNull,
        ];
    }
}
