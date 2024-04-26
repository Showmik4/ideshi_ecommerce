<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLog extends Model
{
    use HasFactory;
    protected $table = "order_log";
    protected $primaryKey = "orderLogId";
    public $timestamps = true;

    protected $fillable = [
        'fkOrderId',
        'status',
        'addedBy',       
    ];

    public function author()
    {
        return $this->hasOne('App\Models\User', 'userId', 'addedBy');
    }

    public function order()
    {
        return $this->hasOne('App\Models\Order', 'orderId', 'orderId');
    }

}
