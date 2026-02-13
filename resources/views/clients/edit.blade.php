<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-500 leading-tight">
            Edit Client: {{ $client->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border border-gray-700 p-8">

                <form action="{{ route('clients.update', $client) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-6">
                        {{-- Name --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Company Name</label>
                            <input type="text" name="name" value="{{ old('name', $client->name) }}" required
                                class="mt-1 block w-full rounded bg-gray-900 border-gray-600 text-white focus:border-red-500 focus:ring-red-500">
                            @error('name')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Contact Email</label>
                            <input type="email" name="contact_email" value="{{ old('contact_email', $client->contact_email) }}" required
                                class="mt-1 block w-full rounded bg-gray-900 border-gray-600 text-white focus:border-red-500 focus:ring-red-500">
                            @error('contact_email')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Website --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Website URL</label>
                            <input type="url" name="site_url" value="{{ old('site_url', $client->site_url) }}" placeholder="https://"
                                class="mt-1 block w-full rounded bg-gray-900 border-gray-600 text-white focus:border-red-500 focus:ring-red-500">
                            @error('site_url')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end mt-8 gap-4">
                        <a href="{{ route('clients.index') }}" class="text-gray-400 hover:text-white py-2">Cancel</a>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow transition">
                            Update Client
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
