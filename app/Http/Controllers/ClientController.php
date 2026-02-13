<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ClientController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Client::class);
        $clients = Client::latest()->paginate(10);
        return view('clients.index', compact('clients'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Client::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:clients,name',
            'contact_email' => 'required|email|max:255',
            'site_url' => 'nullable|url|max:255',
        ]);

        Client::create($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Client added successfully.');
    }

    public function edit(Client $client)
    {
        $this->authorize('update', $client);
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $this->authorize('update', $client);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:clients,name,' . $client->id,
            'contact_email' => 'required|email|max:255',
            'site_url' => 'nullable|url|max:255',
        ]);

        $client->update($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Client updated.');
    }

    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);
        
        $client->projects()->detach();
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Client deleted.');
    }
}