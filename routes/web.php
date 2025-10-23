<?php

use App\Http\Controllers\ShopController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ✅ Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\HomeSettingsController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\HeaderSettingsController;



// ✅ Models
use App\Models\HomeSetting;
use App\Models\Product;
use App\Models\AboutUs;
use App\Models\ContactUs;
use App\Models\TeamMember;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/shop', function () {
    return Inertia::render('Shop');
})->name('shop');

Route::get('/about-us', function () {
    $about = AboutUs::first();
    $teamMembers = \App\Models\TeamMember::all();

    return Inertia::render('AboutUs', [
        'aboutUs' => [
            'hero' => [
                'title' => $about->hero_title ?? '',
                'subtitle' => $about->hero_subtitle ?? '',
                'buttonText' => $about->hero_button_text ?? '',
            ],
            'whoWeAre' => [
                'text' => $about->who_we_are ?? '',
            ],
            'ourValues' => [
                'text' => $about->our_values ?? '',
            ],
            'ourMission' => [
                'text' => $about->our_mission ?? '',
            ],
            'funFacts' => $about->fun_facts ?? [],
            'teamMembers' => $teamMembers->map(function ($member) {
                return [
                    'id' => $member->id,
                    'name' => $member->name,
                    'role' => $member->role,
                    'image' => $member->image ? asset($member->image) : '',
                ];
            })->toArray(),
        ]
    ]);
})->name('about-us');

Route::get('/contact-us', function () {
    $contact = ContactUs::first();

    return inertia('ContactUs', [
        'contact' => $contact ? [
            'page_title' => $contact->page_title,
            'breadcrumb_title' => $contact->breadcrumb_title,
            'office_location' => $contact->office_location,
            'phone_numbers' => $contact->phone_numbers,
            'emails' => $contact->emails,
            'map_title' => $contact->map_title,
            'map_address' => $contact->map_address,
            'newsletter_title' => $contact->newsletter_title,
            'newsletter_subtitle' => $contact->newsletter_subtitle,
            'call_us_text' => $contact->call_us_text,
            'call_us_number' => $contact->call_us_number,
            'features' => $contact->features,
        ] : null,
    ]);
})->name('contact-us');

Route::get('error', function () {
    return Inertia::render('Error404');
})->name('error404');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // 🧭 Admin Dashboard
    Route::get(
        '/admin-dashboard',
        fn() => Inertia::render('AdminPanel/AdminDashboard')
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
        // 🧭 Admin Dashboard
        Route::get(
            '/dashboard',
            fn() => Inertia::render('AdminPanel/AdminDashboard')
        )->name('dashboard');

        // ✅ Home Settings (edit + update)
        Route::get('/home-settings', [HomeSettingsController::class, 'edit'])
            ->name('home-settings.edit');
        Route::post('/home-settings/update', [HomeSettingsController::class, 'update'])
            ->name('home-settings.update');

        // ✅ About Us Admin Routes
        Route::get('/about-us', [AboutUsController::class, 'edit'])->name('about-us.edit');
        Route::post('/about-us', [AboutUsController::class, 'update'])->name('about-us.update');
        Route::post('/about-us/fun-facts', [AboutUsController::class, 'updateFunFacts'])->name('about-us.fun-facts.update');
        Route::post('/about-us/team-members', [AboutUsController::class, 'updateTeamMembers'])->name('about-us.team-members.update');

        // ✅ Product control
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

        // ✅ Contact Us (Admin Panel)
        Route::get('/contact-us', [ContactUsController::class, 'edit'])->name('contact-us.edit');
        Route::post('/contact-us', [ContactUsController::class, 'update'])->name('contact-us.update');

        // ✅ New Arrivals Management
        Route::get('/home-new-arrivals', [ProductController::class, 'editNewArrivals'])
            ->name('home-new-arrivals.edit');
        Route::post('/home-new-arrivals/update', [ProductController::class, 'updateNewArrivals'])
            ->name('home-new-arrivals.update');

        //Header Setting
        Route::get('/header-settings', [HeaderSettingsController::class, 'edit'])->name('header-settings.edit');
        Route::post('/header-settings/update', [HeaderSettingsController::class, 'update'])->name('header-settings.update');
    });
});


// Shop routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/product-details/{id}', [ShopController::class, 'show'])->name('product.details');

require __DIR__ . '/auth.php';

Route::fallback(function () {
    return Inertia::render('Error404');
});