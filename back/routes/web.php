<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SaleController;
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

    // view page routes
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/termsOfService', function () {
        return Inertia::render('TermsOfService');
    })->name('termsOfService');
    Route::get('/privacyPolicy', function () {
        return Inertia::render('PrivacyPolicy');
    })->name('privacyPolicy');

//    PRODUCTS
    Route::get('/products',
        [ProductController::class, 'index']
    )->name('products');

//    SUPPLIERS
    Route::get('/suppliers',
        [SupplierController::class, 'index']
    )->name('suppliers');

//    SALES
    Route::get('/sales',
        [SaleController::class, 'index']
    )->name('sales');

    // export json/xml/pdf fdeile routes >>> PRODUCTS
    Route::post('/exportToJson',
        [ProductController::class, 'exportToJson']
    )->name('exportToJson');
    Route::post('/exportToXml',
        [ProductController::class, 'exportToXml']
    )->name('exportToXml');
    Route::post('/exportToPdf',
        [ProductController::class, 'exportToPdf']
    )->name('exportToPdf');

    // excel file routes >>> PRODUCTS
    Route::get('file-import-export',
        [ProductController::class, 'fileImportExport']);
    Route::post('file-import',
        [ProductController::class, 'fileImport'])
        ->name('file-import');
    Route::get('file-export',
        [ProductController::class, 'fileExport'])
        ->name('file-export');

});

