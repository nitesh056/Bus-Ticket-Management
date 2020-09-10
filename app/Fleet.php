<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fleet extends Model
{
    public $timestamps = false;
    
    public function vehicle(){
        return $this->hasMany(Vehicle::class);
    }
}
