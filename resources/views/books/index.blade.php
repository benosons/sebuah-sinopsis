<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Sebuah Sinopsis - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&family=Noto+Sans:wght@400;500;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#3b82f6",
                        "background-light": "#f6f7f8",
                        "background-dark": "#121212",
                        "surface-dark": "#1E1E1E",
                        "surface-hover": "#252525",
                    },
                    fontFamily: {
                        "display": ["Newsreader", "serif"],
                        "sans": ["Noto Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .dark ::-webkit-scrollbar-thumb { background: #4b5563; }
        .dark ::-webkit-scrollbar-thumb:hover { background: #6b7280; }
        .filled { font-variation-settings: 'FILL' 1; }
    </style>
</head>
<body class="bg-background-light dark:bg-[#0F1115] text-[#111418] dark:text-gray-100 font-display transition-colors duration-300 relative">
    <!-- Background Gradient -->
    <div class="fixed inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-blue-100/40 via-gray-50 to-gray-100 dark:from-blue-900/20 dark:via-[#121212] dark:to-black pointer-events-none"></div>

    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white dark:bg-background-dark/80 backdrop-blur-md border-b border-[#f0f2f4] dark:border-white/10 px-6 lg:px-10 py-3 shadow-sm transition-colors duration-300">
        <div class="max-w-[1280px] mx-auto flex items-center justify-between">
            <div class="flex items-center gap-4 text-[#111418] dark:text-white">
                <div class="size-8 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">auto_stories</span>
                </div>
                <h2 class="text-xl lg:text-2xl font-bold leading-tight tracking-tight">Sebuah Sinopsis</h2>
            </div>
            <nav class="hidden lg:flex items-center gap-8">
                <a class="text-sm font-medium dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors" href="{{ route('books.index') }}">Home</a>
                <a class="text-sm font-medium dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors" href="#">Reviews</a>
                <a class="text-sm font-medium dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors" href="#">Collections</a>
                <a class="text-sm font-medium dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors" href="#">Forum</a>
            </nav>
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="hidden sm:flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-9 px-4 bg-primary text-white text-sm font-bold shadow hover:bg-primary/90 transition-all">
                        <span class="truncate">Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-9 px-4 bg-primary text-white text-sm font-bold shadow hover:bg-primary/90 transition-all">
                        <span class="truncate">Login</span>
                    </a>
                @endauth
                <button class="lg:hidden p-2 text-gray-600 dark:text-gray-300">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>
        </div>
    </header>

    <main class="flex flex-col min-h-screen">
        <!-- Hero Section -->
        <section class="relative w-full bg-[#111921] dark:bg-transparent text-white">
            <div class="absolute inset-0 bg-cover bg-center opacity-30 dark:opacity-20" style="background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=1920&q=80');"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#121212] via-[#121212]/50 to-[#121212]/30"></div>
            <div class="relative z-10 max-w-[960px] mx-auto px-6 py-20 lg:py-28 text-center flex flex-col items-center gap-6">
                <h1 class="text-4xl lg:text-6xl font-bold tracking-tight leading-tight drop-shadow-2xl text-white">
                    Discover your next great read
                </h1>
                <p class="text-lg lg:text-xl text-gray-300 max-w-2xl font-light drop-shadow-md">
                    Explore honest reviews, detailed synopses, and join our thriving literary community.
                </p>
                <div class="w-full max-w-[560px] mt-4">
                    <form action="{{ route('books.index') }}" method="GET" class="relative flex items-center w-full h-14 rounded-xl shadow-lg bg-white/90 dark:bg-white/10 backdrop-blur-md overflow-hidden ring-1 ring-white/20">
                        <div class="grid place-items-center h-full w-12 text-gray-500 dark:text-gray-300">
                            <span class="material-symbols-outlined">search</span>
                        </div>
                        <input class="peer h-full w-full outline-none text-sm text-gray-700 dark:text-gray-100 pr-2 bg-transparent border-none placeholder-gray-500 dark:placeholder-gray-400 font-sans" name="search" placeholder="Search titles, authors, or genres..." type="text" value="{{ request('search') }}"/>
                        <button type="submit" class="bg-primary hover:bg-primary/90 text-white font-bold h-10 px-6 rounded-lg mr-2 transition-colors text-sm shadow-md">
                            Search
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <div class="flex-1 w-full max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-16">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                <!-- Books Grid -->
                <div class="lg:col-span-8 flex flex-col gap-8">
                    <!-- Category Filters -->
                    <div class="flex flex-wrap items-center gap-3 pb-4 border-b border-gray-200 dark:border-white/10">
                        <span class="text-sm font-semibold mr-2 text-gray-500 dark:text-gray-400 uppercase tracking-wider">Browse:</span>
                        <a href="{{ route('books.index') }}" class="px-4 py-1.5 rounded-full {{ !request('category') ? 'bg-primary text-white' : 'bg-white dark:bg-white/5 hover:bg-gray-50 dark:hover:bg-white/10 border border-gray-200 dark:border-white/10 text-gray-700 dark:text-gray-300' }} text-sm font-medium shadow-sm transition-all">All</a>
                        @foreach ($categories as $category)
                            <a href="{{ route('books.index', ['category' => $category->slug]) }}" class="px-4 py-1.5 rounded-full {{ request('category') == $category->slug ? 'bg-primary text-white' : 'bg-white dark:bg-white/5 hover:bg-gray-50 dark:hover:bg-white/10 border border-gray-200 dark:border-white/10 text-gray-700 dark:text-gray-300' }} text-sm font-medium transition-all backdrop-blur-sm">{{ $category->name }}</a>
                        @endforeach
                    </div>

                    @if ($books->count() > 0)
                        <!-- Book Cards Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                            @foreach ($books as $book)
                                <div class="group flex flex-col bg-white/70 dark:bg-white/5 backdrop-blur-md rounded-xl overflow-hidden shadow-sm dark:shadow-black/40 hover:shadow-xl dark:hover:shadow-black/60 hover:-translate-y-1 transition-all duration-300 border border-white/40 dark:border-white/10">
                                    <div class="h-64 overflow-hidden relative bg-gray-100 dark:bg-[#252525]">
                                        @if ($book->cover_image)
                                            <img alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ asset('storage/' . $book->cover_image) }}"/>
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-primary/30 to-primary/60 flex items-center justify-center group-hover:scale-105 transition-transform duration-500">
                                                <span class="material-symbols-outlined text-white/60 text-5xl">menu_book</span>
                                            </div>
                                        @endif
                                        @if ($book->category)
                                            <div class="absolute top-2 right-2 bg-white/90 dark:bg-black/60 backdrop-blur-md px-2 py-1 rounded text-xs font-bold shadow-sm text-gray-800 dark:text-gray-200 border border-white/20">
                                                {{ $book->category->name }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-5 flex flex-col flex-1">
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white leading-tight mb-1">{{ Str::limit($book->title, 30) }}</h3>
                                        <p class="text-primary text-sm font-medium mb-3">{{ $book->author }}</p>
                                        <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-3 mb-4 leading-relaxed font-sans">
                                            {{ Str::limit(strip_tags($book->synopsis), 120) }}
                                        </p>
                                        <div class="mt-auto pt-4 border-t border-gray-200/50 dark:border-white/10 flex items-center justify-between">
                                            <span class="flex items-center text-yellow-500 text-sm gap-1">
                                                <span class="material-symbols-outlined text-sm filled">star</span> 4.8
                                            </span>
                                            <a class="text-primary text-sm font-bold hover:underline" href="{{ route('books.show', $book) }}">Read Synopsis</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if ($books->hasPages())
                            <div class="flex justify-center mt-8">
                                {{ $books->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-16">
                            <div class="w-20 h-20 rounded-full bg-gray-100 dark:bg-white/5 flex items-center justify-center mx-auto mb-4">
                                <span class="material-symbols-outlined text-4xl text-gray-400">library_books</span>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 text-lg">No books found.</p>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <aside class="lg:col-span-4 flex flex-col gap-8">
                    <!-- Trending Books -->
                    <div class="bg-white/70 dark:bg-white/5 backdrop-blur-md rounded-xl p-6 shadow-sm border border-white/40 dark:border-white/10">
                        <div class="flex items-center gap-2 mb-6 border-b border-gray-200 dark:border-white/10 pb-3">
                            <span class="material-symbols-outlined text-primary">trending_up</span>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Trending Books</h3>
                        </div>
                        <ul class="flex flex-col gap-4">
                            @foreach ($trendingBooks as $index => $trending)
                                <li class="flex items-start gap-4 group cursor-pointer">
                                    <span class="text-2xl font-black text-gray-300 dark:text-gray-600 leading-none mt-1">{{ $index + 1 }}</span>
                                    @if ($trending->cover_image)
                                        <img alt="{{ $trending->title }}" class="w-12 h-16 object-cover rounded shadow-sm" src="{{ asset('storage/' . $trending->cover_image) }}"/>
                                    @else
                                        <div class="w-12 h-16 bg-gradient-to-br from-primary/30 to-primary/60 rounded shadow-sm flex items-center justify-center">
                                            <span class="material-symbols-outlined text-white/60 text-sm">menu_book</span>
                                        </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('books.show', $trending) }}" class="font-bold text-sm leading-tight text-gray-900 dark:text-white group-hover:text-primary transition-colors">{{ Str::limit($trending->title, 25) }}</a>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $trending->author }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Recent Discussions -->
                    <div class="bg-white/70 dark:bg-white/5 backdrop-blur-md rounded-xl p-6 shadow-sm border border-white/40 dark:border-white/10">
                        <div class="flex items-center gap-2 mb-6 border-b border-gray-200 dark:border-white/10 pb-3">
                            <span class="material-symbols-outlined text-primary">forum</span>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Discussions</h3>
                        </div>
                        <div class="flex flex-col gap-5">
                            @foreach ($recentComments as $comment)
                                <div class="flex gap-3 items-start">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/40 text-primary flex items-center justify-center text-xs font-bold shrink-0 ring-1 ring-blue-200 dark:ring-blue-800">
                                        {{ strtoupper(substr($comment->user->name ?? 'G', 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium leading-tight mb-1 text-gray-900 dark:text-gray-200">
                                            <span class="text-primary font-bold">{{ $comment->user->name ?? 'Guest' }}</span> commented on 
                                            <span class="italic text-gray-600 dark:text-gray-400">{{ Str::limit($comment->book->title ?? '', 20) }}</span>
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-sans">"{{ Str::limit($comment->content, 60) }}"</p>
                                    </div>
                                </div>
                            @endforeach
                            @if ($recentComments->isEmpty())
                                <p class="text-sm text-gray-500 dark:text-gray-400">No discussions yet.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Newsletter -->
                    <div class="bg-primary/5 dark:bg-primary/10 backdrop-blur-md rounded-xl p-6 border border-primary/20 dark:border-white/10">
                        <h3 class="text-lg font-bold mb-2 text-gray-900 dark:text-white">Weekly Wisdom</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 font-sans">Get book recommendations and synopsis highlights delivered to your inbox.</p>
                        <form class="flex flex-col gap-2">
                            <input class="w-full rounded-lg border-gray-300 dark:border-white/10 text-sm p-2 focus:ring-2 focus:ring-primary/50 outline-none font-sans bg-white/50 dark:bg-white/5 dark:text-white dark:placeholder-gray-400" placeholder="Your email address" type="email"/>
                            <button class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-2 rounded-lg text-sm transition-colors shadow-sm" type="button">
                                Subscribe
                            </button>
                        </form>
                    </div>
                </aside>
            </div>
        </div>

        <!-- Affiliate Disclosure -->
        <div class="bg-gray-50 dark:bg-[#121212] border-t border-gray-200 dark:border-white/5 py-4">
            <div class="max-w-[960px] mx-auto px-6 text-center">
                <p class="text-xs text-gray-500 dark:text-gray-500 font-sans">
                    Transparency: Some links on this page are affiliate links. If you buy through them, we may earn a small commission at no extra cost to you. This helps support our digital library.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white dark:bg-background-dark border-t border-gray-200 dark:border-white/10 py-12">
            <div class="max-w-[960px] mx-auto px-6 flex flex-col items-center gap-8">
                <div class="flex items-center gap-2 text-[#111418] dark:text-white">
                    <span class="material-symbols-outlined text-primary text-2xl">auto_stories</span>
                    <h2 class="text-xl font-bold">Sebuah Sinopsis</h2>
                </div>
                <div class="flex flex-wrap justify-center gap-8 text-sm text-gray-600 dark:text-gray-400 font-medium">
                    <a class="hover:text-primary transition-colors" href="#">About Us</a>
                    <a class="hover:text-primary transition-colors" href="#">Contact</a>
                    <a class="hover:text-primary transition-colors" href="#">Affiliate Disclosure</a>
                    <a class="hover:text-primary transition-colors" href="#">Privacy Policy</a>
                    <a class="hover:text-primary transition-colors" href="#">Terms of Service</a>
                </div>
                <div class="flex gap-6">
                    <a class="text-gray-400 hover:text-primary transition-colors" href="#">
                        <span class="material-symbols-outlined">public</span>
                    </a>
                    <a class="text-gray-400 hover:text-primary transition-colors" href="#">
                        <span class="material-symbols-outlined">alternate_email</span>
                    </a>
                    <a class="text-gray-400 hover:text-primary transition-colors" href="#">
                        <span class="material-symbols-outlined">rss_feed</span>
                    </a>
                </div>
                <p class="text-xs text-gray-400 dark:text-gray-600 font-sans text-center">
                    © {{ date('Y') }} Sebuah Sinopsis. All rights reserved. <br/>Designed for book lovers.
                </p>
            </div>
        </footer>
    </main>
</body>
</html>
