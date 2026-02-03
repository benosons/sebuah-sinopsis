@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('breadcrumbs')
    <span>Master</span>
    <span class="material-symbols-outlined text-base mx-1">chevron_right</span>
    <a href="{{ route('admin.categories.index') }}" class="hover:text-primary">Kategori</a>
    <span class="material-symbols-outlined text-base mx-1">chevron_right</span>
    <span class="font-medium text-gray-900 dark:text-white">Tambah</span>
@endsection

@section('header-actions')
    <button type="button" onclick="document.getElementById('category-form').submit()" class="flex items-center justify-center px-6 h-10 rounded-lg text-sm font-bold text-white bg-primary hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-200">
        Simpan
    </button>
@endsection

@section('content')
<form id="category-form" method="POST" action="{{ route('admin.categories.store') }}">
    @csrf
    <div class="max-w-2xl mx-auto flex flex-col gap-6">
        <!-- Page Heading -->
        <div class="flex flex-col gap-1">
            <h2 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white">Tambah Kategori</h2>
            <p class="text-gray-500 dark:text-gray-400">Buat kategori baru untuk mengorganisir buku.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
            <div class="flex flex-col gap-5">
                <label class="flex flex-col w-full">
                    <p class="text-gray-900 dark:text-gray-200 text-sm font-medium mb-2">Nama Kategori <span class="text-red-500">*</span></p>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-input w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors" placeholder="Contoh: Fiksi, Non-Fiksi, Biografi" required/>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </label>

                <div class="flex flex-col md:flex-row gap-5">
                    <label class="flex flex-col flex-1">
                        <p class="text-gray-900 dark:text-gray-200 text-sm font-medium mb-2">Icon (Material Symbols)</p>
                        <input type="text" name="icon" value="{{ old('icon') }}" class="form-input w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors" placeholder="book, auto_stories, psychology"/>
                        <p class="text-xs text-gray-500 mt-1">
                            <a href="https://fonts.google.com/icons" target="_blank" class="text-primary hover:underline">Lihat daftar icon →</a>
                        </p>
                    </label>

                    <label class="flex flex-col flex-1">
                        <p class="text-gray-900 dark:text-gray-200 text-sm font-medium mb-2">Warna</p>
                        <div class="flex gap-2">
                            <input type="color" name="color" value="{{ old('color', '#0d59f2') }}" class="w-12 h-12 rounded-lg border border-gray-300 dark:border-gray-700 cursor-pointer"/>
                            <input type="text" id="color-text" value="{{ old('color', '#0d59f2') }}" class="form-input flex-1 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors" placeholder="#0d59f2" readonly/>
                        </div>
                    </label>
                </div>

                <!-- Preview -->
                <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Preview:</p>
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gray-100 dark:bg-gray-800">
                        <span id="preview-icon" class="material-symbols-outlined text-lg" style="color: #0d59f2">category</span>
                        <span id="preview-name" class="text-sm font-medium text-gray-700 dark:text-gray-300">Nama Kategori</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    const nameInput = document.querySelector('input[name="name"]');
    const iconInput = document.querySelector('input[name="icon"]');
    const colorInput = document.querySelector('input[name="color"]');
    const colorText = document.getElementById('color-text');
    const previewIcon = document.getElementById('preview-icon');
    const previewName = document.getElementById('preview-name');

    nameInput.addEventListener('input', () => {
        previewName.textContent = nameInput.value || 'Nama Kategori';
    });

    iconInput.addEventListener('input', () => {
        previewIcon.textContent = iconInput.value || 'category';
    });

    colorInput.addEventListener('input', () => {
        previewIcon.style.color = colorInput.value;
        colorText.value = colorInput.value;
    });
</script>
@endpush
