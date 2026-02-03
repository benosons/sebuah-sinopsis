<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Comment;
use App\Models\PageView;
use App\Models\User;
use App\Models\Visitor;
use App\Services\AnalyticsService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected AnalyticsService $analytics;

    public function __construct(AnalyticsService $analytics)
    {
        $this->analytics = $analytics;
    }

    public function index()
    {
        // Stats
        $totalBooks = Book::count();
        $totalComments = Comment::count();
        $totalCategories = Category::count();
        $totalUsers = User::count();
        $publishedBooks = Book::where('is_published', true)->count();
        
        // This week stats
        $startOfWeek = Carbon::now()->startOfWeek();
        $newBooksThisWeek = Book::where('created_at', '>=', $startOfWeek)->count();
        $newCommentsThisWeek = Comment::where('created_at', '>=', $startOfWeek)->count();
        $newUsersThisWeek = User::where('created_at', '>=', $startOfWeek)->count();
        
        // Analytics stats
        $totalVisitors = Visitor::count();
        $visitorsThisMonth = Visitor::thisMonth()->count();
        $pageViewsThisMonth = PageView::thisMonth()->count();
        $pageViewsToday = PageView::today()->count();
        
        // Chart data for traffic performance
        $chartData = $this->analytics->getDailyViewsChart(7);
        
        // Visitor analytics for panel
        $countryBreakdown = $this->analytics->getCountryBreakdown();
        $deviceBreakdown = $this->analytics->getDeviceBreakdown();
        $browserBreakdown = $this->analytics->getBrowserBreakdown();
        $topClickedBooks = $this->analytics->getTopClickedBooks(5);
        $recentVisitors = $this->analytics->getRecentVisitors(8);
        
        // Recent activities (combine books, comments, users)
        $recentActivities = collect();
        
        // Recent books
        $recentBooks = Book::latest()->take(3)->get();
        foreach ($recentBooks as $book) {
            $recentActivities->push([
                'type' => 'book',
                'title' => $book->title,
                'time' => $book->created_at->diffForHumans(),
                'timestamp' => $book->created_at,
            ]);
        }
        
        // Recent comments
        $recentComments = Comment::with(['user', 'book'])->latest()->take(3)->get();
        foreach ($recentComments as $comment) {
            $recentActivities->push([
                'type' => 'comment',
                'user' => $comment->user->name ?? 'Anonymous',
                'book' => $comment->book->title ?? 'Unknown',
                'time' => $comment->created_at->diffForHumans(),
                'timestamp' => $comment->created_at,
            ]);
        }
        
        // Recent users
        $recentUsers = User::latest()->take(2)->get();
        foreach ($recentUsers as $user) {
            $recentActivities->push([
                'type' => 'user',
                'name' => $user->name,
                'time' => $user->created_at->diffForHumans(),
                'timestamp' => $user->created_at,
            ]);
        }
        
        // Sort by timestamp and take top 5
        $recentActivities = $recentActivities->sortByDesc('timestamp')->take(5)->values();
        
        // Top books (by views count)
        $topBooks = Book::withCount('comments')
            ->with('category')
            ->orderByDesc('views_count')
            ->take(5)
            ->get();
        
        return view('dashboard', compact(
            'totalBooks',
            'totalComments',
            'totalCategories',
            'totalUsers',
            'publishedBooks',
            'newBooksThisWeek',
            'newCommentsThisWeek',
            'newUsersThisWeek',
            'totalVisitors',
            'visitorsThisMonth',
            'pageViewsThisMonth',
            'pageViewsToday',
            'chartData',
            'countryBreakdown',
            'deviceBreakdown',
            'browserBreakdown',
            'topClickedBooks',
            'recentVisitors',
            'recentActivities',
            'topBooks'
        ));
    }
}
