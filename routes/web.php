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

Route::get('/shop', function () {
    return Inertia::render('Shop');
})->name('shop');

Route::get('/product-details/{id}', function ($id) {
    // Example static product data (you can replace this with a DB query later)
    $products = [
        1 => [
            'id' => 1,
            'name' => 'Fresh organic kiwi',
            'imagePrimary' => '/assets/images/products/product-image-2-1.jpg',
            'imageSecondary' => '/assets/images/products/product-image-2-2.jpg',
            'priceRange' => '$10.00 - $70.00',
            'rating' => 4,
            'category' => 'Fruits',
            'description' => 'Sweet, tangy, and full of vitamin C. Perfect for a healthy snack.',
        ],
        2 => [
            'id' => 2,
            'name' => 'Dried mango',
            'imagePrimary' => '/assets/images/products/product-image-1-1.jpg',
            'imageSecondary' => '/assets/images/products/product-image-1-2.jpg',
            'priceRange' => '$10.00 - $70.00',
            'rating' => 5,
            'category' => 'Dried Fruits',
            'description' => 'Naturally dried mango slices with no added sugar or preservatives.',
        ],
        3 => [
            'id' => 3,
            'name' => 'Dried banana',
            'imagePrimary' => '/assets/images/products/product-image-3-1.jpg',
            'imageSecondary' => '/assets/images/products/product-image-3-2.jpg',
            'priceRange' => '$60.00 - $80.00',
            'rating' => 4,
            'category' => 'Dried Fruits',
            'description' => 'Crispy and naturally sweet dried banana chips — perfect for snacking.',
        ],
        4 => [
            'id' => 4,
            'name' => 'Crunchy crisps',
            'imagePrimary' => '/assets/images/products/product-image-4-1.jpg',
            'imageSecondary' => '/assets/images/products/product-image-4-2.jpg',
            'priceRange' => '$50.00 - $90.00',
            'rating' => 5,
            'category' => 'Snacks',
            'description' => 'Light, crunchy, and full of flavor — the perfect midday snack.',
        ],
        5 => [
            'id' => 5,
            'name' => 'Jewel cranberries',
            'imagePrimary' => '/assets/images/products/product-image-5-1.jpg',
            'imageSecondary' => '/assets/images/products/product-image-5-2.jpg',
            'priceRange' => '$60.00 - $67.00',
            'rating' => 4,
            'category' => 'Dried Fruits',
            'description' => 'Tangy-sweet dried cranberries packed with antioxidants.',
        ],
    ];

    // Get product by ID or fail
    $product = $products[$id] ?? abort(404, 'Product not found');

    return Inertia::render('ProductDetails', [
        'product' => $product
    ]);
})->name('product-details');


Route::get('/about-us', function () {
    return Inertia::render('AboutUs');
})->name('about-us');

Route::get('/contact-us', function () {
    return Inertia::render('ContactUs');
})->name('contact-us');



require __DIR__.'/auth.php';
