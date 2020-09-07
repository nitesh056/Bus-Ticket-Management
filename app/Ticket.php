<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function trip(){
    	return $this->belongsTo(trip::class);
    }
}
