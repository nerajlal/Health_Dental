<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPricing extends Model
{
    use HasFactory;

    protected $table = 'custom_pricing';

    protected $fillable = [
        'product_id',
        'clinic_id',
        'custom_price',
    ];

    protected $casts = [
        'custom_price' => 'decimal:2',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function clinic()
    {
        return $this->belongsTo(User::class, 'clinic_id');
    }
}