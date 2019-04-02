<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Post extends Model implements HasMedia {

    use HasMediaTrait;
    protected $fillable = [
        'title', 'description','icon','status','category_id', 'attributes','slug','user_id'
    ];


    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function tag() {
        return $this->hasMany('App\Tag');
    }

}