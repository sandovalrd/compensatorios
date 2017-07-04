<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ControlGuardias extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siscomp:controlweek';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Realiza el cambio de guardia semanal';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $guardias = DB::table('guards')
            ->orderby('group_id', 'ASC')
            ->orderby('orden', 'ASC')
            ->get();
        $resta=1;
        $grupo=1;
        foreach ($guardias as $guardia) {  // ejecuta la guardia
            $orden = $guardia->orden;
            $cont=$orden;
            if($grupo<>$guardia->group_id){
                $resta=1;
                $grupo=$guardia->group_id;
            }

            $date= new Carbon('next Thursday');
            $date->addDays(-7);
            $fecha = $date;    
            $cont=$cont-$resta;
            $dias = $cont*7;
            $fecha->addDays($dias);

            DB::table('guards')
            ->where('id', '=',$guardia->id)
            ->update(['orden' => ($orden-$resta), 'date_begin'=>$fecha, 'estatus_guardia_id'=>1 ]);

            if($guardia->estatus_guardia_id==3){
                $resta++;
            }
        }

        $guardias = DB::table('guards') // Mueve el ultima guardia al final de la fila
            ->where('orden', '=', 0)
            ->get();

        foreach ($guardias as $guardia) { 
            $mayor = DB::table('guards')
                ->where('group_id', '=', $guardia->group_id)
                ->max('orden');
            $cont=$mayor+1;

            $date= new Carbon('next Thursday');
            $date->addDays(-7);

            $fecha = $date;
            //$cont--;
            $dias = $cont*7;
            $fecha->addDays($dias);

            DB::table('guards')
                ->where('id', '=' ,$guardia->id)
                ->update(['orden' => ($mayor+1), 'date_begin'=>$fecha, 'estatus_guardia_id'=>1 ]);

            $this->info('Las guardias se ejecutaron perfectamente para todos los grupos');

        }
        
        

        $date= new Carbon('next Thursday');
        $date->addDays(-14);  // -14


        $this->info('mensaje ' . $date);


        $guardias = DB::table('guards_history')
            ->where('date_begin', '=', $date)
            //->where('user_id','=', 16)
            ->get();

        foreach ($guardias as $guardia) {

            $Compensatorio = DB::table('compensatories')
                ->where('user_id', $guardia->user_id)
                ->first();

           if($Compensatorio){
                
                $days = $Compensatorio->days + $guardia->days;

                DB::table('compensatories') 
                    ->where('user_id', $Compensatorio->user_id)
                    ->update(['days' => $days]);
            }else{

                DB::table('compensatories')->insert([
                    'user_id'       => $guardia->user_id, 
                    'days'          => $guardia->days,
                    'days_request'  => 0,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                    ]
                );
            }

        }

    }
}
