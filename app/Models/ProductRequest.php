<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'product_name',
        'company',
        'category',
        'description',
        'estimated_quantity',
        'urgency',
        'preferred_distributor',
        'assigned_distributor_id',
        'assigned_at',
        'expected_price',
        'reference_link',
        'status',
        'admin_notes',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'assigned_at' => 'datetime',
        'expected_price' => 'decimal:2',
    ];

    public function clinic()
    {
        return $this->belongsTo(User::class, 'clinic_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function assignedDistributor()
    {
        return $this->belongsTo(User::class, 'assigned_distributor_id');
    }
}