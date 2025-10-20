<?php

namespace Database\Factories;

use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnrollmentFactory extends Factory
{
    protected $model = Enrollment::class;

    public function definition()
    {
        return [
            'student_id' => null,
            'course_id' => null,
            'enrolled_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'progress' => $this->faker->numberBetween(0, 100),
            'completed' => $this->faker->boolean(20),
        ];
    }
}
