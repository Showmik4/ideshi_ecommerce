<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariationTemp extends Model
{
    use HasFactory;
    protected $table = "product_variation_temp";
    protected $primaryKey = "productVariationTempId";
    public $timestamps = false;
    protected $fillable = 
    [
        'barcode',
        'sessionId',
        'variationType1',
        'variationValue1',
        'variationId1',
        'variationType2',
        'variationValue2',
        'variationId2',
        'salePrice',
        'regularPrice',
        'discount',
        'discountType',
        'stockAlert',
        'variationImage',
        'quantity'
    ];
}
