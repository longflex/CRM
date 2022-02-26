<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncommingLead extends Model
{
    protected $table = 'incomming_leads';
    protected $fillable = ['lead_id'];
}
