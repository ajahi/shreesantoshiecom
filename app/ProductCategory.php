<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class ProductCategory extends Model
{
    use HasMediaTrait;
    protected $fillable = ['title', 'slug', 'description','parent_id','position'];

    public function children() {
        return $this->hasMany('App\ProductCategory','parent_id');
    }
    public function parent() {
        return $this->belongsTo('App\ProductCategory','parent_id');
    }
    public function products(){
        return $this->hasMany('App\Products');
    }
}
