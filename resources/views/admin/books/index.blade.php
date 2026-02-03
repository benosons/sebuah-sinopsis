@extends('layouts.admin')

@section('title', 'Semua Buku')

@section('breadcrumbs')
    <span>Buku</span>
    <span class="material-symbols-outlined text-base mx-1">chevron_right</span>
    <span class="font-medium text-gray-900 dark:text-white">Semua Buku</span>
@endsection

@section('header-actions')
    <a href="{{ route('admin.books.create') }}" class="flex items-center justify-center gap-2 px-4 h-10 rounded-lg text-sm font-bold text-white bg-primary hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-200">
        <span class="material-symbols-outlined text-xl">add</span>
        <span class="hidden sm:inline">Tambah Buku</span>
    </a>
@endsection

@section('content')
<div class="max-w-6xl mx-auto flex flex-col gap-6">
    <!-- Page Heading -->
    <div class="flex flex-col gap-1">
        <h2 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white">Semua Buku</h2>
        <p class="text-gray-500 dark:text-gray-400">Kelola koleksi buku dan sinopsis Anda.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-2xl">menu_book</span>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $books->total() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Buku</p>
                </div>
            </div>
        </div>
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-green-500/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-green-500 text-2xl">visibility</span>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $books->total() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Dipublikasikan</p>
                </div>
            </div>
        </div>
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-amber-500/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-amber-500 text-2xl">chat</span>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Comment::count() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Komentar</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Books Table -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Buku</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Penulis</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden lg:table-cell">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">Tanggal</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($books as $book)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    @if ($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-12 h-16 object-cover rounded-lg shadow-sm">
                                    @else
                                        <div class="w-12 h-16 bg-gradient-to-br from-primary/20 to-primary/40 rounded-lg flex items-center justify-center">
                                            <span class="material-symbols-outlined text-primary/60">menu_book</span>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ Str::limit($book->title, 40) }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 md:hidden">{{ $book->author }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300 hidden md:table-cell">{{ $book->author }}</td>
                            <td class="px-6 py-4 hidden lg:table-cell">
                                @if($book->is_published)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-sm hidden sm:table-cell">{{ $book->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('books.show', $book) }}" target="_blank" class="p-2 rounded-lg text-gray-400 hover:text-primary hover:bg-primary/10 transition-colors" title="Lihat">
                                        <span class="material-symbols-outlined text-xl">visibility</span>
                                    </a>
                                    <a href="{{ route('admin.books.edit', $book) }}" class="p-2 rounded-lg text-gray-400 hover:text-amber-500 hover:bg-amber-500/10 transition-colors" title="Edit">
                                        <span class="material-symbols-outlined text-xl">edit</span>
                                    </a>
                                    <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-500/10 transition-colors" title="Hapus">
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
                                        <span class="material-symbols-outlined text-3xl text-gray-400">library_books</span>
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400 mb-4">Belum ada buku yang ditambahkan.</p>
                                    <a href="{{ route('admin.books.create') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-white bg-primary hover:bg-blue-700 transition-colors">
                                        <span class="material-symbols-outlined text-xl">add</span>
                                        Tambah Buku Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($books->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
                {{ $books->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
