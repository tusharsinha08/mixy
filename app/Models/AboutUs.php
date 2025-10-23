<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $table = 'about_us';

    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'hero_button_text',
        'who_we_are',
        'our_values',
        'our_mission',
        'fun_facts',
    ];

    protected $casts = [
        'fun_facts' => 'array',
    ];
}
