<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;
    protected $table = "product";
    protected $primaryKey = "productId";
    public $timestamps = true;
    protected $fillable = 
    [
        'productCode',
        'productName',
        'slug',
        'tag',
        'fkCategoryId',
        'fkBrandId',
        'fkUnitId',
        'fkProductDetailsId',
        'type',
        'featureImage',
        'status',
        'changed',
        'newArrived',
        'isRecommended',
    ];

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'categoryId', 'fkCategoryId');
    }
    
    public function brand(): HasOne
    {
        return $this->hasOne(Brand::class, 'brandId', 'fkBrandId');
    }

    public function productDetails(): HasOne
    {
        return $this->hasOne(ProductDetail::class, 'productDetailsId', 'fkProductDetailsId');
    }
    
    // public function productDetails()
    // {
    //     return $this->belongsTo(ProductDetail::class, 'fkProductDetailsId', 'productDetailsId');
    // }
    public function sku(): HasMany
    {
        return $this->hasMany(Sku::class, 'fkProductId', 'productId');
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'fkProductId', 'productId');
    }
}
