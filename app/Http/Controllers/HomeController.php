<?php

namespace App\Http\Controllers;

use App\Models\HomeSetting;
use App\Models\HomeBestSeller;
use App\Models\HomeDeal;
use App\Models\HomeCard;
use App\Models\HomeNewArrival;
use App\Models\HomeBanner;
use App\Models\HomeCategory;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            'settings' => HomeSetting::first(),
            'bestSellers' => HomeBestSeller::all(),
            'deals' => HomeDeal::all(),
            'cards' => HomeCard::all(),
            'newArrivals' => HomeNewArrival::all(),
            'banners' => HomeBanner::all(),
            'categories' => HomeCategory::all(),
        ]);
    }
}
