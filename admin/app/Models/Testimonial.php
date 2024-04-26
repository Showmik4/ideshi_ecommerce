<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;
    protected $table = "testimonial";
    protected $primaryKey = "testimonialId";
    public $timestamps = true;
    protected $fillable = [
        'name',
        'designation',
        'imageLink',
        'details',
        'status',
        'homeShow',
    ];
}
