<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ShipmentZone extends Model
{
    use HasFactory;
    protected $table = "shipment_zone";
    protected $primaryKey = "shipmentZoneId";
    public $timestamps = false;
    protected $fillable = [
        'shipmentZoneName',
        'status',
        'fkChargeId',
    ];

    public function charge(): HasOne
    {
        return $this->hasOne(Charge::class, 'chargeId', 'fkChargeId');
    }
}
