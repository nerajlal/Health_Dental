<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'distributor_id',
        'name',
        'sku',
        'description',
        'company',
        'category',
        'base_price',
        'admin_margin',
        'final_price',
        'stock_quantity',
        'unit',
        'image',
        'status',
        'is_active',
        'admin_notes',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'admin_margin' => 'decimal:2',
        'final_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            if ($product->base_price && $product->admin_margin) {
                $product->final_price = $product->base_price + $product->admin_margin;
            }
        });
    }

    public function distributor()
    {
        return $this->belongsTo(User::class, 'distributor_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customPricing()
    {
        return $this->hasMany(CustomPricing::class);
    }

    public function getPriceForClinic($clinicId)
    {
        $customPrice = $this->customPricing()
            ->where('clinic_id', $clinicId)
            ->first();

        return $customPrice ? $customPrice->custom_price : $this->final_price;
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved')->where('is_active', true);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}