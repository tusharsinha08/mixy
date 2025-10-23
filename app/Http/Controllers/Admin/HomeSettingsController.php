<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSetting;
use App\Models\HomeBestSeller;
use App\Models\OfferBanner;
use App\Models\HomeDeal;
use App\Models\HomeCard;
use App\Models\HomeNewArrival;
use App\Models\HomeBanner;
use App\Models\HomeCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class HomeSettingsController extends Controller
{
    public function edit()
    {
        $settings = HomeSetting::first() ?? HomeSetting::create([]);

        return Inertia::render('AdminPanel/HomeSetting', [
            'settings' => $settings,
            'banners' => HomeBanner::all(),
            'bestSellers' => HomeBestSeller::with('product')->get(), // Add eager loading for products
            'deals' => HomeDeal::all(),
            'cards' => HomeCard::all(),
            'newArrivals' => HomeNewArrival::with('product')->get(),
            'categories' => HomeCategory::all(),
            'offerBanners' => OfferBanner::all(),
            'products' => \App\Models\Product::all(),
        ]);
    }

    public function update(Request $request)
    {
        $settings = HomeSetting::first() ?? new HomeSetting();
        $data = $request->except([
            'logo',
            'hero_image',
            'best_sellers',
            'deals',
            'cards',
            'new_arrivals',
            'banners',
            'categories',
            'offer_banners'
        ]);

        
        foreach (['logo', 'hero_image'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $path = $request->file($fileField)->store('uploads/home', 'public');
                $data[$fileField] = Storage::url($path); // This automatically creates the correct URL
            }
        }

        $settings->fill($data)->save();

        /* -----------------------------------------------------------
         *  BEST SELLERS
         * ----------------------------------------------------------- */
        if ($request->has('best_sellers')) {
            HomeBestSeller::truncate();
            foreach ($request->input('best_sellers', []) as $item) {
                HomeBestSeller::create([
                    'product_id' => $item['product_id'] ?? null,
                    'bs_title' => $item['bs_title'] ?? '',
                    'bs_subtitle' => $item['bs_subtitle'] ?? '',
                    'status' => $item['status'] ?? true,
                ]);
            }
        }

        /* -----------------------------------------------------------
         *  OFFER BANNERS
         * ----------------------------------------------------------- */
        if ($request->has('offer_banners')) {
            OfferBanner::truncate();

            foreach ($request->input('offer_banners', []) as $index => $item) {
                $imagePath = $item['image'] ?? '';

                // Check both possible field names
                if ($request->hasFile("offer_banners.{$index}.image_file")) {
                    $path = $request->file("offer_banners.{$index}.image_file")->store('uploads/offer-banners', 'public');
                    $imagePath = Storage::url($path);
                } elseif ($request->hasFile("offer_banners.{$index}.image")) {
                    $path = $request->file("offer_banners.{$index}.image")->store('uploads/offer-banners', 'public');
                    $imagePath = Storage::url($path);
                }

                OfferBanner::create([
                    'title' => $item['title'] ?? '',
                    'subtitle' => $item['subtitle'] ?? '',
                    'image' => $imagePath,
                    'button_text' => $item['button_text'] ?? 'Shop Now',
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
                    'product_id' => $item['product_id'] ?? null,
                ]);
            }
        }

        /* -----------------------------------------------------------
         *  BANNERS 
         * ----------------------------------------------------------- */
        if ($request->has('banners')) {
            HomeBanner::truncate();

            foreach ($request->input('banners', []) as $index => $item) {
                $imagePath = $item['image'] ?? '';

                // Check both possible field names for image upload
                if ($request->hasFile("banners.{$index}.image_file")) {
                    $path = $request->file("banners.{$index}.image_file")->store('uploads/banners', 'public');
                    $imagePath = Storage::url($path);
                } elseif ($request->hasFile("banners.{$index}.image")) {
                    $path = $request->file("banners.{$index}.image")->store('uploads/banners', 'public');
                    $imagePath = Storage::url($path);
                }

                HomeBanner::create([
                    'position' => $item['position'] ?? 'left',
                    'title' => $item['title'] ?? '',
                    'subtitle' => $item['subtitle'] ?? '',
                    'price' => $item['price'] ?? '',
                    'image' => $imagePath,
                ]);
            }
        }

        /* -----------------------------------------------------------
         *  CARDS 
         * ----------------------------------------------------------- */
        if ($request->has('cards')) {
            HomeCard::truncate();

            foreach ($request->input('cards', []) as $index => $item) {
                $imagePath = $item['image'] ?? '';

                // Check both possible field names for image upload
                if ($request->hasFile("cards.{$index}.image_file")) {
                    $path = $request->file("cards.{$index}.image_file")->store('uploads/cards', 'public');
                    $imagePath = Storage::url($path);
                } elseif ($request->hasFile("cards.{$index}.image")) {
                    $path = $request->file("cards.{$index}.image")->store('uploads/cards', 'public');
                    $imagePath = Storage::url($path);
                }

                HomeCard::create([
                    'title' => $item['title'] ?? '',
                    'price' => $item['price'] ?? '',
                    'image' => $imagePath,
                    'button_text' => $item['button_text'] ?? 'Shop Now',
                    'button_icon' => $item['button_icon'] ?? 'fas fa-arrow-right',
                    'button_url' => $item['button_url'] ?? '#',
                ]);
            }
        }


        /* -----------------------------------------------------------
         *  DEALS 
         * ----------------------------------------------------------- */
        if ($request->has('deals')) {
            HomeDeal::truncate();
            foreach ($request->input('deals', []) as $item) {
                HomeDeal::create([
                    'product_id' => $item['product_id'] ?? null,
                    'name' => $item['name'] ?? '',
                    'price_range' => $item['price_range'] ?? '',
                    'image' => $item['image'] ?? '',
                    'sold' => $item['sold'] ?? 0,
                    'available' => $item['available'] ?? 0,
                    'progress' => $item['progress'] ?? 0,
                    'rating' => $item['rating'] ?? 4,
                    'timer_text' => $item['timer_text'] ?? 'Hurry up! Offer ends in:',
                    'start_date' => $item['start_date'] ? Carbon::parse($item['start_date']) : null,
                    'end_date' => $item['end_date'] ? Carbon::parse($item['end_date']) : null,
                    'is_active' => $item['is_active'] ?? true,
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

        return redirect()->back()->with('success', 'Home settings updated successfully!');
    }
}