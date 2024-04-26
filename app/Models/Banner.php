<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Banner extends Model
{
    use HasFactory;
    protected $table = "banner";
    protected $primaryKey = "bannerId";
    public $timestamps = false;
    protected $fillable = 
    [
        'bannerTitle',
        'imageLink',
        'type',
        'status',
        'pageLink',
        'fkPromotionId',
        
    ];

    public function promotion(): HasOne
    {
        return $this->hasOne(Promotion::class, 'promotionId', 'fkPromotionId');
    }

  
        
}
