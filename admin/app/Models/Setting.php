<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = "settings";
    protected $primaryKey = "settingId";
    public $timestamps = false;
    protected $fillable = [
        'companyName',
        'email',
        'logo',
        'logoDark',
        'address',
        'googleMapLink',
        'phone',
        'facebook',
        'twitter',
        'instagram',
        'contactText1',
        'contactText2',
        'openingHoursText1',
        'openingHoursText2',
        'free_delivery_area',
        'return_policy',
        'payment_hour',
        'free_shipping_policy',    
        'shipping_cost',
        'min_price_range',
        'max_price_range'  

    ];
}
