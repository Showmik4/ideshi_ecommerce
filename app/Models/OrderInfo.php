<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderInfo extends Model
{
    use HasFactory;
    protected $table = "order_info";
    protected $primaryKey = "orderId";
    public $timestamps = true;
    protected $fillable = [
        'fkCustomerId',
        'fkStoreId',
        'discount',
        'discountType',
        'vat',
        'orderTotal',
        'orderType',
        'saleType',
        'paymentType',
        'paymentStatus',
        'changed',
        'note',
        'note',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'fkOrderId', 'orderId');
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'customerId', 'fkCustomerId');
    }
}
