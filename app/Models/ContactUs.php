<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_title',
        'breadcrumb_title',
        'office_location',
        'phone_numbers',
        'emails',
        'map_title',
        'map_address',
        'newsletter_title',
        'newsletter_subtitle',
        'call_us_text',
        'call_us_number',
        'features',
    ];

    protected $casts = [
        'phone_numbers' => 'array',
        'emails' => 'array',
        'features' => 'array',
    ];
}
