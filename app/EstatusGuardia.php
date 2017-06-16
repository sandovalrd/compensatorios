<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstatusGuardia extends Model
{
    protected $table = 'statusGuards';

    protected $fillable = ['description'];

    public function guardia(){

    	return $this->hasMany('App\Guardia');

    }

}

