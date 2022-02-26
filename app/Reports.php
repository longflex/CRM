<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Reports extends Model
{
     protected $table = 'reports';

    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
