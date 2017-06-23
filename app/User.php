<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'name', 'lastname', 'ext', 'phone', 'password', 'group_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function group(){

        return $this->belongsTo('App\Group');
        
    }

    public function compensatorio(){

        return $this->belongsTo('App\Compensatorio');
        
    }

    public function roles(){

        return $this->belongsToMany('App\Member', 'member_user');

    }

    public function scopeSearch($query, $id){

        return $query->where('group_id', '=', $id);
    }

    public function guardia(){

        return $this->hasMany('App\Guardia');

    }

    public static function username($grupo_id){

        $users = DB::table('users')
            ->leftJoin('guards', 'users.id', '=', 'guards.user_id')
            ->where('users.group_id', '=', $grupo_id )
            ->whereNull('guards.group_id')
            ->pluck('users.username', 'users.id');

        return $users;
    }
}


