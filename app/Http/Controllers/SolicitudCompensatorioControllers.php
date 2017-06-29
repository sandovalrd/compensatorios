<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Compensatorio;
use App\Group;
use App\User;

class SolicitudCompensatorioControllers extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
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

        //dd($compensatorios);
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

        //Compensatorio::aprobar(1);

        return view('solicitud.edit')
            ->with('disponibles', $disponibles)
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

            Compensatorio::solicitar($id, $valor, $tipo, $user_id);
            return response()->json([
                'id'      =>  $request->id,
                'valor'   =>  $request->valor,
                'tipo'    =>  $tipo
            ]);
        }

        //return redirect()->route('solicitud.index');
    }

    public function aprobar(Request $request){
        if($request->ajax()){
            $user_id = $request->user_id;            
            Compensatorio::aprobar($user_id);
            return response()->json([
                'id'      =>  1,
                'valor'   =>  2,
                'tipo'    =>  3
            ]);
        }
    }
}
