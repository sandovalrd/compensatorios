<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Compensatorio;
use App\Notificacion;
use Carbon\Carbon;
use Jenssegers\Date\Date;
use App\Group;
use App\User;
use App\Email;

class SolicitudCompensatorioControllers extends Controller
{


    public function __construct()
    {
        $this->middleware(['auth', 'CheckRol:user']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $group_id = Auth::user()->group_id;
        $user_id = Auth::user()->id;
        $group = Group::where('id', '=', $group_id )->first();
        $compensatorios = Compensatorio::show($group_id, 'days_request');

        return view('solicitud.index')
            ->with('group', $group)
            ->with('user_id', $user_id)
            ->with('compensatorios', $compensatorios);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $disponibles=Compensatorio::disponibles($id);
        //dd($disponibles);
        $notificar = Notificacion::where([
                ['status', 0],
                ['user_id', $user->id]
                ])->count();

        //Compensatorio::aprobar(1);

        return view('solicitud.edit')
            ->with('disponibles', $disponibles)
            ->with('notificar', $notificar)
            ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function solicitar(Request $request){

        //$compensatorio = compensatorio::find($id);
        

        if($request->ajax()){

            $id     = $request->id;
            $valor  = $request->valor;
            $tipo   = $request->tipo;
            $user_id= $request->user_id;
            $fecha  = $request->fecha;
            $desde  = $request->desde;


            $user = User::find($user_id);

            Compensatorio::solicitar($id, $valor, $tipo, $user_id);
            
            if ($tipo==1){
                $fecha2  = new Date($desde); 
                $fecha2 = $fecha2->format('l d \\d\\e F Y');
                Email::guardarNotificacion(3, $user_id, $fecha, $user->group_id, $fecha2, $valor);
            }else{
                Email::guardarNotificacion(4, $user_id, $fecha, $user->group_id);
            }

            return response()->json([
                'id'      =>  $request->id,
                'valor'   =>  $request->valor,
                'tipo'    =>  $request->fecha
            ]);
        }

        //return redirect()->route('solicitud.index');
    }

    public function aprobar(Request $request){

        if($request->ajax()){
            $fecha = Carbon::now();
            $user = User::find($request->user_id);
            Compensatorio::aprobar($user->id);
            Email::guardarEmail(5, $user->id, $fecha, $user->group_id);
            return response()->json([
                'id'      =>  1,
                'valor'   =>  2,
                'tipo'    =>  3
            ]);
        }
    }

    public function notificar(){

        $group_id = Auth::user()->group_id;
        $user_id = Auth::user()->id;

        Email::guardarEmail(3, $user_id, 'fecha', $group_id);
        Email::guardarEmail(4, $user_id, 'fecha', $group_id);

        return redirect()->route('solicitud.index');

    }
}
