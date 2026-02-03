@extends('layouts.admin')

@section('title', 'Permission Management')

@section('breadcrumbs')
    <span>Settings</span>
    <span class="material-symbols-outlined text-base mx-1">chevron_right</span>
    <span class="font-medium text-gray-900 dark:text-white">Permissions</span>
@endsection

@section('header-actions')
    <button onclick="document.getElementById('create-modal').classList.remove('hidden')" class="flex items-center justify-center gap-2 px-4 h-10 rounded-lg text-sm font-bold text-white bg-primary hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-200">
        <span class="material-symbols-outlined text-xl">add</span>
        <span class="hidden sm:inline">Add Permission</span>
    </button>
@endsection

@section('content')
<div class="max-w-6xl mx-auto flex flex-col gap-6">
    <!-- Page Heading -->
    <div class="flex flex-col gap-1">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Permission Management</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Manage all system permissions that can be assigned to roles.</p>
    </div>

    @if (session('success'))
        <div class="bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-500/30 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="material-symbols-outlined text-xl">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <!-- Permissions Grouped by Category -->
    @php
        $groupedPermissions = $permissions->groupBy(function($permission) {
            return explode('-', $permission->name)[0] ?? 'other';
        });
    @endphp

    <div class="space-y-6">
        @foreach($groupedPermissions as $group => $perms)
            <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-lg">key</span>
                        {{ ucfirst($group) }}
                        <span class="text-gray-400 font-normal normal-case">({{ $perms->count() }} permissions)</span>
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="text-xs text-gray-500 dark:text-gray-400 uppercase">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold">Permission Name</th>
                                <th class="px-6 py-3 text-left font-semibold hidden md:table-cell">Guard</th>
                                <th class="px-6 py-3 text-left font-semibold hidden lg:table-cell">Roles Using</th>
                                <th class="px-6 py-3 text-right font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($perms as $permission)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium bg-primary/10 text-primary dark:bg-primary/20 dark:text-blue-400">
                                            {{ $permission->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-sm hidden md:table-cell">
                                        {{ $permission->guard_name }}
                                    </td>
                                    <td class="px-6 py-4 hidden lg:table-cell">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($permission->roles->take(3) as $role)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                                    {{ ucfirst($role->name) }}
                                                </span>
                                            @endforeach
                                            @if($permission->roles->count() > 3)
                                                <span class="text-xs text-gray-400">+{{ $permission->roles->count() - 3 }} more</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-1">
                                            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure? This will remove this permission from all roles.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-500/10 transition-colors" title="Delete">
                                                    <span class="material-symbols-outlined text-xl">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach

        @if($permissions->isEmpty())
            <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-12 text-center">
                <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-3xl text-gray-400">key_off</span>
                </div>
                <p class="text-gray-500 dark:text-gray-400 mb-4">No permissions found.</p>
                <button onclick="document.getElementById('create-modal').classList.remove('hidden')" class="text-primary hover:underline font-medium">Create your first permission</button>
            </div>
        @endif
    </div>
</div>

<!-- Create Permission Modal -->
<div id="create-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="document.getElementById('create-modal').classList.add('hidden')"></div>
        <div class="relative bg-surface-light dark:bg-surface-dark rounded-xl shadow-2xl max-w-md w-full p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Create Permission</h3>
                <button onclick="document.getElementById('create-modal').classList.add('hidden')" class="p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form method="POST" action="{{ route('permissions.store') }}">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Permission Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="form-input w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white h-11 px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm" placeholder="e.g. book-create, user-delete" required/>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Use format: resource-action (e.g. book-create)</p>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('create-modal').classList.add('hidden')" class="px-4 h-10 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 h-10 rounded-lg text-sm font-bold text-white bg-primary hover:bg-blue-700 transition-colors">
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
