<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Guardia extends Model
{
    protected $table = 'guards';

    protected $fillable = ['date_begin', 'orden', 'days', 'estatus_guardia_id', 'user_id', 'group_id'];

    public function user(){

    	return $this->hasMany('App\User');

    }

    public function group(){

        return $this->belongsTo('App\Group');
        
    }

    public function estatus(){

        return $this->belongsTo('App\EstatusGuardia');

    }

    public static function estatusUpdate($id, $estatus){
        DB::table('guards')
            ->where('user_id', $id)
            ->update(['estatus_guardia_id' => $estatus]);
    }

    public static function dateUpdate($id, $fecha){
        DB::table('guards')
            ->where('user_id', $id)
            ->update(['date_begin' => $fecha]);
    }

    public static function orden($grupo){

        return $max = Guardia::where('group_id', '=', $grupo)->max('orden') + 1;
    }

    public static function proxFecha($orden){

        $fecha = new Carbon('next thursday');    
        if ($orden>1){
            $orden--;
            $dias = $orden*7;
            $fecha->addDays($dias);
        }
        
        
        //$date = Guardia::where('group_id', '=', $grupo)->pluck('date_begin');
        //$fecha = Carbon::createFromFormat('Y-m-d', $date[0]); 

        return $fecha->format('d-m-Y');
    }

    public function scopeSearch($query, $id){


        $guardias = DB::table('users')
            ->join('guards', 'users.id', '=', 'guards.user_id')
            ->select('users.*', 'guards.*')
            ->where('guards.group_id', '=', $id)
            ->orderby('guards.orden', 'ASC');
    

        return $guardias;

    }


    public function scopeGuardias($query, $id){


        $guardias = DB::table('guards')
            ->join('users', 'guards.user_id', '=', 'users.id')
            ->join('statusGuards', 'guards.estatus_guardia_id', '=', 'statusGuards.id')
            ->select('users.*', 'guards.*', 'statusGuards.*')
            ->where('guards.group_id', '=', $id)
            ->orderby('guards.orden', 'ASC');
    
        return $guardias;

    }

    public static function home($fecha){

        $guardias = DB::table('guards')
            ->join('users', 'guards.user_id', '=', 'users.id')
            ->join('statusGuards', 'guards.estatus_guardia_id', '=', 'statusGuards.id')
            ->join('groups', 'guards.group_id', '=', 'groups.id')
            ->select('users.*', 'guards.*', 'statusGuards.*', 'groups.name as grupo')
            ->where([
                    ['guards.date_begin', '=', $fecha],
                    ['guards.estatus_guardia_id', '<>', 3], //Estatus diferente a rechazado
            ]);
    
        return $guardias;

    }

    public static function history($fecha){

        $guardias = DB::table('guards_history')
            ->join('users', 'guards_history.user_id', '=', 'users.id')
            ->join('statusGuards', 'guards_history.estatus_guardia_id', '=', 'statusGuards.id')
            ->join('groups', 'guards_history.group_id', '=', 'groups.id')
            ->select('users.*', 'guards_history.*', 'statusGuards.*', 'groups.name as grupo')
            ->where([
                    ['guards_history.date_begin', '=', $fecha],
                    ['guards_history.estatus_guardia_id', '<>', 3], //Estatus diferente a rechazado
            ]);
    
        return $guardias;

    }

    public static function guardarHistorial($guardia){ //Historia de Guardias
        
        DB::table('guards_history')->insert([
            'date_begin' => $guardia->date_begin, 
            'days' => $guardia->days, 
            'days_take' => 0, 
            'days_request' => 0,
            'user_id' => $guardia->user_id, 
            'estatus_guardia_id' => 2, // estatus aceptada
            'group_id' => $guardia->group_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }


}
