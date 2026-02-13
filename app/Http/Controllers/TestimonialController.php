<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    /**
     * Store a newly created testimonial in storage.
     */
    public function store(Request $request, Project $project)
    {
        // 1. Validate the simple inputs
        $validated = $request->validate([
            'author' => 'required|string|max:255',
            'quote' => 'required|string|min:5',
        ]);

        // 2. Create the testimonial using the relationship
        $project->testimonials()->create($validated);

        // 3. Redirect back to the SAME page
        return redirect()->route('projects.show', $project)
            ->with('success', 'Testimonial added successfully!');
    }

    public function destroy(Testimonial $testimonial)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $testimonial->delete();

        return back()->with('success', 'Testimonial deleted successfully.');
    }
}
