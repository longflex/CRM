<?php


namespace App\Services;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Laralum\Laralum;
use App\ManualLoggedCall;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\One\User;
use App\Jobs\ProcessCsvUpload;

/**
 * Class LeadService
 * @package App\Services\Lead
 */
class LeadService
{
    public function getLeadForTable($data,$client_id){
        $manual = DB::table('manual_logged_call')
                ->join('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
                ->select('member_id')
                ->where(function ($manual) use ($data) {
                    if ($data->filter_by_campaign != null && $data->filter_by_campaign != 0) {
                        $manual->where('manual_logged_call.campaign_id', $data->filter_by_campaign);
                    }
                    if(Laralum::loggedInUser()->id != 1){
                        $manual->where('campaign_leads.agent_id', Laralum::loggedInUser()->id);
                    }
                })
                ->where('manual_logged_call.status','1');
        $manuarray = $manual;
                $leads = DB::table('leads')
                    ->join('campaign_leads', 'leads.id', 'campaign_leads.lead_id')
                    ->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
                    ->leftJoin('manual_logged_call', function ($leads) use ($data) {
                        $leads->on('leads.id', '=', 'manual_logged_call.member_id');
                        if ($data->filter_by_campaign != null && $data->filter_by_campaign != 0) {
                            $leads->where('manual_logged_call.campaign_id', $data->filter_by_campaign);
                        }
                    })
                    ->select('leads.id', 'leads.member_id','leads.name', 'leads.mobile', 'leads.lead_status', 'leads.last_contacted_date', 'leads.preferred_language', 'manual_logged_call.outcome','manual_logged_call.created_at','manual_logged_call.description','manual_logged_call.date','manual_logged_call.duration', 'manual_logged_call.updated_at', 'users.name as assign_to','manual_logged_call.call_status')
                    //->where('leads.lead_status', '!=', 3)
                    ->where('leads.client_id', $client_id)
                    ->where(function ($leads) use ($data, $manuarray) {
                        // $manual = DB::table('manual_logged_call')
                        //     ->join('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
                        //     ->select('member_id')
                        //     ->where(function ($manual) use ($data) {
                        //         if ($data->filter_by_campaign != null) {
                        //             $manual->where('manual_logged_call.campaign_id', $data->filter_by_campaign);
                        //         }
                        //     })
                        //     ->where('manual_logged_call.status','1')
                        //     ->get();
                        //$manuarray = [];
                        //foreach($manual as $manu){
                            //$manuarray[] = $manu->member_id;
                        //}
                        if ($data->filter_by_data_id != null) {
                            $leads->where('leads.lead_status', $data->filter_by_data_id);
                        }
                        if ($data->filter_by_campaign != null && $data->filter_by_campaign != 0) {
                            $leads->where('campaign_leads.campaign_id', $data->filter_by_campaign);
                        }else{
                            $campaignarray = DB::table('campaign_agents')
                            ->select('campaign_id')
                            ->where(function ($manual) use ($data) {
                                if(Laralum::loggedInUser()->id != 1){
                                    $manual->where('agent_id', Laralum::loggedInUser()->id);
                                }
                            })
                            ->groupBy('campaign_id');
                            $leads->whereIn('campaign_leads.campaign_id', $campaignarray);
                        }
                        if ($data->filter_by_agent != null) {
                            $leads->where('campaign_leads.agent_id', $data->filter_by_agent);
                        }
                        if ($data->filter_by_call_status == 1) {
                            $leads->whereNotIn('leads.id', $manuarray);
                        } elseif($data->filter_by_call_status == 2) {
                            $leads->where('manual_logged_call.call_status', 2);
                            if ($data->filter_by_campaign != null && $data->filter_by_campaign != 0) {
                                $leads->where('manual_logged_call.campaign_id', $data->filter_by_campaign);
                            }
                        } elseif($data->filter_by_call_status == 3) {
                            $leads->where('manual_logged_call.call_status', 3);
                            if ($data->filter_by_campaign != null && $data->filter_by_campaign != 0) {
                                $leads->where('manual_logged_call.campaign_id', $data->filter_by_campaign);
                            }
                        }  elseif($data->filter_by_call_status == 0) {
                           // $leads->where('manual_logged_call.call_status', 2)->orWhere('manual_logged_call.call_status', 3);
                        } else {
                            $leads->whereNotIn('leads.id', $manuarray);
                        }
                        if ($data->filter_by_account_type != null) {
                            $leads->where('leads.account_type', $data->filter_by_account_type);
                        }
                        if ($data->filter_by_member_type != null) {
                            $leads->where('leads.member_type', $data->filter_by_member_type);
                        }
                        if ($data->filter_by_prayer_request != null) {
                            $leads->where('leads.issue_id', $data->filter_by_prayer_request);
                        }
                        if ($data->filter_by_department != null) {
                            $leads->where('leads.department', $data->filter_by_department);
                        }
                        if ($data->filter_by_call != null) {
                            $leads->where('manual_logged_call.outcome', $data->filter_by_call);
                        }
                        if ($data->filter_by_source != null) {
                            $leads->where('leads.lead_source', $data->filter_by_source);
                        }
                        if ($data->filter_by_gender != null) {
                            $leads->where('leads.gender', $data->filter_by_gender);
                        }
                        //to do
                        if(Laralum::loggedInUser()->id != 1){
                            $leads->where('campaign_leads.agent_id', Laralum::loggedInUser()->id);
                        }
                        if ($data->filter_by_blood_group != null) {
                            $leads->where('leads.blood_group', $data->filter_by_blood_group);
                        }
                        if ($data->filter_by_marital_status != null) {
                            $leads->where('leads.married_status', $data->filter_by_marital_status);
                        }
                        if ($data->filter_by_date_of_birth != null) {
                            $dateData = explode(' - ', $data->filter_by_date_of_birth);
                            $leads->whereBetween('leads.date_of_birth', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
                        }
                        if ($data->filter_by_date_of_anniversary != null) {
                            $dateData1 = explode(' - ', $data->filter_by_date_of_anniversary);
                            $leads->whereBetween('leads.date_of_anniversary', [date("Y-m-d", strtotime($dateData1[0])), date("Y-m-d", strtotime($dateData1[1]))]);
                        }
                        if ($data->filter_by_recently_contacted != null) {
                            $dateData3 = explode(' - ', $data->filter_by_recently_contacted);
                            $leads->whereBetween('leads.last_contacted_date', [date("Y-m-d", strtotime($dateData3[0])), date("Y-m-d", strtotime($dateData3[1]))]);
                        }
                        // if ($data->filter_by_Date != null) {
                        //     $dateData4 = explode(' - ', $data->filter_by_Date);
                        //     if($dateData4[0] == $dateData4[1]){
                        //         $leads->whereDate('campaign_leads.created_at', date("Y-m-d", strtotime($dateData4[0])));
                        //     }else{
                        //         $leads->whereBetween('campaign_leads.created_at', [date("Y-m-d", strtotime($dateData4[0])), date("Y-m-d", strtotime($dateData4[1]))]);
                        //     }
                        // }
                        if ($data->filter_by_call_required != null) {
                            $leads->where('leads.call_required', $data->filter_by_call_required);
                        }
                        if ($data->filter_by_sms_required != null) {
                            $leads->where('leads.sms_required', $data->filter_by_sms_required);
                        }
                        if ($data->filter_by_preferred_language != null) {
                            $leads->where('leads.preferred_language', $data->filter_by_preferred_language);
                        }

                        // if ($data->search_query != null) {
                        //     $query = $data->search_query;
                        //     //$donations->where('donations.id', '6');
                        //     $donations->where('leads.id', 'like', '%'.$query.'%')
                        //     ->orWhere('leads.name', 'like', '%'.$query.'%');
                        // }
                    });
                //->paginate(10);
                $leads->groupBy('leads.id');
        return $leads;
    }

    /**
     * @param $leads
     * @return mixed
     * @throws \Exception
     */
    public function getLeadForAutoDial($data, $client_id){

        $manual = DB::table('manual_logged_call')
                ->join('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
                ->select('member_id')
                ->where(function ($manual) use ($data) {
                    if ($data->filter_by_campaign != null) {
                        $manual->where('manual_logged_call.campaign_id', $data->filter_by_campaign);
                    }
                    if(Laralum::loggedInUser()->id != 1){
                        $manual->where('campaign_leads.agent_id', Laralum::loggedInUser()->id);
                    }
                })
                ->where('manual_logged_call.status','1');
        $manuarray = $manual;
        
        $leads = DB::table('leads')
                    ->join('campaign_leads', 'leads.id', 'campaign_leads.lead_id')
                    ->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
                    ->leftJoin('manual_logged_call', function ($leads) use ($data) {
                        $leads->on('leads.id', '=', 'manual_logged_call.member_id');
                        if ($data->filter_by_campaign != null) {
                            $leads->where('manual_logged_call.campaign_id', $data->filter_by_campaign);
                        }
                    })
                    ->select('leads.id', 'leads.member_id','leads.name', 'leads.mobile', 'leads.lead_status', 'leads.last_contacted_date', 'leads.preferred_language', 'manual_logged_call.outcome','manual_logged_call.created_at','manual_logged_call.description','manual_logged_call.date','manual_logged_call.duration', 'users.name as assign_to','manual_logged_call.call_status')
                    //->where('leads.lead_status', '!=', 3)
                    ->where('leads.client_id', $client_id)
                    ->where(function ($leads) use ($data, $manuarray) {

                        if ($data->filter_by_campaign != null) {
                            $leads->where('campaign_leads.campaign_id', $data->filter_by_campaign);
                        }

                        $leads->whereNotIn('leads.id', $manuarray);
                        
                        if(Laralum::loggedInUser()->id != 1){
                            $leads->where('campaign_leads.agent_id', Laralum::loggedInUser()->id);
                        }
                    })
                //->paginate(10);
                ->groupBy('leads.id')
                ->orderBy('leads.id', 'desc')
                ->get();
        return $leads;
    }

    /**
     * @param $leads
     * @return mixed
     * @throws \Exception
     */
    public function leadDataTable($leads)
    {
        return DataTables::of($leads)
            ->addColumn('checkbox', function ($lead) {
                return "<input type='checkbox' id='".$lead->id."' name='sms' value='".$lead->id."'>";
            })->addColumn('id', function ($lead) {
                return $lead->id;
            })->addColumn('name', function ($lead) {
                if ($lead->name != null || $lead->name != "") {
                    return '<a href="' . route('Crm::lead_details', ['id' => $lead->id]) . '">'.$lead->name.'</a>';
                } else {
                    return 'Not available';
                }
            })->addColumn('mobile', function ($lead) {
                if ($lead->mobile != null || $lead->mobile != "") {
                    return $lead->mobile;
                } else {
                    return 'Not available';
                }
            })->addColumn('assign_to', function ($lead) {
                if ($lead->assign_to != null || $lead->assign_to != "") {
                    return $lead->assign_to;
                } else {
                    return 'Not available';
                }
            })->addColumn('lead_status', function ($lead) {
                $lead_status_selected1="";
                $lead_status_selected2="";
                $lead_status_selected3="";
                $lead_status_selected4="";
                $lead_status_selected5="";
                if ($lead->lead_status == 1) {
                        $lead_status_selected1 = "selected";
                    } elseif ($lead->lead_status == 2) {
                        $lead_status_selected2 = "selected";
                    } elseif ($lead->lead_status == 3) {
                        $lead_status_selected3 = "selected";
                    } elseif ($lead->lead_status == 4) {
                        $lead_status_selected4 = "selected";
                    } elseif ($lead->lead_status == 5) {
                        $lead_status_selected5 = "selected";
                    } else {
                        $lead_status_selected6 = "";
                    }
                if($lead->call_status == '1' || $lead->call_status == null){
                return '<select class="form-control form-control-sm custom-select leadstatusupdate" data-id="'.$lead->id.'">
                        <option value="1" '.$lead_status_selected1.'>Assigned</option>
                        <option value="2" '. $lead_status_selected2.'>Open</option>
                        <option value="3" '. $lead_status_selected3.'>Converted</option>
                        <option value="4" '.$lead_status_selected4.'>Follow Up</option>
                        <option value="5" '.$lead_status_selected5.'>Closed</option>
                    </select>';
                }elseif($lead->call_status == '2'){
                    if ($lead->lead_status == 1) {
                        $lead_status = '<span class="badge badge-primary">Assigned</span>';
                    } elseif ($lead->lead_status == 2) {
                        $lead_status = '<span class="badge badge-info">Open</span>';
                    } elseif ($lead->lead_status == 3) {
                        $lead_status = '<span class="badge badge-success">Converted</span>';
                    } elseif ($lead->lead_status == 4) {
                        $lead_status = '<span class="badge badge-warning">Follow Up</span>';
                    } elseif ($lead->lead_status == 5) {
                        $lead_status = '<span class="badge badge-danger">Closed</span>';
                    } else {
                        $lead_status = '<span class="badge badge-secondary">Not available</span>';
                    }
                    return $lead_status;
                }elseif($lead->call_status == '3'){
                    if ($lead->lead_status == 1) {
                        $lead_status = '<span class="badge badge-primary">Assigned</span>';
                    } elseif ($lead->lead_status == 2) {
                        $lead_status = '<span class="badge badge-info">Open</span>';
                    } elseif ($lead->lead_status == 3) {
                        $lead_status = '<span class="badge badge-success">Converted</span>';
                    } elseif ($lead->lead_status == 4) {
                        $lead_status = '<span class="badge badge-warning">Follow Up</span>';
                    } elseif ($lead->lead_status == 5) {
                        $lead_status = '<span class="badge badge-danger">Closed</span>';
                    } else {
                        $lead_status = '<span class="badge badge-secondary">Not available</span>';
                    }
                    return $lead_status;
                }
                
            })->addColumn('preferred_language', function ($lead) {
                if ($lead->preferred_language != null || $lead->preferred_language != "") {
                    return $lead->preferred_language;
                } else {
                    return 'Not available';
                }
            })->addColumn('call_status', function ($lead) {
                if($lead->call_status == '1' || $lead->call_status == null){
                return '<select class="form-control form-control-sm custom-select callstatus" data-id="'.$lead->id.'">
                        <option disabled selected>Available</option>
                        <option value="2">Completed</option>
                        <option value="3">Follow</option>
                    </select>';
                }elseif($lead->call_status == '2'){
                    return 'Completed';
                }elseif($lead->call_status == '3'){
                    return 'Follow';
                }
            })->addColumn('updated_at', function ($lead) {
                if ($lead->updated_at != NULL || $lead->updated_at != "") { 
                    return date('d-M-Y', strtotime($lead->updated_at));
                } else {
                    return 'Not available';
                }
            })->addColumn('action', function ($lead) {
                $action = '<a class="mr-1" href="javascript:void(0);" data-target="#oppenRadioModal" onClick ="oppenRadioModal('.$lead->id.','.$lead->mobile.')" ><i class="uil-plus-circle"></i></a> <a href="javascript:void(0);" onClick ="manualsinglecall('.$lead->mobile.')"><i class="uil-phone"></i></a>';
                return $action;
             })
            ->escapeColumns('checkbox,action')
            ->make(true);
    }

   public function getLeadForTableLeadList($data,$client_id){

        $leads = DB::table('leads') 
                    ->leftJoin('campaign_leads', 'leads.id', 'campaign_leads.lead_id')
                    ->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
                    //->leftJoin('manual_logged_call', 'leads.id', 'manual_logged_call.member_id')
                    ->leftJoin('manual_logged_call', function ($leads) use ($data) {
                        $leads->on('leads.id', '=', 'manual_logged_call.member_id');
                        if ($data->filter_by_campaign != null && $data->filter_by_campaign != 0) {
                            $leads->where('manual_logged_call.campaign_id', $data->filter_by_campaign);
                        }
                    });
                    if ($data->filter_by_lead_incoming != null) {
                        $leads->Join('incomming_leads', function ($leads) use ($data) {
                            $leads->on('leads.id', '=', 'incomming_leads.lead_id');
                        
                            $leads->whereNotNull('incomming_leads.lead_id');
                        
                        });
                    }                    
                    $leads->leftJoin('member_issues', 'leads.id', 'member_issues.member_id')
                    ->select('leads.id', 'leads.member_id','leads.name', 'leads.mobile', 'leads.lead_status', 'leads.last_contacted_date', 'leads.preferred_language', 'manual_logged_call.outcome','manual_logged_call.created_at','manual_logged_call.description','manual_logged_call.date','manual_logged_call.duration', 'users.name as assign_to','manual_logged_call.call_status');
                    if ($data->filter_by_lead_incoming == null) {
                        $leads->where('leads.lead_status', '!=', 3);
                    }
                    $leads->where('leads.client_id', $client_id)
                    ->where(function ($leads) use ($data) {
        $assigned_lead_ids = DB::table('campaign_leads')->groupBy('lead_id')->pluck('lead_id');
        $manual = DB::table('manual_logged_call')
                ->join('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
                ->select('member_id')
                ->where(function ($manual) use ($data) {
                    if ($data->filter_by_campaign != null && $data->filter_by_campaign != 0) {
                        $manual->where('manual_logged_call.campaign_id', $data->filter_by_campaign);
                    }
                    if(Laralum::loggedInUser()->id != 1){
                        $manual->where('campaign_leads.agent_id', Laralum::loggedInUser()->id);
                    }
                })
                ->where('manual_logged_call.status','1');
        $manuarray = $manual;
        // $manual = DB::table('manual_logged_call')->join('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')->select('member_id')->get();
        // $manuarray = [];
        // foreach($manual as $manu){
        //     $manuarray[] = $manu->member_id;
        // }
        if ($data->filter_by_data_id != null) {
            $leads->where('leads.lead_status', $data->filter_by_data_id);
        }
        if ($data->filter_by_campaign != null && $data->filter_by_campaign != 0) {
            $leads->where('campaign_leads.campaign_id', $data->filter_by_campaign);
        }else{
            $campaignarray = DB::table('campaign_agents')
            ->select('campaign_id')
            ->where(function ($manual) use ($data) {
                if(Laralum::loggedInUser()->id != 1){
                    $manual->where('agent_id', Laralum::loggedInUser()->id);
                }
            })
            ->groupBy('campaign_id');
            $leads->whereIn('campaign_leads.campaign_id', $campaignarray);
        }
        if ($data->filter_by_agent != null) {
            $leads->where('campaign_leads.agent_id', $data->filter_by_agent);
        }
        
        if ($data->filter_by_call_status != '') {
            $leads->where('manual_logged_call.call_status', $data->filter_by_call_status);
        }
        if ($data->filter_by_campaign_status == 1) {
            $leads->whereNotIn('leads.id', $manuarray);
        } elseif($data->filter_by_campaign_status == 2) {
            $leads->where('manual_logged_call.call_status', 2);
        } elseif($data->filter_by_campaign_status == 3) {
            $leads->where('manual_logged_call.call_status', 3);
        }

        if ($data->filter_by_account_type != null) {
            $leads->where('leads.account_type', $data->filter_by_account_type);
        }
        if ($data->filter_by_member_type != null) {
            $leads->where('leads.member_type', json_encode($data->filter_by_member_type));
        }
        if ($data->filter_by_prayer_request != null) {
            $leads->where('leads.issue_id', $data->filter_by_prayer_request);
        }
        if ($data->filter_by_department != null) {
            $leads->where('leads.department', $data->filter_by_department);
        }
        if ($data->filter_by_call != null) {
            $leads->where('manual_logged_call.outcome', $data->filter_by_call);
        }
        if ($data->filter_by_call_type != null) {
            $leads->where('manual_logged_call.call_type', $data->filter_by_call_type);
        }
        if ($data->filter_by_source != null) {
            $leads->where('leads.lead_source', $data->filter_by_source);
        }
        if ($data->filter_by_gender != null) {
            $leads->where('leads.gender', $data->filter_by_gender);
        }
        if ($data->filter_by_blood_group != null) {
            $leads->where('leads.blood_group', $data->filter_by_blood_group);
        }
        if ($data->filter_by_marital_status != null) {
            $leads->where('leads.married_status', $data->filter_by_marital_status);
        }
        if ($data->filter_by_date_of_birth != null) {
            $dateData = explode(' - ', $data->filter_by_date_of_birth);
            $leads->whereBetween('leads.date_of_birth', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
        }
        if ($data->filter_by_date_of_anniversary != null) {
            $dateData1 = explode(' - ', $data->filter_by_date_of_anniversary);
            $leads->whereBetween('leads.date_of_anniversary', [date("Y-m-d", strtotime($dateData1[0])), date("Y-m-d", strtotime($dateData1[1]))]);
        }
        if ($data->filter_by_recently_contacted != null) {
            $dateData3 = explode(' - ', $data->filter_by_recently_contacted);
            $leads->whereBetween('leads.last_contacted_date', [date("Y-m-d", strtotime($dateData3[0])), date("Y-m-d", strtotime($dateData3[1]))]);
        }
        if(Laralum::loggedInUser()->reseller_id != 0){
            $leads->where('leads.created_by', Laralum::loggedInUser()->id);
        }
        if ($data->filter_by_Date != null) {
            $dateData4 = explode(' - ', $data->filter_by_Date);
            $leads->whereBetween('leads.created_at', [date("Y-m-d", strtotime($dateData4[0])), date("Y-m-d", strtotime($dateData4[1]))]);
        }
        if ($data->filter_by_call_required != null) {
            $leads->where('leads.call_required', $data->filter_by_call_required);
        }
        if ($data->filter_by_sms_required != null) {
            $leads->where('leads.sms_required', $data->filter_by_sms_required);
        }
        if ($data->filter_by_preferred_language != null) {
            $leads->where('leads.preferred_language', $data->filter_by_preferred_language);
        }
        
        // if ($data->filter_by_call_status != null) {
        //     $leads->where('manual_logged_call.call_status', $data->filter_by_call_status);
        // }
        if ($data->filter_by_campaign != null) {
            $leads->where('campaign_leads.campaign_id', $data->filter_by_campaign);
        }
        if ($data->filter_by_campaign_assigned == 'assigned') {
            $leads->whereIn('leads.id', $assigned_lead_ids);
        }
        if($data->filter_by_campaign_assigned == 'unassigned'){
            $leads->whereNotIn('leads.id', $assigned_lead_ids);
        }
        if ($data->filter_by_prayer_followup_date != null) {
            $dateData4 = explode(' - ', $data->filter_by_prayer_followup_date);
            $leads->whereBetween('member_issues.follow_up_date', [date("Y-m-d", strtotime($dateData4[0])), date("Y-m-d", strtotime($dateData4[1]))]);
        }
        if ($data->filter_by_lead_response != null) {
            $leads->whereIn('leads.lead_response', $data->filter_by_lead_response);
        }
        // if ($data->search_query != null) {
        //     $query = $data->search_query;
        //     //$donations->where('donations.id', '6');
        //     $leads->where('leads.id', 'like', '%'.$query.'%')
        //     ->orWhere('leads.name', 'like', '%'.$query.'%');
        // }
    })
    ->groupBy('leads.id');

        //$leads->groupBy('leads.id');
        return $leads;
    }

    public function leadDataTableLeadList($leads)
    {
        return DataTables::of($leads)
            ->addColumn('checkbox', function ($lead) {
                return "<input type='checkbox' id='".$lead->id."' name='sms' value='".$lead->id."'>";
            })->addColumn('id', function ($lead) {
                return $lead->id;
            })->addColumn('name', function ($lead) {
                if ($lead->name != null || $lead->name != "") {
                    return '<a href="' . route('Crm::lead_details', ['id' => $lead->id]) . '">'.$lead->name.'</a>';
                } else {
                    return 'Not available';
                }
            })->addColumn('mobile', function ($lead) {
                if ($lead->mobile != null || $lead->mobile != "") {
                    return $lead->mobile;
                } else {
                    return 'Not available';
                }
            })->addColumn('assign_to', function ($lead) {
                if ($lead->assign_to != null || $lead->assign_to != "") {
                    return $lead->assign_to;
                } else {
                    return 'Not available';
                }
            })->addColumn('lead_status', function ($lead) {
                if ($lead->lead_status == 1) {
                    $lead_status = '<span class="badge badge-primary">Assigned</span>';
                } elseif ($lead->lead_status == 2) {
                    $lead_status = '<span class="badge badge-info">Open</span>';
                } elseif ($lead->lead_status == 3) {
                    $lead_status = '<span class="badge badge-success">Converted</span>';
                } elseif ($lead->lead_status == 4) {
                    $lead_status = '<span class="badge badge-warning">Follow Up</span>';
                } elseif ($lead->lead_status == 5) {
                    $lead_status = '<span class="badge badge-danger">Closed</span>';
                } else {
                    $lead_status = '<span class="badge badge-secondary">Not available</span>';
                }
                return $lead_status;
            })->addColumn('last_contacted_date', function ($lead) {
                if ($lead->last_contacted_date != NULL || $lead->last_contacted_date != "") { 
                    return date('d-M-Y', strtotime($lead->last_contacted_date));
                } else {
                    return 'Not available';
                }
            })->addColumn('preferred_language', function ($lead) {
                if ($lead->preferred_language != null || $lead->preferred_language != "") {
                    return $lead->preferred_language;
                } else {
                    return 'Not available';
                }
            })->addColumn('outcome', function ($lead) {
                if ($lead->outcome != null || $lead->outcome != "") {
                    return $lead->outcome;
                } else {
                    return 'Not available';
                }
            })->addColumn('call_status', function ($lead) {
                if ($lead->call_status != null || $lead->call_status != "") {
                    if($lead->call_status == '1'){
                        return 'Available';
                    }elseif($lead->call_status == '2'){
                        return 'Completed';
                    }elseif($lead->call_status == '3'){
                        return 'Follow';
                    }
                } else {
                    return 'Not available';
                }
            })->addColumn('action', function ($lead) {
                return '<a href="' . route('Crm::lead_edit',['id'=>$lead->id]) . '"><i class="uil-edit"></i></a> <a href="javascript:void(0);" data-id="'.$lead->id.'" onclick="destroy('.$lead->id.')"><i class="uil-trash"></i></a>';
             })
            ->escapeColumns('checkbox,action')
            ->make(true);
    }

    public function mobileExistCheck($mobile, $client_id, $user_id) {
        return DB::table('leads')
                ->where('mobile', $mobile)
                ->where('user_id', $user_id)
                ->where('client_id', $client_id)
                ->count();
    }
 
    public function getUserSessionForTable($data){
        $userData = DB::table('users as u')
                    ->leftJoin('sessions as s', 'u.id', '=', 's.user_id')
                    //->leftJoin('campaign_leads', 'campaign_leads.agent_id', 'u.id')
                    ->leftJoin('manual_logged_call', function ($userData) use ($data) {
                        $userData->on('u.id', '=', 'manual_logged_call.created_by');
                        if ($data->filter_by_session_campaign != null) {
                            $userData->where('manual_logged_call.campaign_id', $data->filter_by_session_campaign);
                        }
                    })
                    ->leftJoin('campaigns', 'campaigns.id', 'manual_logged_call.campaign_id')
                    ->select('u.id','u.name','u.mobile','s.last_activity','campaigns.name as campaign_name',DB::raw("COUNT(manual_logged_call.id) as total_calls"), DB::raw("time(SUM(manual_logged_call.duration)) as tatal_call_duration"), DB::raw("SUM(CASE WHEN manual_logged_call.call_type = '0' THEN 1 ELSE 0 END) AS manualCount"), DB::raw("SUM(CASE WHEN manual_logged_call.call_type = '1' THEN 1 ELSE 0 END) AS autoCount"), DB::raw("SUM(CASE WHEN manual_logged_call.call_purpose = 'Add Prayer Request' THEN 1 ELSE 0 END) AS prayerCount"), DB::raw("SUM(CASE WHEN manual_logged_call.call_purpose = 'Add Donation' THEN 1 ELSE 0 END) AS donationCount"), DB::raw("SUM(CASE WHEN manual_logged_call.call_purpose = 'Will Donate' THEN 1 ELSE 0 END) AS willDonateCount"), DB::raw("SUM(CASE WHEN manual_logged_call.outcome = 'Both Answered' THEN 1 ELSE 0 END) AS total_recieved"), DB::raw("SUM(CASE WHEN manual_logged_call.outcome != 'Both Answered' THEN 1 ELSE 0 END) AS total_missed_call"));

        if (Laralum::loggedInUser()->reseller_id == 0) {
            $userData->where('u.reseller_id', Laralum::loggedInUser()->id);
        } else {
            $userData->where('u.reseller_id', Laralum::loggedInUser()->reseller_id);
        }
        if ($data->filter_by_session_campaign != null) {
            $userData->where('manual_logged_call.campaign_id', $data->filter_by_session_campaign);
        }
        if ($data->filter_by_session_call_type != null) {
            $userData->where('manual_logged_call.call_type', $data->filter_by_session_call_type);
        }
        if ($data->filter_by_session_status != null) {
            $usersIds = DB::table('sessions')->where('user_id', '!=', 1)->pluck('user_id');
            if($data->filter_by_session_status == 1){
                $userData->whereIn('u.id', $usersIds);
            }elseif ($data->filter_by_session_status == 0) {
                $userData->whereNotIn('u.id', $usersIds);
            } 
        }

        $current_date = date('Y-m-d');
		$userData->whereDate('manual_logged_call.updated_at', $current_date);

        if(Laralum::loggedInUser()->id != 1){
            $userData->where('u.id', Laralum::loggedInUser()->id);
        }
        if(Laralum::loggedInUser()->reseller_id != 0){
            $userData->where('manual_logged_call.created_by', Laralum::loggedInUser()->id);
        }
        // if ($data->filter_by_Date != null) {
        //     $dateData4 = explode(' - ', $data->filter_by_Date);
        //     $leads->whereBetween('leads.created_at', [date("Y-m-d", strtotime($dateData4[0])), date("Y-m-d", strtotime($dateData4[1]))]);
        // }

        $userData->groupBy('u.id');
        return $userData;
    }

    public function userSessionDataTable($userData)
    {
        return DataTables::of($userData)
            ->addColumn('name', function ($user) {
                if ($user->name != null || $user->name != "") {
                    return $user->name;
                } else {
                    return 'N.A';
                }
            })->addColumn('mobile', function ($user) {
                if ($user->mobile != null || $user->mobile != "") {
                    return $user->mobile;
                } else {
                    return 'N.A';
                }  //and . total_recieved total_missed_call
            })->addColumn('total_recieved', function ($user) {
                if ($user->total_recieved != null || $user->total_recieved != "") {
                    return $user->total_recieved;
                } else {
                    return 'N.A';
                }
                
            })->addColumn('total_missed_call', function ($user) {
                if ($user->total_missed_call != null || $user->total_missed_call != "") {
                    return $user->total_missed_call;
                } else {
                    return 'N.A';
                }
                
            })
            // ->addColumn('campaign', function ($user) {
            //     if ($user->campaign_name != null || $user->campaign_name != "") {
            //         return $user->campaign_name;
            //     } else {
            //         return 'N.A';
            //     }
                
            // })
            ->addColumn('session', function ($user) {
                if ($user->last_activity != NULL) {
                    $status = '<span class="badge badge-success">Active</span>';
                }else{
                    $status = '<span class="badge badge-danger">Inactive</span>'; 
                }
                return $status;
            })->addColumn('total_calls', function ($user) {
                if ($user->total_calls != null || $user->total_calls != "") {
                    return $user->total_calls;
                } else {
                    return 'N.A';
                }
                
            })->addColumn('tatal_call_duration', function ($user) {
                if ($user->tatal_call_duration != null || $user->tatal_call_duration != "") {
                    return $user->tatal_call_duration;
                } else {
                    return 'N.A';
                }
                
            })->addColumn('total_manual_dial', function ($user) {
                if ($user->manualCount != null || $user->manualCount != "") {
                    return $user->manualCount;
                } else {
                    return 'N.A';
                }
                
            })->addColumn('total_auto_dial', function ($user) {
                if ($user->autoCount != null || $user->autoCount != "") {
                    return $user->autoCount;
                } else {
                    return 'N.A';
                }
                
            })->addColumn('total_prayer_request', function ($user) {
                if ($user->prayerCount != null || $user->prayerCount != "") {
                    return $user->prayerCount;
                } else {
                    return 'N.A';
                }
                
            })->addColumn('total_donations', function ($user) {
                if ($user->donationCount != null || $user->donationCount != "") {
                    return $user->donationCount;
                } else {
                    return 'N.A';
                }
                
            })->addColumn('total_will_donate', function ($user) {
                if ($user->willDonateCount != null || $user->willDonateCount != "") {
                    return $user->willDonateCount;
                } else {
                    return 'N.A';
                }
                
            })

            ->escapeColumns('session')
            ->make(true);
    }

    public function getCallLogReportForTable($data,$client_id){
        

        $callLogReport = DB::table('manual_logged_call') 
                    ->leftJoin('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
                    //->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
                    //->leftJoin('manual_logged_call', 'leads.id', 'manual_logged_call.member_id')
                    //->leftJoin('member_issues', 'leads.id', 'member_issues.member_id')
                    ->select('manual_logged_call.*')
                    //->where('leads.lead_status', '!=', 3)
                    ->where('manual_logged_call.client_id', $client_id)
                    ->where(function ($callLogReport) use ($data) {
        // $assigned_lead_ids = DB::table('campaign_leads')->groupBy('lead_id')->pluck('lead_id');
         $manual = DB::table('manual_logged_call')->join('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')->select('member_id')->get();
         $manuarray = [];
         foreach($manual as $manu){
             $manuarray[] = $manu->member_id;
         }

        if ($data->filter_by_agent != null) {
            $callLogReport->where('manual_logged_call.created_by', $data->filter_by_agent);
        }
        if ($data->filter_by_campaign_status == 1) {
            $callLogReport->whereNotIn('manual_logged_call.member_id', $manuarray);
        } elseif($data->filter_by_campaign_status == 2) {
            $callLogReport->where('manual_logged_call.call_status', 2);
        } elseif($data->filter_by_campaign_status == 3) {
            $callLogReport->where('manual_logged_call.call_status', 3);
        }

        if ($data->filter_by_call != null) {
            $callLogReport->where('manual_logged_call.outcome', $data->filter_by_call);
        }
        if ($data->filter_by_call_type != null) {
            $callLogReport->where('manual_logged_call.call_type', $data->filter_by_call_type);
        }
        if ($data->filter_by_call_source != null) {
            $callLogReport->where('manual_logged_call.call_source', $data->filter_by_call_source);
        }

        if ($data->filter_by_campaign != null) {
            $callLogReport->where('campaign_leads.campaign_id', $data->filter_by_campaign);
        }

        if ($data->date_range_filter != null) {
            $dateData = explode(' - ', $data->date_range_filter);
            if($dateData[0] == $dateData[1]){
                $callLogReport->whereDate('manual_logged_call.updated_at', date("Y-m-d", strtotime($dateData[0])));
            }else{
                $callLogReport->whereBetween('manual_logged_call.updated_at', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
            }
        }

        if(Laralum::loggedInUser()->id != 1 && Laralum::loggedInUser()->id != 2){
            $callLogReport->where('manual_logged_call.created_by', Laralum::loggedInUser()->id);
        } 
        if ($data->filter_by_call_purpose != null) {
            $callLogReport->where('manual_logged_call.call_purpose', $data->filter_by_call_purpose);
        }
    })
    ->groupBy('manual_logged_call.id');
    return $callLogReport;
    }

    public function callLogReportDataTable($callLogReport)
    {
        return DataTables::of($callLogReport)
            ->addColumn('checkbox', function ($callLog) {
                return "<input type='checkbox' id='".$callLog->id."' name='sms' value='".$callLog->id."'>";
            })->addColumn('id', function ($callLog) {
                return $callLog->id;
            })->addColumn('lead_number', function ($callLog) {
                if ($callLog->lead_number != null || $callLog->lead_number != "") {
                    return $callLog->lead_number;
                } else {
                    return 'N.A';
                }
            })->addColumn('agent_number', function ($callLog) {
                if ($callLog->agent_number != null || $callLog->agent_number != "") {
                    return $callLog->agent_number;
                } else {
                    return 'N.A';
                }
            })->addColumn('did', function ($callLog) {
                if ($callLog->did != null || $callLog->did != "") {
                    return $callLog->did;
                } else {
                    return 'N.A';
                }
            })->addColumn('call_outcome', function ($callLog) {
                if ($callLog->outcome == '1') { 
                    return "in Process";
                }elseif ($callLog->outcome == '2') { 
                    return "Running";
                }elseif ($callLog->outcome == '3') { 
                    return "Both Answered";
                }elseif ($callLog->outcome == '4') { 
                    return "To (Customer) Answered - From (Agent) Unanswered";
                }elseif ($callLog->outcome == '5') { 
                    return "To (Customer) Answered";
                }elseif ($callLog->outcome == '6') { 
                    return "To (Customer) Unanswered - From (Agent) Answered";
                }elseif ($callLog->outcome == '7') { 
                    return "From (Agent) Unanswered";
                }elseif ($callLog->outcome == '8') { 
                    return "To (Customer) Unanswered";
                }elseif ($callLog->outcome == '9') { 
                    return "Both Unanswered";
                }elseif ($callLog->outcome == '10') { 
                    return "From (Agent) Answered";
                }elseif ($callLog->outcome == '11') { 
                    return "Rejected Call";
                }elseif ($callLog->outcome == '12') { 
                    return "Skipped";
                }elseif ($callLog->outcome == '13') { 
                    return "From (Agent) Failed";
                }elseif ($callLog->outcome == '14') { 
                    return "To (Customer) Failed - From (Agent) Answered";
                }elseif ($callLog->outcome == '15') { 
                    return "To (Customer) Failed";
                }elseif ($callLog->outcome == '16') { 
                    return "To (Customer) Answered - From (Agent) Failed";
                } else {
                    return 'N.A';
                }
            })->addColumn('call_purpose', function ($callLog) {
                if ($callLog->call_purpose != NULL || $callLog->call_purpose != "") { 
                    return $callLog->call_purpose;
                } else {
                    return 'N.A';
                }
            })->addColumn('call_type', function ($callLog) {
                    return ($callLog->call_type == '0') ? "Manual" : "Auto";
            })->addColumn('call_source', function ($callLog) {
                return ($callLog->call_source == 1) ? "Incoming" : "Outgoing";
                // if ($callLog->call_source == 1) { 
                //     return "Incoming";
                // } else if($callLog->call_source == 0){
                //     return "Outgoing";
                // }else{
                //     return 'N.A';
                // }
            })->addColumn('created_at', function ($callLog) {
                if ($callLog->created_at != null || $callLog->created_at != "") {
                    return date('d-M-Y H:i', strtotime($callLog->created_at));
                } else {
                    return 'N.A';
                }
            })->addColumn('duration', function ($callLog) {
                if ($callLog->duration != NULL || $callLog->duration != "") { 
                    return $callLog->duration;
                } else {
                    return 'N.A';
                }
            })->addColumn('recordings_file', function ($callLog) {
                if ($callLog->recordings_file != NULL || $callLog->recordings_file != "") {
                    //$recordings_file = str_replace("/","*",$callLog->recordings_file);
                    $userId = "17231630";
                    $token = "g575vT9yamViSspY5QYY";
                    $url = 'https://s-ct3.sarv.com/Audio/v1/recording?data={"userId": "'.$userId.'" ,"token": "'.$token.'" ,"file": "'.$callLog->recordings_file.'"}';
                    //return "<a class='play-audio' data-index='$url'>Play</a>";
                    return "<a href='$url' download class='play-audio'>Download</a>";
                    //return '<audio controls><source src="'.$callLog->recordings_file.'" type="audio/mpeg"></audio>';
                } else {
                    return 'N.A';
                } 
            })
            ->escapeColumns('checkbox')
            ->make(true);
    }


    public function getOngoingCallDetails($lead_number) {
        return DB::table('manual_logged_call')
                ->where('lead_number', $lead_number)
                //->where('agent_number', $agent_number)
                ->where('status', 0)
                ->orderBy('id', 'desc')
                ->first();
    }

    public function getCallDetails($lead_number, $agent_number) {
        return DB::table('manual_logged_call')
                ->where('lead_number', $lead_number)
                ->where('agent_number', $agent_number)
                ->where('status', 0)
                ->orderBy('id', 'desc')
                ->first();
    }

    public function updateCall($data, $request) 
    {
        $call_status = (isset($request->callStatus) && $request->callStatus == '3') ? 2 : 3;
        $agent_number = isset($request->masterAgentNumber) ? substr($request->masterAgentNumber, 2): '';
        DB::table('manual_logged_call')
            ->where('id', $data->id)
            ->update([ 
                'agent_number' =>  isset($request->CTC->from) ? $request->CTC->from : $agent_number, 
                'duration' =>  $request->talkDuration, 
                'outcome' =>  $request->callStatus,
                'recordings_file' => isset($request->recordings[0]->file) ? $request->recordings[0]->file : '',  
                'call_status' => $call_status,
                'status' => 1 
            ]);
    }

    public function addUnanswerIncomingCall($request) {
        $lead_number = substr($request->cNumber, 2);
        $leads = DB::table('leads')->where('mobile', $lead_number)->first();
        return ManualLoggedCall::create([
            'client_id' => '2',
            'member_id' => ($leads) ? $leads->id : '0',
            'lead_number' => isset($request->cNumber) ? substr($request->cNumber, 2) : '', 
            'did' => isset($request->did) ? $request->did : '', 
            'outcome' => '4',
            'status' => '1',
            'call_source' => '1'	   
        ]);
    }

    public function addCallLog($data, $request) {
        DB::table('auto_call_logs')->insert([
            'userId' => isset($request->userId) ? $request->userId : '', 
            'linker_id' => isset($data->id) ? $data->id : '', 
            'did' => isset($request->did) ? $request->did : '', 
            'cType' => isset($request->cType) ? $request->cType : '',
            'campId' => isset($request->campId) ? $request->campId : '',
            'ivrSTime' => isset($request->ivrSTime) ? $request->ivrSTime : '',
            'ivrETime' => isset($request->ivrETime) ? $request->ivrETime : '',
            'ivrDuration' => isset($request->ivrDuration) ? $request->ivrDuration : '',
            'cNumber' => isset($request->cNumber) ? $request->cNumber : '',
            'masterNumCTC' => isset($request->masterNumCTC) ? $request->masterNumCTC : '',
            'masterAgent' => isset($request->masterAgent) ? $request->masterAgent : '',
            'masterAgentNumber' => isset($request->masterAgentNumber) ? $request->masterAgentNumber	 : '',
            'inboundDuration' => isset($request->inboundDuration) ? $request->inboundDuration : '',
            'masterGroupId' => isset($request->masterGroupId) ? $request->masterGroupId : '',
            'talkDuration' => isset($request->talkDuration) ? $request->talkDuration : '',
            'agentOnCallDuration' => isset($request->agentOnCallDuration) ? $request->agentOnCallDuration : '',
            'callId' => isset($request->callId) ? $request->callId : '',
            'firstAttended' => isset($request->firstAttended) ? $request->firstAttended : '',
            'firstAnswerTime' => isset($request->firstAnswerTime) ? $request->firstAnswerTime : '',
            'lastHangupTime' => isset($request->lastHangupTime) ? $request->lastHangupTime : '',
            'lastFirstDuration' => isset($request->lastFirstDuration) ? $request->lastFirstDuration : '',
            'custAnswerSTime' => isset($request->custAnswerSTime) ? $request->custAnswerSTime : '',
            'custAnswerETime' => isset($request->custAnswerETime) ? $request->custAnswerETime : '',
            'custAnswerDuration' => isset($request->custAnswerDuration) ? $request->custAnswerDuration : '',
            'callStatus' => isset($request->callStatus) ? $request->callStatus : '',
            'ivrExecuteFlow' => isset($request->ivrExecuteFlow) ? $request->ivrExecuteFlow : '',
            'HangupBySourceDetected' => isset($request->HangupBySourceDetected) ? $request->HangupBySourceDetected : '',
            'totalHoldDuration' => isset($request->totalHoldDuration) ? $request->totalHoldDuration : '',
            'recordings_nodeid' => isset($request->recordings[0]->nodeid) ? $request->recordings[0]->nodeid : '',
            'recordings_visitId' => isset($request->recordings[0]->visitId) ? $request->recordings[0]->visitId : '',
            'recordings_file' => isset($request->recordings[0]->file) ? $request->recordings[0]->file : '',
            'recordings_time' => isset($request->recordings[0]->time) ? $request->recordings[0]->time : '',
            'created_at' => date('Y-m-d H:i:s'),	   
            'updated_at' => date('Y-m-d H:i:s')	   
        ]);
    }
//for import
    // public function importToDb()
    // {
        
    //     $path = resource_path('pending-files/*.csv');

    //     $files = glob($path);

    //     foreach ($files as $file) {

    //         ProcessCsvUpload::dispach($file);
    //     }
    // }










}
