<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $table = "slider";
    protected $primaryKey = "sliderId";
    public $timestamps = false;
    protected $fillable = [
        'titleText',
        'mainText',
        'subText',
        'imageLink',
        'status',
        'pageLink',
        'serial',
    ];
}
