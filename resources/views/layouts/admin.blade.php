<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ \App\Models\Setting::get('site_name', 'Sebuah Sinopsis') }}</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#0d59f2",
                        "background-light": "#f5f6f8",
                        "background-dark": "#101622",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1c2433",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .icon-filled {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-gray-900 dark:text-gray-100 transition-colors duration-200">
    <div class="flex h-screen overflow-hidden">
        <!-- Side Navigation Bar -->
        <aside id="sidebar" class="w-64 flex flex-col bg-surface-light dark:bg-surface-dark border-r border-gray-200 dark:border-gray-800 flex-shrink-0 transition-all duration-200 fixed lg:relative h-full z-40 -translate-x-full lg:translate-x-0">
            <div class="flex flex-col h-full p-4">
                <!-- Brand -->
                <div class="flex flex-col mb-8 px-2">
                    <a href="{{ route('books.index') }}" class="flex items-center gap-2 text-gray-900 dark:text-white hover:text-primary transition-colors">
                        @php $siteLogo = \App\Models\Setting::get('site_logo'); @endphp
                        @if($siteLogo)
                            <img src="{{ asset('storage/' . $siteLogo) }}" alt="Logo" class="w-8 h-8 object-contain">
                        @else
                            <span class="material-symbols-outlined text-primary text-2xl">auto_stories</span>
                        @endif
                        <span class="text-lg font-bold leading-normal">{{ \App\Models\Setting::get('site_name', 'Sebuah Sinopsis') }}</span>
                    </a>
                    <p class="text-gray-500 dark:text-gray-400 text-xs font-normal leading-normal">Admin Dashboard</p>
                </div>
                
                <!-- Navigation Links -->
                <nav class="flex flex-col gap-1 flex-1">
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primary dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }} transition-colors" href="{{ route('dashboard') }}">
                        <span class="material-symbols-outlined {{ request()->routeIs('dashboard') ? 'icon-filled' : '' }} text-xl">dashboard</span>
                        <span class="text-sm {{ request()->routeIs('dashboard') ? 'font-bold' : 'font-medium' }}">Dashboard</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.books.index') ? 'bg-primary/10 text-primary dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }} transition-colors" href="{{ route('admin.books.index') }}">
                        <span class="material-symbols-outlined {{ request()->routeIs('admin.books.index') ? 'icon-filled' : '' }} text-xl">article</span>
                        <span class="text-sm {{ request()->routeIs('admin.books.index') ? 'font-bold' : 'font-medium' }}">All Posts</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.books.create') ? 'bg-primary/10 text-primary dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }} transition-colors" href="{{ route('admin.books.create') }}">
                        <span class="material-symbols-outlined {{ request()->routeIs('admin.books.create') ? 'icon-filled' : '' }} text-xl">add_box</span>
                        <span class="text-sm {{ request()->routeIs('admin.books.create') ? 'font-bold' : 'font-medium' }}">Add New Book</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-primary/10 text-primary dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }} transition-colors" href="{{ route('admin.categories.index') }}">
                        <span class="material-symbols-outlined {{ request()->routeIs('admin.categories.*') ? 'icon-filled' : '' }} text-xl">category</span>
                        <span class="text-sm {{ request()->routeIs('admin.categories.*') ? 'font-bold' : 'font-medium' }}">Categories</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.comments.*') ? 'bg-primary/10 text-primary dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }} transition-colors" href="#">
                        <span class="material-symbols-outlined {{ request()->routeIs('admin.comments.*') ? 'icon-filled' : '' }} text-xl">chat</span>
                        <span class="text-sm {{ request()->routeIs('admin.comments.*') ? 'font-bold' : 'font-medium' }}">Comments</span>
                    </a>

                    <!-- Settings Section -->
                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <p class="px-3 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Settings</p>
                        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('users.*') ? 'bg-primary/10 text-primary dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }} transition-colors" href="{{ route('users.index') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('users.*') ? 'icon-filled' : '' }} text-xl">people</span>
                            <span class="text-sm {{ request()->routeIs('users.*') ? 'font-bold' : 'font-medium' }}">Users</span>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('roles.*') ? 'bg-primary/10 text-primary dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }} transition-colors" href="{{ route('roles.index') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('roles.*') ? 'icon-filled' : '' }} text-xl">admin_panel_settings</span>
                            <span class="text-sm {{ request()->routeIs('roles.*') ? 'font-bold' : 'font-medium' }}">Roles</span>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('permissions.*') ? 'bg-primary/10 text-primary dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }} transition-colors" href="{{ route('permissions.index') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('permissions.*') ? 'icon-filled' : '' }} text-xl">key</span>
                            <span class="text-sm {{ request()->routeIs('permissions.*') ? 'font-bold' : 'font-medium' }}">Permissions</span>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-primary/10 text-primary dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }} transition-colors" href="{{ route('admin.settings.index') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('admin.settings.*') ? 'icon-filled' : '' }} text-xl">tune</span>
                            <span class="text-sm {{ request()->routeIs('admin.settings.*') ? 'font-bold' : 'font-medium' }}">Site Settings</span>
                        </a>
                    </div>
                </nav>
                
                <!-- Bottom Links -->
                <div class="mt-auto flex flex-col gap-1 border-t border-gray-100 dark:border-gray-800 pt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <span class="material-symbols-outlined text-xl">logout</span>
                            <span class="text-sm font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Sidebar Overlay (Mobile) -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col h-full overflow-hidden relative">
            <!-- Top Header -->
            <header class="h-16 flex items-center justify-between px-4 md:px-8 bg-surface-light dark:bg-surface-dark border-b border-gray-200 dark:border-gray-800 flex-shrink-0 z-10">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <!-- Breadcrumbs -->
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                        @yield('breadcrumbs')
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @yield('header-actions')
                    
                    <!-- User Info -->
                    <div class="hidden md:flex items-center gap-2 pl-4 border-l border-gray-200 dark:border-gray-700">
                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center">
                            <span class="text-primary text-sm font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-4 md:p-8">
                @if (session('success'))
                    <div class="max-w-5xl mx-auto mb-6">
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg flex items-center gap-2" role="alert">
                            <span class="material-symbols-outlined text-xl">check_circle</span>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="max-w-5xl mx-auto mb-6">
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg" role="alert">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="material-symbols-outlined text-xl">error</span>
                                <span class="font-medium">Terjadi kesalahan:</span>
                            </div>
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @yield('content')
                
                <!-- Footer Spacer -->
                <div class="h-20"></div>
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

    </script>
    @stack('scripts')
</body>
</html>
