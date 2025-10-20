<?php

namespace Database\Factories;

use App\Models\QuizAttempt;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizAttemptFactory extends Factory
{
    protected $model = QuizAttempt::class;

    public function definition()
    {
        return [
            'quiz_id' => null,
            'student_id' => null,
            'score' => $this->faker->numberBetween(0, 100),
            'attempted_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }
}
