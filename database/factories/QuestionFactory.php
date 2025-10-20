<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        $options = [
            'option_a' => $this->faker->word,
            'option_b' => $this->faker->word,
            'option_c' => $this->faker->word,
            'option_d' => $this->faker->word,
        ];

        $correct = $this->faker->randomElement(['option_a', 'option_b', 'option_c', 'option_d']);

        return array_merge([
            'quiz_id' => null, // set when associating
            'question_text' => $this->faker->sentence,
            'correct_option' => $correct,
        ], $options);
    }
}
