<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryService extends Model
{
    use HasFactory;
    protected $table ='delivery_service';
    protected $primaryKey='deliveryServiceId';

    public function delivered()
    {
        return $this->hasMany('App\Models\Order', 'delivery_service', 'deliveryServiceId');
    }
}
