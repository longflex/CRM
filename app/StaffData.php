<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


class StaffData extends Model
{
	protected $table = 'staffdatas';
	protected $fillable = ['staff_id' , 'staff_relation', 'staff_relation_name', 'staff_relation_mobile', 'staff_relation_dob'];

}
// `educations` `id``staff_id``edu_school_name``edu_degree``edu_branch``edu_completion_date``edu_add_note``edu_interest``created_at``updated_at`



//`staff_experience``exp_id``exp_staff_id``exp_company_name``exp_job_title``exp_from_date``exp_to_date``created_at``updated_at`


//`staffdatas``id``staff_id``staff_relation``staff_relation_name``staff_relation_mobile``staff_relation_dob``created_at``updated_at`