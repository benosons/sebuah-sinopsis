@extends('layouts.admin')

@section('title', 'User Management')

@section('breadcrumbs')
    <span>Settings</span>
    <span class="material-symbols-outlined text-base mx-1">chevron_right</span>
    <span class="font-medium text-gray-900 dark:text-white">Users</span>
@endsection

@section('header-actions')
    <a href="{{ route('users.create') }}" class="flex items-center justify-center gap-2 px-4 h-10 rounded-lg text-sm font-bold text-white bg-primary hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-200">
        <span class="material-symbols-outlined text-xl">add</span>
        <span class="hidden sm:inline">Add User</span>
    </a>
@endsection

@section('content')
<div class="max-w-6xl mx-auto flex flex-col gap-6">
    <!-- Page Heading -->
    <div class="flex flex-col gap-1">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">User Management</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Manage all registered users and their roles.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-2xl">people</span>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $users->total() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Users</p>
                </div>
            </div>
        </div>
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-green-500/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-green-500 text-2xl">admin_panel_settings</span>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ \Spatie\Permission\Models\Role::count() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Roles</p>
                </div>
            </div>
        </div>
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-amber-500/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-amber-500 text-2xl">key</span>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ \Spatie\Permission\Models\Permission::count() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Permissions</p>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-500/30 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="material-symbols-outlined text-xl">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <!-- Users Table -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden lg:table-cell">Roles</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">Joined</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 md:hidden">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300 hidden md:table-cell">{{ $user->email }}</td>
                            <td class="px-6 py-4 hidden lg:table-cell">
                                <div class="flex flex-wrap gap-1">
                                    @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $role)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary dark:bg-primary/20 dark:text-blue-400">
                                                {{ $role }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-gray-400 text-sm">No roles</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-sm hidden sm:table-cell">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('users.show', $user->id) }}" class="p-2 rounded-lg text-gray-400 hover:text-primary hover:bg-primary/10 transition-colors" title="View">
                                        <span class="material-symbols-outlined text-xl">visibility</span>
                                    </a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="p-2 rounded-lg text-gray-400 hover:text-amber-500 hover:bg-amber-500/10 transition-colors" title="Edit">
                                        <span class="material-symbols-outlined text-xl">edit</span>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-500/10 transition-colors" title="Delete">
                                            <span class="material-symbols-outlined text-xl">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-4">
                                        <span class="material-symbols-outlined text-3xl text-gray-400">person_off</span>
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400 mb-4">No users found.</p>
                                    <a href="{{ route('users.create') }}" class="text-primary hover:underline font-medium">Add your first user</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if ($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
