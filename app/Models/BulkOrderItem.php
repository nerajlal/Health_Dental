<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'bulk_order_id',
        'product_id',
        'total_quantity',
    ];

    protected $casts = [
        'total_quantity' => 'integer',
    ];

    public function bulkOrder()
    {
        return $this->belongsTo(BulkOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}