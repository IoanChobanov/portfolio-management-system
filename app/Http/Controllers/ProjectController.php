<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Services\ProjectService;
use App\Models\Client;
use App\Models\Technology;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) 
    {
        $this->authorize('viewAny', Project::class);

        $query = Project::with(['technologies', 'clients']);


        // Search by Title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by Client
        if ($request->filled('client_id')) {
            $query->whereHas('clients', function ($q) use ($request) {
                $q->where('clients.id', $request->client_id);
            });
        }

        // Filter by Technology
        if ($request->filled('technology_id')) {
            $query->whereHas('technologies', function ($q) use ($request) {
                $q->where('technologies.id', $request->technology_id);
            });
        }

        $projects = $query->latest()->paginate(5)->withQueryString();

        $clients = Client::orderBy('name')->get();
        $technologies = Technology::orderBy('name')->get();

        // Total Projects
        $stats['total'] = Project::count();

        // Average Duration 
        $stats['avg_duration'] = round(Project::whereNotNull('finished_at')
            ->whereNotNull('started_at')
            ->selectRaw('AVG(DATEDIFF(finished_at, started_at)) as avg')
            ->value('avg') ?? 0);

        // Oldest Project 
        $stats['oldest'] = Project::min('started_at');

        // Top Client
        $stats['top_client'] = Client::withCount('projects')
            ->orderByDesc('projects_count')
            ->first();

        return view('projects.index', compact('projects', 'clients', 'technologies', 'stats'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Project::class);
        
        $clients = Client::all();
        $technologies = Technology::all();
        
        return view('projects.create', compact('clients', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $this->authorize('create', Project::class);

        $this->projectService->storeProject($request->validated());

        return redirect()->route('projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        $project->load(['technologies', 'clients', 'testimonials', 'media']);

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        
        $clients = Client::all();
        $technologies = Technology::all();
        
        return view('projects.edit', compact('project', 'clients', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $this->projectService->updateProject($project, $request->validated());

        return redirect()->route('projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $this->projectService->deleteProject($project);

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
