<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AvatarController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/user', [HomeController::class, 'user'])->name('user');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Department
    Route::resource('/dashboard/department', DepartmentController::class);

       // หน้าแสดงฟอร์มอัปโหลด avatar
    Route::get('/avatar/upload', [AvatarController::class, 'create'])
       ->name('avatar.create');
    Route::post('/avatar', [AvatarController::class, 'store'])
    ->name('avatar.store');
    Route::delete('/avatar', [AvatarController::class, 'destroy'])
         ->name('avatar.destroy');

});

require __DIR__.'/auth.php';