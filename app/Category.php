<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Category extends Model implements HasMedia {

    use HasMediaTrait;
    protected $fillable = [
        'title', 'description','position'
    ];

    public function posts() {
        return $this->hasMany('App\Post');
    }

}
