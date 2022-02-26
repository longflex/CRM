<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Group extends Model
{
     protected $table = 'group';

    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
