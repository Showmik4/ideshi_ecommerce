<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotDeal extends Model
{
    use HasFactory;
    protected $table = "hotdeals";
    protected $primaryKey = "hotDealId";
    public $timestamps = false;
    protected $fillable = [
        'hotDealName',
        'startDate',
        'endDate',
        'amount',
        'percentage',
        'imageLink',
        'status',
    ];
}
