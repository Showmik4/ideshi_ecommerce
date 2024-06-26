<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    use HasFactory;
    protected $table = "variation";
    protected $primaryKey = "variationId";
    public $timestamps = false;
    protected $fillable = [
        'variationType',
        'selectionType',
        'variationValue',
    ];
}
