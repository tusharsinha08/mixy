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
use Inertia\Inertia;

class HomeSettingsController extends Controller
{
 
    public function edit()
    {
        $settings = HomeSetting::first() ?? HomeSetting::create([]);

        return Inertia::render('AdminPanel/HomeSetting', [
            'settings' => $settings,
            'bestSellers' => HomeBestSeller::all(),
            'deals' => HomeDeal::all(),
            'cards' => HomeCard::all(),
            'newArrivals' => HomeNewArrival::all(),
            'banners' => HomeBanner::all(),
            'categories' => HomeCategory::all(),
        ]);
    }

  
    public function update(Request $request)
    {
        // ✅ Save main settings 
        $settings = HomeSetting::first() ?? new HomeSetting();
        $data = $request->except([
            'logo',
            'hero_image',
            'best_sellers',
            'deals',
            'cards',
            'new_arrivals',
            'banners',
            'categories'
        ]);

        // ✅ Handle image uploads
        foreach (['logo', 'hero_image'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $path = $request->file($fileField)->store('uploads/home', 'public');
                $data[$fileField] = '/storage/' . $path;
            }
        }

        $settings->fill($data)->save();


        /* -----------------------------------------------------------
         *  DEALS
         * ----------------------------------------------------------- */
        if ($request->has('deals')) {
            HomeDeal::truncate();
            foreach ($request->input('deals', []) as $item) {
                HomeDeal::create([
                    'name' => $item['name'] ?? '',
                    'price_range' => $item['price_range'] ?? '',
                    'image' => $item['image'] ?? '',
                    'sold' => $item['sold'] ?? 0,
                    'available' => $item['available'] ?? 0,
                    'progress' => $item['progress'] ?? 0,
                    'rating' => $item['rating'] ?? 5,
                ]);
            }
        }

        /* -----------------------------------------------------------
         *  CARDS
         * ----------------------------------------------------------- */
        if ($request->has('cards')) {
            HomeCard::truncate();
            foreach ($request->input('cards', []) as $item) {
                HomeCard::create([
                    'title' => $item['title'] ?? '',
                    'price' => $item['price'] ?? '',
                    'image' => $item['image'] ?? '',
                    'button_text' => $item['button_text'] ?? 'Shop Now',
                    'button_icon' => $item['button_icon'] ?? 'fas fa-arrow-right',
                    'button_url' => $item['button_url'] ?? '#',
                ]);
            }
        }

        /* -----------------------------------------------------------
         *  NEW ARRIVALS
         * ----------------------------------------------------------- */
        if ($request->has('new_arrivals')) {
            HomeNewArrival::truncate();
            foreach ($request->input('new_arrivals', []) as $item) {
                HomeNewArrival::create([
                    'name' => $item['name'] ?? '',
                    'price_range' => $item['price_range'] ?? '',
                    'image' => $item['image'] ?? '',
                    'rating' => $item['rating'] ?? 4,
                ]);
            }
        }

        /* -----------------------------------------------------------
         *  BANNERS
         * ----------------------------------------------------------- */
        if ($request->has('banners')) {
            HomeBanner::truncate();
            foreach ($request->input('banners', []) as $item) {
                HomeBanner::create([
                    'position' => $item['position'] ?? 'left',
                    'title' => $item['title'] ?? '',
                    'subtitle' => $item['subtitle'] ?? '',
                    'price' => $item['price'] ?? '',
                    'image' => $item['image'] ?? '',
                ]);
            }
        }

        /* -----------------------------------------------------------
         *  CATEGORIES
         * ----------------------------------------------------------- */
        if ($request->has('categories')) {
            HomeCategory::truncate();
            foreach ($request->input('categories', []) as $item) {
                HomeCategory::create([
                    'name' => $item['name'] ?? '',
                    'image' => $item['image'] ?? '',
                    'products' => $item['products'] ?? 0,
                ]);
            }
        }

        return redirect()->back()->with('success', '✅ Home settings updated successfully and saved!');
    }
}
