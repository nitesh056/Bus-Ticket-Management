<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    public function getRouteName(){
    	return $this->starting_destination * $this->ending_destination;
    }
}
