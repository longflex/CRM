<?php


namespace App\Services;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Laralum\Laralum;
use Illuminate\Support\Facades\Auth;

/**
 * Class MemberService
 * @package App\Services\Member
 */
class MemberService
{
    /**
     * @param $data
     */
  

    /**
     * @return \Illuminate\Support\Collection
     */

    public function getMemberForTable($data,$client_id){
        $leads = DB::table('leads'); 
                if (($data->filter_by_campaign != null && $data->filter_by_campaign != 0) || $data->filter_by_agent != null || $data->filter_by_campaign != null) {
                    $leads->leftJoin('campaign_leads', 'leads.id', 'campaign_leads.lead_id');
                }
                    //->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
                    //->leftJoin('manual_logged_call', 'leads.id', 'manual_logged_call.member_id')

                    if ($data->filter_by_call_status != '' || $data->filter_by_campaign_status == 2 || $data->filter_by_campaign_status == 3) {                        
                        $leads->leftJoin('manual_logged_call', function ($leads) use ($data) {
                            $leads->on('leads.id', '=', 'manual_logged_call.member_id');
                            if ($data->filter_by_campaign != null && $data->filter_by_campaign != 0) {
                                $leads->where('manual_logged_call.campaign_id', $data->filter_by_campaign);
                            }
                        });
                    }

                    $leads->leftJoin('member_issues', 'leads.id', 'member_issues.member_id');

                    if ($data->filter_by_call_status != '' || $data->filter_by_campaign_status == 2 || $data->filter_by_campaign_status == 3) {
                        $leads->select('leads.id', 'leads.member_id','leads.name', 'leads.sponsor_code', 'leads.partner_code', 'leads.mobile', 'leads.lead_status', 'leads.last_contacted_date', 'leads.preferred_language', 'manual_logged_call.outcome','manual_logged_call.created_at','manual_logged_call.description','manual_logged_call.date','manual_logged_call.duration', 'manual_logged_call.call_status');
                    }else{                            
                        $leads->select('leads.id', 'leads.member_id','leads.name', 'leads.sponsor_code', 'leads.partner_code', 'leads.mobile', 'leads.lead_status', 'leads.last_contacted_date', 'leads.preferred_language');
                    }
                    $leads->where('leads.lead_status', '=', 3)
                    ->where('leads.client_id', $client_id)
                    ->where(function ($leads) use ($data) {

        if ($data->filter_by_campaign_assigned == 'assigned' || $data->filter_by_campaign_assigned == 'unassigned') {
            $assigned_lead_ids = DB::table('campaign_leads')->groupBy('lead_id')->pluck('lead_id');
        }            
        if ($data->filter_by_campaign_status == 1) {
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
        }

        if ($data->filter_by_data_id != null) {
            $leads->where('leads.lead_status', $data->filter_by_data_id);
        }

        if ($data->filter_by_campaign != null && $data->filter_by_campaign != 0) {
            $leads->where('campaign_leads.campaign_id', $data->filter_by_campaign);
        }else{
            // $campaignarray = DB::table('campaign_agents')
            // ->select('campaign_id')
            // ->where(function ($manual) use ($data) {
            //     if(Laralum::loggedInUser()->id != 1){
            //         $manual->where('agent_id', Laralum::loggedInUser()->id);
            //     }
            // })
            // ->groupBy('campaign_id');
            //$leads->whereIn('campaign_leads.campaign_id', $campaignarray);
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
            $leads->where('leads.member_type', 'like', '%' . $data->filter_by_member_type . '%');
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
            $newDate = date("Y-m-d", strtotime($dateData[0]));
            //$leads->whereBetween('leads.date_of_birth', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
            $leads->where(function ($data) use ($newDate) {
                $data->whereMonth('leads.date_of_birth', Carbon::createFromFormat('Y-m-d', $newDate)->month)
                    ->whereDay('leads.date_of_birth', Carbon::createFromFormat('Y-m-d', $newDate)->day);
            });
        }
        if ($data->filter_by_date_of_anniversary != null) {
            $dateData1 = explode(' - ', $data->filter_by_date_of_anniversary);
            $leads->whereBetween('leads.date_of_anniversary', [date("Y-m-d", strtotime($dateData1[0])), date("Y-m-d", strtotime($dateData1[1]))]);
        }
        if ($data->filter_by_recently_contacted != null) {
            $dateData3 = explode(' - ', $data->filter_by_recently_contacted);
            $leads->whereBetween('leads.last_contacted_date', [date("Y-m-d", strtotime($dateData3[0])), date("Y-m-d", strtotime($dateData3[1]))]);
        }
        if(Laralum::loggedInUser()->id != 1){
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
    return $leads;
}
                    
    

    /**
     * @param $leads
     * @return mixed
     * @throws \Exception
     */
    public function memberDataTable($leads)
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
            })->addColumn('preferred_language', function ($lead) {
                if ($lead->preferred_language != null || $lead->preferred_language != "") {
                    return $lead->preferred_language;
                } else {
                    return 'Not available';
                }
            })->addColumn('action', function ($lead) {
                return '<a href="' . route('Crm::member_edit',['id'=>$lead->id]) . '"><i class="uil-edit"></i></a> <a href="javascript:void(0);" data-id="'.$lead->id.'" onclick="destroy('.$lead->id.')"><i class="uil-trash"></i></a>';
            })
            ->escapeColumns('checkbox,action')
            ->make(true);
    }

    public function getMemberOccasionForTable($data){
        // $occasions = DB::table('leads')->where('leads.lead_status', '=', 3);
        //             //->leftJoin('agent_leads', 'leads.id', 'agent_leads.lead_id')
        //             //->leftJoin('users', 'leads.user_id', 'users.id');
        //         if (Laralum::loggedInUser()->reseller_id == 0) {
        //             $occasions->where('leads.client_id', Laralum::loggedInUser()->id);
        //         } else {
        //             $occasions->where('leads.client_id', Laralum::loggedInUser()->reseller_id);
        //         }
        //         if ($data->filter_by_data_id != null) {
        //             $filter_by_data_id = $data->filter_by_data_id;
        //             $occasions->where(function ($data) use ($filter_by_data_id) {
        //                 $data->whereMonth('leads.date_of_birth', Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->month)
        //                     ->whereDay('leads.date_of_birth', Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->day);
        //             });
        //             $occasions->orWhere(function ($data) use ($filter_by_data_id) {
        //                 $data->whereDay('leads.date_of_anniversary', Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->day)
        //                       ->whereMonth('leads.date_of_anniversary', Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->month);
        //             });
        //             // $occasions->where(function ($data) use ($filter_by_data_id) {
        //             //     $data->whereMonth('leads.date_of_birth', Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->month)
        //             //         ->whereDay('leads.date_of_birth', Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->day)
        //             //           ->whereDay('leads.date_of_anniversary', Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->day)
        //             //           ->whereMonth('leads.date_of_anniversary', Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->month);
        //             // });
        //            // $occasions->orWhere('leads.date_of_birth', $data->filter_by_data_id);
        //             //$occasions->orWhere('leads.date_of_anniversary', $data->filter_by_data_id);
        //         }



        //         // if ($data->filter_by_account_type != null) {
        //         //     $occasions->where('leads.account_type', $data->filter_by_account_type);
        //         // }
        //         // if ($data->filter_by_member_type != null) {
        //         //     $occasions->where('leads.member_type', $data->filter_by_member_type);
        //         // }
   
                
        //         // if ($data->filter_by_date_of_anniversary != null) {
        //         //     $dateData1 = explode(' - ', $data->filter_by_date_of_anniversary);
        //         //     $occasions->whereBetween('leads.date_of_anniversary', [date("Y-m-d", strtotime($dateData1[0])), date("Y-m-d", strtotime($dateData1[1]))]);
        //         // }
        //         // if ($data->filter_by_recently_contacted != null) {
        //         //     $dateData3 = explode(' - ', $data->filter_by_recently_contacted);
        //         //     $occasions->whereBetween('leads.last_contacted_date', [date("Y-m-d", strtotime($dateData3[0])), date("Y-m-d", strtotime($dateData3[1]))]);
        //         // }
        //         $occasions->select('leads.id', 'leads.name', 'leads.date_of_anniversary', 'leads.date_of_birth', 'leads.mobile', 'leads.profile_photo');
        //             // ->orderBy('leads.updated_at','desc');
        //         // foreach ($occasions as $key => $value) {$value->date_of_anniversary==0;
        //             /*if ((Carbon::createFromFormat('Y-m-d', $value->date_of_birth)->day) == (Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->day) && (Carbon::createFromFormat('Y-m-d', $value->date_of_birth)->month)== (Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->month)){
        //                 $occasions[$key]->date_of_birth= 'Yes';
        //             }
        //             else{
        //                 $occasions[$key]->date_of_birth='';
        //             } 
        //              if ((Carbon::createFromFormat('Y-m-d', $value->date_of_anniversary)->day) == (Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->day) && (Carbon::createFromFormat('Y-m-d', $value->date_of_anniversary)->month) == (Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->month)){
        //                 $occasions[$key]->date_of_anniversary= 'Yes';
        //             }
        //             else{
        //                 $occasions[$key]->date_of_anniversary='';
        //             }*/
        //         //}
        // return $occasions;
        
        error_log("\n".date("Y-m-d h:i:sa")."\n".$data->draw."\n".$data."\n"."\n"."\n", 3, "c:/my-errors.log");
        error_log("\n".date("Y-m-d H:i:s.").gettimeofday()['usec']."\n".round(microtime(true) * 1000)."\n -2 \n", 3, "c:/my-errors.log");
        $results = DB::select( DB::raw("SELECT id,name,mobile FROM leads  WHERE lead_status = 3 AND client_id = 1 AND (date_of_anniversary LIKE '%01-05' OR date_of_birth LIKE '%01-05') LIMIT 0,10") );
        $results = DB::table('leads')->select(DB::raw("count(id)"))->whereRaw("lead_status = 3 AND client_id = 1 AND (date_of_anniversary LIKE '%01-05' OR date_of_birth LIKE '%01-05')")->get();
        error_log($results."\n".date("Y-m-d H:i:s.").gettimeofday()['usec']."\n".round(microtime(true) * 1000)."\n -1 \n", 3, "c:/my-errors.log");
        //$acount = count($results);
        $a = (int) filter_var($results, FILTER_SANITIZE_NUMBER_INT);  
        //$a = explode("}",explode(":",$results)[1]);
        error_log($a."\n".date("Y-m-d H:i:s.").gettimeofday()['usec']."\n".round(microtime(true) * 1000)."\n -3 \n", 3, "c:/my-errors.log");
        // error_log("\n---3---\ngetMemberOccasionForTable(service)\n".date("Y-m-d h:i:sa")."\n", 3, "c:/my-errors.log");        
        //$re = print_r($results);
        //var_dump($results);
        // $arr = [];
        // $arr["val1"]=10;
        // $arr["val2"]=20;
        // $object = (object) $arr;
        $offs = $data->start;
        $len = $data->length;
        // $total = DB::table('leads')->count();
        // $datasets = DB::table('leads')->select('id','name', 'mobile')->offset($offs)->limit(10)->get();
        // foreach($datasets as $dataset){
        //     $dataset->occasion = 'Birthday';
        // }

        // $txt = '{"draw":'.$data->draw.',"recordsTotal":'.$total.',"recordsFiltered":'.$total.',"data":';
        // $txt .= $datasets;
        // $txt .= '}';

        //$occasions = DB::table('leads')->select('leads.name','leads.mobile');
        // error_log("\n---3---\ngetMemberOccasionForTable(service)\n".date("Y-m-d h:i:sa")."\n"."\n"."\n".$txt."\n"."\n", 3, "c:/my-errors.log");
        error_log("\n".date("Y-m-d H:i:s.").gettimeofday()['usec']."\n".round(microtime(true) * 1000)."\n 0 \n", 3, "c:/my-errors.log");
        $occasions = DB::table('leads')->where('leads.lead_status', '=', 3);
                    //->leftJoin('agent_leads', 'leads.id', 'agent_leads.lead_id')
                    //->leftJoin('users', 'leads.user_id', 'users.id');
                    $idd = '';
                if (Laralum::loggedInUser()->reseller_id == 0) {
                    $occasions->where('leads.client_id', Laralum::loggedInUser()->id);
                    $idd = Laralum::loggedInUser()->id;
                } else {
                    $occasions->where('leads.client_id', Laralum::loggedInUser()->reseller_id);
                    $idd = Laralum::loggedInUser()->reseller_id;
                }
                if ($data->filter_by_data_id != null) {
                    $filter_by_data_id = $data->filter_by_data_id;
                    $occasions->where(function ($data) use ($filter_by_data_id) {
                        $data->whereMonth('leads.date_of_birth', Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->month)
                            ->whereDay('leads.date_of_birth', Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->day);
                    });
                    $occasions->orWhere(function ($data) use ($filter_by_data_id) {
                        $data->whereDay('leads.date_of_anniversary', Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->day)
                              ->whereMonth('leads.date_of_anniversary', Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->month);
                    });
                     // $occasions->where(function ($data) use ($filter_by_data_id) {
                    //     $data->whereMonth('leads.date_of_birth', Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->month)
                    //         ->whereDay('leads.date_of_birth', Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->day)
                    //           ->whereDay('leads.date_of_anniversary', Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->day)
                    //           ->whereMonth('leads.date_of_anniversary', Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->month);
                    // });
                   // $occasions->orWhere('leads.date_of_birth', $data->filter_by_data_id);
                    //$occasions->orWhere('leads.date_of_anniversary', $data->filter_by_data_id);
                }
                //$tt = print_r($occasions);
                error_log("\n".date("Y-m-d H:i:s.").gettimeofday()['usec']."\n".$idd."\n".round(microtime(true) * 1000)."\n 1 \n", 3, "c:/my-errors.log");


                // if ($data->filter_by_account_type != null) {
                //     $occasions->where('leads.account_type', $data->filter_by_account_type);
                // }
                // if ($data->filter_by_member_type != null) {
                //     $occasions->where('leads.member_type', $data->filter_by_member_type);
                // }
   
                
                // if ($data->filter_by_date_of_anniversary != null) {
                //     $dateData1 = explode(' - ', $data->filter_by_date_of_anniversary);
                //     $occasions->whereBetween('leads.date_of_anniversary', [date("Y-m-d", strtotime($dateData1[0])), date("Y-m-d", strtotime($dateData1[1]))]);
                // }
                // if ($data->filter_by_recently_contacted != null) {
                //     $dateData3 = explode(' - ', $data->filter_by_recently_contacted);
                //     $occasions->whereBetween('leads.last_contacted_date', [date("Y-m-d", strtotime($dateData3[0])), date("Y-m-d", strtotime($dateData3[1]))]);
                // }
                $occasions->select('leads.id', 'leads.name', 'leads.date_of_anniversary', 'leads.date_of_birth', 'leads.mobile', 'leads.profile_photo');
                $t2 = round(microtime(true) * 1000);
                error_log("\n".date("Y-m-d H:i:s.").gettimeofday()['usec']."\n".$t2."\n 2 \n", 3, "c:/my-errors.log");
                $total = $occasions->count();
                $t3 = round(microtime(true) * 1000);
                $tgap = $t3-$t2;
                error_log("\n".date("Y-m-d H:i:s.").gettimeofday()['usec']."\n".$t3.'|'.$tgap."\n 3 \n", 3, "c:/my-errors.log");
                $datasets = $occasions->offset($offs)->limit($len)->get();
                $t4 = round(microtime(true) * 1000);
                $tgap = $t4-$t3;
                error_log("\n".date("Y-m-d H:i:s.").gettimeofday()['usec']."\n".$t4.'|'.$tgap."\n 4 \n", 3, "c:/my-errors.log");
                foreach($datasets as $dataset){
                    $dataset->occasion = 'Birthday';
                }
                error_log("\n".date("Y-m-d H:i:s.").gettimeofday()['usec']."\n".round(microtime(true) * 1000)."\n 5 \n", 3, "c:/my-errors.log");
                $txt = '{"draw":'.$data->draw.',"recordsTotal":'.$total.',"recordsFiltered":'.$total.',"data":';
                $txt .= $datasets;
                $txt .= '}';
                    // ->orderBy('leads.updated_at','desc');
                // foreach ($occasions as $key => $value) {$value->date_of_anniversary==0;
                    /*if ((Carbon::createFromFormat('Y-m-d', $value->date_of_birth)->day) == (Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->day) && (Carbon::createFromFormat('Y-m-d', $value->date_of_birth)->month)== (Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->month)){
                        $occasions[$key]->date_of_birth= 'Yes';
                    }
                    else{
                        $occasions[$key]->date_of_birth='';
                    } 
                    if ((Carbon::createFromFormat('Y-m-d', $value->date_of_anniversary)->day) == (Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->day) && (Carbon::createFromFormat('Y-m-d', $value->date_of_anniversary)->month) == (Carbon::createFromFormat('Y-m-d', $filter_by_data_id)->month)){
                        $occasions[$key]->date_of_anniversary= 'Yes';
                    }
                    else{
                        $occasions[$key]->date_of_anniversary='';
                    }*/
                //}
                //error_log("\n---start---\ngetMemberOccasionForTable(service)\n".date("Y-m-d h:i:sa")."\n".$occasions."\n", 3, "c:/my-errors.log");
                //error_log("\n***start***\nservice_first\n".date("Y-m-d h:i:sa")."\n".response()->json($occasions)."\n***end***\n", 3, "c:/my-errors.log");
                error_log("\n".date("Y-m-d H:i:s.").gettimeofday()['usec']."\n".round(microtime(true) * 1000)."\n 6 \n", 3, "c:/my-errors.log");
                return $txt;
        
        
    }

    /**
     * @param $leads
     * @return mixed
     * @throws \Exception
     */
    public function memberOccasionDataTable($occasions)
    {
        return DataTables::of($occasions)
            ->addColumn('checkbox', function ($occasions) {
                return "<input type='checkbox' id='".$occasions->id."' name='sms' value='".$occasions->id."'>";
            })->addColumn('image', function ($occasions) {
                if ($occasions->name != null || $occasions->name != "") {
                    return '<div class="media"><img class="mr-2 rounded-circle" src="'.$occasions->profile_photo.'" width="40" alt="NA"></div>';
                } else {
                    return 'N.A';
                }
            })->addColumn('name', function ($occasions) {
                if ($occasions->name != null || $occasions->name != "") {
                    return '<div class="media"><div class="media-body"><h5 class="mt-0 mb-1">'.$occasions->name.'</h5></div>';
                } else {
                    return 'N.A';
                }
            })->addColumn('mobile', function ($occasions) {
                if ($occasions->mobile != null || $occasions->mobile != "") {
                    return $occasions->mobile;
                } else {
                    return 'N.A';
                }
            })->addColumn('occasion', function ($occasions) {
                if ($occasions->date_of_birth != null || $occasions->date_of_birth != "") {
                    return "Birthday";
                }elseif ($occasions->date_of_anniversary != null || $occasions->date_of_anniversary != "") {
                    return "Anniversary";
                } else {
                    return 'N.A';
                }
            })
            ->escapeColumns('checkbox')
            ->make(true);
    }

    public function getMemberUpcomingOccasionForTable($data){
        $currentDt= date('Y-m-d');
        $occasions = DB::table('leads')->where('leads.lead_status', '=', 3);
                    //->leftJoin('agent_leads', 'leads.id', 'agent_leads.lead_id')
                    //->leftJoin('users', 'leads.user_id', 'users.id');
                if (Laralum::loggedInUser()->reseller_id == 0) {
                    $occasions->where('leads.client_id', Laralum::loggedInUser()->id);
                } else {
                    $occasions->where('leads.client_id', Laralum::loggedInUser()->reseller_id);
                }

                $occasions->where(function ($data) use ($currentDt) {
                    $data->whereDay('leads.date_of_birth', '>=', date('d', strtotime($currentDt)))->whereMonth('leads.date_of_birth', '>=', Carbon::createFromFormat('Y-m-d', $currentDt)->month);
                });

                $occasions->orWhere(function ($data) use ($currentDt) {
                    $data->whereDay('leads.date_of_anniversary', '>=',date('d', strtotime($currentDt)))
                        ->whereMonth('leads.date_of_anniversary', '>=', Carbon::createFromFormat('Y-m-d', $currentDt)->month);
                });
                // $occasions->where(function ($data) use ($currentDt) {
                //     $data->where('leads.date_of_birth', '>=',Carbon::createFromFormat('Y-m-d', $currentDt))->whereMonth('leads.date_of_birth', '>=', Carbon::createFromFormat('Y-m-d', $currentDt)->month)
                //         ->orWhere('leads.date_of_anniversary', '>=',Carbon::createFromFormat('Y-m-d', $currentDt))
                //         ->orWhereMonth('leads.date_of_anniversary', '>=', Carbon::createFromFormat('Y-m-d', $currentDt)->month);
                // });

                // if ($data->filter_by_account_type != null) {
                //     $occasions->where('leads.account_type', $data->filter_by_account_type);
                // }
                // if ($data->filter_by_member_type != null) {
                //     $occasions->where('leads.member_type', $data->filter_by_member_type);
                // }
   
                
                // if ($data->filter_by_date_of_anniversary != null) {
                //     $dateData1 = explode(' - ', $data->filter_by_date_of_anniversary);
                //     $occasions->whereBetween('leads.date_of_anniversary', [date("Y-m-d", strtotime($dateData1[0])), date("Y-m-d", strtotime($dateData1[1]))]);
                // }
                // if ($data->filter_by_recently_contacted != null) {
                //     $dateData3 = explode(' - ', $data->filter_by_recently_contacted);
                //     $occasions->whereBetween('leads.last_contacted_date', [date("Y-m-d", strtotime($dateData3[0])), date("Y-m-d", strtotime($dateData3[1]))]);
                // }
                $occasions->select('leads.id', 'leads.name', 'leads.date_of_anniversary', 'leads.date_of_birth', 'leads.mobile', 'leads.profile_photo');
                    // ->orderBy('leads.updated_at','desc');
        return $occasions;
    }

    /**
     * @param $leads
     * @return mixed
     * @throws \Exception
     ->addColumn('checkbox', function ($occasions) {
                return "<input type='checkbox' id='".$occasions->id."' name='sms' value='".$occasions->id."'>";
            })->addColumn('image', function ($occasions) {
                if ($occasions->name != null || $occasions->name != "") {
                    return '<div class="media"><img class="mr-2 rounded-circle" src="'.$occasions->profile_photo.'" width="40" alt="NA"></div>';
                } else {
                    return 'N.A';
                }
            })
     */
    public function memberUpcomingOccasionDataTable($occasions)
    {
        return DataTables::of($occasions)
            ->addColumn('name', function ($occasions) {
                if ($occasions->name != null || $occasions->name != "") {
                    return $occasions->name;
                } else {
                    return 'N.A';
                }
            })->addColumn('birthday', function ($occasions) {
                if ($occasions->date_of_birth != null || $occasions->date_of_birth != "") {
                    return date('d-M', strtotime($occasions->date_of_birth));
                } else {
                    return 'N.A';
                }
            })
            ->addColumn('anniversary', function ($occasions) {
                if ($occasions->date_of_anniversary != null || $occasions->date_of_anniversary != "") {
                    return date('d-M', strtotime($occasions->date_of_anniversary));
                } else {
                    return 'N.A';
                }
            })
            //->escapeColumns('checkbox')
            ->make(true);
    }

}
