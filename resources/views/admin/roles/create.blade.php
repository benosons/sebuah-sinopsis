@extends('layouts.admin')

@section('title', 'Create Role')

@section('breadcrumbs')
    <span>Settings</span>
    <span class="material-symbols-outlined text-base mx-1">chevron_right</span>
    <a href="{{ route('roles.index') }}" class="hover:text-primary">Roles</a>
    <span class="material-symbols-outlined text-base mx-1">chevron_right</span>
    <span class="font-medium text-gray-900 dark:text-white">Create</span>
@endsection

@section('header-actions')
    <a href="{{ route('roles.index') }}" class="hidden sm:flex items-center justify-center px-4 h-10 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
        <span class="material-symbols-outlined text-xl mr-1">arrow_back</span>
        Back
    </a>
    <button type="submit" form="role-form" class="flex items-center justify-center px-6 h-10 rounded-lg text-sm font-bold text-white bg-primary hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-200">
        Create Role
    </button>
@endsection

@section('content')
<form id="role-form" method="POST" action="{{ route('roles.store') }}">
    @csrf
    <div class="max-w-4xl mx-auto flex flex-col gap-6">
        <!-- Page Heading -->
        <div class="flex flex-col gap-1">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Create New Role</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Define a new role with specific permissions.</p>
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

        <!-- Role Details Card -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-xl">admin_panel_settings</span>
                Role Details
            </h3>
            <div class="flex flex-col gap-4">
                <!-- Name -->
                <label class="flex flex-col w-full max-w-md">
                    <p class="text-gray-700 dark:text-gray-300 text-sm font-medium mb-1.5">Role Name <span class="text-red-500">*</span></p>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-input w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white h-11 px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm" placeholder="e.g. editor, moderator" required/>
                </label>
            </div>
        </div>

        <!-- Permissions Card -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-xl">key</span>
                    Permissions
                </h3>
                <button type="button" onclick="toggleAllPermissions()" class="text-sm font-medium text-primary hover:underline">
                    Select All
                </button>
            </div>
            
            @php
                $groupedPermissions = $permissions->groupBy(function($permission) {
                    return explode('-', $permission->name)[0] ?? 'other';
                });
            @endphp

            <div class="space-y-6">
                @foreach($groupedPermissions as $group => $perms)
                    <div>
                        <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">{{ ucfirst($group) }}</p>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            @foreach($perms as $permission)
                                <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer transition-colors">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="permission-checkbox w-5 h-5 rounded border-gray-300 dark:border-gray-600 text-primary focus:ring-primary/20" {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $permission->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</form>

<script>
function toggleAllPermissions() {
    const checkboxes = document.querySelectorAll('.permission-checkbox');
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    checkboxes.forEach(cb => cb.checked = !allChecked);
}
</script>
@endsection
