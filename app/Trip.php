<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    public $timestamps = false;
    
    public function route(){
    	return $this->belongsTo(Route::class);
    }
    public function vehicle(){
    	return $this->belongsTo(vehicle::class);
    }
}
