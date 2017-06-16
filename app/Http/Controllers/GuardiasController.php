<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreGuardiaRequest;
use App\Group;
use App\User;
use App\Guardia;
use Jenssegers\Date\Date;

class GuardiasController extends Controller
{

    public function __construct(){

        Date::setLocale('es');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getChange(Request $request){

        if($request->ajax()){

            $guardia1 = Guardia::find($request->id1);
            $guardia2 = Guardia::find($request->id2);

            $fecha1 = $guardia1->date_begin;
            $orden1 = $guardia1->orden;

            $guardia1->date_begin = $guardia2->date_begin;
            $guardia1->orden = $guardia2->orden;

            $guardia2->date_begin = $fecha1;
            $guardia2->orden = $orden1;        
            
            $guardia1->save();
            $guardia2->save();

            return response()->json([
                'id1'      =>  $request->id1,
                'id2'      =>  $request->id2
            ]);
        }
    }

    public function index(Request $request)
    {

        if(!$request->group_id){
            $group_id = 1; // por defecto trae a Soporte Tecnico especializado
        }else{
            $group_id = $request->group_id;
        }
        $groups = Group::orderBy('name', 'ASC')->pluck('name', 'id');
        $guardias = Guardia::search($group_id)->paginate(10);

        return view('admin.guardias.index')
            ->with('group_id', $group_id)
            ->with('guardias', $guardias)
            ->with('groups', $groups);

    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $group = Group::find($id);
        $users = User::username($group->id); //->pluck('username', 'id'); ///ojo
        //dd($users);
        return view('admin.guardias.create')
            ->with('users', $users)
            ->with('group', $group);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGuardiaRequest $request)
    {

       $guardia = new Guardia();
       $orden = Guardia::orden($request->group_id);
       
       $fecha = Guardia::proxFecha($orden);
       $fecha = Date::createFromFormat('d-m-Y', $fecha);
       $guardia->orden=$orden;
       $guardia->days=$request->days;
       $guardia->user_id=$request->user_id;
       $guardia->group_id=$request->group_id;
       $guardia->estatus_guardia_id=1; // Estatus Pendiente
       $guardia->date_begin=$fecha;
       $guardia->save();

       Flash('Guardia creada con exito!')->success()->important();

       return redirect()->route('guardias.index', 'group_id=' . $request->group_id);
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
        $guardia = Guardia::find($id);
        $user = User::find($guardia->user_id);
        return view('admin.guardias.edit')
            ->with('guardia', $guardia)
            ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreGuardiaRequest $request, $id)
    {
        $guardia = Guardia::find($id);
        $guardia->days=$request->days;
        $guardia->save();

        return redirect()->route('guardias.index',  'group_id=' . $guardia->group_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $guardia = Guardia::find($id);
        $user = User::find($guardia->user_id);
        $guardia->delete();
        

        Flash('El usuario ' . $user->name . ' fue Eliminado de la guardia!')->success()->important();
        return redirect()->route('guardias.index',  'group_id=' . $guardia->group_id);
    }
}
