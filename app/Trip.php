<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    public $timestamps = false;
    protected $casts = [
        'allocated_seats' => 'array'
    ];
    public function route(){
    	return $this->belongsTo(Route::class);
    }
    public function vehicle(){
    	return $this->belongsTo(vehicle::class);
    }
}
