@extends('layouts.admin')

@section('title', 'User Details')

@section('breadcrumbs')
    <span>Settings</span>
    <span class="material-symbols-outlined text-base mx-1">chevron_right</span>
    <a href="{{ route('users.index') }}" class="hover:text-primary">Users</a>
    <span class="material-symbols-outlined text-base mx-1">chevron_right</span>
    <span class="font-medium text-gray-900 dark:text-white">{{ Str::limit($user->name, 20) }}</span>
@endsection

@section('header-actions')
    <a href="{{ route('users.index') }}" class="hidden sm:flex items-center justify-center px-4 h-10 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
        <span class="material-symbols-outlined text-xl mr-1">arrow_back</span>
        Back
    </a>
    <a href="{{ route('users.edit', $user->id) }}" class="flex items-center justify-center px-6 h-10 rounded-lg text-sm font-bold text-white bg-primary hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-200">
        <span class="material-symbols-outlined text-xl mr-1">edit</span>
        Edit User
    </a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto flex flex-col gap-6">
    <!-- User Profile Card -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
        <div class="bg-gradient-to-r from-primary to-purple-600 h-24"></div>
        <div class="px-6 pb-6">
            <div class="flex flex-col sm:flex-row items-center sm:items-end gap-4 -mt-12">
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-primary to-purple-600 flex items-center justify-center text-white font-bold text-3xl border-4 border-white dark:border-gray-900 shadow-lg">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div class="text-center sm:text-left pb-2">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h2>
                    <p class="text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- User Details -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-xl">info</span>
                User Information
            </h3>
            <dl class="space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-800">
                    <dt class="text-sm text-gray-500 dark:text-gray-400">Full Name</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</dd>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-800">
                    <dt class="text-sm text-gray-500 dark:text-gray-400">Email</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->email }}</dd>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-800">
                    <dt class="text-sm text-gray-500 dark:text-gray-400">Joined</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->created_at->format('d M Y, H:i') }}</dd>
                </div>
                <div class="flex justify-between items-center py-2">
                    <dt class="text-sm text-gray-500 dark:text-gray-400">Email Verified</dt>
                    <dd>
                        @if($user->email_verified_at)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400">
                                <span class="material-symbols-outlined text-sm">verified</span>
                                Verified
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400">
                                <span class="material-symbols-outlined text-sm">pending</span>
                                Pending
                            </span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Roles & Permissions -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-xl">admin_panel_settings</span>
                Roles & Permissions
            </h3>
            
            <div class="mb-4">
                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Assigned Roles</p>
                <div class="flex flex-wrap gap-2">
                    @if(!empty($user->getRoleNames()))
                        @foreach($user->getRoleNames() as $role)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary/10 text-primary dark:bg-primary/20 dark:text-blue-400">
                                {{ ucfirst($role) }}
                            </span>
                        @endforeach
                    @else
                        <span class="text-gray-400 text-sm">No roles assigned</span>
                    @endif
                </div>
            </div>

            <div>
                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Permissions</p>
                <div class="flex flex-wrap gap-2 max-h-48 overflow-y-auto">
                    @if(!empty($user->getAllPermissions()))
                        @foreach($user->getAllPermissions() as $permission)
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                {{ $permission->name }}
                            </span>
                        @endforeach
                    @else
                        <span class="text-gray-400 text-sm">No permissions</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="bg-red-50 dark:bg-red-500/5 rounded-xl border border-red-200 dark:border-red-500/20 p-6">
        <h3 class="text-base font-bold text-red-700 dark:text-red-400 mb-2 flex items-center gap-2">
            <span class="material-symbols-outlined text-xl">warning</span>
            Danger Zone
        </h3>
        <p class="text-sm text-red-600 dark:text-red-400 mb-4">Once you delete a user, there is no going back. Please be certain.</p>
        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center justify-center px-4 h-10 rounded-lg text-sm font-bold text-white bg-red-600 hover:bg-red-700 transition-colors">
                <span class="material-symbols-outlined text-xl mr-1">delete</span>
                Delete User
            </button>
        </form>
    </div>
</div>
@endsection
