<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-500 leading-tight">
            {{ __('Manage Technologies') }}
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

                {{-- The List --}}
                <div class="md:col-span-2">
                    <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border border-gray-700">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">Tech Name</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-800 divide-y divide-gray-700">
                                @foreach ($technologies as $tech)
                                    <tr x-data="{ editing: false, inputName: '{{ $tech->name }}' }" class="hover:bg-gray-700 transition">

                                        {{-- NAME --}}
                                        <td class="px-6 py-4 text-sm font-bold text-white">

                                            {{-- READ MODE: Show text --}}
                                            <span x-show="!editing" x-text="inputName"></span>

                                            {{-- EDIT MODE: Show Form & Input --}}
                                            <form id="update-form-{{ $tech->id }}" action="{{ route('technologies.update', $tech) }}"
                                                method="POST" x-show="editing" style="display: none;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="text" name="name" x-model="inputName"
                                                    class="w-full h-8 px-2 py-1 text-sm rounded bg-gray-900 border-gray-600 text-white focus:border-red-500 focus:ring-red-500">
                                            </form>
                                        </td>

                                        {{-- ACTIONS --}}
                                        <td class="px-6 py-4 text-right text-sm font-medium">

                                            {{-- READ MODE: Edit / Delete --}}
                                            <div x-show="!editing">
                                                @can('update', $tech)
                                                    <button @click="editing = true; $nextTick(() => $refs.input.focus())"
                                                        class="text-blue-400 hover:text-blue-300 mr-3 cursor-pointer">
                                                        Edit
                                                    </button>
                                                @endcan

                                                @can('delete', $tech)
                                                    <form action="{{ route('technologies.destroy', $tech) }}" method="POST"
                                                        class="inline-block" onsubmit="return confirm('Delete {{ $tech->name }}?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-400">Delete</button>
                                                    </form>
                                                @endcan
                                            </div>

                                            {{-- EDIT MODE: Save / Cancel --}}
                                            <div x-show="editing" style="display: none;">
                                                <button type="submit" form="update-form-{{ $tech->id }}"
                                                    class="text-green-400 hover:text-green-300 mr-3 font-bold">
                                                    Save
                                                </button>

                                                <button @click="editing = false; inputName = '{{ $tech->name }}'"
                                                    class="text-gray-400 hover:text-gray-200">
                                                    Cancel
                                                </button>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $technologies->links() }}
                    </div>
                </div>

                @can('create', App\Models\Technology::class)
                    <div>
                        <div class="bg-gray-800 p-6 rounded-lg border border-gray-700 shadow-xl sticky top-8">
                            <h3 class="text-lg font-bold text-white mb-4">Add New Skill</h3>

                            <form action="{{ route('technologies.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Name</label>
                                    <input type="text" name="name" placeholder="e.g. Tailwind CSS" required
                                        class="w-full rounded bg-gray-900 border-gray-600 text-white focus:border-red-500 focus:ring-red-500">
                                    @error('name')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow transition">
                                    + Add Technology
                                </button>
                            </form>
                        </div>
                    </div>
                @endcan

            </div>
        </div>
    </div>
</x-app-layout>
