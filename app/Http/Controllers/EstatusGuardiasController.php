<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Guardia;
use App\Group;
use App\User;
use App\Email;
use App\EstatusGuardia;
use Mail;

class EstatusGuardiasController extends Controller
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
    public function index(Request $request)
    {

        $group_id = Auth::user()->group_id;

        $group = Group::where('id', '=', $group_id )->first();
        $guardias = Guardia::guardias($group_id)->get();
        
        return view('guardias.index')
            ->with('group_id', $group_id)
            ->with('guardias', $guardias)
            ->with('group', $group);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
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

        $estatus = EstatusGuardia::where([['id','<>',4],['id','<>',1]])->pluck('description', 'id');
        return view('guardias.edit')
            ->with('estatus', $estatus)
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

        $user = User::find($id);
        $guardia = Guardia::where('user_id', '=', $id)->first();
        $fecha = $guardia->date_begin;

        if($request->estatus_id==3){    //Guardia rechazada
            $count = Guardia::where('group_id', '=', $user->group_id)->count();
            if($guardia->orden==$count){
                 Flash('No hay usuarios disponibles para la próxima guardia!')->error();
            }else{
                $orden = $guardia->orden;
                $orden++;
                $guardia = Guardia::where([
                    ['group_id', '=', $user->group_id],
                    ['orden', '=', $orden],
                ])->first();
                Guardia::estatusUpdate($id, $request->estatus_id);
                Guardia::dateUpdate($guardia->user_id, $fecha); 
                Email::guardarEmail(2, $guardia->user_id, $fecha, $user->group_id);
                Flash('Guardia rechazada!')->success()->important();             
            }
        }else{

            // Cambiar el estatus de la guardia
            Guardia::estatusUpdate($id, $request->estatus_id);
            // Guardar en el historial de guardias
            Guardia::guardarHistorial($guardia);
            Email::guardarEmail(1, $user->id, $fecha, $user->group_id);
            Flash('Guardia aceptada!')->success()->important();
        }
        

        

        return redirect()->route('guardia.index', 'group_id=' . $user->group_id);
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
}
