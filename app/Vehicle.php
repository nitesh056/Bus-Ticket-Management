<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    public $timestamps = false;
    
    public function fleet(){
    	return $this->belongsTo(Fleet::class);
    }
    public function trip(){
        return $this->hasMany(Trip::class);
    }
}
