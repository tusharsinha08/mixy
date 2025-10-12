<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\HomeSettingsController;
use App\Http\Controllers\Admin\HomeBestSellerController;
use App\Models\HomeSetting;


Route::get('/', function () {
    $settings = HomeSetting::first() ?? new HomeSetting();

    return Inertia::render('Home', [
        'settings' => $settings,
    ]);
})->name('home');

/*
|--------------------------------------------------------------------------
| Authenticated Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // 🧭 Admin Dashboard
    Route::get('/admin-dashboard', fn() =>
        Inertia::render('AdminPanel/AdminDashboard')
    )->name('admin-dashboard');

    // 🧑‍💼 Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Admin Panel
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {

        // ✅ Home Settings (edit + update)
        Route::get('/home-settings', [HomeSettingsController::class, 'edit'])
            ->name('home-settings.edit');
        Route::post('/home-settings/update', [HomeSettingsController::class, 'update'])
            ->name('home-settings.update');

        // ✅ Home Best Sellers (resource)
        Route::resource('home-best-sellers', HomeBestSellerController::class)->except(['show']);

        // Optional: endpoint to fetch best sellers separately
        Route::get('/home-settings/best-sellers', [HomeSettingsController::class, 'getBestSellers']);
    });
});

require __DIR__ . '/auth.php';
