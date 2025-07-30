<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'delivery_address',
        'phone_number',
        'payment_method',
        'payment_receipt',
        'payment_status',
        'admin_notes',
        'status_updated_at'
    ];

    protected $casts = [
        'status_updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getPaymentReceiptUrlAttribute()
    {
        if ($this->payment_receipt) {
            return asset('storage/' . $this->payment_receipt);
        }
        return null;
    }
}