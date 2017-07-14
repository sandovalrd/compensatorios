<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

	protected $table = 'members';

    protected $fillable = ['name'];

    public function users(){

        return $this->belongsToMany('App\User', 'member_user')->withTimestamps();

    }
}
