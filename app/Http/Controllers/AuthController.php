<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Adldap\Laravel\Facades\Adldap;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\StoreLoginReguest;
use Laracasts\Flash\Flash;
use App\User;

class AuthController extends Controller
{

	use AuthenticatesUsers;
	protected $redirectTo = '/home';

    function getLogin(){

    	return view('admin.auth.login');
    }

    function posLogin(StoreLoginReguest $request){

    	$username = $request->username;
    	$password = $request->password;
    	$user = User::where('username', '=', $username)->first();

 		if (Adldap::auth()->attempt($username, $password)) {
 			if($user){
 				Auth::loginUsingId($user->id);
 				return redirect()->route('home');
 			}else{
 				Flash('Usuario no registrado en el sistema!')->error()->important();
 				return view('admin.auth.login');	
 			}
 		}else{
 			Flash('Usuario o contraseña incorrectas!')->error()->important();
 			return view('admin.auth.login');
 		}
    }

    function getlogout(){
    	Auth::logout();
    	return redirect()->route('login');
    }
}
