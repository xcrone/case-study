<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Guest
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

require __DIR__.'/auth.php';

// Auth
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Home
    Route::prefix('home')->controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('home.index');
    });

    // Profile
    Route::prefix('profile')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'edit')->name('profile.edit');
        Route::patch('/', 'update')->name('profile.update');
        Route::delete('/', 'destroy')->name('profile.destroy');
    });

    // Cart
    Route::prefix('cart')->controller(CartController::class)->group(function () {
        Route::get('/show', 'show')->name('cart.show');
        Route::post('/add', 'add')->name('cart.add');
        Route::post('/remove', 'remove')->name('cart.remove');
    });

    // Order
    Route::prefix('order')->controller(OrderController::class)->group(function () {
        Route::get('/', 'index')->name('order.index');
        Route::post('/create', 'create')->name('order.create');
    });

    // Activity
    Route::prefix('activity')->controller(ActivityController::class)->group(function () {
        Route::get('/', 'index')->name('activity.index');
    });
});
