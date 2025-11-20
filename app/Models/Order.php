<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'status',
        'total_amount',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    // Relationships
    public function clinic()
    {
        return $this->belongsTo(User::class, 'clinic_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}