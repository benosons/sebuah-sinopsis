@extends('layouts.admin')

@section('title', 'Role Management')

@section('breadcrumbs')
    <span>Settings</span>
    <span class="material-symbols-outlined text-base mx-1">chevron_right</span>
    <span class="font-medium text-gray-900 dark:text-white">Roles</span>
@endsection

@section('header-actions')
    <a href="{{ route('roles.create') }}" class="flex items-center justify-center gap-2 px-4 h-10 rounded-lg text-sm font-bold text-white bg-primary hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-200">
        <span class="material-symbols-outlined text-xl">add</span>
        <span class="hidden sm:inline">Add Role</span>
    </a>
@endsection

@section('content')
<div class="max-w-6xl mx-auto flex flex-col gap-6">
    <!-- Page Heading -->
    <div class="flex flex-col gap-1">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Role Management</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Define roles and assign permissions to control access.</p>
    </div>

    @if (session('success'))
        <div class="bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-500/30 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="material-symbols-outlined text-xl">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <!-- Roles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($roles as $role)
            <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-2xl">admin_panel_settings</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white text-lg">{{ ucfirst($role->name) }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $role->users->count() }} users</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1">
                        <a href="{{ route('roles.edit', $role->id) }}" class="p-2 rounded-lg text-gray-400 hover:text-amber-500 hover:bg-amber-500/10 transition-colors" title="Edit">
                            <span class="material-symbols-outlined text-xl">edit</span>
                        </a>
                        @if ($role->name !== 'admin')
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this role?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-500/10 transition-colors" title="Delete">
                                <span class="material-symbols-outlined text-xl">delete</span>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                
                <!-- Permissions -->
                <div class="border-t border-gray-100 dark:border-gray-800 pt-4">
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Permissions</p>
                    <div class="flex flex-wrap gap-2">
                        @if($role->permissions->count() > 0)
                            @foreach($role->permissions->take(5) as $permission)
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                    {{ $permission->name }}
                                </span>
                            @endforeach
                            @if($role->permissions->count() > 5)
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-primary/10 text-primary">
                                    +{{ $role->permissions->count() - 5 }} more
                                </span>
                            @endif
                        @else
                            <span class="text-sm text-gray-400">No permissions assigned</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-12 text-center">
                    <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-3xl text-gray-400">admin_panel_settings</span>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">No roles found.</p>
                    <a href="{{ route('roles.create') }}" class="text-primary hover:underline font-medium">Create your first role</a>
                </div>
            </div>
        @endforelse
    </div>

    @if ($roles->hasPages())
    <div class="mt-4">
        {{ $roles->links() }}
    </div>
    @endif
</div>
@endsection
