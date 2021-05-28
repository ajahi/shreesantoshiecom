<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'firstname','lastname','email','phone_number','address','message'
    ];
}