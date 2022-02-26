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
class CallLogService
{
    /**
     * @param $data
     */
  

    /**
     * @return \Illuminate\Support\Collection
     */
   public function getLeadCallForTable($id){
        $callLog = DB::table('manual_logged_call')
        ->leftJoin('users', 'manual_logged_call.created_by', 'users.id')
        ->leftJoin('leads', 'leads.id', 'manual_logged_call.member_id')
        ->where('manual_logged_call.member_id', $id)
        ->select('manual_logged_call.*', 'leads.name', 'users.name as attended_by');
        if(Laralum::loggedInUser()->id != 1){
            $callLog->where('manual_logged_call.created_by', Laralum::loggedInUser()->id);
        }
        // ->orderBy('manual_logged_call.created_at', 'desc');
        return $callLog;
    }

     public function callLogDataTable($callLog)
    {
        return DataTables::of($callLog)
            ->addColumn('id', function ($callLog) {
                return $callLog->id;
            })->addColumn('name', function ($callLog) {
                return $callLog->name;
            })->addColumn('attended_by', function ($callLog) {
                return $callLog->attended_by;
            })->addColumn('created_at', function ($callLog) {
                return date('d-M-Y', strtotime($callLog->created_at));
            })->addColumn('description', function ($callLog) {
                return $callLog->description;
            })->addColumn('outcome', function ($callLog) {
                return $callLog->outcome;
            })->addColumn('date', function ($callLog) {
                return date('d-M-Y', strtotime($callLog->date));
            })->addColumn('duration', function ($callLog) {
                return $callLog->duration;
            })->make(true);
    }
     public function getLeadCallDashboard($data){
        $callLog = DB::table('manual_logged_call')
        //->leftJoin('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
        ->leftJoin('users', 'manual_logged_call.created_by', 'users.id')
        ->leftJoin('leads', 'leads.id', 'manual_logged_call.member_id')
        ->select('manual_logged_call.*', 'leads.name', 'users.name as attended_by');
        // if ($data->filter_by_agent != null && $data->filter_by_agent != "") {
        //     $callLog->where('manual_logged_call.created_by', $data->filter_by_agent);
        // }
        // if ($data->filter_by_Date != null) {
        //     $dateData4 = explode(' - ', $data->filter_by_Date);
        //     $callLog->whereBetween('manual_logged_call.created_at', [date("Y-m-d", strtotime($dateData4[0])), date("Y-m-d", strtotime($dateData4[1]))]);
        // }
        if(Laralum::loggedInUser()->id != 1){
            $callLog->where('manual_logged_call.created_by', Laralum::loggedInUser()->id);
        }

        // $callLog->orderBy('manual_logged_call.created_at', 'desc');
        return $callLog;
    }
    public function callLogDashboard($callLog)
    {
        return DataTables::of($callLog)
            ->addColumn('id', function ($callLog) {
                return $callLog->id;
            })->addColumn('name', function ($callLog) {
                if ($callLog->name != NULL || $callLog->name != "") { 
                    return $callLog->name;
                } elseif($callLog->lead_number != NULL || $callLog->lead_number != "") {
                    return $callLog->lead_number;
                }else{
                    return 'N.A';
                }
            })->addColumn('attended_by', function ($callLog) {
                return $callLog->attended_by;
            })->addColumn('call_outcome', function ($callLog) {
                return $callLog->call_outcome;
            })->addColumn('created_at', function ($callLog) {
                return date('d-M-Y h:i:s', strtotime($callLog->created_at));
            })->addColumn('description', function ($callLog) {
                return $callLog->description;
            })->addColumn('duration', function ($callLog) {
                return $callLog->duration;
            })
            // ->addColumn('action', function ($callLog) {
            //     $action = '<a href="javascript:void(0);" onClick ="callLogEditModal('.$callLog->id.')"><i class="uil-edit"></i></a>';
            //     return $action;
            //  })->escapeColumns('action')
            ->make(true);
    }



    

}
