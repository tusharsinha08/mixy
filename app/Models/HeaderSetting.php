<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'topbar_text',
        'topbar_help_text',
        'topbar_phone',
        'logo',
        'logo_url',
        'search_placeholder',
        'icon_user',
        'icon_wishlist',
        'icon_cart',
        'nav_links'
    ];

    protected $casts = [
        'nav_links' => 'array'
    ];

    /**
     * Get the default header settings
     */
    public static function getSettings()
    {
        $settings = self::first();
        
        if (!$settings) {
            // Return default settings if none exist
            return [
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
            ];
        }

        return $settings->toArray();
    }
}