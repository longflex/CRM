<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
	protected $table = 'educations';
    protected $fillable = ['staff_id' , 'edu_school_name', 'edu_degree', 'edu_branch', 'edu_completion_date','edu_add_note','edu_interest'];
// `educations` `id``staff_id``edu_school_name``edu_degree``edu_branch``edu_completion_date``edu_add_note``edu_interest``created_at``updated_at`
//`staffdatas``id``staff_id``staff_relation``staff_relation_name``staff_relation_mobile``staff_relation_dob``created_at``updated_at`
// `educations` `id``staff_id``edu_school_name``edu_degree``edu_branch``edu_completion_date``edu_add_note``edu_interest``created_at``updated_at`


}


 