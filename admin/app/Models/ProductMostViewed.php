<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMostViewed extends Model
{
    use HasFactory;
    protected $table = "product_most_viewed";
    protected $primaryKey = "productMostViewedId";
    public $timestamps = true;
    protected $fillable = [
        'fkUserId',
        'userIp',
        'fkProductId',
    ];
}
