<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('roles.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Back
                        </a>
                    </div>

                    <div class="mb-4">
                        <x-label for="name" :value="__('Name:')" />
                        <p class="mt-1 text-gray-900">{{ $role->name }}</p>
                    </div>

                    <div class="mb-4">
                        <x-label for="permissions" :value="__('Permissions:')" />
                        @if(!empty($role->permissions))
                            @foreach($role->permissions as $v)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $v->name }}
                                </span>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
