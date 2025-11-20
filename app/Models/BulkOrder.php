<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'distributor_id',
        'status',
        'total_amount',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    // Relationships
    public function distributor()
    {
        return $this->belongsTo(User::class, 'distributor_id');
    }

    public function items()
    {
        return $this->hasMany(BulkOrderItem::class);
    }

    public function clinic_orders()
    {
        // This gets all the individual clinic orders that are part of this bulk order
        return $this->hasManyThrough(
            Order::class,
            OrderItem::class,
            'product_id', // Foreign key on order_items table
            'id', // Foreign key on orders table
            'id', // Local key on bulk_orders table
            'order_id' // Local key on order_items table
        )->distinct();
    }
}