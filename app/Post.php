<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model implements HasMedia {

    use HasMediaTrait;
    use HasSlug;
    protected $fillable = [
        'title', 'description','icon','status','category_id', 'attributes','user_id','meta_description'
    ];


    public function category() {
        return $this->belongsTo('App\Category');
    }
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function tags() {
        return $this->belongsToMany('App\Tag');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->usingSeparator(env('SLUG',"-"));
    }
}
