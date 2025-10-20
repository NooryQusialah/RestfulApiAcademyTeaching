<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
{
    protected $model = Quiz::class;

    public function definition()
    {
        return [
            'course_id' => null, // set when associating
            'title' => $this->faker->sentence,
            'description' => $this->faker->optional()->paragraph,
            'total_marks' => $this->faker->numberBetween(10, 100),
        ];
    }
}
