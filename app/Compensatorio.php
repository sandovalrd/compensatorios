<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Compensatorio extends Model
{
    protected $table = 'compensatories';

    protected $fillable = ['days', 'days_request', 'user_id'];

    public function user(){

    	return $this->hasMany('App\User');

    }

    public static function show($grupo){

    	$users = DB::table('users')
            ->join('compensatories', 'users.id', '=', 'compensatories.user_id')
            ->select('users.*', 'compensatories.*')
            ->where('users.group_id', '=', $grupo)
            ->orderby('days', 'DESC')
            ->get();

         return $users;
    
    }
}
