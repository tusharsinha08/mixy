<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeSetting;

class HomeSettingsSeeder extends Seeder
{
    public function run(): void
    {
        HomeSetting::updateOrCreate(
            ['id' => 1],
            [
                'topbar_text' => '100% ORGANIC POTATO',
                'topbar_phone' => '+880 1234 567890',
                'logo' => '/assets/images/logo.png',
                'hero_title' => 'Potato Chips & Pepper With Onion',
                'hero_subtitle' => 'Fresh & Crispy Snacks for Everyone',
                'hero_price' => '$18.36',
                'hero_image' => '/assets/images/hero/slider1_mixy1.webp',

                'offer_banners' => json_encode([
                    [
                        'title' => 'Chocolate Cookies Best Sweets In Town',
                        'subtitle' => 'FROM 20% OFF',
                        'image' => '/assets/images/banners/img1_banner1_mixy1.webp',
                    ],
                    [
                        'title' => 'Capture The Delicious Moments',
                        'subtitle' => 'FROM 30% OFF',
                        'image' => '/assets/images/banners/img1_banner1_mixy2.webp',
                    ],
                ]),
                 'featured_category' => json_encode([
                    'image' => '/assets/images/banners/img_banner4_mixy1.webp'
                ]),
          

                'newsletter' => json_encode([
                    'title' => 'Sign up to Newsletter',
                    'subtitle' => '...and receive $20 coupon for first shopping',
                    'button_text' => 'Subscribe',
                    'placeholder' => 'Your Email Address...',
                    'phone' => '+8 88 55 4168',
                ]),

                'services' => json_encode([
                    ['icon' => 'fas fa-truck', 'title' => 'Free Shipping', 'subtitle' => 'Online Only. Exclusions Apply'],
                    ['icon' => 'fa-brands fa-square-font-awesome-stroke', 'title' => 'Best Price Guarantee', 'subtitle' => 'If You Find a Lower Price'],
                    ['icon' => 'fas fa-shopping-basket', 'title' => 'Free Curbside Pickup', 'subtitle' => 'Grab Your Gear and Go'],
                    ['icon' => 'fas fa-headset', 'title' => 'Support 24/7', 'subtitle' => 'Contact us 24 hours a day'],
                ]),

                'footer' => json_encode([
                    'text' => '© 2025 Mixy. All rights reserved.'
                ]),

                'icons' => json_encode([
                    'scroll' => 'icon-rt-arrow-up'
                ]),
            ]
        );
    }
}
