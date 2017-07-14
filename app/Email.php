<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Jenssegers\Date\Date;
use App\User;

class Email extends Model
{
    protected $table = 'email';

    protected $fillable = ['subject', 'to', 'cc', 'message', 'status'];


    public static function guardarEmail($tipo, $user_id, $fecha, $grupo_id, $desde = null){
    	$dominio = '@pdvsa.com';
    	$user = User::find($user_id);
    	$cc='';
    	$email = false;

    	if($tipo==1 || $tipo == 2){
    		$fecha  = new Date($fecha); 
    		$fecha = $fecha->format('l d \\d\\e F Y');  
    	}

    	$supervisores = User::searchSupervisor($grupo_id);

     	foreach ($supervisores as $supervisor) {
    		$cc = $cc . $supervisor->username . $dominio . ',';
    	}

    	$long = strlen($cc)-1;
    	$cc = substr($cc, 0, $long);

    	$to = $user->username . $dominio;

    	if($tipo==1){ // Guardia aceptada
    		$message='Se informa que el empleado ' . $user->name . ' ' . $user->lastname  .' acepto la guardia correspondiente al ' . $fecha .'.';
    		$subject = "Próxima guardia";
    		$email = true;
    	}
		if($tipo==2){ // Guardia Rechazada
			$message='Se informa que el empleado ' . Auth::user()->name . ' ' . Auth::user()->lastname  .' cambio la guardia correspondiente al ' . $fecha .', por tal motivo usted es el próximo en el orden de la misma';
    		$subject = "Cambio de guardia";
    		$cc = $cc . Auth::user()->username . $dominio . ']';
    		$email = true;
		}

		if($tipo==3){ // Solicitar compensatorio
			
    		$fecha  = ''; 
    		$desde 	= '';
    		$cont	= 0;

    		$notificaciones = DB::table('notificaciones')
	            ->select('*')
	            ->where([
                    ['user_id', '=', $user->id],
                    ['tipo', 	'=', $tipo],
                    ['status', 	'=', 0], 
            		])
	            ->get();

	        foreach ($notificaciones as $notificacion) {
	        	$cont++;
				$fecha2  = new Date($notificacion->desde); 
    			$fecha2 = $fecha2->format('l d \\d\\e F Y');  

    			if($cont == $notificaciones->count() && $cont !=1){
    				$long = strlen($fecha)-2;
    				$fecha = substr($fecha, 0, $long);
    				$long = strlen($desde)-2;
    				$desde = substr($desde, 0, $long);
    				$fecha =  $fecha . ' y ' . $notificacion->fecha . ', ';
	        		$desde =  $desde . ' y ' . $fecha2 . ' respectivamente';

    			}else{

	        		$fecha = $fecha . $notificacion->fecha . ', ';
	        		$desde = $desde . $fecha2 . ', ';
    			}
	        	$email = true;

	        	DB::table('notificaciones') 
                    ->where('id', $notificacion->id)
                    ->update(['status' => 1]);
                
	        }

			$message='Se informa que el empleado ' . $user->name . ' ' . $user->lastname  .' ha solicitado días compensatorios, correspondiente a la(s) guardia(s) del ' . $fecha . 'por lo que se requiere de su aprobación, ';
			$message = $message . 'los mismos serán tomados a partir del ' . $desde .'.';

    		$subject = "Solicitud de compensatorios";

    		$copia 	= $to;
    		$to 	= $cc;
    		$cc 	= $copia;
		}

		if($tipo==4){ // anular solicitud de compensatorio


    		$fecha  = ''; 
    		$cont 	= 0;

    		$notificaciones = DB::table('notificaciones')
	            ->select('*')
	            ->where([
                    ['user_id', '=', $user->id],
                    ['tipo', 	'=', $tipo],
                    ['status', 	'=', 0], 
            		])
	            ->get();

	        foreach ($notificaciones as $notificacion) {

	        	$cont++;
    			if($cont == $notificaciones->count() && $cont !=1){
    				$long = strlen($fecha)-2;
    				$fecha = substr($fecha, 0, $long);
    				$fecha =  $fecha . ' y ' . $notificacion->fecha . ', ';
    			}else{
	        		$fecha = $fecha . $notificacion->fecha . ', ';
    			}
	        	$email = true;

	        	DB::table('notificaciones') 
                    ->where('id', $notificacion->id)
                    ->update(['status' => 1]);
                
	        }

			$message='Se informa que el empleado ' . $user->name . ' ' . $user->lastname  .' ha anulado la solicitud de días compensatorios, correspondiente a la(s) guardia(s) del ' . $fecha . 'por lo que ya no se requiere de su aprobación.';
    		$subject = "Solicitud Anulada";

    		$copia 	= $to;
    		$to 	= $cc;
    		$cc 	= $copia;
		}

		if($tipo==5){ // aprobar compensatorio
			$message='Estimado Sr.(a) ' . $user->name . ' ' . $user->lastname  .', el presente es para comunicarle que su solicitud de compensatorios ha sido aprobada por el supervisor ' . Auth::user()->name . ' ' . Auth::user()->lastname ;
    		$subject = "Solicitud Aprobada";
    		$email = true;

		}

		if($email){
			DB::table('email')->insert([
				'subject' 	=> $subject,
				'to' 		=> $to,
				'cc'		=> $cc,
				'message'	=> $message,
				'created_at' => Date::now(),
	            'updated_at' => Date::now()
				]
			);
		}
    }

    public static function guardarNotificacion($tipo, $user_id, $fecha, $grupo_id, $desde = null){

    	DB::table('notificaciones')->insert([
			'tipo' 		=> $tipo,
			'user_id' 	=> $user_id,
			'fecha'		=> $fecha,
			'grupo_id'	=> $grupo_id,
			'desde'		=>	$desde,
			'created_at' => Date::now(),
            'updated_at' => Date::now()
			]
		);
    }
}
