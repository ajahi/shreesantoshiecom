<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Menu extends Model implements HasMedia
{

    use HasMediaTrait;
    protected $fillable = [
        'title', 'description', 'position','parent_id'
    ];
    public function children() {
        return $this->hasMany('App\Menu','parent_id');
    }
    public function parent() {
        return $this->belongsTo('App\Menu','parent_id');
    }


}
