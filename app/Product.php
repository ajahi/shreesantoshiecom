<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use App\Http\Resources\Media as MediaResource;
use Spatie\MediaLibrary\Models\Media;

class Product extends Model implements HasMedia
{
    use HasMediaTrait;
    protected $fillable=['title','description','slug','purchase_price','sell_price','user_id','counts','quantity','position','status'];

    public function categories() {
        return $this->belongsToMany('App\ProductCategory','product_product_categories')->withPivot('product_id');
    }
    public function user() {
        return $this->belongsTo('App\User');
    }
    public  function photo(){
        if (count($this->getMedia('')) > 0) {
            return MediaResource::collection($this->getMedia(''));
        }

    }
    public function tags(){
        return $this->belongsToMany('App\Tag');
    }

}
