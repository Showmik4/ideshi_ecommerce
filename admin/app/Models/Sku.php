<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sku extends Model
{
    use HasFactory;
    protected $table = "sku";
    protected $primaryKey = "skuId";
    public $timestamps = true;
    protected $fillable = [
        'barcode',
        'fkProductId',
        'salePrice',
        'regularPrice',
        'discount',
        'discountType',
        'stockAlert',
        'status',
    ];

    public function stockRecord()
    {
        return $this->hasMany(Stock::class, 'fkskuId', 'skuId');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'productId', 'fkProductId');
    }

    public function variationRelation(): HasMany
    {
        return $this->hasMany(VariationRelation::class, 'skuId', 'skuId');
    }

    public function variationImage(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'fkSkuId', 'skuId');
    }
}
