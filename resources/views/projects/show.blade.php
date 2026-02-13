<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-red-500 leading-tight">
                {{ $project->title }}
            </h2>
            <div class="flex gap-2">
                @can('update', $project)
                    <a href="{{ route('projects.edit', $project) }}"
                        class="bg-gray-700 hover:bg-gray-600 text-white text-sm font-bold py-2 px-4 rounded shadow transition">
                        Edit Project
                    </a>
                @endcan
                <a href="{{ route('projects.index') }}"
                    class="bg-gray-700 hover:bg-gray-600 text-white text-sm font-bold py-2 px-4 rounded shadow transition">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- HERO SECTION --}}
            <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border border-gray-700 mb-8">
                @if ($project->media->first())
                    <div class="w-full max-h-96 relative flex items-center justify-center bg-black">
                        <img src="{{ Str::startsWith($project->media->first()->file_path, 'http') ? $project->media->first()->file_path : asset('storage/' . $project->media->first()->file_path) }}"
                            class="w-auto h-auto max-h-96 object-contain">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-80"></div>
                        <div class="absolute bottom-0 left-0 p-8">
                            <span
                                class="px-3 py-1 text-xs font-bold uppercase tracking-wider text-white bg-red-600 rounded-full mb-2 inline-block">
                                {{ str_replace('_', ' ', $project->status) }}
                            </span>
                            <h1 class="text-4xl font-bold text-white">{{ $project->title }}</h1>
                        </div>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- MAIN CONTENT --}}
                <div class="md:col-span-2 space-y-8">

                    {{-- Description --}}
                    <div class="bg-gray-800 p-6 rounded-lg border border-gray-700 shadow-lg">
                        <h3 class="text-xl font-bold text-white mb-4 border-b border-gray-700 pb-2">About the Project</h3>
                        <div class="prose prose-invert max-w-none text-gray-300">
                            {!! nl2br(e($project->description)) !!}
                        </div>
                    </div>

                    <div class="mt-6 border-t border-gray-700 pt-6">
                        <h3 class="text-lg font-bold text-white mb-3">Project Timeline</h3>
                        <div class="flex items-center space-x-8">

                            {{-- Start Date --}}
                            <div>
                                <div class="text-xs text-gray-400 uppercase font-bold">Started</div>
                                <div class="text-xl text-white">{{ $project->started_at->format('F d, Y') }}</div>
                            </div>

                            {{-- Arrow Icon --}}
                            <div class="text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                                    </path>
                                </svg>
                            </div>

                            {{-- Finish Date --}}
                            <div>
                                <div class="text-xs text-gray-400 uppercase font-bold">Finished</div>
                                @if ($project->finished_at)
                                    <div class="text-xl text-green-400">{{ $project->finished_at->format('F d, Y') }}</div>
                                @else
                                    <div class="text-xl text-yellow-500 italic">In Progress</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-800 p-6 rounded-lg border border-gray-700 shadow-lg">
                        <div class="mb-6 border-b border-gray-700 pb-2">
                            <h3 class="text-xl font-bold text-white">Client Testimonials</h3>
                        </div>

                        {{-- LIST EXISTING TESTIMONIALS --}}
                        @if ($project->testimonials->count() > 0)
                            <div class="grid grid-cols-1 gap-4 mb-8">
                                @foreach ($project->testimonials as $testimonial)
                                    <div class="bg-gray-700 p-4 rounded-lg border-l-4 border-red-500 relative">

                                        @if (Auth::check() && Auth::user()->role === 'admin')
                                            <form action="{{ route('testimonials.destroy', $testimonial) }}" method="POST"
                                                class="absolute top-2 right-2 z-10">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Delete this testimonial?')"
                                                    class="text-gray-500 hover:text-red-500 transition p-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif

                                        <svg class="absolute top-4 left-4 w-8 h-8 text-gray-600 opacity-50 transform -scale-x-100"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M14.017 21L14.017 18C14.017 16.096 14.017 14.192 14.017 12.288C14.017 11.231 14.545 10.366 15.601 9.696C16.657 9.026 17.813 8.691 19.069 8.691L19.069 5C17.087 5 15.207 5.757 13.429 7.271C11.651 8.785 10.762 10.881 10.762 13.56L10.762 21L14.017 21ZM5 21L5 18C5 16.096 5 14.192 5 12.288C5 11.231 5.528 10.366 6.584 9.696C7.64 9.026 8.796 8.691 10.052 8.691L10.052 5C8.07 5 6.19 5.757 4.412 7.271C2.634 8.785 1.745 10.881 1.745 13.56L1.745 21L5 21Z" />
                                        </svg>
                                        <p class="text-gray-300 italic pl-8 mb-3">"{{ $testimonial->quote }}"</p>
                                        <div class="text-right">
                                            <p class="text-sm font-bold text-white">— {{ $testimonial->author }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 italic mb-8">No testimonials yet.</p>
                        @endif

                        {{-- INLINE ADD FORM --}}
                        <div class="bg-gray-900 rounded p-4 border border-gray-600">
                            <h4 class="text-sm font-bold text-gray-300 uppercase mb-3">Testimonial</h4>

                            <form action="{{ route('testimonials.store', $project) }}" method="POST">
                                @csrf

                                <div class="space-y-4">
                                    {{-- Quote Input --}}
                                    <div>
                                        <textarea name="quote" rows="2" placeholder="Testimonial" required
                                            class="w-full rounded bg-gray-800 border-gray-600 text-white text-sm focus:border-red-500 focus:ring-red-500 placeholder-gray-500">{{ old('quote') }}</textarea>
                                        @error('quote')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Author & Button Row --}}
                                    <div class="flex items-center gap-4">
                                        <div class="flex-grow">
                                            <input type="text" name="author" placeholder="Name" value="{{ old('author') }}" required
                                                class="w-full rounded bg-gray-800 border-gray-600 text-white text-sm focus:border-red-500 focus:ring-red-500 placeholder-gray-500">
                                            @error('author')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-2 px-4 rounded shadow transition">
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- SIDEBAR DETAILS --}}
                <div class="space-y-6">

                    {{-- Key Info Card --}}
                    <div class="bg-gray-800 p-6 rounded-lg border border-gray-700 shadow-lg">
                        <h4 class="text-sm font-bold text-gray-400 uppercase mb-4">Project Details</h4>

                        <div class="space-y-4">
                            <div>
                                <span class="text-xs text-gray-500 block">Clients</span>
                                <div class="text-white font-medium">
                                    {{ $project->clients->pluck('name')->join(', ') ?: 'N/A' }}
                                </div>
                            </div>

                            <div>
                                <span class="text-xs text-gray-500 block">Timeline</span>
                                <div class="text-white font-medium">
                                    {{ optional($project->started_at)->format('M Y') }}
                                    -
                                    {{ optional($project->finished_at)->format('M Y') ?? 'Present' }}
                                </div>
                            </div>

                            <div>
                                <span class="text-xs text-gray-500 block">Permalink</span>
                                <a href="{{ route('projects.show', $project) }}"
                                    class="text-red-400 hover:text-red-300 text-sm truncate block">
                                    {{ $project->slug }}
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Tech Stack Card --}}
                    <div class="bg-gray-800 p-6 rounded-lg border border-gray-700 shadow-lg">
                        <h4 class="text-sm font-bold text-gray-400 uppercase mb-4">Technologies</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($project->technologies as $tech)
                                <span class="px-3 py-1 rounded text-xs font-bold bg-gray-700 text-gray-200 border border-gray-600">
                                    {{ $tech->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
