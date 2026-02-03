@extends('layouts.admin')

@section('title', 'Site Settings')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700">Dashboard</a>
    <span class="text-gray-400">/</span>
    <span class="text-gray-900 dark:text-white">Site Settings</span>
@endsection

@section('content')
<div class="max-w-4xl">
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl flex items-center gap-3">
            <span class="material-symbols-outlined text-green-600 dark:text-green-400">check_circle</span>
            <p class="text-green-700 dark:text-green-300">{{ session('success') }}</p>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Site Identity -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6 mb-6">
            <div class="flex items-center gap-2 mb-6">
                <span class="material-symbols-outlined text-primary">settings</span>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Site Identity</h3>
            </div>

            <div class="space-y-6">
                <!-- Site Name -->
                <div>
                    <label for="site_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Site Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="site_name" 
                        name="site_name" 
                        value="{{ old('site_name', $settings['site_name']) }}"
                        class="w-full px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-gray-900 dark:text-white"
                        required
                    >
                    @error('site_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Site Description -->
                <div>
                    <label for="site_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Site Description
                    </label>
                    <textarea 
                        id="site_description" 
                        name="site_description" 
                        rows="3"
                        class="w-full px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-gray-900 dark:text-white resize-none"
                    >{{ old('site_description', $settings['site_description']) }}</textarea>
                    @error('site_description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Site Email -->
                <div>
                    <label for="site_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Contact Email
                    </label>
                    <input 
                        type="email" 
                        id="site_email" 
                        name="site_email" 
                        value="{{ old('site_email', $settings['site_email']) }}"
                        class="w-full px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-gray-900 dark:text-white"
                    >
                    @error('site_email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Site Logo -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6 mb-6">
            <div class="flex items-center gap-2 mb-6">
                <span class="material-symbols-outlined text-primary">image</span>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Site Logo</h3>
            </div>

            <div class="flex flex-col md:flex-row gap-6">
                <!-- Current Logo Preview -->
                <div class="flex-shrink-0">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Current Logo</p>
                    <div class="w-40 h-40 bg-gray-100 dark:bg-gray-800 rounded-xl flex items-center justify-center border-2 border-dashed border-gray-300 dark:border-gray-600 overflow-hidden" id="logo-preview-container">
                        @if($settings['site_logo'])
                            <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Site Logo" class="w-full h-full object-contain" id="logo-preview">
                        @else
                            <div class="text-center text-gray-400" id="logo-placeholder">
                                <span class="material-symbols-outlined text-4xl mb-1">add_photo_alternate</span>
                                <p class="text-xs">No logo set</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Upload Section -->
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Upload New Logo</p>
                    
                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-primary transition-colors" id="drop-zone">
                        <input 
                            type="file" 
                            id="site_logo" 
                            name="site_logo" 
                            accept="image/png,image/jpeg,image/jpg,image/svg+xml,image/webp"
                            class="hidden"
                            onchange="previewLogo(this)"
                        >
                        <label for="site_logo" class="cursor-pointer">
                            <span class="material-symbols-outlined text-4xl text-gray-400 mb-2">cloud_upload</span>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Click to upload or drag and drop</p>
                            <p class="text-xs text-gray-400">PNG, JPG, SVG, or WebP (max 2MB)</p>
                        </label>
                    </div>

                    @error('site_logo')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror

                    @if($settings['site_logo'])
                        <div class="mt-4 flex items-center gap-2">
                            <input type="checkbox" id="remove_logo" name="remove_logo" value="1" class="rounded text-primary focus:ring-primary">
                            <label for="remove_logo" class="text-sm text-gray-600 dark:text-gray-400">Remove current logo</label>
                        </div>
                    @endif

                    <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <p class="text-xs text-blue-700 dark:text-blue-300">
                            <span class="font-semibold">Tip:</span> For best results, use a square logo with transparent background. Recommended size: 200x200 pixels or larger.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Maintenance Mode -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6 mb-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">construction</span>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Maintenance Mode</h3>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-lg transition-colors" id="maintenance-icon-bg">
                        <span class="material-symbols-outlined" id="maintenance-icon">
                            {{ $settings['maintenance_mode'] ? 'construction' : 'check_circle' }}
                        </span>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white" id="maintenance-title">
                            {{ $settings['maintenance_mode'] ? 'Under Maintenance' : 'Site is Live' }}
                        </h4>
                        <p class="text-sm text-gray-500" id="maintenance-desc">
                            {{ $settings['maintenance_mode'] ? 'Public users see the maintenance page' : 'Site is accessible to all users' }}
                        </p>
                    </div>
                </div>
                
                <button 
                    type="button" 
                    id="maintenance-toggle"
                    onclick="toggleMaintenanceMode()"
                    class="relative inline-flex h-7 w-14 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 {{ $settings['maintenance_mode'] ? 'bg-orange-500' : 'bg-green-500' }}"
                    role="switch"
                    aria-checked="{{ $settings['maintenance_mode'] ? 'true' : 'false' }}"
                >
                    <span 
                        id="maintenance-toggle-dot"
                        class="pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $settings['maintenance_mode'] ? 'translate-x-7' : 'translate-x-0' }}"
                    ></span>
                </button>
            </div>
            
            <p class="mt-4 text-xs text-gray-400">
                <span class="material-symbols-outlined text-sm align-middle">info</span>
                When enabled, public visitors will see an "Under Construction" page. Admin users can still access the site normally.
            </p>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('dashboard') }}" class="px-6 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-xl">save</span>
                Save Settings
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const container = document.getElementById('logo-preview-container');
            container.innerHTML = `<img src="${e.target.result}" alt="Logo Preview" class="w-full h-full object-contain" id="logo-preview">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Drag and drop
const dropZone = document.getElementById('drop-zone');
const fileInput = document.getElementById('site_logo');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, () => dropZone.classList.add('border-primary', 'bg-primary/5'), false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, () => dropZone.classList.remove('border-primary', 'bg-primary/5'), false);
});

dropZone.addEventListener('drop', (e) => {
    const dt = e.dataTransfer;
    const files = dt.files;
    fileInput.files = files;
    previewLogo(fileInput);
}, false);

// Maintenance Mode Toggle
async function toggleMaintenanceMode() {
    const toggle = document.getElementById('maintenance-toggle');
    const toggleDot = document.getElementById('maintenance-toggle-dot');
    const icon = document.getElementById('maintenance-icon');
    const iconBg = document.getElementById('maintenance-icon-bg');
    const title = document.getElementById('maintenance-title');
    const desc = document.getElementById('maintenance-desc');
    
    try {
        const response = await fetch('{{ route("admin.toggle-maintenance") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            if (data.maintenance_mode) {
                toggle.classList.remove('bg-green-500');
                toggle.classList.add('bg-orange-500');
                toggleDot.classList.remove('translate-x-0');
                toggleDot.classList.add('translate-x-7');
                icon.textContent = 'construction';
                icon.classList.remove('text-green-600');
                icon.classList.add('text-orange-600');
                iconBg.classList.remove('bg-green-100', 'dark:bg-green-900/20');
                iconBg.classList.add('bg-orange-100', 'dark:bg-orange-900/20');
                title.textContent = 'Under Maintenance';
                desc.textContent = 'Public users see the maintenance page';
            } else {
                toggle.classList.remove('bg-orange-500');
                toggle.classList.add('bg-green-500');
                toggleDot.classList.remove('translate-x-7');
                toggleDot.classList.add('translate-x-0');
                icon.textContent = 'check_circle';
                icon.classList.remove('text-orange-600');
                icon.classList.add('text-green-600');
                iconBg.classList.remove('bg-orange-100', 'dark:bg-orange-900/20');
                iconBg.classList.add('bg-green-100', 'dark:bg-green-900/20');
                title.textContent = 'Site is Live';
                desc.textContent = 'Site is accessible to all users';
            }
        }
    } catch (error) {
        console.error('Error toggling maintenance mode:', error);
    }
}
</script>
@endpush
@endsection
