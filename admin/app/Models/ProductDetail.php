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
    protected $fillable = [
        'shortDescription',
        'longDescription',
        'fabricDetails',
        'pattern',
        'fit',
        'nace',
        'sleeve',
        'style',
    ];
}
