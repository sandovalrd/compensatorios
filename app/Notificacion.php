<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones';

    protected $fillable = ['tipo', 'user_id', 'fecha', 'grupo_id', 'desde', 'status'];
}
