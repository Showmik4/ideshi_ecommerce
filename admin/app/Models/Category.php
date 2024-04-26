<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory;
    protected $table = "category";
    protected $primaryKey = "categoryId";
    public $timestamps = true;
    protected $fillable = [
        'categoryName',
        'parent',
        'subParent',
        'homeShow',
        'imageLink',
        'bannerLink',
        'category_serial',
        'gender',
    ];

    public function parentCategory(): HasOne
    {
        return $this->hasOne(__CLASS__, 'categoryId', 'parent');
    }
}
