<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    protected $table = 'service_orders';
    protected $primaryKey = 'id';

    protected $fillable = [
        'vehiclePlate',
        'entryDateTime',
        'exitDateTime',
        'priceType',
        'price',
        'user_id'
    ];

    # Casts
    protected $casts = [
        'entryDateTime' => 'datetime',
        'exitDateTime' => 'datetime',
    ];

    # Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
