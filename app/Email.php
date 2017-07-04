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


    public static function guardarEmail($tipo, $user_id, $fecha, $grupo_id){
    	$dominio = '@pdvsa.com';
    	$user = User::find($user_id);

    	$fecha  = new Date(); 

    	$fecha = $fecha->format('l d, F Y'); 

    	$supervisores = User::searchSupervisor($grupo_id);
    	$cc='[';

    	foreach ($supervisores as $supervisor) {
    		$cc = $cc . $supervisor->username . $dominio . ',';

    	}

    	$to = $user->username . $dominio;

    	if($tipo==1){ // Guardia aceptada
    		$message='Se informa que el empleado ' . $user->name . ' ' . $user->lastname  .' acepto la guardia correspondiente al ' . $fecha;
    		$subject = "Próxima guardia";
    		$cc = $cc . ']';
    	}
		if($tipo==2){ // Guardia Rechazada
			$message='Se informa que el empleado ' . Auth::user()->name . ' ' . Auth::user()->lastname  .' cambio la guardia correspondiente al ' . $fecha .', por tal motivo usted es el próximo en el orden de la misma';
    		$subject = "Cambio de guardia";
    		$cc = $cc . Auth::user()->username . $dominio . ']';
		}

		if($tipo==3){ // Solicitar compensatorio
			$message='Se informa que el empleado ' . $user->name . ' ' . $user->lastname  .' ha solicitado días compensatorios, por lo que se requiere de su aprobación';
    		$subject = "Solicitud de compensatorios";
    		$cc = $cc . ']';

    		$copia 	= $to;
    		$to 	= $cc;
    		$cc 	= $copia;
		}

		if($tipo==4){ // anular solicitud de compensatorio
			$message='Se informa que el empleado ' . $user->name . ' ' . $user->lastname  .' ha anulado la solicitud de días compensatorios, por lo que ya no se requiere de su aprobación';
    		$subject = "Solicitud Anulada";
    		$cc = $cc . ']';

    		$copia 	= $to;
    		$to 	= $cc;
    		$cc 	= $copia;
		}

		if($tipo==5){ // aprobar compensatorio
			$message='Estimado Sr.(a) ' . $user->name . ' ' . $user->lastname  .', el presente es para comunicarle que su solicitud de compensatorio ha sido aprobada por el supervisor ' . Auth::user()->name . ' ' . Auth::user()->lastname ;
    		$subject = "Solicitud Aprobada";
    		$cc = $cc . ']';

		}


    	

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
