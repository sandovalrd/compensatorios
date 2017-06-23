<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Guardia;
use App\Group;
use Illuminate\Support\Facades\Auth;
use App\Compensatorio;

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
        
        $fecha = new Carbon('next thursday');
        $fecha->addDays(-7);
        $guardias = Guardia::history($fecha)->get();
        $fecha = new Carbon('next thursday');
        $proximas = Guardia::home($fecha)->get();

        $group_id = Auth::user()->group_id;
        $group = Group::where('id', '=', $group_id )->first();
        $compensatorios = Compensatorio::show($group_id);

        return view('home')
            ->with('proximas', $proximas)
            ->with('compensatorios', $compensatorios)
            ->with('guardias', $guardias);
    }
}
