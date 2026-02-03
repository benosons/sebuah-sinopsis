@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumbs')
    <span>Admin</span>
    <span class="material-symbols-outlined text-base mx-1">chevron_right</span>
    <span class="font-medium text-gray-900 dark:text-white">Overview</span>
@endsection

@section('header-actions')
    <button class="flex items-center gap-2 px-4 h-9 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
        <span class="material-symbols-outlined text-[18px]">calendar_today</span>
        <span>Last 30 Days</span>
    </button>
    <button class="flex items-center justify-center h-9 w-9 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-500 hover:text-primary transition-colors">
        <span class="material-symbols-outlined text-[20px]">notifications</span>
    </button>
@endsection

@section('content')
<div class="max-w-7xl mx-auto flex flex-col gap-6">
    <!-- Page Heading -->
    <div class="flex flex-col gap-1 mb-2">
        <h2 class="text-2xl font-black tracking-tight text-gray-900 dark:text-white">Dashboard Overview</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Welcome back, here's what's happening with your content today.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <!-- Total Books -->
        <div class="bg-surface-light dark:bg-surface-dark p-5 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 flex flex-col justify-between h-32 hover:border-primary/50 transition-colors group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Books</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($totalBooks) }}</h3>
                </div>
                <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg text-blue-600 dark:text-blue-400 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/40 transition-colors">
                    <span class="material-symbols-outlined">menu_book</span>
                </div>
            </div>
            <div class="flex items-center gap-1 text-xs font-medium text-green-600 dark:text-green-400">
                <span class="material-symbols-outlined text-[14px]">trending_up</span>
                <span>+{{ $newBooksThisWeek }} new this week</span>
            </div>
        </div>

        <!-- Total Comments -->
        <div class="bg-surface-light dark:bg-surface-dark p-5 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 flex flex-col justify-between h-32 hover:border-primary/50 transition-colors group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Comments</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($totalComments) }}</h3>
                </div>
                <div class="p-2 bg-purple-50 dark:bg-purple-900/20 rounded-lg text-purple-600 dark:text-purple-400 group-hover:bg-purple-100 dark:group-hover:bg-purple-900/40 transition-colors">
                    <span class="material-symbols-outlined">chat</span>
                </div>
            </div>
            <div class="flex items-center gap-1 text-xs font-medium text-green-600 dark:text-green-400">
                <span class="material-symbols-outlined text-[14px]">trending_up</span>
                <span>+{{ $newCommentsThisWeek }} new this week</span>
            </div>
        </div>

        <!-- Page Views -->
        <div class="bg-surface-light dark:bg-surface-dark p-5 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 flex flex-col justify-between h-32 hover:border-primary/50 transition-colors group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Page Views</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($pageViewsThisMonth) }}</h3>
                </div>
                <div class="p-2 bg-green-50 dark:bg-green-900/20 rounded-lg text-green-600 dark:text-green-400 group-hover:bg-green-100 dark:group-hover:bg-green-900/40 transition-colors">
                    <span class="material-symbols-outlined">visibility</span>
                </div>
            </div>
            <div class="flex items-center gap-1 text-xs font-medium text-green-600 dark:text-green-400">
                <span class="material-symbols-outlined text-[14px]">trending_up</span>
                <span>{{ $pageViewsToday }} views today</span>
            </div>
        </div>

        <!-- Visitors -->
        <div class="bg-surface-light dark:bg-surface-dark p-5 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 flex flex-col justify-between h-32 hover:border-primary/50 transition-colors group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Visitors</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($visitorsThisMonth) }}</h3>
                </div>
                <div class="p-2 bg-orange-50 dark:bg-orange-900/20 rounded-lg text-orange-600 dark:text-orange-400 group-hover:bg-orange-100 dark:group-hover:bg-orange-900/40 transition-colors">
                    <span class="material-symbols-outlined">person</span>
                </div>
            </div>
            <div class="flex items-center gap-1 text-xs font-medium text-gray-500 dark:text-gray-400">
                <span class="material-symbols-outlined text-[14px]">groups</span>
                <span>{{ $totalVisitors }} total visitors</span>
            </div>
        </div>
    </div>

    <!-- Charts & Activities Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Traffic Performance Chart -->
        <div class="lg:col-span-2 bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Traffic Performance</h3>
                <select class="text-xs border-none bg-gray-100 dark:bg-gray-800 rounded px-2 py-1 text-gray-600 dark:text-gray-300 focus:ring-0 cursor-pointer">
                    <option>Unique Visitors</option>
                    <option>Page Views</option>
                    <option>CTR</option>
                </select>
            </div>
            <div class="relative h-64 w-full">
                <!-- Chart Grid Lines -->
                <div class="absolute inset-0 flex flex-col justify-between text-xs text-gray-400 dark:text-gray-600">
                    <div class="border-b border-gray-100 dark:border-gray-800 w-full h-0"></div>
                    <div class="border-b border-gray-100 dark:border-gray-800 w-full h-0"></div>
                    <div class="border-b border-gray-100 dark:border-gray-800 w-full h-0"></div>
                    <div class="border-b border-gray-100 dark:border-gray-800 w-full h-0"></div>
                    <div class="border-b border-gray-100 dark:border-gray-800 w-full h-0"></div>
                </div>
                <!-- SVG Chart -->
                <svg class="absolute inset-0 h-full w-full" preserveAspectRatio="none" viewBox="0 0 100 50">
                    <defs>
                        <linearGradient id="chartGradient" x1="0" x2="0" y1="0" y2="1">
                            <stop offset="0%" stop-color="#0d59f2" stop-opacity="0.3"></stop>
                            <stop offset="100%" stop-color="#0d59f2" stop-opacity="0"></stop>
                        </linearGradient>
                    </defs>
                    <path d="M0,50 L0,35 Q10,25 20,30 T40,20 T60,25 T80,10 T100,15 L100,50 Z" fill="url(#chartGradient)" stroke="none"></path>
                    <path d="M0,35 Q10,25 20,30 T40,20 T60,25 T80,10 T100,15" fill="none" stroke="#0d59f2" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8"></path>
                </svg>
                <!-- Tooltip -->
                <div class="absolute top-[20%] left-[80%] -translate-x-1/2 -translate-y-full mb-2">
                    <div class="bg-gray-900 text-white text-[10px] py-1 px-2 rounded shadow-lg whitespace-nowrap">
                        2,405 Views
                    </div>
                    <div class="w-2 h-2 bg-primary rounded-full border-2 border-white mx-auto mt-1"></div>
                </div>
            </div>
            <div class="flex justify-between text-xs text-gray-400 mt-2 px-1">
                <span>Mon</span>
                <span>Tue</span>
                <span>Wed</span>
                <span>Thu</span>
                <span>Fri</span>
                <span>Sat</span>
                <span>Sun</span>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6 flex flex-col">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-5">Recent Activities</h3>
            <div class="flex flex-col gap-6 overflow-y-auto max-h-[320px] pr-2">
                @forelse($recentActivities as $activity)
                    <div class="flex gap-3">
                        @if($activity['type'] === 'book')
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined text-sm">post_add</span>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-sm text-gray-800 dark:text-gray-200">
                                    New book added: <span class="font-medium">"{{ Str::limit($activity['title'], 25) }}"</span>
                                </p>
                                <span class="text-xs text-gray-400 mt-0.5">{{ $activity['time'] }}</span>
                            </div>
                        @elseif($activity['type'] === 'comment')
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600">
                                <span class="material-symbols-outlined text-sm">comment</span>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-sm text-gray-800 dark:text-gray-200">
                                    <span class="font-medium">{{ $activity['user'] }}</span> commented on <span class="italic">"{{ Str::limit($activity['book'], 20) }}"</span>
                                </p>
                                <span class="text-xs text-gray-400 mt-0.5">{{ $activity['time'] }}</span>
                            </div>
                        @elseif($activity['type'] === 'user')
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600">
                                <span class="material-symbols-outlined text-sm">person_add</span>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-sm text-gray-800 dark:text-gray-200">
                                    New user registered: <span class="font-medium">{{ $activity['name'] }}</span>
                                </p>
                                <span class="text-xs text-gray-400 mt-0.5">{{ $activity['time'] }}</span>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-400">
                        <span class="material-symbols-outlined text-3xl mb-2">inbox</span>
                        <p class="text-sm">No recent activities</p>
                    </div>
                @endforelse
            </div>
            <a href="#" class="mt-auto pt-4 text-center text-sm font-medium text-primary hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors w-full border-t border-gray-100 dark:border-gray-800">
                View All Activity
            </a>
        </div>
    </div>

    <!-- Top Performing Books -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Top Performing Books</h3>
            <a href="{{ route('admin.books.index') }}" class="text-sm text-primary hover:underline font-medium">View All Books</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700">
                        <th class="py-3 px-4 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Book Title</th>
                        <th class="py-3 px-4 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Author</th>
                        <th class="py-3 px-4 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 hidden md:table-cell">Category</th>
                        <th class="py-3 px-4 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 text-right hidden sm:table-cell">Comments</th>
                        <th class="py-3 px-4 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-50 dark:divide-gray-800">
                    @forelse($topBooks as $book)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    @if($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="h-10 w-8 object-cover rounded shadow-sm flex-shrink-0">
                                    @else
                                        <div class="h-10 w-8 bg-gray-200 dark:bg-gray-700 rounded shadow-sm flex-shrink-0 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-gray-400 text-sm">menu_book</span>
                                        </div>
                                    @endif
                                    <span class="font-medium text-gray-900 dark:text-white">{{ Str::limit($book->title, 30) }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-gray-600 dark:text-gray-300">{{ $book->author }}</td>
                            <td class="py-3 px-4 text-gray-600 dark:text-gray-300 hidden md:table-cell">{{ $book->category->name ?? '-' }}</td>
                            <td class="py-3 px-4 text-right font-medium text-gray-900 dark:text-white hidden sm:table-cell">{{ $book->comments_count }}</td>
                            <td class="py-3 px-4 text-center">
                                @if($book->is_featured)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        Featured
                                    </span>
                                @elseif($book->is_published)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                        Draft
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-400">
                                <span class="material-symbols-outlined text-3xl mb-2">library_books</span>
                                <p class="text-sm">No books yet</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Visitor Analytics Panel -->
    <div class="mt-6">
        <div class="flex items-center gap-2 mb-4">
            <span class="material-symbols-outlined text-primary text-2xl">analytics</span>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Visitor Analytics</h3>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Visitors by Country -->
            <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white">Visitors by Country</h4>
                    <span class="material-symbols-outlined text-gray-400">public</span>
                </div>
                @if(count($countryBreakdown) > 0)
                    <div class="space-y-3">
                        @php $maxCount = max(array_column($countryBreakdown, 'count')); @endphp
                        @foreach($countryBreakdown as $country)
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center text-xs font-bold text-primary">
                                    {{ strtoupper(substr($country['country'], 0, 2)) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $country['country'] }}</span>
                                        <span class="text-xs text-gray-500">{{ $country['count'] }}</span>
                                    </div>
                                    <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-1.5">
                                        <div class="bg-primary h-1.5 rounded-full" style="width: {{ ($country['count'] / $maxCount) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-400">
                        <span class="material-symbols-outlined text-3xl mb-2">language</span>
                        <p class="text-sm">No country data yet</p>
                    </div>
                @endif
            </div>

            <!-- Top Clicked Books -->
            <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white">Most Viewed Books</h4>
                    <span class="material-symbols-outlined text-gray-400">local_fire_department</span>
                </div>
                @if(count($topClickedBooks) > 0)
                    <div class="space-y-3">
                        @foreach($topClickedBooks as $index => $book)
                            <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold 
                                    {{ $index === 0 ? 'bg-yellow-100 text-yellow-700' : ($index === 1 ? 'bg-gray-100 text-gray-600' : ($index === 2 ? 'bg-orange-100 text-orange-700' : 'bg-gray-50 text-gray-500')) }}">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $book['title'] }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $book['author'] }}</p>
                                </div>
                                <div class="flex items-center gap-1 text-xs text-gray-500">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                    <span>{{ number_format($book['views_count']) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-400">
                        <span class="material-symbols-outlined text-3xl mb-2">menu_book</span>
                        <p class="text-sm">No view data yet</p>
                    </div>
                @endif
            </div>

            <!-- Device & Browser Stats -->
            <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white">Device & Browser</h4>
                    <span class="material-symbols-outlined text-gray-400">devices</span>
                </div>
                
                <!-- Device Breakdown -->
                <div class="mb-6">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Devices</p>
                    @if(count($deviceBreakdown) > 0)
                        <div class="flex gap-2 flex-wrap">
                            @foreach($deviceBreakdown as $device => $count)
                                <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-50 dark:bg-gray-800 rounded-full">
                                    <span class="material-symbols-outlined text-sm text-gray-500">
                                        {{ $device === 'desktop' ? 'computer' : ($device === 'mobile' ? 'smartphone' : 'tablet') }}
                                    </span>
                                    <span class="text-xs font-medium text-gray-700 dark:text-gray-300 capitalize">{{ $device }}</span>
                                    <span class="text-xs text-primary font-bold">{{ $count }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-gray-400">No device data</p>
                    @endif
                </div>

                <!-- Browser Breakdown -->
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Browsers</p>
                    @if(count($browserBreakdown) > 0)
                        <div class="space-y-2">
                            @foreach($browserBreakdown as $browser => $count)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $browser }}</span>
                                    <span class="text-xs font-bold text-primary">{{ $count }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-gray-400">No browser data</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Visitors Table -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6 mt-6">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-bold text-gray-900 dark:text-white">Recent Visitors</h4>
                <span class="text-xs text-gray-500">Last 8 visitors</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-700">
                            <th class="py-2 px-3 text-xs font-semibold uppercase tracking-wide text-gray-500">IP</th>
                            <th class="py-2 px-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Country</th>
                            <th class="py-2 px-3 text-xs font-semibold uppercase tracking-wide text-gray-500 hidden sm:table-cell">Device</th>
                            <th class="py-2 px-3 text-xs font-semibold uppercase tracking-wide text-gray-500 hidden md:table-cell">Browser</th>
                            <th class="py-2 px-3 text-xs font-semibold uppercase tracking-wide text-gray-500 hidden lg:table-cell">OS</th>
                            <th class="py-2 px-3 text-xs font-semibold uppercase tracking-wide text-gray-500 text-right">Time</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-50 dark:divide-gray-800">
                        @forelse($recentVisitors as $visitor)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                <td class="py-2 px-3 font-mono text-xs text-gray-600 dark:text-gray-400">{{ $visitor['ip'] }}</td>
                                <td class="py-2 px-3">
                                    <span class="inline-flex items-center gap-1">
                                        <span class="w-5 h-5 rounded bg-primary/10 flex items-center justify-center text-[10px] font-bold text-primary">
                                            {{ strtoupper(substr($visitor['country'] ?? 'UN', 0, 2)) }}
                                        </span>
                                        <span class="text-gray-700 dark:text-gray-300">{{ $visitor['country'] ?? 'Unknown' }}</span>
                                    </span>
                                </td>
                                <td class="py-2 px-3 hidden sm:table-cell">
                                    <span class="inline-flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                        <span class="material-symbols-outlined text-sm">
                                            {{ $visitor['device'] === 'desktop' ? 'computer' : ($visitor['device'] === 'mobile' ? 'smartphone' : 'tablet') }}
                                        </span>
                                        <span class="capitalize">{{ $visitor['device'] }}</span>
                                    </span>
                                </td>
                                <td class="py-2 px-3 text-gray-600 dark:text-gray-400 hidden md:table-cell">{{ $visitor['browser'] }}</td>
                                <td class="py-2 px-3 text-gray-600 dark:text-gray-400 hidden lg:table-cell">{{ $visitor['os'] }}</td>
                                <td class="py-2 px-3 text-right text-gray-500 text-xs">{{ $visitor['time'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400">
                                    <span class="material-symbols-outlined text-3xl mb-2">person_off</span>
                                    <p class="text-sm">No visitors yet</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
