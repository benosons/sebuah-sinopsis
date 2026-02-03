@extends('layouts.admin')

@section('title', 'Role Details')

@section('breadcrumbs')
    <span>Settings</span>
    <span class="material-symbols-outlined text-base mx-1">chevron_right</span>
    <a href="{{ route('roles.index') }}" class="hover:text-primary">Roles</a>
    <span class="material-symbols-outlined text-base mx-1">chevron_right</span>
    <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst($role->name) }}</span>
@endsection

@section('header-actions')
    <a href="{{ route('roles.index') }}" class="hidden sm:flex items-center justify-center px-4 h-10 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
        <span class="material-symbols-outlined text-xl mr-1">arrow_back</span>
        Back
    </a>
    <a href="{{ route('roles.edit', $role->id) }}" class="flex items-center justify-center px-6 h-10 rounded-lg text-sm font-bold text-white bg-primary hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-200">
        <span class="material-symbols-outlined text-xl mr-1">edit</span>
        Edit Role
    </a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto flex flex-col gap-6">
    <!-- Role Header -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-xl bg-primary/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-primary text-4xl">admin_panel_settings</span>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ ucfirst($role->name) }}</h2>
                <p class="text-gray-500 dark:text-gray-400">{{ $role->users->count() }} users • {{ $role->permissions->count() }} permissions</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Permissions -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-xl">key</span>
                Permissions ({{ $role->permissions->count() }})
            </h3>
            @if($role->permissions->count() > 0)
                <div class="flex flex-wrap gap-2 max-h-64 overflow-y-auto">
                    @foreach($role->permissions as $permission)
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                            {{ $permission->name }}
                        </span>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400 text-sm">No permissions assigned to this role.</p>
            @endif
        </div>

        <!-- Users with this Role -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-xl">group</span>
                Users ({{ $role->users->count() }})
            </h3>
            @if($role->users->count() > 0)
                <div class="space-y-3 max-h-64 overflow-y-auto">
                    @foreach($role->users as $user)
                        <a href="{{ route('users.show', $user->id) }}" class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white text-sm">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400 text-sm">No users assigned to this role.</p>
            @endif
        </div>
    </div>

    <!-- Danger Zone -->
    @if($role->name !== 'admin')
    <div class="bg-red-50 dark:bg-red-500/5 rounded-xl border border-red-200 dark:border-red-500/20 p-6">
        <h3 class="text-base font-bold text-red-700 dark:text-red-400 mb-2 flex items-center gap-2">
            <span class="material-symbols-outlined text-xl">warning</span>
            Danger Zone
        </h3>
        <p class="text-sm text-red-600 dark:text-red-400 mb-4">Deleting this role will remove it from all users who currently have it.</p>
        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role? This action cannot be undone.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center justify-center px-4 h-10 rounded-lg text-sm font-bold text-white bg-red-600 hover:bg-red-700 transition-colors">
                <span class="material-symbols-outlined text-xl mr-1">delete</span>
                Delete Role
            </button>
        </form>
    </div>
    @endif
</div>
@endsection
