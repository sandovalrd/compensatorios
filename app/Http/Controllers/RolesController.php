<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;


use App\User;
use App\Member;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = User::find($id);
        return view('admin.roles.index')->with('user', $user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $roles = Member::orderby('id', 'ASC')->pluck('name', 'id');
        $user = User::find($id);

        return view('admin.roles.create')
            ->with('roles', $roles)
            ->with('user', $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user->roles->contains($request->rol_id)) {
            $user->roles()->attach($request->rol_id); 
            $user = User::find($request->user_id);
        }else{
             $error = new MessageBag;
             $error->add('key', 'Rol ya existe para éste usuario');

             return redirect('admin/roles/' . $user->id . '/index')->withErrors($error);
        }
        return view('admin.roles.index')->with('user', $user);
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
        //
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
    public function destroy($id, $rol)
    {
        $user = User::find($id);
        $user->roles()->detach($rol);
        $rol = Member::find($rol);
        

        Flash('El rol ' . $rol->name . ' fue Eliminado!')->success()->important();
        return view('admin.roles.index')->with('user', $user);
    }
}
