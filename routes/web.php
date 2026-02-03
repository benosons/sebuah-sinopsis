<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('books.index');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

require __DIR__.'/auth.php';

Route::group(['middleware' => ['auth', 'role:Super-Admin']], function () {
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::resource('roles', App\Http\Controllers\Admin\RoleController::class);
    Route::resource('permissions', App\Http\Controllers\Admin\PermissionController::class)->only(['index', 'store', 'destroy']);
    
    // Maintenance Mode Toggle
    Route::post('/admin/toggle-maintenance', [App\Http\Controllers\Admin\SettingController::class, 'toggleMaintenance'])->name('admin.toggle-maintenance');
    Route::get('/admin/maintenance-status', [App\Http\Controllers\Admin\SettingController::class, 'getMaintenanceStatus'])->name('admin.maintenance-status');
});

// Admin Books Routes
Route::group(['middleware' => ['auth', 'role:Super-Admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::resource('books', App\Http\Controllers\Admin\BookController::class);
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
    
    // Site Settings
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
});

// Public Routes (with maintenance mode check and visitor tracking)
Route::middleware([
    \App\Http\Middleware\CheckMaintenanceMode::class,
    \App\Http\Middleware\TrackVisitor::class,
])->group(function () {
    Route::get('/books', [App\Http\Controllers\BookController::class, 'index'])->name('books.index');
    Route::get('/books/{book}', [App\Http\Controllers\BookController::class, 'show'])->name('books.show');
});

// Comment Routes
Route::post('/books/{book}/comments', [App\Http\Controllers\CommentController::class, 'store'])
    ->middleware('auth')
    ->name('comments.store');

