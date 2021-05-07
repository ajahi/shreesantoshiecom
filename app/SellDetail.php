<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellDetail extends Model
{
    protected $fillable=['product_id','sell_id','quantity','status','price'];
    public function sell(){
        return $this->belongsTo('App\sell');
    }
    public function product(){
        return $this->belongsTo('App\Product');
    }
}
