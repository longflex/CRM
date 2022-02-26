<?php


namespace App\Services;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Laralum\Laralum;
use Auth;

/**
 * Class DonationService
 * @package App\Services\Lead
 */
class DepartmentService
{
    /**
     * @param $data
     */
  

    /**
     * @return \Illuminate\Support\Collection
     */
   public function getDepartmentForTable($data,$client_id){
        $departments = DB::table('departments')
        //->leftJoin('users', 'manual_logged_call.created_by', 'users.id')
        //->leftJoin('leads', 'leads.id', 'manual_logged_call.member_id')
        ->where('departments.client_id', $client_id)
        ->select('departments.*');
        return $departments;
    }

     public function departmentDataTable($departments)
    {
        return DataTables::of($departments)
            ->addColumn('id', function ($department) {
                return $department->id;
            })->addColumn('department', function ($department) {
                return $department->department;
            })->addColumn('action', function ($department) {
            $action = '<a href="' . route('Crm::department_edit',['id'=>$department->id]) . '" ><i class="uil-edit"></i></a><a href="javascript:void(0);" data-id="'.$department->id.'" onclick="destroy('.$department->id.')"><i class="uil-trash"></i></a>';
            return $action;
            })->escapeColumns('action')->make(true);
    }


    

}
