<?php

namespace App\Modules\Site\Models;


use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Site extends Model implements HasMedia {

    use HasMediaTrait;
    protected $fillable = [
        'title', 'slogan', 'description', 'logo', 'website', 'email', 'location', 'telephone', 'working_days', 'facebook', 'google', 'twitter', 'instagram', 'linkedin', 'skype', 'attributes'
    ];


}
