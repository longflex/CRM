<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffExperience extends Model
{
	protected $table = 'staff_experience';
    protected $fillable = ['exp_staff_id' , 'exp_company_name', 'exp_job_title', 'exp_from_date', 'exp_to_date','exp_job_desc'];
//`staff_experience``exp_id``exp_staff_id``exp_company_name``exp_job_title``exp_from_date``exp_to_date`,'exp_job_desc'`created_at``updated_at`


}

