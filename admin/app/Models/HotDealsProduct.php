<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class HotDealsProduct extends Model
{
    use HasFactory;
    protected $table ='hotdeals_product';
    protected $primaryKey='hotdeals_productID';
    public $timestamps = false;


    public function product()
    {
        return $this->hasOne('App\Models\Product', 'productId', 'fkproductId');
    }
    public function hotdeals()
    {
        return $this->hasOne('App\Models\HotDeal', 'hotDealId', 'fkhotdealsId');
    }
}
