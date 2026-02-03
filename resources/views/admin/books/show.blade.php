@extends('layouts.admin')

@section('title', $book->title)

@section('breadcrumbs')
    <span>Buku</span>
    <span class="material-symbols-outlined text-base mx-1">chevron_right</span>
    <span class="font-medium text-gray-900 dark:text-white">{{ Str::limit($book->title, 30) }}</span>
@endsection

@section('header-actions')
    <a href="{{ route('books.show', $book) }}" target="_blank" class="hidden sm:flex items-center justify-center px-4 h-10 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
        <span class="material-symbols-outlined text-xl mr-1">visibility</span>
        Lihat Public
    </a>
    <a href="{{ route('admin.books.edit', $book) }}" class="flex items-center justify-center px-6 h-10 rounded-lg text-sm font-bold text-white bg-primary hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-200">
        <span class="material-symbols-outlined text-xl mr-1">edit</span>
        Edit
    </a>
@endsection

@section('content')
<div class="max-w-5xl mx-auto flex flex-col gap-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            <!-- Book Info Card -->
            <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    @if ($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-40 h-56 object-cover rounded-lg shadow-lg flex-shrink-0 mx-auto md:mx-0">
                    @else
                        <div class="w-40 h-56 bg-gradient-to-br from-primary/20 to-primary/40 rounded-lg shadow-lg flex items-center justify-center flex-shrink-0 mx-auto md:mx-0">
                            <span class="material-symbols-outlined text-5xl text-primary/60">menu_book</span>
                        </div>
                    @endif
                    <div class="flex-1">
                        <h1 class="text-2xl font-black text-gray-900 dark:text-white mb-2">{{ $book->title }}</h1>
                        <p class="text-gray-600 dark:text-gray-400 mb-1">
                            <span class="font-medium">Penulis:</span> {{ $book->author }}
                        </p>
                        @if ($book->publisher)
                            <p class="text-gray-600 dark:text-gray-400 mb-4">
                                <span class="font-medium">Penerbit:</span> {{ $book->publisher }}
                            </p>
                        @endif
                        
                        <div class="flex flex-wrap gap-2 mt-4">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                                Published
                            </span>
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400">
                                <span class="material-symbols-outlined text-sm">chat</span>
                                {{ $book->allComments->count() }} Komentar
                            </span>
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700 text-sm text-gray-500 dark:text-gray-400">
                            <p>Dibuat: {{ $book->created_at->format('d M Y H:i') }}</p>
                            <p>Diupdate: {{ $book->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Synopsis Card -->
            <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">description</span>
                    Sinopsis
                </h3>
                <div class="prose prose-gray dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed">
                    {!! nl2br(e($book->synopsis)) !!}
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="flex flex-col gap-6">
            <!-- Affiliate Links Card -->
            @if ($book->affiliate_links && count(array_filter($book->affiliate_links, fn($l) => !empty($l['name']))) > 0)
                <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">shopping_cart</span>
                        Link Afiliasi
                    </h3>
                    <div class="flex flex-col gap-2">
                        @foreach ($book->affiliate_links as $link)
                            @if (!empty($link['name']) && !empty($link['url']))
                                <a href="{{ $link['url'] }}" target="_blank" rel="noopener" class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700 hover:border-primary transition-colors group">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded bg-white dark:bg-gray-700 flex items-center justify-center shadow-sm">
                                            <span class="text-[10px] font-bold text-gray-700 dark:text-gray-300">{{ strtoupper(substr($link['name'], 0, 3)) }}</span>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $link['name'] }}</span>
                                    </div>
                                    <span class="material-symbols-outlined text-gray-400 group-hover:text-primary transition-colors">open_in_new</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Actions Card -->
            <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">more_horiz</span>
                    Aksi
                </h3>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('admin.books.edit', $book) }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <span class="material-symbols-outlined text-amber-500">edit</span>
                        <span class="font-medium">Edit Buku</span>
                    </a>
                    <a href="{{ route('books.show', $book) }}" target="_blank" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <span class="material-symbols-outlined text-primary">visibility</span>
                        <span class="font-medium">Lihat di Website</span>
                    </a>
                    <form action="{{ route('admin.books.destroy', $book) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                            <span class="material-symbols-outlined">delete</span>
                            <span class="font-medium">Hapus Buku</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
