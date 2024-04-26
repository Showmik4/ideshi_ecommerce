<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = "contact";
    protected $primaryKey = "contactId";
    public $timestamps = true;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
    ];
}
