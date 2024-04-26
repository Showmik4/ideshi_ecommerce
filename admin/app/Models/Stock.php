<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $table = "stock_record";
    protected $primaryKey = "stock_recordId";
    public $timestamps = false;
    protected $fillable = [
        'fkskuId',
        'batchId',
        'stock',
        'type',
        'identifier',
    ];
}
