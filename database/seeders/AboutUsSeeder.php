<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AboutUs;

class AboutUsSeeder extends Seeder
{
    public function run(): void
    {
        AboutUs::create([
            'hero_title' => 'Mixy is the Largest Organic Store',
            'hero_subtitle' => 'Great theme, excellent support. We had a few small issues with dropdown menus and support fixed them quickly.',
            'hero_button_text' => 'Shop Now',
            'who_we_are' => 'After every trip to Hawaii, I always have a few DMs asking where we stayed...',
            'our_values' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
            'our_mission' => 'Non diam phasellus vestibulum lorem sed risus ultricies...',
            'fun_facts' => [
                ['icon' => '❤️', 'count' => 159, 'label' => 'Satisfied Clients'],
                ['icon' => '🌍', 'count' => 68, 'label' => 'Projects a Year'],
                ['icon' => '🏆', 'count' => 88, 'label' => 'Awards Won'],
                ['icon' => '🚀', 'count' => 668, 'label' => 'Support Tickets'],
            ],
           
        ]);
    }
}