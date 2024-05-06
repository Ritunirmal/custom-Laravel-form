<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'razorpay_payment_id',
        'razorpay_order_id',
        'razorpay_signature',
        'payment_mode',
        'amount',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
