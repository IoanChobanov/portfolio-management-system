<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-500 leading-tight">
            {{ __('Manage Clients') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 bg-green-900 border-l-4 border-green-500 p-4 text-green-100 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- LEFT COLUMN: Client List (2/3 width) --}}
                <div class="md:col-span-2">
                    <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border border-gray-700">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">Client Info
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-800 divide-y divide-gray-700">
                                @foreach ($clients as $client)
                                    <tr class="hover:bg-gray-700 transition">
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-white">{{ $client->name }}</div>
                                            <div class="text-xs text-gray-400">{{ $client->contact_email }}</div>
                                            @if ($client->site_url)
                                                <a href="{{ $client->site_url }}" target="_blank"
                                                    class="text-xs text-blue-400 hover:underline">
                                                    {{ parse_url($client->site_url, PHP_URL_HOST) }} ↗
                                                </a>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-medium">
                                            @can('update', $client)
                                                <a href="{{ route('clients.edit', $client) }}"
                                                    class="text-blue-400 hover:text-blue-300 mr-3">Edit</a>
                                            @endcan

                                            @can('delete', $client)
                                                <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline-block"
                                                    onsubmit="return confirm('Delete {{ $client->name }}?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-400">Delete</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $clients->links() }}
                    </div>
                </div>

                {{-- RIGHT COLUMN: Quick Add Form (1/3 width) --}}
                @can('create', App\Models\Client::class)
                    <div>
                        <div class="bg-gray-800 p-6 rounded-lg border border-gray-700 shadow-xl sticky top-8">
                            <h3 class="text-lg font-bold text-white mb-4">Add New Client</h3>

                            <form action="{{ route('clients.store') }}" method="POST">
                                @csrf

                                {{-- Name --}}
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Company Name</label>
                                    <input type="text" name="name" placeholder="e.g. Acme Corp" required
                                        class="w-full rounded bg-gray-900 border-gray-600 text-white focus:border-red-500 focus:ring-red-500">
                                    @error('name')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Contact Email</label>
                                    <input type="email" name="contact_email" placeholder="contact@acme.com" required
                                        class="w-full rounded bg-gray-900 border-gray-600 text-white focus:border-red-500 focus:ring-red-500">
                                    @error('contact_email')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Website --}}
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Website (Optional)</label>
                                    <input type="url" name="site_url" placeholder="https://acme.com"
                                        class="w-full rounded bg-gray-900 border-gray-600 text-white focus:border-red-500 focus:ring-red-500">
                                    @error('site_url')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow transition">
                                    + Add Client
                                </button>
                            </form>
                        </div>
                    </div>
                @endcan

            </div>
        </div>
    </div>
</x-app-layout>
