<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test, že môžeme získať zoznam úloh cez API.
     */
    public function test_can_fetch_tasks()
    {
        // Vytvor 3 testovacie úlohy
        Task::factory()->count(3)->create();

        // Odošli GET požiadavku na API endpoint
        $response = $this->getJson('/api/tasks');

        // Očakávaj úspešnú odpoveď a štruktúru JSON
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     '*' => ['id', 'name', 'description', 'created_at', 'updated_at'],
                 ]);
    }

    /**
     * Test, že môžeme vytvoriť novú úlohu cez API.
     */
    public function test_can_create_task()
    {
        // Priprav údaje pre novú úlohu
        $taskData = [
            'name' => 'New Task',
            'description' => 'Description of the new task.',
        ];

        // Odošli POST požiadavku na API endpoint
        $response = $this->postJson('/api/tasks', $taskData);

        // Očakávaj úspešnú odpoveď a správne údaje v databáze
        $response->assertStatus(201)
                 ->assertJsonFragment($taskData);

        $this->assertDatabaseHas('tasks', $taskData);
    }

    /**
     * Test, že môžeme vymazať úlohu cez API.
     */
    public function test_can_delete_task()
    {
        // Vytvor testovaciu úlohu
        $task = Task::factory()->create();

        // Odošli DELETE požiadavku na API endpoint
        $response = $this->deleteJson("/api/tasks/{$task->id}");

        // Očakávaj úspešnú odpoveď a odstránenie z databázy
        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
