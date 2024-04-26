<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;
    protected $table = "customer";
    protected $primaryKey = "customerId";
    public $timestamps = true;
    protected $fillable = [
        'fkUserId',
        'phone',
        'status',
        'customerImage',
        'membership',
        'fkAddressId',
        'fkShipmentZoneId',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'userId', 'fkUserId');
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class, 'addressId', 'fkAddressId');
    }

    public function shipmentZone(): HasOne
    {
        return $this->hasOne(ShipmentZone::class, 'shipmentZoneId', 'fkShipmentZoneId');
    }
}
