<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;
    protected $table = "product_details";
    protected $primaryKey = "productDetailsId";
    public $timestamps = false;
    protected $fillable = 
    [
        'shortDescription',
        'longDescription',
        'fabricDetails',
    ];

    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }

    // ProductDetail model
    public function product()
    {
        return $this->hasOne(Product::class, 'productDetailsId', 'fkProductDetailsId');
    }


}
