<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Portfolio Projects') }}
            </h2>

            {{-- Create Button --}}
            @can('create', App\Models\Project::class)
                <a href="{{ route('projects.create') }}"
                    class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-2 px-4 rounded shadow transition">
                    + New Project
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

                {{-- Total --}}
                <div class="bg-gray-800 p-4 rounded-lg border border-gray-700 shadow text-center">
                    <div class="text-xs text-gray-400 uppercase font-bold">Total</div>
                    <div class="text-2xl text-white font-bold">{{ $stats['total'] }}</div>
                </div>

                {{-- Avg Duration --}}
                <div class="bg-gray-800 p-4 rounded-lg border border-gray-700 shadow text-center">
                    <div class="text-xs text-gray-400 uppercase font-bold">Avg Duration</div>
                    <div class="text-2xl text-yellow-500 font-bold">{{ $stats['avg_duration'] }} <span
                            class="text-xs text-gray-500">days</span></div>
                </div>

                {{-- Oldest --}}
                <div class="bg-gray-800 p-4 rounded-lg border border-gray-700 shadow text-center">
                    <div class="text-xs text-gray-400 uppercase font-bold">First Project</div>
                    <div class="text-sm text-white font-bold mt-2">
                        {{ $stats['oldest'] ? \Carbon\Carbon::parse($stats['oldest'])->format('M Y') : '-' }}
                    </div>
                </div>

                {{-- Top Client --}}
                <div class="bg-gray-800 p-4 rounded-lg border border-gray-700 shadow text-center">
                    <div class="text-xs text-gray-400 uppercase font-bold">Top Client</div>
                    <div class="text-sm text-blue-400 font-bold mt-2 truncate">
                        {{ $stats['top_client']->name ?? 'None' }}
                    </div>
                    <div class="text-xs text-gray-500">
                        ({{ $stats['top_client']->projects_count ?? 0 }} projects)
                    </div>
                </div>
            </div>

            {{-- Success Notification --}}
            @if (session('success'))
                <div class="mb-6 bg-green-50 text-green-700 border-l-4 border-green-500 p-4 shadow-sm" role="alert">
                    <p class="font-bold">Success</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- The Table Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                {{-- FILTER BAR --}}
                <div class="mb-6 bg-gray-800 p-4 rounded-lg border border-gray-700 shadow-sm">
                    <form method="GET" action="{{ route('projects.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">

                        {{-- Search Input --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-400 mb-1">Title</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                                class="w-full rounded bg-gray-900 border-gray-600 text-white text-sm focus:border-red-500 focus:ring-red-500">
                        </div>

                        {{-- Status Dropdown --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-400 mb-1">Status</label>
                            <select name="status"
                                class="w-full rounded bg-gray-900 border-gray-600 text-white text-sm focus:border-red-500 focus:ring-red-500">
                                <option value="">All Statuses</option>
                                <option value="idea" {{ request('status') == 'idea' ? 'selected' : '' }}>Idea</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="on_hold" {{ request('status') == 'on_hold' ? 'selected' : '' }}>On Hold</option>
                            </select>
                        </div>

                        {{-- Client Dropdown --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-400 mb-1">Client</label>
                            <select name="client_id"
                                class="w-full rounded bg-gray-900 border-gray-600 text-white text-sm focus:border-red-500 focus:ring-red-500">
                                <option value="">All Clients</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Technology Dropdown --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-400 mb-1">Technology</label>
                            <select name="technology_id"
                                class="w-full rounded bg-gray-900 border-gray-600 text-white text-sm focus:border-red-500 focus:ring-red-500">
                                <option value="">All Tech</option>
                                @foreach ($technologies as $tech)
                                    <option value="{{ $tech->id }}" {{ request('technology_id') == $tech->id ? 'selected' : '' }}>
                                        {{ $tech->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="md:col-span-4 flex justify-end items-center gap-4 mt-2 border-t border-gray-700 pt-3">
                            @if (request()->anyFilled(['search', 'status', 'client_id', 'technology_id']))
                                <a href="{{ route('projects.index') }}"
                                    class="text-xs text-gray-400 hover:text-white uppercase font-bold tracking-wider">
                                    Clear Filters
                                </a>
                            @endif
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-2 px-6 rounded shadow transition">
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Project</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Client & Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Timeline</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tech Stack</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($projects as $project)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    {{-- Image + Title --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                @if ($project->media->first())
                                                    {{-- Logic to handle URLs vs Local Files --}}
                                                    <img class="h-12 w-12 rounded object-cover"
                                                        src="{{ Str::startsWith($project->media->first()->file_path, 'http') ? $project->media->first()->file_path : asset('storage/' . $project->media->first()->file_path) }}"
                                                        alt="">
                                                @else
                                                    {{-- Fallback Icon if broken/missing --}}
                                                    <div
                                                        class="h-12 w-12 rounded bg-gray-100 flex items-center justify-center text-gray-400">
                                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900">{{ $project->title }}</div>
                                                <div class="text-xs text-gray-500 truncate max-w-xs">
                                                    {{ Str::limit($project->description, 50) }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Client & Badge --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 mb-1">
                                            {{ $project->clients->pluck('name')->join(', ') ?: 'No Client' }}</div>
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $project->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $project->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $project->status === 'on_hold' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $project->status === 'idea' ? 'bg-gray-100 text-gray-800' : '' }}">
                                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-white">Started: {{ $project->started_at->format('M d, Y') }}</div>
                                        @if ($project->finished_at)
                                            <div class="text-sm text-green-400">Finished: {{ $project->finished_at->format('M d, Y') }}
                                            </div>
                                        @else
                                            <div class="text-xs text-gray-500 italic mt-1">Ongoing</div>
                                        @endif
                                    </td>

                                    {{-- Tech Stack --}}
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($project->technologies->take(3) as $tech)
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                                    {{ $tech->name }}
                                                </span>
                                            @endforeach
                                            @if ($project->technologies->count() > 3)
                                                <span class="text-xs text-gray-400 pl-1">+{{ $project->technologies->count() - 3 }}</span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('projects.show', $project) }}"
                                            class="text-blue-400 hover:text-blue-300 mr-3">View</a>
                                        @can('update', $project)
                                            <a href="{{ route('projects.edit', $project) }}"
                                                class="text-gray-600 hover:text-red-600 mr-3 transition">Edit</a>
                                        @endcan
                                        @can('delete', $project)
                                            <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline-block"
                                                onsubmit="return confirm('Are you sure you want to delete this project?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-900 transition">Delete</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination Links --}}
            <div class="mt-4">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
