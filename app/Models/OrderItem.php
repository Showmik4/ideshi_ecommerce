<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model
{
    use HasFactory;
    protected $table = "order_item";
    protected $primaryKey = "orderItemId";
    public $timestamps = false;
    protected $fillable = [
        'fkOrderId',
        'fkSkuId',
        'price',
        'quantity',
        'discount',
        'discountType',
        'total',
        'returned',
        'return_reason',
    ];

    public function order(): HasOne
    {
        return $this->hasOne(OrderInfo::class, 'orderId', 'fkOrderId');
    }

    public function sku(): HasOne
    {
        return $this->hasOne(Sku::class, 'skuId', 'fkSkuId');
    }
}
