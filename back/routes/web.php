<?php

use App\Http\Controllers\ProductController;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

//Route::get('{any?}', function () {
//    return view('index');
//})->where('any', '.*');

//Route::inertia('/about', 'AboutComponent');

//Inertia::share();

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/suppliers', function () {
        return Inertia::render('TermsOfService');
    })->name('suppliers');

    Route::get('/sales', function () {
        return Inertia::render('PrivacyPolicy');
    })->name('sales');

    Route::get('/products',
        [ProductController::class, 'index']
    )->name('products');

    Route::post('/exportToJson',
        [ProductController::class, 'exportToJson']
    )->name('exportToJson');

    Route::post('/exportToXml',
        [ProductController::class, 'exportToXml']
    )->name('exportToXml');

});