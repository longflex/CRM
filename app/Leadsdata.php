<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leadsdata extends Model
{
	protected $fillable = ['member_id' , 'member_relation', 'member_relation_name', 'member_relation_mobile', 'member_relation_dob'];

}
