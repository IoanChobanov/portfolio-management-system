<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectService
{
    /**
     * Store a new project, its relationships, and cover image.
     */
    public function storeProject(array $validatedData)
    {
        return DB::transaction(function () use ($validatedData) {
            $techIds = $validatedData['technologies'] ?? [];
            $clientIds = $validatedData['clients'] ?? [];
            $imageFile = $validatedData['cover_image'] ?? null;

            unset($validatedData['technologies'], $validatedData['clients'], $validatedData['cover_image']);

            $project = Project::create($validatedData);

            if ($imageFile) {
                $path = $imageFile->store('project_images', 'public');
                
                $project->media()->create([
                    'file_path' => $path,
                    'kind' => 'image',
                ]);
            }

            $project->technologies()->sync($techIds);
            $project->clients()->sync($clientIds);

            return $project;
        });
    }

    /**
     * Update an existing project.
     */
    public function updateProject(Project $project, array $validatedData)
    {
        return DB::transaction(function () use ($project, $validatedData) {
            $techIds = $validatedData['technologies'] ?? [];
            $clientIds = $validatedData['clients'] ?? [];
            $imageFile = $validatedData['cover_image'] ?? null;

            unset($validatedData['technologies'], $validatedData['clients'], $validatedData['cover_image']);

            $project->update($validatedData);

            if ($imageFile) {
                $path = $imageFile->store('project_images', 'public');
                
                $project->media()->create([
                    'file_path' => $path,
                    'kind' => 'image',
                ]);
               
            }

            $project->technologies()->sync($techIds);
            $project->clients()->sync($clientIds);

            return $project;
        });
    }
    
    /**
     * Delete a project.
     */
    public function deleteProject(Project $project)
    {
        foreach($project->media as $media) {
            if (Storage::disk('public')->exists($media->file_path)) {
                Storage::disk('public')->delete($media->file_path);
            }
        }
        
        return $project->delete();
    }
}