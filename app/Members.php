<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Members extends Model
{
    protected $table = 'leads';

    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function hasRole($name)
    {
        foreach($this->roles as $role){
            if($role->name == $name){
                return true;
            }
        }
        return false;
    }

}
