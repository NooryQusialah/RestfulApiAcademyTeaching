<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        return [
            'id' => null, // This will be set when associating with a User
            'enrollment_number' => Str::random(10),
            'level' => $this->faker->randomElement(['Freshman', 'Sophomore', 'Junior', 'Senior']),
            'major' => $this->faker->optional()->word,
            'date_of_birth' => $this->faker->optional()->date,
        ];
    }
}
