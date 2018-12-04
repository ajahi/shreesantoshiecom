<?php

namespace App\Modules\Post\Models;


use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Post extends Model implements HasMedia {

    use HasMediaTrait;
    protected $fillable = [
        'title', 'description','icon','status','category_id'
    ];


    public function category() {
        return $this->belongsTo('App\Modules\Category\Models\Category');
    }

}