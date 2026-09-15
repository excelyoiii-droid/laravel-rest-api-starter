<?php

namespace Tests\Feature\API\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Task;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_dapat_melihat_daftar_task(): void
    {
        // Arrange
        $task = Task::factory()->count(2)->create();
        // Act
        $response = $this->getJson('/api/v1/tasks');
        // Assert
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
        $response->assertJsonFragment([
            'id' => $task[0]->id,
            'name' => $task[0]->name,
            'is_completed' => $task[0]->is_completed,
        ]);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'is_completed',
                ]
            ]
        ]);
    }
}
