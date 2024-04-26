<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    use HasFactory;
    protected $table = "meta_data";
    protected $primaryKey = "metaId";
    public $timestamps = false;
    protected $fillable = [
        'metaName',
        'metaContent',
    ];
}
