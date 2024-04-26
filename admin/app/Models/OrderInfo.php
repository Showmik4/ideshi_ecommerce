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

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'customerId', 'fkCustomerId');
    }

    public function orderedProduct()
    {
        return $this->hasMany('App\Models\OrderItem', 'fkOrderId', 'orderId');
    }

  

    public function transaction()
    {
        return $this->hasMany('App\Models\Transaction', 'fkorderId', 'orderId');
    }

    public function orderStatusLogs()
    {
        return $this->hasMany('App\Models\OrderLog', 'fkOrderId', 'orderId');
    }

    public function delivery()
    {
        return $this->hasOne('App\Models\DeliveryService', 'deliveryServiceId', 'delivery_service');
    }

    public function deliveryBalance()
    {
        return $this->hasOne('App\Models\DeliveryServiceBalance', 'orderId', 'orderId');
    }

    public function lastStatus()
    {
        return $this->hasOne('App\Models\OrderLog', 'fkOrderId', 'orderId')->where('status','!=',NULL)->orderBy('created_at','desc')->latest();
    }

    public function paidAmount()
    {
        return $this->transaction->where('payment_type','!=','return')->sum('amount');
    }
    protected $casts = [
        'orderTotal' => 'float',
    ];
}
