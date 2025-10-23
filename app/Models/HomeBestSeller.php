<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeBestSeller extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'bs_title',
        'bs_subtitle',
        'status',
    ];

    // ✅ Relation to Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
