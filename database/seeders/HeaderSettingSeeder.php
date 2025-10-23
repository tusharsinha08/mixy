<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeaderSetting;
use Illuminate\Support\Facades\Storage;



class HeaderSettingSeeder extends Seeder
{
    public function run(): void
    {
        Storage::disk('public')->makeDirectory('uploads/header');

        HeaderSetting::create([
            'topbar_text' => 'Free shipping on orders over $25.',
            'topbar_help_text' => 'Need help? Call Us:',
            'topbar_phone' => '888554168',
            'logo' => '/assets/images/logo.png',
            'logo_url' => '/',
            'search_placeholder' => 'Search product...',
            'icon_user' => 'fas fa-user',
            'icon_wishlist' => 'fas fa-heart',
            'icon_cart' => 'fas fa-shopping-bag',
            'nav_links' => [
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Shop', 'url' => '/shop'],
                ['label' => 'About Us', 'url' => '/about-us'],
                ['label' => 'Contact Us', 'url' => '/contact-us']
            ]
        ]);
    }
}