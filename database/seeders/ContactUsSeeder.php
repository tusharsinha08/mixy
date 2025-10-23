<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactUs;

class ContactUsSeeder extends Seeder
{
    public function run(): void
    {
        ContactUs::create([
            'page_title' => 'Contact Us',
            'breadcrumb_title' => 'Let us know how we can help',
            'office_location' => 'Riverside Building, County Hall, London SE1 7PB, United Kingdom',
            'phone_numbers' => ['1.800.440.0680', '1.612.696.3400'],
            'emails' => ['support@mixy.com', 'info@mixy.com'],
            'map_title' => 'Our Location',
            'map_address' => 'Riverside Building, County Hall, London',
            'newsletter_title' => 'Sign up to Newsletter',
            'newsletter_subtitle' => '...and receive $20 coupon for first shopping',
            'call_us_text' => 'Call Us 24/7',
            'call_us_number' => '+8 88 55 4168',
            'features' => [
                ['icon' => 'fas fa-truck', 'title' => 'Free Shipping', 'subtitle' => 'Online Only. Exclusions Apply'],
                ['icon' => 'fas fa-money-bill-wave', 'title' => 'Best Price Guarantee', 'subtitle' => 'If You Find a Lower Price'],
                ['icon' => 'fas fa-gift', 'title' => 'Free Curbside Pickup', 'subtitle' => 'Grab Your Gear and Go'],
                ['icon' => 'fas fa-headset', 'title' => 'Support 24/7', 'subtitle' => 'Contact us 24 hours a day'],
            ],
        ]);
    }
}
