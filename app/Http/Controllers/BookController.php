<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Comment;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected AnalyticsService $analytics;

    public function __construct(AnalyticsService $analytics)
    {
        $this->analytics = $analytics;
    }

    /**
     * Display the homepage with the list of books.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Track page view for homepage
        $visitor = $request->attributes->get('visitor');
        if ($visitor) {
            $this->analytics->trackPageView($request, $visitor, null, 'Home - Sebuah Sinopsis');
        }

        $query = Book::where('is_published', true);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('synopsis', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $books = $query->with('category')->latest()->paginate(9)->withQueryString();

        // Categories for filter
        $categories = Category::orderBy('name')->get();

        // Trending books (featured or latest for now)
        $trendingBooks = Book::where('is_published', true)
            ->where('is_featured', true)
            ->latest()
            ->take(3)
            ->get();

        // If no featured books, get latest ones
        if ($trendingBooks->isEmpty()) {
            $trendingBooks = Book::where('is_published', true)
                ->latest()
                ->take(3)
                ->get();
        }

        // Recent comments
        $recentComments = Comment::with(['user', 'book'])
            ->whereHas('book', function ($q) {
                $q->where('is_published', true);
            })
            ->latest()
            ->take(3)
            ->get();

        return view('books.index', compact('books', 'categories', 'trendingBooks', 'recentComments'));
    }

    /**
     * Display the specified book.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Book $book)
    {
        // Track page view for this book
        $visitor = $request->attributes->get('visitor');
        if ($visitor) {
            $this->analytics->trackPageView($request, $visitor, $book, $book->title . ' - Sebuah Sinopsis');
        }

        $book->load(['comments' => function ($query) {
            $query->with('user', 'replies.user')->latest();
        }]);
        
        return view('books.show', compact('book'));
    }
}
