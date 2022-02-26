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
class DesignationService
{
    /**
     * @param $data
     */
  

    /**
     * @return \Illuminate\Support\Collection
     */
   public function getDesignationForTable($data,$client_id){
        $designation = DB::table('designation')
        //->leftJoin('users', 'manual_logged_call.created_by', 'users.id')
        //->leftJoin('leads', 'leads.id', 'manual_logged_call.member_id')
        ->where('designation.client_id', $client_id)
        ->select('designation.*');
        return $designation;
    }

     public function designationDataTable($designation)
    {
        return DataTables::of($designation)
            ->addColumn('id', function ($desig) {
                return $desig->id;
            })->addColumn('designation', function ($desig) {
                return $desig->designation;
            })->addColumn('action', function ($desig) {
            $action = '<a href="' . route('Crm::designation_edit',['id'=>$desig->id]) . '" ><i class="uil-edit"></i></a><a href="javascript:void(0);" data-id="'.$desig->id.'" onclick="destroy('.$desig->id.')"><i class="uil-trash"></i></a>';
            return $action;
            })->escapeColumns('action')->make(true);
    }


    

}
