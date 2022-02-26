<?php
namespace App\Exports;
use App\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\DB;

class UsersExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
	
	use Exportable;

    // public function __construct(int $year)
    // {
    //     $this->year = $year;
    // }
    public function __construct(int $client_id, $ids)
    {
        $this->client = $client_id;
        $this->ids = $ids;
        //$this->year = $year;
    }
    public function query()
    {

        //`users``id``name``email``department``mobile``address`

//`user_details` `id``user_id``nick_name``location``reporting_to``work_title``hire_source``joining_date``seating_location``work_status``staff_type``work_phone``extension``work_role``experience``pan_no``adhar_no``tags``married_status``age``job_desc``about_me``exit_date``expertise``gender``created_at``updated_at`

//`educations``id``staff_id``edu_school_name``edu_degree``edu_branch``edu_completion_date``edu_add_note``edu_interest``created_at``updated_at`

//`staffdatas``id``staff_id``staff_relation``staff_relation_name``staff_relation_mobile``staff_relation_dob``created_at``updated_at`

// `staff_experience``exp_id``exp_staff_id``exp_company_name``exp_job_title``exp_from_date``exp_to_date``exp_job_desc``created_at``updated_at`
        // return User::query()->select('id', 'name', 'email', 'mobile', 'created_at')->whereYear('created_at', $this->year);
         return User::query()->select('id', 'name', 'email', 'mobile', 'created_at')->whereIn('id', $this->ids);
    }
   
	public function headings(): array
    {

        return [
		    'ID',
            'Name',
            'Email',
            'Phone No',
            'Created',            
        ];

    }
}
