<?php

namespace App\Http\Controllers;

use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TechnologyController extends Controller
{
    use AuthorizesRequests; 

    public function index()
    {
        $this->authorize('viewAny', Technology::class);
        
        $technologies = Technology::latest()->paginate(15);
        
        return view('technologies.index', compact('technologies'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Technology::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:technologies,name',
        ]);

        Technology::create($validated);

        return redirect()->route('technologies.index')
            ->with('success', 'Technology added successfully.');
    }

    public function edit(Technology $technology)
    {
        $this->authorize('update', $technology);
        return view('technologies.edit', compact('technology'));
    }

    public function update(Request $request, Technology $technology)
    {
        $this->authorize('update', $technology);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:technologies,name,' . $technology->id,
        ]);

        $technology->update($validated);

        return redirect()->route('technologies.index')
            ->with('success', 'Technology updated.');
    }

    public function destroy(Technology $technology)
    {
        $this->authorize('delete', $technology);
        
        $technology->projects()->detach();
        $technology->delete();

        return redirect()->route('technologies.index')
            ->with('success', 'Technology deleted.');
    }
}