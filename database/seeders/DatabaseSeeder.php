<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Editor User',
            'email' => 'editor@example.com',
            'password' => bcrypt('password'),
            'role' => 'editor',
        ]);

        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $techs = Technology::factory(12)->create(); 
        $clients = Client::factory(10)->create();

        $projects = Project::factory(50)->create();

        foreach ($projects as $project) {
            $project->technologies()->attach($techs->random(rand(1, 4))->pluck('id'));
            
            $project->clients()->attach($clients->random(1)->pluck('id'));

            \App\Models\Media::factory()->create([
                'project_id' => $project->id,
                'kind' => 'image',
                'file_path' => 'https://placehold.co/600x400/2d3748/white?text=' . urlencode($project->title)
            ]);

            if (rand(0, 1)) { 
                \App\Models\Testimonial::factory()->create(['project_id' => $project->id]);
            }
        }
    }
}