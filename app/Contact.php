<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Contact extends Model
{
     protected $table = 'contacts';

    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
