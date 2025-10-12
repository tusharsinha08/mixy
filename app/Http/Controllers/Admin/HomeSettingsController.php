<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSetting;
use App\Models\HomeBestSeller;
use App\Models\HomeDeal;
use App\Models\HomeCard;
use App\Models\HomeNewArrival;
use App\Models\HomeBanner;
use App\Models\HomeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class HomeSettingsController extends Controller
{
    
    public function edit()
    {
        $settings = HomeSetting::first() ?? HomeSetting::create([]);

        /* -------------------------
         *  BEST SELLERS
         * ------------------------- */
        $bestSellers = HomeBestSeller::all();
        if ($bestSellers->isEmpty()) {
            $defaultSellers = [
                [
                    'name' => 'Pure Honey',
                    'price_range' => '$10 - $20',
                    'image' => '/uploads/bestsellers/honey.webp',
                    'rating' => 5,
                    'button_text' => 'Buy Now',
                    'button_icon' => 'fas fa-shopping-bag',
                ],
                [
                    'name' => 'Organic Tea',
                    'price_range' => '$8 - $15',
                    'image' => '/uploads/bestsellers/tea.webp',
                    'rating' => 4,
                    'button_text' => 'Buy Now',
                    'button_icon' => 'fas fa-shopping-bag',
                ],
                [
                    'name' => 'Natural Face Cream',
                    'price_range' => '$12 - $25',
                    'image' => '/uploads/bestsellers/cream.webp',
                    'rating' => 5,
                    'button_text' => 'Buy Now',
                    'button_icon' => 'fas fa-shopping-bag',
                ],
            ];
            HomeBestSeller::insert($defaultSellers);
            $bestSellers = HomeBestSeller::all();
        }

        /* -------------------------
         *  DEALS
         * ------------------------- */
        $deals = HomeDeal::all();
        if ($deals->isEmpty()) {
            $defaultDeals = [
                [
                    'title' => 'Organic Coconut',
                    'price' => '$10.00 - $70.00',
                    'image' => '/assets/images/products/product-image-7-1.jpg',
                    'sold' => 365,
                    'available' => 634,
                    'progress' => 40,
                    'rating' => 4,
                ],
                [
                    'title' => 'Almond Organic',
                    'price' => '$10.00 - $70.00',
                    'image' => '/assets/images/products/product-image-8-1.jpg',
                    'sold' => 220,
                    'available' => 480,
                    'progress' => 60,
                    'rating' => 5,
                ],
            ];
            HomeDeal::insert($defaultDeals);
            $deals = HomeDeal::all();
        }

        /* -------------------------
         *  CARDS
         * ------------------------- */
        $cards = HomeCard::all();
        if ($cards->isEmpty()) {
            $defaultCards = [
                [
                    'title' => 'Fresh Organic Kiwi',
                    'price' => '$10.00 - $70.00',
                    'image' => '/assets/images/products/product-image-2-1.jpg',
                    'button_text' => 'Shop Now',
                    'button_icon' => 'fas fa-arrow-right',
                ],
                [
                    'title' => 'Dried Mango',
                    'price' => '$10.00 - $70.00',
                    'image' => '/assets/images/products/product-image-1-1.jpg',
                    'button_text' => 'Shop Now',
                    'button_icon' => 'fas fa-arrow-right',
                ],
            ];
            HomeCard::insert($defaultCards);
            $cards = HomeCard::all();
        }

        /* -------------------------
         *  NEW ARRIVALS
         * ------------------------- */
        $newArrivals = HomeNewArrival::all();
        if ($newArrivals->isEmpty()) {
            $defaultArrivals = [
                [
                    'name' => 'Fresh organic kiwi',
                    'price_range' => '$10.00 - $70.00',
                    'image' => '/assets/images/products/product-image-2-1.jpg',
                    'rating' => 4,
                ],
                [
                    'name' => 'Dried mango',
                    'price_range' => '$10.00 - $70.00',
                    'image' => '/assets/images/products/product-image-1-1.jpg',
                    'rating' => 5,
                ],
            ];
            HomeNewArrival::insert($defaultArrivals);
            $newArrivals = HomeNewArrival::all();
        }

        /* -------------------------
         *  BANNERS (Natural Product)
         * ------------------------- */
        $banners = HomeBanner::all();
        if ($banners->isEmpty()) {
            $defaultBanners = [
                [
                    'position' => 'left',
                    'title' => 'Fresh Organic Kiwi',
                    'subtitle' => 'Healthy & Delicious',
                    'price' => '$10.00 - $70.00',
                    'image' => '/uploads/banners/kiwi.jpg',
                ],
                [
                    'position' => 'right',
                    'title' => 'Dried Mango',
                    'subtitle' => 'Natural Sweetness',
                    'price' => '$8.00 - $30.00',
                    'image' => '/uploads/banners/mango.jpg',
                ],
            ];
            HomeBanner::insert($defaultBanners);
            $banners = HomeBanner::all();
        }

        /* -------------------------
         *  CATEGORIES (Popular)
         * ------------------------- */
        $categories = HomeCategory::all();
        if ($categories->isEmpty()) {
            $defaultCategories = [
                ['name' => 'Fruits', 'image' => '/uploads/categories/fruits.jpg', 'products' => 120],
                ['name' => 'Vegetables', 'image' => '/uploads/categories/vegetables.jpg', 'products' => 90],
                ['name' => 'Snacks', 'image' => '/uploads/categories/snacks.jpg', 'products' => 60],
                ['name' => 'Juices', 'image' => '/uploads/categories/juices.jpg', 'products' => 45],
            ];
            HomeCategory::insert($defaultCategories);
            $categories = HomeCategory::all();
        }

        return Inertia::render('AdminPanel/HomeSetting', [
            'settings' => $settings,
            'bestSellers' => $bestSellers,
            'deals' => $deals,
            'cards' => $cards,
            'newArrivals' => $newArrivals,
            'banners' => $banners,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request)
    {
        $settings = HomeSetting::first() ?? new HomeSetting();
        $data = $request->except([
            'logo', 'hero_image', 'best_sellers', 'deals', 'cards', 'new_arrivals', 'banners', 'categories'
        ]);

        /* FILE UPLOADS */
        foreach (['logo', 'hero_image'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $path = $request->file($fileField)->store('uploads/home', 'public');
                $data[$fileField] = '/storage/' . $path;
            }
        }

        $settings->fill($data)->save();

        /* BEST SELLERS */
        if ($request->has('best_sellers')) {
            HomeBestSeller::truncate();
            foreach ($request->input('best_sellers') as $item) {
                HomeBestSeller::create([
                    'name' => $item['name'] ?? '',
                    'price_range' => $item['priceRange'] ?? '',
                    'image' => $item['image'] ?? null,
                    'rating' => $item['rating'] ?? 5,
                    'button_text' => $item['button_text'] ?? 'Add to cart',
                    'button_icon' => $item['button_icon'] ?? 'fas fa-shopping-bag',
                ]);
            }
        }

        /* DEALS */
        if ($request->has('deals')) {
            HomeDeal::truncate();
            foreach ($request->input('deals') as $item) {
                HomeDeal::create([
                    'title' => $item['title'] ?? '',
                    'price' => $item['price'] ?? '',
                    'image' => $item['image'] ?? null,
                    'sold' => $item['sold'] ?? 0,
                    'available' => $item['available'] ?? 0,
                    'progress' => $item['progress'] ?? 0,
                    'rating' => $item['rating'] ?? 0,
                ]);
            }
        }

        /* CARDS */
        if ($request->has('cards')) {
            HomeCard::truncate();
            foreach ($request->input('cards') as $item) {
                HomeCard::create([
                    'title' => $item['title'] ?? '',
                    'price' => $item['price'] ?? '',
                    'image' => $item['image'] ?? null,
                    'button_text' => $item['button_text'] ?? 'Shop Now',
                    'button_icon' => $item['button_icon'] ?? 'fas fa-arrow-right',
                    'button_url' => $item['button_url'] ?? '#',
                ]);
            }
        }

        /* NEW ARRIVALS */
        if ($request->has('new_arrivals')) {
            HomeNewArrival::truncate();
            foreach ($request->input('new_arrivals') as $item) {
                HomeNewArrival::create([
                    'name' => $item['name'] ?? '',
                    'price_range' => $item['priceRange'] ?? '',
                    'image' => $item['image'] ?? null,
                    'rating' => $item['rating'] ?? 4,
                ]);
            }
        }

        /* BANNERS */
        if ($request->has('banners')) {
            HomeBanner::truncate();
            foreach ($request->input('banners') as $item) {
                HomeBanner::create([
                    'position' => $item['position'] ?? 'left',
                    'title' => $item['title'] ?? 'Strawberry Velvet Cake',
                    'subtitle' => $item['subtitle'] ?? '100% Natural Organic',
                    'price' => $item['price'] ?? '$30.66',
                    'image' => $item['image'] ?? null,
                ]);
            }
        }

        /* CATEGORIES */
        if ($request->has('categories')) {
            HomeCategory::truncate();
            foreach ($request->input('categories') as $item) {
                HomeCategory::create([
                    'name' => $item['name'] ?? '',
                    'image' => $item['image'] ?? null,
                    'products' => $item['products'] ?? 0,
                ]);
            }
        }

        return redirect()->back()->with('success', '✅ Home settings updated successfully!');
    }
}
