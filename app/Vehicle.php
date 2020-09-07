<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    public function fleet(){
    	return $this->belongsTo(Fleet::class);
    }
}
