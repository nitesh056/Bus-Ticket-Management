<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public $timestamps = false;
    
    public function trip(){
    	return $this->belongsTo(trip::class);
    }
    public function user(){
    	return $this->belongsTo(User::class);
    }
}
