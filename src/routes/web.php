<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;

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
    return view('welcome');
});

Route::get('/', [ContactController::class, 'index'])->name('contact.index');

Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');

Route::post('/thanks', [ContactController::class, 'store'])->name('contact.store');

Route::get('/thanks', function () {
    return view('thanks');
});

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');

Route::get('/admin/{id}', [AdminController::class, 'show'])->name('admin.show');

Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

Route::get('/admin/export', [AdominController::class, 'export'])->name('admin.export');

Route::middleware(['auth'])->group(function() {
    Route::get('/admin', [AdminController::class, 'index']);
});