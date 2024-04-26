<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Menu extends Model
{
    use HasFactory;
    protected $table = "menu";
    protected $primaryKey = "menuId";
    public $timestamps = true;
    protected $fillable = [
        'menuName',
        'parent',
        'menuOrder',
        'menuType',        
        'status',
        'fkPageId',
    ];

    public function page(): HasOne
    {
        return $this->hasOne(Page::class, 'pageId', 'fkPageId');
    }

    public function parentMenu(): HasOne
    {
        return $this->hasOne(__CLASS__, 'menuId', 'parent');
    }
}
