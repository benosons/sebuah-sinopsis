<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Sebuah Sinopsis - {{ $book->title }}</title>
    <meta name="description" content="{{ Str::limit(strip_tags($book->synopsis), 160) }}"/>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&family=Noto+Sans:wght@400;500;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#3b82f6",
                        "background-main": "#09090b",
                        "surface-card": "#18181b",
                        "surface-highlight": "#27272a",
                        "text-main": "#f4f4f5",
                        "text-muted": "#a1a1aa",
                        "border-subtle": "#27272a",
                        amazon: "#FF9900",
                        tokopedia: "#03AC0E",
                    },
                    fontFamily: {
                        display: ["Newsreader", "serif"],
                        sans: ["Noto Sans", "sans-serif"],
                    },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .glass-nav {
                @apply bg-[#09090b]/80 backdrop-blur-md border-b border-border-subtle;
            }
            .glass-card {
                @apply bg-surface-card/60 backdrop-blur-xl border border-white/10 shadow-xl;
            }
            .glass-panel-dark {
                @apply bg-black/30 backdrop-blur-sm border border-white/5;
            }
        }
    </style>
</head>
<body class="bg-background-main font-display text-text-main min-h-screen flex flex-col antialiased selection:bg-primary/30 selection:text-white relative overflow-x-hidden">
    <!-- Background Effects -->
    <div class="fixed inset-0 pointer-events-none -z-10">
        <div class="absolute top-[-10%] left-[-10%] w-[50vw] h-[50vw] rounded-full bg-primary/10 blur-[100px] opacity-40"></div>
        <div class="absolute top-[30%] right-[-10%] w-[40vw] h-[40vw] rounded-full bg-purple-500/10 blur-[120px] opacity-30"></div>
        <div class="absolute bottom-[-10%] left-[10%] w-[60vw] h-[60vw] rounded-full bg-blue-600/10 blur-[150px] opacity-30"></div>
    </div>

    <!-- Header -->
    <header class="sticky top-0 z-50 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 gap-4">
                <div class="flex items-center gap-3">
                    <a href="{{ route('books.index') }}" class="flex items-center gap-3">
                        <div class="text-white bg-primary/20 p-2 rounded-lg border border-white/5">
                            <span class="material-symbols-outlined text-2xl">local_library</span>
                        </div>
                        <h1 class="text-xl font-bold tracking-tight text-white hidden sm:block font-sans">Sebuah Sinopsis</h1>
                    </a>
                </div>
                <nav class="hidden md:flex items-center gap-8">
                    <a class="text-sm font-medium text-text-muted hover:text-white transition-colors" href="{{ route('books.index') }}">Home</a>
                    <a class="text-sm font-medium text-text-muted hover:text-white transition-colors" href="#">Categories</a>
                    <a class="text-sm font-medium text-text-muted hover:text-white transition-colors" href="#">Top Charts</a>
                    <a class="text-sm font-medium text-text-muted hover:text-white transition-colors" href="#">Community</a>
                </nav>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-white text-black hover:bg-gray-200 px-5 py-2 rounded-full text-sm font-bold transition-colors whitespace-nowrap font-sans shadow-lg shadow-white/5">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-white text-black hover:bg-gray-200 px-5 py-2 rounded-full text-sm font-bold transition-colors whitespace-nowrap font-sans shadow-lg shadow-white/5">
                            Sign In
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 relative z-10">
        <!-- Breadcrumb -->
        <nav aria-label="Breadcrumb" class="flex mb-8">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 font-sans">
                <li class="inline-flex items-center">
                    <a class="inline-flex items-center text-sm font-medium text-text-muted hover:text-white transition-colors" href="{{ route('books.index') }}">
                        <span class="material-symbols-outlined text-[18px] mr-2">home</span>
                        Home
                    </a>
                </li>
                @if ($book->category)
                <li>
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-text-muted text-[16px]">chevron_right</span>
                        <a class="ml-1 text-sm font-medium text-text-muted hover:text-white md:ml-2 transition-colors" href="{{ route('books.index', ['category' => $book->category->slug]) }}">{{ $book->category->name }}</a>
                    </div>
                </li>
                @endif
                <li>
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-text-muted text-[16px]">chevron_right</span>
                        <span class="ml-1 text-sm font-medium text-white md:ml-2">{{ Str::limit($book->title, 30) }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Book Detail Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 mb-16">
            <!-- Book Cover -->
            <div class="lg:col-span-4 flex flex-col gap-6">
                <div class="relative group w-full max-w-[360px] mx-auto lg:mx-0 shadow-2xl shadow-black/80 rounded-lg overflow-hidden bg-surface-card aspect-[2/3] border border-border-subtle ring-1 ring-white/5">
                    @if ($book->cover_image)
                        <div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-105 opacity-95 group-hover:opacity-100" style="background-image: url('{{ asset('storage/' . $book->cover_image) }}');"></div>
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-primary/30 to-primary/60 flex items-center justify-center">
                            <span class="material-symbols-outlined text-white/40 text-6xl">menu_book</span>
                        </div>
                    @endif
                    @if ($book->is_featured)
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur text-black text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm font-sans">
                        Featured
                    </div>
                    @endif
                </div>

                <!-- Mobile Affiliate Links -->
                @if ($book->affiliate_links && count($book->affiliate_links) > 0)
                <div class="flex lg:hidden flex-col gap-3 font-sans">
                    @foreach ($book->affiliate_links as $link)
                        @if (!empty($link['name']) && !empty($link['url']))
                            @php
                                $isAmazon = str_contains(strtolower($link['name']), 'amazon');
                                $isTokopedia = str_contains(strtolower($link['name']), 'tokopedia');
                            @endphp
                            <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" class="w-full {{ $isAmazon ? 'bg-amazon hover:bg-yellow-500 text-black' : ($isTokopedia ? 'bg-tokopedia hover:opacity-90 text-white' : 'bg-primary hover:bg-primary/90 text-white') }} h-12 rounded-lg font-bold flex items-center justify-center gap-2 transition-all shadow-lg">
                                <span class="material-symbols-outlined">{{ $isAmazon ? 'shopping_cart' : 'storefront' }}</span>
                                Buy on {{ $link['name'] }}
                            </a>
                        @endif
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Book Info -->
            <div class="lg:col-span-8 flex flex-col">
                <div class="border-b border-border-subtle pb-6 mb-6">
                    @if ($book->category)
                    <div class="flex items-center gap-2 text-primary mb-3 font-medium text-sm font-sans tracking-wide uppercase">
                        <span class="material-symbols-outlined text-[18px] fill-current">auto_stories</span>
                        <span>{{ $book->category->name }}</span>
                    </div>
                    @endif
                    <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight mb-4 tracking-tight">{{ $book->title }}</h1>
                    <div class="flex flex-wrap items-center gap-4 text-lg text-text-muted">
                        <span class="font-sans">By <span class="text-white font-semibold border-b border-white/20 pb-0.5">{{ $book->author }}</span></span>
                        <span class="w-1 h-1 rounded-full bg-text-muted/30"></span>
                        <div class="flex items-center text-yellow-400 gap-1">
                            <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1">star</span>
                            <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1">star</span>
                            <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1">star</span>
                            <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1">star</span>
                            <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1">star_half</span>
                            <span class="text-white font-bold ml-1 text-base font-sans">4.5</span>
                            <span class="text-sm text-text-muted font-normal ml-1 font-sans">({{ $book->comments->count() }} reviews)</span>
                        </div>
                    </div>
                </div>

                <!-- Synopsis -->
                <div class="prose prose-invert prose-lg max-w-none text-gray-300 mb-8 font-display leading-relaxed">
                    {!! nl2br(e($book->synopsis)) !!}
                </div>

                <!-- Book Details Card -->
                <div class="glass-card grid grid-cols-2 md:grid-cols-4 gap-6 p-6 rounded-2xl mb-8 font-sans">
                    <div class="flex flex-col gap-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-text-muted">Publisher</span>
                        <span class="font-medium text-white">{{ $book->publisher ?? 'N/A' }}</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-text-muted">Released</span>
                        <span class="font-medium text-white">{{ $book->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-text-muted">Category</span>
                        <span class="font-medium text-white">{{ $book->category->name ?? 'Uncategorized' }}</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-text-muted">ISBN</span>
                        <span class="font-medium text-white">{{ $book->isbn ?? 'N/A' }}</span>
                    </div>
                </div>

                <!-- Desktop Affiliate Links -->
                @if ($book->affiliate_links && count($book->affiliate_links) > 0)
                <div class="hidden lg:flex flex-wrap gap-4 font-sans">
                    @foreach ($book->affiliate_links as $link)
                        @if (!empty($link['name']) && !empty($link['url']))
                            @php
                                $isAmazon = str_contains(strtolower($link['name']), 'amazon');
                                $isTokopedia = str_contains(strtolower($link['name']), 'tokopedia');
                            @endphp
                            <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" class="flex-1 max-w-[240px] {{ $isAmazon ? 'bg-amazon hover:bg-yellow-500 text-black' : ($isTokopedia ? 'bg-tokopedia hover:opacity-90 text-white' : 'bg-primary hover:bg-primary/90 text-white') }} h-14 rounded-lg font-bold flex items-center justify-center gap-3 transition-all shadow-lg hover:-translate-y-0.5">
                                <span class="material-symbols-outlined">{{ $isAmazon ? 'shopping_cart' : 'storefront' }}</span>
                                Buy on {{ $link['name'] }}
                            </a>
                        @endif
                    @endforeach
                    <button aria-label="Add to wishlist" class="px-4 h-14 rounded-lg border border-border-subtle bg-surface-card hover:bg-surface-highlight flex items-center justify-center transition-all group">
                        <span class="material-symbols-outlined text-text-muted group-hover:text-primary transition-colors">bookmark</span>
                    </button>
                    <button aria-label="Share" class="px-4 h-14 rounded-lg border border-border-subtle bg-surface-card hover:bg-surface-highlight flex items-center justify-center transition-all group">
                        <span class="material-symbols-outlined text-text-muted group-hover:text-primary transition-colors">share</span>
                    </button>
                </div>
                @endif
            </div>
        </div>

        <!-- Discussion Section -->
        @if ($book->allow_comments)
        <section class="max-w-4xl mx-auto border-t border-border-subtle pt-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-white font-sans tracking-tight">Discussion ({{ $book->comments->count() }})</h2>
                <div class="flex items-center gap-3 bg-surface-card px-4 py-2 rounded-full border border-border-subtle hover:border-white/20 transition-colors">
                    <span class="text-xs uppercase tracking-wider font-bold text-text-muted font-sans">Sort</span>
                    <select class="bg-transparent border-none text-sm font-bold text-white focus:ring-0 cursor-pointer py-0 pr-6 pl-0 font-sans">
                        <option class="bg-surface-card text-white">Top Rated</option>
                        <option class="bg-surface-card text-white">Newest</option>
                    </select>
                </div>
            </div>

            @if (session('success'))
                <div class="glass-card bg-green-500/10 border-green-500/30 text-green-400 px-6 py-4 rounded-xl mb-8 font-sans" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Comment Form -->
            @auth
            <form method="POST" action="{{ route('comments.store', $book) }}" class="glass-card p-6 rounded-2xl mb-10">
                @csrf
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm ring-2 ring-white/5 border border-primary/20">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                    </div>
                    <div class="flex-grow">
                        <textarea name="body" class="w-full bg-background-main/80 border border-white/10 rounded-xl p-4 text-white placeholder-text-muted focus:ring-1 focus:ring-primary focus:border-primary/50 transition-all resize-y text-base font-sans" placeholder="Share your thoughts on this book..." rows="3" required>{{ old('body') }}</textarea>
                        @error('body')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                        <div class="flex justify-between items-center mt-4">
                            <div class="flex items-center gap-1 text-text-muted">
                                <button type="button" class="hover:text-white hover:bg-white/5 transition-colors p-2 rounded"><span class="material-symbols-outlined text-[20px]">format_bold</span></button>
                                <button type="button" class="hover:text-white hover:bg-white/5 transition-colors p-2 rounded"><span class="material-symbols-outlined text-[20px]">format_italic</span></button>
                                <button type="button" class="hover:text-white hover:bg-white/5 transition-colors p-2 rounded"><span class="material-symbols-outlined text-[20px]">link</span></button>
                            </div>
                            <button type="submit" class="bg-white hover:bg-gray-200 text-black px-6 py-2.5 rounded-lg text-sm font-bold transition-colors font-sans shadow-lg shadow-white/5">
                                Post Review
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            @else
            <div class="glass-card p-6 rounded-2xl mb-10 text-center">
                <p class="text-text-muted font-sans">
                    <a href="{{ route('login') }}" class="text-primary hover:text-white font-bold">Sign in</a> 
                    to join the discussion and share your review.
                </p>
            </div>
            @endauth

            <!-- Comments List -->
            <div class="flex flex-col gap-6">
                @forelse ($book->comments as $comment)
                <article class="flex flex-col gap-4 glass-card p-6 rounded-xl transition-all hover:bg-surface-card/70 hover:shadow-primary/5">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-purple-600 text-white flex items-center justify-center text-xs font-bold ring-2 ring-white/10">
                                {{ strtoupper(substr($comment->user->name ?? 'G', 0, 2)) }}
                            </div>
                        </div>
                        <div class="flex-grow">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="font-bold text-white text-sm font-sans">{{ $comment->user->name ?? 'Guest' }}</h3>
                                    <span class="text-xs text-text-muted font-sans">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex text-yellow-400">
                                    @for ($i = 0; $i < 5; $i++)
                                        <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1">star</span>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-300 text-base leading-relaxed mb-4 font-sans">
                                {{ $comment->body }}
                            </p>
                            <div class="flex items-center gap-6 text-sm font-sans">
                                <button class="flex items-center gap-2 text-text-muted hover:text-white transition-colors font-medium group">
                                    <span class="material-symbols-outlined text-[18px] group-hover:text-primary transition-colors">thumb_up</span>
                                    {{ rand(5, 100) }}
                                </button>
                                <button onclick="toggleReplyForm({{ $comment->id }})" class="flex items-center gap-2 text-text-muted hover:text-white transition-colors font-medium group">
                                    <span class="material-symbols-outlined text-[18px] group-hover:text-primary transition-colors">chat_bubble</span>
                                    Reply
                                </button>
                            </div>

                            <!-- Reply Form -->
                            @auth
                            <div id="reply-form-{{ $comment->id }}" class="hidden mt-4">
                                <form method="POST" action="{{ route('comments.reply', $comment) }}" class="glass-panel-dark p-4 rounded-lg">
                                    @csrf
                                    <textarea name="body" rows="2" class="w-full bg-background-main/80 border border-white/10 rounded-lg p-3 text-white placeholder-text-muted focus:ring-1 focus:ring-primary text-sm font-sans" placeholder="Write a reply..." required></textarea>
                                    <div class="flex justify-end mt-2">
                                        <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg text-sm font-bold font-sans">Reply</button>
                                    </div>
                                </form>
                            </div>
                            @endauth
                        </div>
                    </div>

                    <!-- Replies -->
                    @foreach ($comment->replies as $reply)
                    <div class="ml-14 glass-panel-dark p-4 rounded-lg flex gap-4 mt-2">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold ring-1 ring-white/10">
                                {{ strtoupper(substr($reply->user->name ?? 'G', 0, 2)) }}
                            </div>
                        </div>
                        <div class="flex-grow">
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="font-bold text-white text-sm font-sans">{{ $reply->user->name ?? 'Guest' }}</h3>
                                <span class="text-xs text-text-muted font-sans">• {{ $reply->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-400 text-sm leading-relaxed mb-3 font-sans">
                                {{ $reply->body }}
                            </p>
                            <div class="flex items-center gap-6 text-sm font-sans">
                                <button class="flex items-center gap-2 text-text-muted hover:text-white transition-colors font-medium group">
                                    <span class="material-symbols-outlined text-[16px] group-hover:text-primary transition-colors">thumb_up</span>
                                    {{ rand(1, 20) }}
                                </button>
                                <button class="flex items-center gap-2 text-text-muted hover:text-white transition-colors font-medium group">
                                    Reply
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </article>
                @empty
                <div class="text-center py-12">
                    <div class="w-16 h-16 rounded-full bg-surface-card flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-3xl text-text-muted">chat_bubble</span>
                    </div>
                    <p class="text-text-muted font-sans">No reviews yet. Be the first to share your thoughts!</p>
                </div>
                @endforelse

                @if ($book->comments->count() > 5)
                <div class="text-center mt-8">
                    <button class="text-white font-bold text-sm border border-border-subtle bg-surface-card px-8 py-3 rounded-full hover:bg-surface-highlight transition-all font-sans hover:border-white/20 shadow-lg">
                        Load more comments
                    </button>
                </div>
                @endif
            </div>
        </section>
        @else
        <section class="max-w-4xl mx-auto border-t border-border-subtle pt-16 text-center">
            <div class="w-16 h-16 rounded-full bg-surface-card flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-3xl text-text-muted">comments_disabled</span>
            </div>
            <p class="text-text-muted font-sans">Comments are disabled for this book.</p>
        </section>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-surface-card border-t border-border-subtle mt-20 py-12 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3 text-white">
                <span class="material-symbols-outlined text-[24px] text-primary">local_library</span>
                <span class="font-bold font-sans">Sebuah Sinopsis</span>
            </div>
            <div class="text-sm text-text-muted font-sans">
                © {{ date('Y') }} Sebuah Sinopsis. All rights reserved.
            </div>
            <div class="flex gap-6">
                <a class="text-text-muted hover:text-white transition-colors" href="#"><span class="material-symbols-outlined">mail</span></a>
                <a class="text-text-muted hover:text-white transition-colors" href="#"><span class="material-symbols-outlined">public</span></a>
            </div>
        </div>
    </footer>

    <script>
        function toggleReplyForm(commentId) {
            const form = document.getElementById('reply-form-' + commentId);
            form.classList.toggle('hidden');
        }
    </script>
</body>
</html>
