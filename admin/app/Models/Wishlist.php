<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Wishlist extends Model
{
    use HasFactory;
    protected $table = "wishlist";
    protected $primaryKey = "wishlistId";
    public $timestamps = true;
    protected $fillable = [
        'fkSkuId',
        'fkCustomerId',
    ];

    public function sku(): HasOne
    {
        return $this->hasOne(Sku::class, 'skuId', 'fkSkuId');
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'customerId', 'fkCustomerId');
    }
}
