<?php

namespace App\Http\Controllers;

use App\Models\HomeSetting;
use App\Models\HomeBestSeller;
use App\Models\HomeDeal;
use App\Models\HomeCard;
use App\Models\HomeNewArrival;
use App\Models\HomeBanner;
use App\Models\HomeCategory;
use App\Models\OfferBanner;
use App\Models\Product;
use Carbon\Carbon;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $settings = HomeSetting::first() ?? new HomeSetting();
        $banners = HomeBanner::all();

        $settings->natural_banners = $this->transformBanners($banners);

        // Fetch data with eager loading and status filtering
        $bestSellers = HomeBestSeller::with(['product' => function($query) {
            $query->select('id', 'name', 'price_range', 'image_primary', 'rating', 'slug');
        }])->where('status', true)->get();

        $newArrivals = HomeNewArrival::with(['product' => function($query) {
            $query->select('id', 'name', 'price_range', 'image_primary', 'rating', 'slug');
        }])->get();

        // Fetch active deals with product info
              $deals = HomeDeal::with('product')
            ->where('is_active', true)
            ->get()
            ->map(function ($deal) {
                return [
                    'id' => $deal->id,
                    'product_id' => $deal->product_id,
                    'name' => $deal->name ?? $deal->product->name ?? '',
                    'image' => $deal->image ?? $deal->product->image_primary ?? '',
                    'price_range' => $deal->price_range ?? $deal->product->price_range ?? '',
                    'sold' => $deal->sold,
                    'available' => $deal->available,
                    'progress' => $deal->progress,
                    'rating' => $deal->rating ?? 4,
                    'timer_text' => $deal->timer_text,
                    'start_date' => $deal->start_date ? Carbon::parse($deal->start_date)->toDateTimeLocalString() : null,
                    'end_date' => $deal->end_date ? Carbon::parse($deal->end_date)->toDateTimeLocalString() : null,
                    'is_active' => $deal->is_active,
                ];
            })
            ->filter(function ($deal) {
                // Only show active deals that haven't expired or don't have end dates
                if (!$deal['is_active']) return false;
                if (!$deal['end_date']) return true;
                return Carbon::parse($deal['end_date'])->isFuture();
            })
            ->values();


        // Get all products for fallback mapping
        $products = Product::select('id', 'name', 'price_range', 'image_primary', 'rating', 'slug')->get();

        return Inertia::render('Home', [
            'settings' => $settings,
            'bestSellers' => $bestSellers,
            'deals' => $deals,
            'cards' => HomeCard::all(),
            'newArrivals' => $newArrivals,
            'banners' => $banners,
            'categories' => HomeCategory::all(),
            'offerBanners' => OfferBanner::all(),
            'products' => $products,
        ]);
    }

    private function transformBanners($banners)
    {
        // Initialize with defaults
        $transformed = [
            'left' => [
                'image' => '/assets/images/banners/img1_banner3_mixy1.webp',
                'subtitle' => '100% Natural Organic',
                'title' => 'Strawberry Velvet Cake',
                'price' => '$70.00',
            ],
            'right' => [
                'image' => '/assets/images/banners/img2_banner3_mixy1.webp',
                'title' => 'Organic Nuts',
                'price' => 'SAVE 20%',
            ],
        ];

        // Update with actual data from database
        foreach ($banners as $banner) {
            if ($banner->position === 'left') {
                $transformed['left'] = [
                    'image' => $banner->image ?: $transformed['left']['image'],
                    'subtitle' => $banner->subtitle ?: $transformed['left']['subtitle'],
                    'title' => $banner->title ?: $transformed['left']['title'],
                    'price' => $banner->price ?: $transformed['left']['price'],
                ];
            } elseif ($banner->position === 'right') {
                $transformed['right'] = [
                    'image' => $banner->image ?: $transformed['right']['image'],
                    'title' => $banner->title ?: $transformed['right']['title'],
                    'price' => $banner->price ?: $transformed['right']['price'],
                ];
            }
        }

        return $transformed;
    }
}