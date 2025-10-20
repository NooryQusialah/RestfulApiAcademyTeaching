<?php

namespace Tests\Feature;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_and_create_comment()
    {
        $lesson = Lesson::factory()->create();

        // public list
        $res = $this->getJson("/api/v1/lessons/{$lesson->id}/comments");
        $res->assertStatus(200);

        // create user and auth
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $payload = ['content' => 'This is a test comment'];
        $create = $this->postJson("/api/v1/lessons/{$lesson->id}/comments", $payload);
        $create->assertStatus(200)->assertJsonStructure(['data' => ['id', 'content', 'created_at']]);

        $commentId = $create->json('data.id');

        // show
        $show = $this->getJson("/api/v1/lessons/{$lesson->id}/comments/{$commentId}");
        $show->assertStatus(200)->assertJsonPath('data.id', $commentId);

        // update
        $update = $this->putJson("/api/v1/lessons/{$lesson->id}/comments/{$commentId}", ['content' => 'updated']);
        $update->assertStatus(200)->assertJsonPath('data.content', 'updated');

        // delete
        $delete = $this->deleteJson("/api/v1/lessons/{$lesson->id}/comments/{$commentId}");
        $delete->assertStatus(200);
    }
}
