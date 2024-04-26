<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $table = "product_image";
    protected $primaryKey = "productImageId";
    public $timestamps = false;
    protected $fillable = 
    [
        'fkProductId',
        'fkSkuId',
        'imageType',
        'image',
    ];
}
