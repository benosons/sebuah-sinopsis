@extends('layouts.admin')

@section('title', 'Tambah Buku Baru')

@section('breadcrumbs')
    <span>Books</span>
    <span class="material-symbols-outlined text-base mx-1">chevron_right</span>
    <span class="font-medium text-gray-900 dark:text-white">New Post</span>
@endsection

@section('header-actions')
    <button type="button" onclick="saveDraft()" class="hidden sm:flex items-center justify-center px-4 h-10 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
        Save Draft
    </button>
    <button type="button" onclick="document.getElementById('book-form').submit()" class="flex items-center justify-center px-6 h-10 rounded-lg text-sm font-bold text-white bg-primary hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-200">
        Publish
    </button>
@endsection

@section('content')
<form id="book-form" method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="status" id="status-input" value="published">
    
    <div class="max-w-6xl mx-auto flex flex-col gap-6">
        <!-- Page Heading -->
        <div class="flex flex-col gap-1">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Create New Post</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Fill in the details below to add a new book review.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Main Form Data -->
            <div class="lg:col-span-2 flex flex-col gap-6">
                <!-- Card: Book Details -->
                <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-xl">menu_book</span>
                        Book Details
                    </h3>
                    <div class="flex flex-col gap-4">
                        <!-- Book Title -->
                        <label class="flex flex-col w-full">
                            <p class="text-gray-700 dark:text-gray-300 text-sm font-medium mb-1.5">Book Title <span class="text-red-500">*</span></p>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-input w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white h-11 px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm" placeholder="Enter the full title of the book" required/>
                        </label>
                        
                        <!-- Author & Publisher -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="flex flex-col">
                                <p class="text-gray-700 dark:text-gray-300 text-sm font-medium mb-1.5">Author</p>
                                <input type="text" name="author" value="{{ old('author') }}" class="form-input w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white h-11 px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm" placeholder="Author Name" required/>
                            </label>
                            <label class="flex flex-col">
                                <p class="text-gray-700 dark:text-gray-300 text-sm font-medium mb-1.5">Publisher</p>
                                <input type="text" name="publisher" value="{{ old('publisher') }}" class="form-input w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white h-11 px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm" placeholder="Publisher Name"/>
                            </label>
                        </div>
                        
                        <!-- ISBN & Category -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="flex flex-col">
                                <p class="text-gray-700 dark:text-gray-300 text-sm font-medium mb-1.5">ISBN-13</p>
                                <input type="text" name="isbn" value="{{ old('isbn') }}" class="form-input w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white h-11 px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm" placeholder="e.g. 978-3-16-148410-0"/>
                            </label>
                            <label class="flex flex-col">
                                <p class="text-gray-700 dark:text-gray-300 text-sm font-medium mb-1.5">Category</p>
                                <div class="relative">
                                    <select name="category_id" class="form-select w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white h-11 px-4 pr-10 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors appearance-none text-sm">
                                        <option value="">Select Genre</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                                        <span class="material-symbols-outlined text-xl">expand_more</span>
                                    </span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Card: Synopsis -->
                <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6 flex flex-col flex-1">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-xl">description</span>
                        Synopsis
                    </h3>
                    <div class="flex flex-col rounded-lg border border-gray-300 dark:border-gray-700 overflow-hidden focus-within:ring-2 focus-within:ring-primary/20 focus-within:border-primary transition-all flex-1">
                        <!-- Toolbar -->
                        <div class="bg-gray-50 dark:bg-gray-800 border-b border-gray-300 dark:border-gray-700 px-3 py-2 flex items-center gap-1">
                            <button type="button" class="w-8 h-8 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 flex items-center justify-center" title="Bold">
                                <span class="material-symbols-outlined text-lg">format_bold</span>
                            </button>
                            <button type="button" class="w-8 h-8 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 flex items-center justify-center" title="Italic">
                                <span class="material-symbols-outlined text-lg">format_italic</span>
                            </button>
                            <button type="button" class="w-8 h-8 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 flex items-center justify-center" title="Underline">
                                <span class="material-symbols-outlined text-lg">format_underlined</span>
                            </button>
                            <div class="w-px h-5 bg-gray-300 dark:bg-gray-600 mx-1"></div>
                            <button type="button" class="w-8 h-8 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 flex items-center justify-center" title="Bulleted List">
                                <span class="material-symbols-outlined text-lg">format_list_bulleted</span>
                            </button>
                            <button type="button" class="w-8 h-8 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 flex items-center justify-center" title="Insert Link">
                                <span class="material-symbols-outlined text-lg">link</span>
                            </button>
                        </div>
                        <!-- Editor Area -->
                        <textarea name="synopsis" class="w-full min-h-[280px] p-4 bg-white dark:bg-gray-900 text-gray-900 dark:text-white border-none focus:ring-0 resize-y text-sm leading-relaxed" placeholder="Write the book synopsis and review here..." required>{{ old('synopsis') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Right Column: Media & Settings -->
            <div class="flex flex-col gap-6">
                <!-- Card: Cover Image -->
                <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-xl">image</span>
                        Book Cover
                    </h3>
                    <label for="cover_image" class="block">
                        <div id="cover-preview" class="w-full aspect-[3/4] border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg flex flex-col items-center justify-center p-6 text-center hover:border-primary hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all cursor-pointer group">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mb-3 group-hover:bg-primary/20 transition-colors">
                                <span class="material-symbols-outlined text-primary text-2xl">cloud_upload</span>
                            </div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Click to upload</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">or drag and drop here</p>
                            <p class="text-[10px] text-gray-400 mt-4 uppercase tracking-wide">SVG, PNG, JPG (MAX 2MB)</p>
                        </div>
                        <input type="file" id="cover_image" name="cover_image" class="hidden" accept="image/*" onchange="previewImage(this)">
                    </label>
                </div>

                <!-- Card: Affiliate Links -->
                <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-xl">shopping_cart</span>
                        Affiliate Links
                    </h3>
                    <div class="flex flex-col gap-4">
                        <!-- Add New Link -->
                        <div class="flex flex-col gap-2">
                            <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Add New Link</label>
                            <input type="text" id="new-marketplace" class="form-input w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white h-10 px-3 focus:ring-1 focus:ring-primary focus:border-primary" placeholder="Marketplace (e.g. Amazon)"/>
                            <div class="flex gap-2">
                                <input type="url" id="new-url" class="form-input flex-1 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white h-10 px-3 focus:ring-1 focus:ring-primary focus:border-primary" placeholder="https://..."/>
                                <button type="button" onclick="addAffiliateLink()" class="h-10 w-10 rounded-lg bg-primary text-white flex items-center justify-center hover:bg-blue-600 transition-colors flex-shrink-0">
                                    <span class="material-symbols-outlined">add</span>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Added Links -->
                        <div id="affiliate-container" class="flex flex-col gap-2">
                            <!-- Affiliate link items will be added here -->
                        </div>
                    </div>
                </div>

                <!-- Card: Publish Settings -->
                <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-xl">visibility</span>
                        Publish Settings
                    </h3>
                    <div class="flex flex-col gap-4">
                        <!-- Status -->
                        <label class="flex flex-col">
                            <p class="text-gray-700 dark:text-gray-300 text-sm font-medium mb-1.5">Status</p>
                            <div class="relative">
                                <select name="is_published" class="form-select w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white h-10 px-3 pr-10 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors appearance-none text-sm">
                                    <option value="1" selected>Published</option>
                                    <option value="0">Draft</option>
                                </select>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                                    <span class="material-symbols-outlined text-lg">expand_more</span>
                                </span>
                            </div>
                        </label>
                        
                        <!-- Featured -->
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" class="w-5 h-5 rounded border-gray-300 dark:border-gray-600 text-primary focus:ring-primary/20">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Featured Post</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Show on homepage featured section</p>
                            </div>
                        </label>
                        
                        <!-- Allow Comments -->
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="allow_comments" value="1" checked class="w-5 h-5 rounded border-gray-300 dark:border-gray-600 text-primary focus:ring-primary/20">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Allow Comments</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Enable reader discussions</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    let affiliateLinkIndex = 0;

    function previewImage(input) {
        const preview = document.getElementById('cover-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover rounded-lg">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function addAffiliateLink() {
        const marketplace = document.getElementById('new-marketplace').value;
        const url = document.getElementById('new-url').value;
        
        if (!marketplace || !url) {
            alert('Please fill in both marketplace name and URL');
            return;
        }

        const container = document.getElementById('affiliate-container');
        const div = document.createElement('div');
        div.className = 'flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700';
        div.innerHTML = `
            <input type="hidden" name="affiliate_links[${affiliateLinkIndex}][name]" value="${marketplace}">
            <input type="hidden" name="affiliate_links[${affiliateLinkIndex}][url]" value="${url}">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white dark:bg-gray-700 flex items-center justify-center shadow-sm border border-gray-100 dark:border-gray-600">
                    <span class="text-[10px] font-bold text-primary">${marketplace.substring(0, 3).toUpperCase()}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-900 dark:text-white">${marketplace}</span>
                    <span class="text-xs text-gray-500 truncate max-w-[140px]">${url}</span>
                </div>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-gray-400 hover:text-red-500 transition-colors p-1">
                <span class="material-symbols-outlined text-lg">delete</span>
            </button>
        `;
        container.appendChild(div);
        
        // Clear inputs
        document.getElementById('new-marketplace').value = '';
        document.getElementById('new-url').value = '';
        affiliateLinkIndex++;
    }

    function saveDraft() {
        document.getElementById('status-input').value = 'draft';
        document.getElementById('book-form').submit();
    }
</script>
@endpush
