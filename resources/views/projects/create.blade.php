<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-500 leading-tight">
            {{ __('Create New Project') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border border-gray-700 p-8">

                <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-6">

                        {{-- Title --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Project Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" required
                                class="mt-1 block w-full rounded bg-gray-900 border-gray-600 text-white focus:border-red-500 focus:ring-red-500 placeholder-gray-500">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Slug & Status --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-300">Slug (URL)</label>
                                <input type="text" name="slug" value="{{ old('slug') }}" required
                                    class="mt-1 block w-full rounded bg-gray-900 border-gray-600 text-white focus:border-red-500 focus:ring-red-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300">Status</label>
                                <select name="status"
                                    class="mt-1 block w-full rounded bg-gray-900 border-gray-600 text-white focus:border-red-500 focus:ring-red-500 text-sm">
                                    <option value="idea">Idea</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="on_hold">On Hold</option>
                                </select>
                            </div>
                        </div>

                        {{-- Dates --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Start Date --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-300">Start Date</label>
                                <input type="date" name="started_at" value="{{ old('started_at') }}"
                                    class="mt-1 block w-full rounded bg-gray-900 border-gray-600 text-white focus:border-red-500 focus:ring-red-500 text-sm">

                                @error('started_at')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Finish Date --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-300">Finish Date</label>
                                <input type="date" name="finished_at" value="{{ old('finished_at') }}"
                                    class="mt-1 block w-full rounded bg-gray-900 border-gray-600 text-white focus:border-red-500 focus:ring-red-500 text-sm">

                                @error('finished_at')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Description</label>
                            <textarea name="description" rows="3"
                                class="mt-1 block w-full rounded bg-gray-900 border-gray-600 text-white focus:border-red-500 focus:ring-red-500 text-sm">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="border-t border-gray-700 my-8"></div>

                    {{-- MEDIA & RELATIONS --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        {{-- Cover Image --}}
                        <div x-data="{ imageUrl: null }">
                            <label class="block text-sm font-medium text-gray-300 mb-2">Cover Image</label>

                            <label
                                class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-600 border-dashed rounded-lg cursor-pointer bg-gray-800 hover:bg-gray-700 hover:border-red-500 transition relative overflow-hidden">

                                <div x-show="!imageUrl" class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    <p class="text-xs text-gray-400">Click to upload</p>
                                </div>

                                <img x-show="imageUrl" :src="imageUrl"
                                    class="absolute inset-0 w-full h-full object-cover rounded-lg opacity-90" style="display: none;">

                                <input name="cover_image" type="file" class="hidden" accept="image/*"
                                    @change="imageUrl = URL.createObjectURL($event.target.files[0])" />
                            </label>
                        </div>

                        {{-- Assign Client --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Assign Client</label>
                            <div class="h-32 overflow-y-auto border border-gray-600 rounded bg-gray-900 p-2">
                                @foreach ($clients as $client)
                                    <div class="flex items-center mb-2">
                                        <input type="checkbox" name="clients[]" value="{{ $client->id }}"
                                            class="rounded bg-gray-700 border-gray-500 text-red-600 focus:ring-red-500">
                                        <label class="ml-2 text-sm text-gray-300">{{ $client->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('clients')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- Tech Stack --}}
                    <div class="mt-8">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Tech Stack</label>
                        <div class="flex flex-wrap gap-3">
                            @foreach ($technologies as $tech)
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="technologies[]" value="{{ $tech->id }}"
                                        class="rounded bg-gray-700 border-gray-500 text-red-600 focus:ring-red-500">
                                    <span class="ml-2 text-sm text-gray-300">{{ $tech->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('technologies')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center justify-end mt-8 gap-4">
                        <a href="{{ route('projects.index') }}" class="text-sm text-gray-400 hover:text-white transition">Cancel</a>
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow-lg transform hover:scale-105 transition duration-150">
                            Save Project
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
