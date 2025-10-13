<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Home'); 
})->name('home');


Route::get('/welcome', function () {
    return Inertia::render('welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/admin-dashboard', function () {
    return Inertia::render('AdminPanel/AdminDashboard');
})->middleware(['auth', 'verified'])->name('admin-dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/shop', function () {
    return Inertia::render('Shop');
})->name('shop');


Route::get('/aboutus', function () {
    return Inertia::render('AboutUs');
})->name('aboutus');

Route::get('/contactus', function () {
    return Inertia::render('ContactUs');
})->name('contactus');

Route::get('/error404', function () {
    return Inertia::render('Error404');
})->name('error404');

// Route::get('/{any}', function () {
//     return Inertia::render('Error404');
// })->where('any', '.*');


require __DIR__.'/auth.php';