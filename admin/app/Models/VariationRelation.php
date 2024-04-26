<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VariationRelation extends Model
{
    use HasFactory;
    protected $table = "variation_relation";
    protected $primaryKey = "variationRelationId";
    public $timestamps = false;
    protected $fillable = [
        'skuId',
        'productId',
        'variationId',
    ];

    public function variation(): HasOne
    {
        return $this->hasOne(Variation::class, 'variationId', 'variationId');
    }
}
