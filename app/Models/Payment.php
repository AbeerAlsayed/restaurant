<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * الحقول التي يمكن تعبئتها (Mass Assignment).
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'amount',
        'payment_method',
        'status',
        'stripe_payment_id'
    ];

    /**
     * العلاقة مع الطلبات (Order).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
