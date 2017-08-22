<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Compensatorio;
use Carbon\Carbon;


class Compensatorio extends Model
{
    protected $table = 'compensatories';

    protected $fillable = ['days', 'days_request', 'user_id'];

    public function user(){

    	return $this->hasMany('App\User');

    }

    public static function show($grupo, $order){

    	$users = DB::table('users')
            ->join('compensatories', 'users.id', '=', 'compensatories.user_id')
            ->select('users.*', 'compensatories.*')
            //->where('users.group_id', '=', $grupo)
            ->where([
                    ['users.group_id', '=', $grupo],
                    ['compensatories.days', '>', 0]])
                    
            ->orderby($order, 'DESC')
            ->get();

         return $users;
    
    }

    public static function disponibles($user_id){

    	$hoy  = new Carbon('last thursday');   

    	$compensatorios = DB::table('users')
            ->join('guards_history', 'users.id', '=', 'guards_history.user_id')
            ->select('users.*', 'guards_history.*')
            ->where([
                    ['users.id', '=', $user_id],
                    ['guards_history.date_begin', '<', $hoy],
                    ['guards_history.estatus_guardia_id', '=', 2]])
            ->orderby('guards_history.date_begin', 'ASC')
            ->get();

        return $compensatorios;
    }

    public static function solicitar($id, $valor, $tipo, $user_id){

    	$compensatorio = Compensatorio::where('user_id', '=', $user_id)->first();
    	$history = DB::table('guards_history')
                     ->select('*')
                     ->where('id', '=', $id)
                     ->first();


    	$disponible = $history->days; 
    	$solicitado = $history->days_request; 

    	if($tipo==1){
    		$disponible = $disponible - $valor;
    		$solicitado = $solicitado + $valor;
    		$compensatorio->days = $compensatorio->days - $valor;
    		$compensatorio->days_request = $compensatorio->days_request + $valor;
    	}else{
    		$disponible = $disponible + $valor;
    		$solicitado = $solicitado - $valor;
    		$compensatorio->days = $compensatorio->days + $valor;
    		$compensatorio->days_request = $compensatorio->days_request - $valor;
    	}

    	$compensatorio->save();

    	DB::table('guards_history')
            	->where('id', $id)
            	->update(['days' => $disponible, 'days_request'=>$solicitado]);

    }

    public static function aprobar($user_id){
    	$compensatorio = Compensatorio::where('user_id', '=', $user_id)->first();
    	$dias = $compensatorio->days_request;
    	$compensatorio->days_request = 0;
    	$status = 0;
    	$compensatorio->save();

		$historicos = DB::table('guards_history')
		                     ->select('*')
		                     ->where([
                    				['user_id', '=', $user_id],
                    				['days_request', '>', 0]])
		                     ->get();
		
		foreach ($historicos as $history) {
			if($history->days==0){
				$status = 4;
			}else{
				$status = 2;
			}
			$disfrutados = $history->days_take;
			DB::table('guards_history')
        	->where('id', $history->id)
        	->update([
        		'days_take' 			=> $history->days_request + $disfrutados, 
        		'estatus_guardia_id'	=> $status,
        		'days_request'			=> 0
        	]);			
		}
    }
}
