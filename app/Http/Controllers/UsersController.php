<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Adldap\Laravel\Facades\Adldap;
use Laracasts\Flash\Flash;
use App\User;
use App\Group;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::orderBy('id', 'ASC')->paginate(10);
        $groups = Group::orderBy('name', 'ASC')->pluck('name', 'id');
        $users->each(function( $users ){
            $users->group;
        });

        return view('admin.users.index')
            ->with('users', $users)
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
        $user->roles    ()->attach(1); // Rol de Usuario
        

        Flash('Empleado creado con exito!')->success()->important();

        return redirect()->route('users.index');
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

        
        $users = User::find($id);
        $users->username = $request->username;
        $users->name = $request->name;
        $users->lastname = $request->lastname;
        $users->ext = $request->ext;
        $users->phone = $request->phone;
        $users->group_id = $request->group_id;
        $users->save();

        Flash('Usuario Mdificado!')->success()->important();
        return redirect()->route('users.index');
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
