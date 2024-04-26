<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;
    protected $table='batch';
    protected $primaryKey='batchId';

   public function sku()
   {
       return $this->hasOne('App\Models\Sku', 'skuId', 'skuId');
   }

   public function stock()
   {
       return $this->hasOne('App\Models\Stock', 'batchId', 'batchId');
   }

   public function in()
    {
        return $this->hasMany('App\Models\Stock', 'batchId', 'batchId')->where('type','in');
    }

    public function out()
    {
        return $this->hasMany('App\Models\Stock', 'batchId', 'batchId')->where('type','out');
    }

    public function vendorData()
    {
        return $this->hasOne('App\Models\Vendor', 'vendor_id', 'vendor');
    }

    public function store(){
       return $this->hasOne('App\Models\Store', 'storeId', 'storeId');
    }
}
