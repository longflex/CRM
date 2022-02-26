<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDetail extends Model
{
    protected $table = 'user_details';
	protected $fillable = ['user_id' , 'nick_name', 'location', 'reporting_to', 'work_title', 'hire_source', 'joining_date', 'seating_location', 'work_status', 'staff_type', 'work_phone', 'extension', 'work_role', 'experience', 'pan_no', 'adhar_no', 'tags', 'married_status', 'age', 'job_desc', 'about_me', 'exit_date', 'expertise', 'expertise', 'gender'];
	//`user_details``id``user_id``nick_name``location``reporting_to``work_title``hire_source``joining_date``seating_location``work_status``staff_type``work_phone``extension``work_role``experience``pan_no``adhar_no``tags``married_status``age``job_desc``about_me``exit_date``expertise``gender`
}
