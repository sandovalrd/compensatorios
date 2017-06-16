<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Guardia;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $fecha = new Carbon('last thursday');
        $guardias = Guardia::history($fecha)->get();
        $fecha = new Carbon('next thursday');
        $proximas = Guardia::home($fecha)->get();

        return view('home')
            ->with('proximas', $proximas)
            ->with('guardias', $guardias);
    }
}
