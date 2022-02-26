<?php


namespace App\Services;

use App\Http\Controllers\Laralum\Laralum;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Auth;

/**
 * Class LeadService
 * @package App\Services\Lead
 */
class StaffService
{
    /**
     * @param $data
     */
  
    public function emailExistCheck($email){
        return DB::table('users')->where('email', $email)->count();
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function getStaffForTable($data){
        $staffs = DB::table('users as u')
                    ->leftJoin('departments as d', 'u.department', '=', 'd.id')
                    ->leftJoin('user_details as ud', 'u.id', '=', 'ud.user_id')
                    ->select('u.id','u.name','u.email','u.mobile','u.address','u.updated_at','d.department','ud.location','ud.reporting_to','ud.gender','ud.hire_source','ud.joining_date','ud.work_role','ud.exit_date','ud.staff_type','ud.work_status');
        if (Laralum::loggedInUser()->reseller_id == 0) {
            $staffs->where('u.reseller_id', Laralum::loggedInUser()->id);
        } else {
            $staffs->where('u.reseller_id', Laralum::loggedInUser()->reseller_id);
        }

        if ($data->filter_by_created_date_range != null) {
            $dateData = explode(' - ', $data->filter_by_created_date_range);
            $staffs->whereBetween('u.created_at', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
        }

        if ($data->filter_by_work_status != null) {
            $staffs->where('ud.work_status', $data->filter_by_work_status);
        }
        if ($data->filter_by_staff_type != null) {
            $staffs->where('ud.staff_type', $data->filter_by_staff_type);
        }
        if ($data->filter_by_reporting_to != null) {
            $staffs->where('ud.reporting_to', $data->filter_by_reporting_to);
        }
        if ($data->filter_by_department != null) {
            $staffs->where('u.department', $data->filter_by_department);
        }

        if ($data->filter_by_work_role != null) {
            $staffs->where('ud.work_role', $data->filter_by_work_role);
        }
        if ($data->filter_by_gender != null) {
            $staffs->where('ud.gender', $data->filter_by_gender);
        }
        if ($data->filter_by_marital_status != null) {
            $staffs->where('ud.married_status', $data->filter_by_marital_status);
        }
        return $staffs;                                   
    }

    /**
     * @param $leads
     * @return mixed
     * @throws \Exception
     */
    public function staffDataTable($staffs)
    {
        return DataTables::of($staffs)
            ->addColumn('checkbox', function ($staff) {
                
                return "<input type='checkbox' id='".$staff->id."' name='sms' value='".$staff->id."'>";
            })->addColumn('id', function ($staff) {
                return $staff->id;
            })->addColumn('name', function ($staff) {
                return "<a href=".route('Crm::staff_details', ['id' => $staff->id]).">". $staff->name."</a>";
                //return $staff->name;
            })->addColumn('email', function ($staff) {
                return $staff->email;
            })->addColumn('mobile', function ($staff) {
                return $staff->mobile;
            })->addColumn('department', function ($staff) {
                return $staff->department;
            })->addColumn('staff_type', function ($staff) {
                return $staff->staff_type;
            })->addColumn('work_status', function ($staff) {
                return $staff->work_status;
            })->addColumn('work_role', function ($staff) {
                return $staff->work_role;
            })->addColumn('hire_source', function ($staff) {
                return $staff->hire_source;
            })->addColumn('action', function ($staff) {
                $action = '<a href="javascript:void(0);" data-id="'.$staff->id.'" class="action-icon button_password"><i class="mdi mdi-key"></i></a>
                <a href="' . route('Crm::staff_edit',['id'=>$staff->id]) . '" class="action-icon"><i class="mdi mdi-pencil"></i></a>
                <a href="javascript:void(0);" data-id="'.$staff->id.'" class="action-icon button_delete">
                    <i class="mdi mdi-delete"></i>
                </a>';
                return $action;
            })
            ->escapeColumns('checkbox,action')
            ->make(true);
    }

}
