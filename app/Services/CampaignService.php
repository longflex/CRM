<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Laralum\Laralum;
use App\Campaign;
use App\CampaignAgent;
use App\User;

/**
 * Class CampaignService
 * @package App\Services\Campaign
 */
class CampaignService
{
    public function getCampaignForTable($data,$client_id) {
        // $camps = Campaign::with('campaign_agents.user_list')
        //                 ->whereHas('campaign_agents.user_list', function($query) {
        //                     $query->select('name');
        //                 })
        //                 ->select('id', 'name', 'type', 'status');
        $camps = DB::table('campaign_leads')
                    ->join('campaigns', 'campaigns.id', 'campaign_leads.campaign_id') 
                    ->join('leads', 'campaign_leads.lead_id', '=', 'leads.id')
                    ->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
                    ->leftJoin('manual_logged_call', function ($camps) use ($data) {
                        $camps->on('campaign_leads.lead_id', '=', 'manual_logged_call.member_id');
                        if ($data->filter_by_campaign != null) {
                            $camps->where('manual_logged_call.campaign_id', $data->filter_by_campaign);
                        }
                    })
                    ->select('campaign_leads.id', 'campaign_leads.campaign_id', 'campaigns.type', 'campaigns.status','leads.name','manual_logged_call.outcome','manual_logged_call.call_purpose','users.name as assigned_to','users.mobile as user_mobile','leads.mobile as lead_mobile')
                    ->where('campaigns.client_id', $client_id)
                    
                    ->where(function ($camps) use ($data) {
                        $manual = DB::table('manual_logged_call')
                            ->join('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
                            ->select('member_id')
                            ->where(function ($manual) use ($data) {
                                if ($data->filter_by_campaign != null) {
                                    $manual->where('manual_logged_call.campaign_id', $data->filter_by_campaign);
                                }
                            })
                            ->where('manual_logged_call.status','1')
                            ->get();
                        $manuarray = [];
                        foreach($manual as $manu){
                            $manuarray[] = $manu->member_id;
                        }
                        if ($data->filter_by_campaign != null) {
                            $camps->where('campaign_leads.campaign_id', $data->filter_by_campaign);
                        }
                        if ($data->filter_by_agent != null) {
                            $camps->where('campaign_leads.agent_id', $data->filter_by_agent);
                        }
                        if ($data->filter_by_campaign_status == 1) {
                            $camps->whereNotIn('leads.id', $manuarray);
                        } elseif($data->filter_by_campaign_status == 2) {
                            $camps->where('manual_logged_call.call_status', 2)
                                ->where('manual_logged_call.campaign_id', $data->filter_by_campaign);
                        } elseif($data->filter_by_campaign_status == 3) {
                            $camps->where('manual_logged_call.call_status', 3)
                                ->where('manual_logged_call.campaign_id', $data->filter_by_campaign);
                        }  elseif($data->filter_by_campaign_status == 0) {
                           // $leads->where('manual_logged_call.call_status', 2)->orWhere('manual_logged_call.call_status', 3);
                        }
                        if ($data->filter_by_call_type != null) {
                            $camps->where('manual_logged_call.call_type', $data->filter_by_call_type);
                        }

                        if ($data->filter_by_call_purpose != null) {
                            $camps->where('manual_logged_call.call_purpose', $data->filter_by_call_purpose);
                        }

                        if ($data->filter_by_date_range != null) {
                            $dateData = explode(' - ', $data->filter_by_date_range);
                            if($dateData[0] == $dateData[1]){
                                $camps->whereDate('manual_logged_call.updated_at', date("Y-m-d", strtotime($dateData[0])));
                            }else{
                                $camps->whereBetween('manual_logged_call.updated_at', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
                            }
                        }
                        // if ($data->filter_by_agentGroup != null && $data->filter_by_agentGroup != "") {
                        //     $agentGroupId =DB::table('role_user')->where('role_id', $data->filter_by_agentGroup)->pluck('user_id');
                        //     $camps->whereIn('campaign_leads.agent_id', $agentGroupId);
                        // }

                        //to do
                        if(Laralum::loggedInUser()->id != 1){
                            $camps->where('campaign_leads.agent_id', Laralum::loggedInUser()->id);
                        }
                    });


        // $camps->groupBy('campaigns.id');
        // dd($camps->get());
        return $camps;
    }

    /**
     * @param $camps
     * @return mixed
     * @throws \Exception
     */
    public function campaignDataTable($camps)
    {
        return DataTables::of($camps)
            ->addColumn('checkbox', function ($camp) {
                return "<input type='checkbox' id='".$camp->id."' name='sms' value='".$camp->id."'>";
            })->addColumn('name', function ($camp) {
                if ($camp->name != null || $camp->name != "") {
                    return $camp->name;
                } else {
                    return 'N.A';
                }
            })->addColumn('assigned_to', function ($camp) {
                if ($camp->assigned_to != null || $camp->assigned_to != "") {
                    return $camp->assigned_to;
                } else {
                    return 'N.A';
                }
            })->addColumn('call_status', function ($camp) {
                if ($camp->outcome != NULL || $camp->outcome != "") {
                    if ($camp->outcome == '1') {
                        return 'in Process';
                    } elseif($camp->outcome == '2') {
                        return 'Running';
                    } elseif($camp->outcome == '3') {
                        return 'Both Answered';
                    }elseif($camp->outcome == '4') {
                        return 'To (Customer) Answered - From (Agent) Unanswered';
                    } elseif($camp->outcome == '5') {
                        return 'To (Customer) Answered';
                    }elseif($camp->outcome == '6') {
                        return 'To (Customer) Unanswered - From (Agent) Answered.';
                    } elseif($camp->outcome == '7') {
                        return 'From (Agent) Unanswered';
                    }elseif($camp->outcome == '8') {
                        return 'To (Customer) Unanswered.';
                    } elseif($camp->outcome == '9') {
                        return 'Both Unanswered';
                    }elseif($camp->outcome == '10') {
                        return 'From (Agent) Answered.';
                    } elseif($camp->outcome == '11') {
                        return 'Rejected Call';
                    }elseif($camp->outcome == '12') {
                        return 'Skipped';
                    } elseif($camp->outcome == '13') {
                        return 'From (Agent) Failed.';
                    }elseif($camp->outcome == '14') {
                        return 'To (Customer) Failed - From (Agent) Answered';
                    } elseif($camp->outcome == '15') {
                        return 'To (Customer) Failed';
                    }elseif($camp->outcome == '16') {
                        return 'To (Customer) Answered - From (Agent) Failed';
                    }
                } else {
                    return 'N.A';
                }
                
            })->addColumn('lead_mobile', function ($camp) {
                if ($camp->lead_mobile != null || $camp->lead_mobile != "") {
                    return $camp->lead_mobile;
                } else {
                    return 'N.A';
                }
            })->addColumn('user_mobile', function ($camp) {
                if ($camp->user_mobile != null || $camp->user_mobile != "") {
                    return $camp->user_mobile;
                } else {
                    return 'N.A';
                }
            })->addColumn('campaign_status', function ($camp) {
                if ($camp->status != null || $camp->status != "") {
                    if ($camp->status == '1') {
                        return 'Pause';
                    } elseif($camp->status == '2') {
                        return 'Stop';
                    } elseif($camp->status == '3') {
                        return 'Resume';
                    }
                } else {
                    return 'N.A';
                }
            })->addColumn('call_purpose', function ($camp) {
                if ($camp->call_purpose != null || $camp->call_purpose != "") {
                    return $camp->call_purpose;
                } else {
                    return 'N.A';
                }
            })->addColumn('action', function ($camp) {
                $action = '<a href="javascript:void(0);" onclick="campaignAssignedLeadDestroy('.$camp->id.','.$camp->campaign_id.')" title="Delete assigned lead"><i class="uil-trash font-16"></i></a>';
                return $action;
             })
            ->escapeColumns('checkbox,action')
            ->make(true);
    }

    
}
