@extends('layouts.admin')

@section('title', 'Kategori')

@section('breadcrumbs')
    <span>Master</span>
    <span class="material-symbols-outlined text-base mx-1">chevron_right</span>
    <span class="font-medium text-gray-900 dark:text-white">Kategori</span>
@endsection

@section('header-actions')
    <a href="{{ route('admin.categories.create') }}" class="flex items-center justify-center gap-2 px-4 h-10 rounded-lg text-sm font-bold text-white bg-primary hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-200">
        <span class="material-symbols-outlined text-xl">add</span>
        <span class="hidden sm:inline">Tambah Kategori</span>
    </a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto flex flex-col gap-6">
    <!-- Page Heading -->
    <div class="flex flex-col gap-1">
        <h2 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white">Kategori Buku</h2>
        <p class="text-gray-500 dark:text-gray-400">Kelola kategori untuk mengorganisir buku.</p>
    </div>

    <!-- Categories Table -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Icon</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jumlah Buku</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($category->color)
                                        <div class="w-3 h-3 rounded-full" style="background-color: {{ $category->color }}"></div>
                                    @endif
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $category->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                @if ($category->icon)
                                    <span class="material-symbols-outlined">{{ $category->icon }}</span>
                                @else
                                    <span class="text-sm">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                    {{ $category->books_count }} buku
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="p-2 rounded-lg text-gray-400 hover:text-amber-500 hover:bg-amber-500/10 transition-colors" title="Edit">
                                        <span class="material-symbols-outlined text-xl">edit</span>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
                            <td colspan="4" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-4">
                                        <span class="material-symbols-outlined text-3xl text-gray-400">category</span>
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400 mb-4">Belum ada kategori.</p>
                                    <a href="{{ route('admin.categories.create') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-white bg-primary hover:bg-blue-700 transition-colors">
                                        <span class="material-symbols-outlined text-xl">add</span>
                                        Tambah Kategori
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($categories->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
