<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Adldap\Laravel\Facades\Adldap;
use Laracasts\Flash\Flash;
use Jenssegers\Date\Date;
use App\User;
use App\Group;
use App\Guardia;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //dd($request);
        if(!$request->group_id){
            $group_id = 1; // por defecto trae a Soporte Tecnico especializado
        }else{
            $group_id = $request->group_id;
        }
        $users = User::search($group_id)->paginate(10);
        $groups = Group::orderBy('name', 'ASC')->pluck('name', 'id');
        $users->each(function( $users ){
            $users->group;
        });

        return view('admin.users.index')
            ->with('users', $users)
            ->with('group_id', $group_id)
            ->with('groups', $groups);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('admin.users.create')->with('groups', $groups);
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
                
        if($request->ajax()){
            $username = $request->username;
            $user = Adldap::search()->users()->find($username);
            if($user){
                $name = $user->givenname;
                $lastname = explode(" ", $user->displayname[0],2);
                $ext = $user->ipphone;
                $phone = $user->mobile;
            }else{
                $name = "";
                $lastname[0] = "";
                $ext = "";
                $phone = "";
            }

            return response()->json([
                'name'      =>  $name,
                'lastname'  =>  $lastname[0],
                'ext'       =>  $ext,
                'phone'     =>  $phone

            ]);
        }

        $user = new User($request->all());
        $user->save();

        if($request->agregar=='1'){ // Agregar la guardia
           $guardia = new Guardia();
           $orden = Guardia::orden($request->group_id);
           $fecha = Guardia::proxFecha($orden);
           $fecha = Date::createFromFormat('d-m-Y', $fecha);
           $guardia->orden=$orden;
           $guardia->days=2;
           $guardia->user_id=$user->id;
           $guardia->group_id=$request->group_id;
           $guardia->estatus_guardia_id=1; // Estatus Pendiente
           $guardia->date_begin=$fecha;
           $guardia->save();
        }

        $user->roles()->attach(1); // Rol Usuario
        

        Flash('Empleado creado con exito!')->success()->important();

        return redirect()->route('users.index', 'group_id=' . $request->group_id);
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
        $groups = Group::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('admin.users.edit')
            ->with('user', $user)
            ->with('groups', $groups);
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

        if($request->ajax()){
            $username = $request->username;
            $user = Adldap::search()->users()->find($username);
            if($user){
                $name = $user->givenname;
                $lastname = explode(" ", $user->displayname[0],2);
                $ext = $user->ipphone;
                $phone = $user->mobile;
            }else{
                $name = "";
                $lastname[0] = "";
                $ext = "";
                $phone = "";
            }

            return response()->json([
                'name'      =>  $name,
                'lastname'  =>  $lastname[0],
                'ext'       =>  $ext,
                'phone'     =>  $phone

            ]);
        }

        
        $user = User::find($id);
        $user->username = $request->username;
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->ext = $request->ext;
        $user->phone = $request->phone;
        $user->group_id = $request->group_id;
        $user->save();

        Flash('Usuario Modificado!')->success()->important();
        return redirect()->route('users.index',  'group_id=' . $user->group_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        Flash('El empleado ' . $user->name . ' fue Eliminado!')->success()->important();
        return redirect()->route('users.index');
    }

}
