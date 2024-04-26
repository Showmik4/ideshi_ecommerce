<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = "transaction";
    protected $primaryKey = "transactionId";
    public $timestamps = false;

  
    // protected $fillable = [
    //     'fkskuId',
    //     'batchId',
    //     'stock',
    //     'type',
    //     'identifier',
    // ];
}
