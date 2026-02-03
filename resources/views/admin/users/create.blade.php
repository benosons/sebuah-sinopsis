@extends('layouts.admin')

@section('title', 'Create User')

@section('breadcrumbs')
    <span>Settings</span>
    <span class="material-symbols-outlined text-base mx-1">chevron_right</span>
    <a href="{{ route('users.index') }}" class="hover:text-primary">Users</a>
    <span class="material-symbols-outlined text-base mx-1">chevron_right</span>
    <span class="font-medium text-gray-900 dark:text-white">Create</span>
@endsection

@section('header-actions')
    <a href="{{ route('users.index') }}" class="hidden sm:flex items-center justify-center px-4 h-10 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
        <span class="material-symbols-outlined text-xl mr-1">arrow_back</span>
        Back
    </a>
    <button type="submit" form="user-form" class="flex items-center justify-center px-6 h-10 rounded-lg text-sm font-bold text-white bg-primary hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-200">
        Create User
    </button>
@endsection

@section('content')
<form id="user-form" method="POST" action="{{ route('users.store') }}">
    @csrf
    <div class="max-w-4xl mx-auto flex flex-col gap-6">
        <!-- Page Heading -->
        <div class="flex flex-col gap-1">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Create New User</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Add a new user to the system with assigned roles.</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/30 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- User Details Card -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-xl">person</span>
                User Details
            </h3>
            <div class="flex flex-col gap-4">
                <!-- Name -->
                <label class="flex flex-col w-full">
                    <p class="text-gray-700 dark:text-gray-300 text-sm font-medium mb-1.5">Full Name <span class="text-red-500">*</span></p>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-input w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white h-11 px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm" placeholder="Enter full name" required/>
                </label>
                
                <!-- Email -->
                <label class="flex flex-col w-full">
                    <p class="text-gray-700 dark:text-gray-300 text-sm font-medium mb-1.5">Email Address <span class="text-red-500">*</span></p>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-input w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white h-11 px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm" placeholder="user@example.com" required/>
                </label>

                <!-- Password -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="flex flex-col">
                        <p class="text-gray-700 dark:text-gray-300 text-sm font-medium mb-1.5">Password <span class="text-red-500">*</span></p>
                        <input type="password" name="password" class="form-input w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white h-11 px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm" placeholder="Enter password" required/>
                    </label>
                    <label class="flex flex-col">
                        <p class="text-gray-700 dark:text-gray-300 text-sm font-medium mb-1.5">Confirm Password <span class="text-red-500">*</span></p>
                        <input type="password" name="password_confirmation" class="form-input w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white h-11 px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm" placeholder="Confirm password" required/>
                    </label>
                </div>
            </div>
        </div>

        <!-- Roles Card -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-xl">admin_panel_settings</span>
                Assign Roles
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach ($roles as $role)
                    <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer transition-colors">
                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="w-5 h-5 rounded border-gray-300 dark:border-gray-600 text-primary focus:ring-primary/20" {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ ucfirst($role->name) }}</span>
                    </label>
                @endforeach
            </div>
        </div>
    </div>
</form>
@endsection
