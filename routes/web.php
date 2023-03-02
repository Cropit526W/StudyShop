<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use \App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(['middleware' => ['setLocale']], function () {
    Route::get('/', function () {
        return view('dashboard');
    });

    Route::get('/admin', [AuthController::class, 'login'])->name('admin');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/', [AuthController::class, 'checkChangePass'])->name('change.password');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::get('/', [\App\Http\Controllers\CategoryController::class, 'index'])->name('welcome');

    Route::get('/admin/index', [AdminController::class, 'index'])->name('admins.index');

    Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admins.destroy');

    Route::get('/admin/edit/{admin}', [AdminController::class, 'edit'])->name('admins.edit');

    Route::put('/admins/{admin}', [AdminController::class, 'update'])->name('admins.update');

    Route::get('/admins/add', [AdminController::class, 'add'])->name('admins.add');

    Route::post('/admins/index', [AdminController::class, 'store'])->name('admins.create');

});
Route::post('/locale', [App\Http\Controllers\LocaleController::class, 'update'])->name('locale.update');

Route::get('/about', function () {
    return view('about');
});

Route::get('/contacts', function () {
    return view('contacts');
});
Route::get('/account', function () {
    return view('account');
});



require __DIR__.'/auth.php';

