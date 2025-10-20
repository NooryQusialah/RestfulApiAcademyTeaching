<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    public function test_course_index_and_show()
    {
        Course::factory()->count(3)->create();

        $res = $this->getJson('/api/v1/courses');
        $res->assertStatus(200)->assertJsonStructure(['data']);

        $course = Course::first();
        $show = $this->getJson("/api/v1/courses/{$course->id}");
        $show->assertStatus(200)->assertJsonPath('data.id', $course->id);
    }

    public function test_teacher_can_create_course()
    {
        $user = User::factory()->create();
        $teacher = Teacher::factory()->create(['id' => null]);
        // associate user with teacher
        $teacher->user()->associate($user);
        $teacher->save();

        $this->actingAs($user, 'api');

        $payload = [
            'title' => 'New Course',
            'description' => 'desc',
            'thumbnail' => 'thumb.jpg',
            'price' => 10,
            'category' => 'cat',
            'level' => 'beginner',
            'status' => 'published',
        ];

        $create = $this->postJson('/api/v1/courses', $payload);
        $create->assertStatus(201)->assertJsonPath('data.title', 'New Course');
    }
}
