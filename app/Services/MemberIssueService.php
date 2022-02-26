<?php


namespace App\Services;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Auth;

/**
 * Class MemberIssueService
 * @package App\Services\Lead
 */
class MemberIssueService
{
    /**
     * @param $data
     */
  

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getPrayerRequestForTable($id){
        $issues = DB::table('member_issues')
                    ->leftJoin('users', 'member_issues.created_by', 'users.id')
                    ->select('users.name','member_issues.*')
                    ->where('member_id', $id);
                    // ->orderBy('member_issues.updated_at','desc');
        return $issues;
    }
   
    public function prayerRequestDataTable($issues)
    {
        return DataTables::of($issues)
            ->addColumn('id', function ($issue) {
                return $issue->id;
            })->addColumn('created_at', function ($issue) {
                if ($issue->created_at != null || $issue->created_at != "") {
                    return date('d-M-Y', strtotime($issue->created_at));
                } else {
                    return 'Not available';
                }
            })->addColumn('name', function ($issue) {
                if ($issue->name != null || $issue->name != "") {
                    return $issue->name;
                } else {
                    return 'Not available';
                }
            })->addColumn('issue', function ($issue) {
                if ($issue->issue != null || $issue->issue != "") {
                    return $issue->issue;
                } else {
                    return 'Not available';
                }
            })->addColumn('created_by', function ($issue) {
                if ($issue->created_by != null || $issue->created_by != "") {
                    return $issue->created_by;
                } else {
                    return 'Not available';
                }
            })->addColumn('follow_up_date', function ($issue) {
                if ($issue->follow_up_date != null || $issue->follow_up_date != "") {
                    return date('d-M-Y', strtotime($issue->follow_up_date));
                } else {
                    return 'Not available';
                }
            })->addColumn('status', function ($issue) {
                $todayDate = date("Y-m-d");
                if(strtotime($todayDate) < strtotime($issue->follow_up_date) ) {
                    if ($issue->status == 1) {
                        $status1 = '<span class="badge badge-success">Completd</span>';
                    } elseif ($issue->status == 2) {
                        $status1 = '<span class="badge badge-warning">Pending</span>';
                                         
                    } else {
                        $status1 = '<span class="badge badge-secondary">Not available</span>';
                    }
                } else{
                    if ($issue->status != 1) {
                        $status1 = '<span class="badge badge-danger">Due</span>';
                    }else{
                        $status1 = '<span class="badge badge-success">Completd</span>';
                    }
                    
                }
                
                return $status1;
            })->addColumn('description', function ($issue) {
                if ($issue->description != null || $issue->description != "") {
                    return $issue->description;
                } else {
                    return 'Not available';
                }
            })->addColumn('action', function ($issue) {
                $todayDate = date("Y-m-d");
                $status="";
                if(strtotime($todayDate) < strtotime($issue->follow_up_date) ){
                    $status="";

                    if ($issue->status == 1) {
                        
                        // $status = '<input type="checkbox" id="switch1" onclick="prayerStatusUpdate('.$issue->id.')" checked data-switch="bool"/><label for="switch1" data-on-label="" data-off-label=""></label>';
                    } elseif ($issue->status == 2) {
                        $status='<a href="javascript:void(0);" onclick="prayerStatusUpdate('.$issue->id.')" title="Mark as Completed" data-id="'.$issue->id.'"><i class="uil-check-circle font-20"></i></a>';
                        // $status = '<input type="checkbox" id="switch1" onclick="prayerStatusUpdate('.$issue->id.')" data-switch="bool"/><label for="switch1" data-on-label="" data-off-label=""></label>';
                                         
                    } else {
                        $status = '<span class="badge badge-secondary">N.A</span>';
                    }
                }else{
                    if ($issue->status == 2) {
                    //$status = '<span class="badge badge-danger">Due</span>';
                    }
                }
                $Buttonsacts='<a href="javascript:void(0);" onclick="prayerRquestEditModal('.$issue->id.')"><i class="mdi mdi-lead-pencil font-18"></i></a><a href="javascript:void(0);" data-id="'.$issue->id.'" onclick="destroyPrayerRequest('.$issue->id.')"><i class="uil-trash-alt font-18"></i></a>';
                // $togaction='<div class="row"><div class="col-md-8">'.$status.'</div><div class="col-md-4">'.$Buttonsacts.'</div><div>';
                return $status.$Buttonsacts;
                 
            })
            ->escapeColumns('action')
            ->make(true);
    }

}
