<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    use HasFactory;

    protected $table = "sku";
    protected $primaryKey = "skuId";
    public $timestamps = true;

    public function variationRelation()
    {
        return $this->hasMany(VariationRelation::class, 'skuId', 'skuId');
    }

    public function variationImages()
    {
        return $this->hasMany(ProductImage::class, 'fkSkuId', 'skuId');
    }

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'productId', 'fkProductId');
    }

    public function stockAvailable($skuId = null)
    {
        $stockIn=Stock::where('fkskuId',$skuId)->where('type', 'in')->sum('stock');
        $stockOut=Stock::where('fkskuId',$skuId)->where('type', 'out')->sum('stock');

        return $stockIn-$stockOut;
    }
}
