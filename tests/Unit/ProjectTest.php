<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Client;
use App\Models\Technology;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    #[Test] 
    public function a_user_can_create_a_project()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $client = Client::factory()->create();
        $tech = Technology::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('projects.store'), [
            'title' => 'My Test Project',
            'slug' => 'my-test-project',
            'status' => 'in_progress',
            'started_at' => '2024-01-01',
            'description' => 'Test description content',
            'clients' => [$client->id],
            'technologies' => [$tech->id],
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('projects.index'));

        $this->assertDatabaseHas('projects', [
            'title' => 'My Test Project',
        ]);
    }

    #[Test] 
    public function a_project_requires_a_title()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('projects.store'), [
            'title' => '',
        ]);

        $response->assertSessionHasErrors('title');
    }
}