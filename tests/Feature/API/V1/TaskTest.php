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
        // $response->assertJsonFragment([
        //     'id' => $task[0]->id,
        //     'name' => $task[0]->name,
        //     'is_completed' => $task[0]->is_completed,
        // ]);

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

    public function test_user_dapat_melihat_satu_task ():void
    {
        //arrange
        $task=Task::factory()->create();
        //act
        $response=$this->getJson('api/v1/tasks/'. $task->id);
        //assert
        $response->assertStatus(200);
        // $response->assertJsonCount(1, 'data');

         $response->assertJsonStructure([
            'data' => [
                    'id',
                    'name',
                    'is_completed',
            ]
        ]);
    }

    //post=insertData
    public function test_user_dapat_insert_task():void
    {
        //arrange
        $response=$this->postJson('api/v1/tasks',[
            'name'=>'newTask',
            'is_completed'=>1
        ]);
        //act
        //assert
        $response->assertCreated();
        $this->assertDatabaseHas('tasks', [
            'name'=>'newTask',
            'is_completed'=>1

        ]);
    }
    //update=
    public function test_user_dapat_update():void
    {
        //arrange
        $task=Task::factory()->create();
        $response=$this->putJson('api/v1/tasks/'. $task->id, [
            'name'=>'SayaUpdate'

            ]);
        //assert
        $response->assertOk();
        $response->assertJsonFragment([
            'name'=>'SayaUpdate'
        ]);
    }

    //delete=
    public function test_user_dapat_menghapus():void
    {
        //arrange
        $task=Task::factory()->create();
        $response=$this->deleteJson('api/v1/tasks/'. $task->id);
        //assert
        $response->assertOk();
        // $response->assertNoContent();
        $this->assertDatabaseMissing('tasks',[
            'id'=>$task->id
        ]);

    }

}
