<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'isbn' => 'nullable|string|max:20',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'synopsis' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'affiliate_links' => 'nullable|array',
            'affiliate_links.*.name' => 'required_with:affiliate_links|string|max:255',
            'affiliate_links.*.url' => 'required_with:affiliate_links|url',
            'is_published' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'allow_comments' => 'nullable|boolean',
        ]);

        $data = $request->only('title', 'category_id', 'isbn', 'author', 'publisher', 'synopsis', 'affiliate_links');
        $data['slug'] = Str::slug($request->title);
        $data['is_published'] = $request->boolean('is_published', true);
        $data['is_featured'] = $request->boolean('is_featured', false);
        $data['allow_comments'] = $request->boolean('allow_comments', true);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('books/covers', 'public');
            $data['cover_image'] = $path;
        }

        Book::create($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'isbn' => 'nullable|string|max:20',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'synopsis' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'affiliate_links' => 'nullable|array',
            'affiliate_links.*.name' => 'required_with:affiliate_links|string|max:255',
            'affiliate_links.*.url' => 'required_with:affiliate_links|url',
            'is_published' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'allow_comments' => 'nullable|boolean',
        ]);

        $data = $request->only('title', 'category_id', 'isbn', 'author', 'publisher', 'synopsis', 'affiliate_links');
        $data['is_published'] = $request->boolean('is_published', true);
        $data['is_featured'] = $request->boolean('is_featured', false);
        $data['allow_comments'] = $request->boolean('allow_comments', true);
        
        // Update slug if title changed
        if ($book->title !== $request->title) {
            $data['slug'] = Str::slug($request->title);
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $path = $request->file('cover_image')->store('books/covers', 'public');
            $data['cover_image'] = $path;
        }

        $book->update($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        // Delete cover image if exists
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}
