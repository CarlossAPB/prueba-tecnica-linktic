<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;

class TaskTest extends TestCase
{
    protected $user;
    protected $headers;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $loginResponse = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $token = $loginResponse->json('access_token');

        $this->headers = [
            'Authorization' => 'Bearer ' . $token,
        ];
    }

    public function test_index_returns_all_tasks()
    {
        Task::factory()->count(3)->create();

        $response = $this->get('/api/tasks', $this->headers);

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_show_returns_task()
    {
        $task = Task::factory()->create();

        $response = $this->get("/api/tasks/{$task->id}", $this->headers);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
                'due_date' => $task->due_date,
            ]);
    }
}
