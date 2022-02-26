<?php

namespace App\Exports;

use App\Lead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\DB;

class LeadsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    use Exportable;

    public function __construct(int $client_id, $lead_ids)
    {
        $this->client = $client_id;
        $this->members = $lead_ids;
    }

    public function collection()
    {
        if ($this->members != null) {
            $leads = DB::table('leads')
                //->leftJoin('campaign_lead', 'leads.id', 'campaign_lead.lead_id')
                //->leftJoin('users', 'campaign_lead.agent_id', 'users.id')
                //->leftJoin('campaigns', 'campaign_lead.campaign_id', 'campaigns.id')
                ->leftJoin('users', 'leads.agent_id', 'users.id')
                ->select(
                    'leads.id',
                    'leads.account_type',
                    'leads.member_id',
                    'leads.member_type',
                    'leads.department',
                    'leads.lead_source',
                    'leads.name',
                    'leads.gender',
                    'leads.email',
                    'leads.mobile',
                    'leads.address',
                    'leads.state',
                    'leads.district',
                    'leads.pincode',
                    'leads.date_of_birth',
                    'leads.date_of_joining',
                    'leads.blood_group',
                    'leads.married_status',
                    'leads.rfid',
                    'leads.alt_numbers',
                    'leads.country',
                    'leads.qualification',
                    'leads.branch',
                    'leads.sms_required',
                    'leads.call_required',
                    'profession',
                    'leads.sms_language',
                    'leads.lead_status',
                    'leads.preferred_language',
                    'leads.last_contacted_date',
                    //'campaigns.name as campaign'
                )->where('leads.client_id', $this->client)->whereIn('leads.id', $this->members)->orderBy('leads.updated_at', 'desc')->get();
            if (!empty($leads)) {
                foreach ($leads as $key => $lead) {
                    // $get_state = DB::table('state')->get();
                    // $get_district = DB::table('district')->get();
                    // $get_countries = DB::table('countries')->get();
                    //$family_members = DB::table('leadsdatas')->where('member_id', $id)->get();

                    if(!empty($lead->alt_numbers)){
                    if (json_decode($lead->alt_numbers) != null)
                        $leads[$key]->alt_numbers= implode(', ', json_decode($lead->alt_numbers));
                    else  $leads[$key]->alt_numbers='';
                    }else{
                        $leads[$key]->alt_numbers='';
                    }

                    if(!empty($lead->member_type)){
                    if (json_decode($lead->member_type) != null)
                    $leads[$key]->member_type = implode(', ', json_decode($lead->member_type));
                    else $leads[$key]->member_type = '';
                    }else{
                    $leads[$key]->member_type = '';
                    }
                    if (unserialize($lead->address) != null)
                    $leads[$key]->address = implode(', ', unserialize($lead->address));
                    else $leads[$key]->address = '';
                    if (unserialize($lead->district) != null){
                    $dist_arr = [];
                    foreach (unserialize($lead->district) as $district) {
                    array_push($dist_arr, DB::table('district')
                    ->where('DistCode', '=', $district)
                    ->pluck('DistrictName')->first());
                    }
                    $leads[$key]->district = implode(', ', $dist_arr);
                    }
                    else $leads[$key]->district = '';
                    if (unserialize($lead->state) != null){
                    $state_arr = [];
                    foreach (unserialize($lead->state) as $state) {
                    array_push($state_arr, DB::table('state')
                    ->where('StCode', '=', $state)
                    ->pluck('StateName')->first());
                    }
                    $leads[$key]->state = implode(', ', $state_arr);
                    }
                    else $leads[$key]->state = '';
                    if (unserialize($lead->pincode) != null)
                    $leads[$key]->pincode = implode(', ', unserialize($lead->pincode));
                    else $leads[$key]->pincode = '';
                    if (unserialize($lead->country) != null) {
                    $countr_arr = [];
                    foreach (unserialize($lead->country) as $country) {
                    array_push($countr_arr, DB::table('countries')
                    ->where('country_code', '=', $country)
                    ->pluck('country_name')->first());
                    }
                    $leads[$key]->country = implode(', ', $countr_arr);
                    } else $leads[$key]->country = '';

                    if ($lead->sms_required==0){
                        $leads[$key]->sms_required= 'No';
                    }elseif($lead->sms_required==1){
                        $leads[$key]->sms_required='Yes';
                    }
                    else{
                        $leads[$key]->sms_required='';
                    }

                    if ($lead->call_required==0){
                        $leads[$key]->call_required= 'No';
                    }elseif($lead->call_required==1){
                        $leads[$key]->call_required='Yes';
                    }
                    else{
                        $leads[$key]->call_required='';
                    }

                    if ($lead->lead_status==1){
                        $leads[$key]->lead_status= 'Assigned';
                    }elseif($lead->lead_status==2){
                        $leads[$key]->lead_status='Open';
                    }elseif($lead->lead_status==3){
                        $leads[$key]->lead_status='Converted';
                    }elseif($lead->lead_status==4){
                        $leads[$key]->lead_status='Follow Up';
                    }elseif($lead->lead_status==5){
                        $leads[$key]->lead_status='Closed';
                    }else{
                        $leads[$key]->lead_status='';
                    }


                }
            }
            return $leads;
        } else
            return Lead::query()->select('id', 'account_type', 'member_id', 'member_type', 'department', 'lead_source', 'name', 'gender', 'email', 'mobile', 'address', 'state', 'district', 'pincode', 'date_of_birth', 'date_of_joining', 'lead_status', 'preferred_language', 'last_contacted_date')->where('client_id', $this->client);
    }

    public function headings(): array
    {

        return [
            'ID',
            'Account Type',
            'Member Id',
            'Member Type',
            'Department',
            'Lead Source',
            'Name',
            'Gender',
            'Email',
            'Phone No',
            'Address',
            'State',
            'District',
            'Pincode',
            'Date of Birth',
            'Date of Joining',
            'Blood Group',
            'Married Status',
            'RFID',
            'Alternate Numbers',
            'Country',
            'Qualification',
            'Branch',
            'Sms Required',
            'Call Required',
            'Profession',
            'Sms Language',
            'Lead Status',
            'Preferred Language',
            'Last Lontacted Date',
            //'Campaign'
        ];
    }
}


public function exportSelected(Request $request)
    {
        if (Laralum::loggedInUser()->reseller_id == 0) {
            $client_id = Laralum::loggedInUser()->id;
        } else {
            $client_id = Laralum::loggedInUser()->reseller_id;
        }
        $filter_by_data_id = $request->input('filter_by_data_id');
        $filter_by_agent = $request->input('filter_by_agent');
        $filter_by_call_status = $request->input('filter_by_call_status');
        $filter_by_account_type = $request->input('filter_by_account_type');
        $filter_by_member_type = $request->input('filter_by_member_type');
        $filter_by_prayer_request = $request->input('filter_by_prayer_request');
        $filter_by_department = $request->input('filter_by_department');
        $filter_by_call = $request->input('filter_by_call');
        $filter_by_source = $request->input('filter_by_source');
        $filter_by_gender = $request->input('filter_by_gender');
        $filter_by_blood_group = $request->input('filter_by_blood_group');
        $filter_by_marital_status = $request->input('filter_by_marital_status');
        $filter_by_date_of_birth = $request->input('filter_by_date_of_birth');
        $filter_by_date_of_anniversary = $request->input('filter_by_date_of_anniversary');
        $filter_by_recently_contacted = $request->input('filter_by_recently_contacted');
        $filter_by_Date = $request->input('filter_by_Date');
        $filter_by_call_required = $request->input('filter_by_call_required');
        $filter_by_sms_required = $request->input('filter_by_sms_required');
        $filter_by_preferred_language = $request->input('filter_by_preferred_language');

        $filter_by_campaign = $request->input('filter_by_campaign');
        $filter_by_campaign_assigned = $request->input('filter_by_campaign_assigned');
        $filter_by_campaign_status = $request->input('filter_by_campaign_status');
        $filter_by_prayer_followup_date = $request->input('filter_by_prayer_followup_date');
        $filter_by_call_type = $request->input('filter_by_call_type');                            
        $filter_by_lead_response = $request->input('filter_by_lead_response');
        if(Laralum::loggedInUser()->id != 1){
            $agent_check=Laralum::loggedInUser()->id;
        }else{
            $agent_check="";
        }

        
        if($request->select_all_option_check==1){

            $manual = DB::table('manual_logged_call')
                    ->join('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
                    ->select('member_id')
                    ->where(function ($manual) use ($request) {
                        if ($request->filter_by_campaign != null) {
                            $manual->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
                        }
                        // if(Laralum::loggedInUser()->id != 1){
                        //     $manual->where('campaign_leads.agent_id', Laralum::loggedInUser()->id);
                        // }
                    })
                    ->where('manual_logged_call.status','1');
            $manuarray = $manual;

            $leadsData = DB::table('leads')
                        ->leftJoin('users', 'leads.agent_id', 'users.id')
                        ->leftJoin('campaign_leads', 'leads.id', 'campaign_leads.lead_id')
                        //->leftJoin('manual_logged_call', 'leads.id', 'manual_logged_call.member_id')
                        ->leftJoin('manual_logged_call', function ($leadsData) use ($request) {
                        $leadsData->on('leads.id', '=', 'manual_logged_call.member_id');
                            if ($request->filter_by_campaign != null) {
                                $leadsData->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
                            }
                        })
                        ->leftJoin('member_issues', 'leads.id', 'member_issues.member_id')
                        ->select('leads.id')
                        ->where('leads.client_id', $client_id)
                        ->where('leads.lead_status','!=',3)
                        ->when($filter_by_data_id, function ($query, $filter_by_data_id) {
                            return $query->where('leads.lead_status', $filter_by_data_id);
                        })
                        ->when($filter_by_agent, function ($query, $filter_by_agent) {
                            return $query->where('campaign_leads.agent_id', $filter_by_agent);
                        })
                        ->when($filter_by_call_status, function ($query, $filter_by_call_status) {
                            return $query->where('manual_logged_call.call_status', $filter_by_call_status);
                        })
                        ->when($filter_by_account_type, function ($query, $filter_by_account_type) {
                            return $query->where('leads.account_type', $filter_by_account_type);
                        })
                        ->when($filter_by_member_type, function ($query, $filter_by_member_type) {
                            return $query->where('leads.member_type', $filter_by_member_type);
                        })
                        ->when($filter_by_prayer_request, function ($query, $filter_by_prayer_request) {
                            return $query->where('leads.issue_id', $filter_by_prayer_request);
                        })
                        ->when($filter_by_department, function ($query, $filter_by_department) {
                            return $query->where('leads.department', $filter_by_department);
                        })
                        ->when($filter_by_call, function ($query, $filter_by_call) {
                            return $query->where('manual_logged_call.outcome', $filter_by_call);
                        })
                        ->when($filter_by_source, function ($query, $filter_by_source) {
                            return $query->where('leads.lead_source', $filter_by_source);
                        })
                        ->when($filter_by_gender, function ($query, $filter_by_gender) {
                            return $query->where('leads.gender', $filter_by_gender);
                        })
                        ->when($filter_by_blood_group, function ($query, $filter_by_blood_group) {
                            return $query->where('leads.blood_group', $filter_by_blood_group);
                        })

                        ->when($filter_by_marital_status, function ($query, $filter_by_marital_status) {
                            return $query->where('leads.married_status', $filter_by_marital_status);
                        })
                        ->when($filter_by_date_of_birth, function ($query, $filter_by_date_of_birth) {
                            $dateData = explode(' - ', $filter_by_date_of_birth);
                            return $query->whereBetween('leads.date_of_birth', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
                        })
                        ->when($filter_by_date_of_anniversary, function ($query, $filter_by_date_of_anniversary) {
                            $dateData1 = explode(' - ', $filter_by_date_of_anniversary);
                            return $query->whereBetween('leads.date_of_anniversary', [date("Y-m-d", strtotime($dateData1[0])), date("Y-m-d", strtotime($dateData1[1]))]);
                        })
                        ->when($filter_by_recently_contacted, function ($query, $filter_by_recently_contacted) {
                            $dateData3 = explode(' - ', $filter_by_recently_contacted);
                            return $query->whereBetween('leads.last_contacted_date', [date("Y-m-d", strtotime($dateData3[0])), date("Y-m-d", strtotime($dateData3[1]))]);
                        })
                        ->when($filter_by_Date, function ($query, $filter_by_Date) {
                            $dateData4 = explode(' - ', $filter_by_Date);
                            return $query->whereBetween('leads.created_at', [date("Y-m-d", strtotime($dateData4[0])), date("Y-m-d", strtotime($dateData4[1]))]);
                        })
                        ->when($filter_by_call_required, function ($query, $filter_by_call_required) {
                            return $query->where('leads.call_required', $filter_by_call_required);
                        })
                        ->when($filter_by_sms_required, function ($query, $filter_by_sms_required) {
                            return $query->where('leads.sms_required', $filter_by_sms_required);
                        })
                        ->when($filter_by_preferred_language, function ($query, $filter_by_preferred_language) {
                            return $query->where('leads.preferred_language', $filter_by_preferred_language);
                        })
                        ->when($agent_check, function ($query, $agent_check) {
                            return $query->where('campaign_leads.agent_id', $agent_check);
                        })
                        ->where(function ($leadsData) use ($request, $manuarray) {

                            $assigned_lead_ids = DB::table('campaign_leads')->groupBy('lead_id')->pluck('lead_id');
                            if ($request->filter_by_campaign != null) {
                                $leadsData->where('campaign_leads.campaign_id', $request->filter_by_campaign);
                            }

                            if ($request->filter_by_campaign_status == 1) {
                                $leadsData->whereNotIn('leads.id', $manuarray);
                            } elseif($request->filter_by_campaign_status == 2) {
                                $leadsData->where('manual_logged_call.call_status', 2)
                                    ->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
                            } elseif($request->filter_by_campaign_status == 3) {
                                $leadsData->where('manual_logged_call.call_status', 3)
                                    ->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
                            }

                            if ($request->filter_by_campaign_assigned == 'assigned') {
                                $leadsData->whereIn('leads.id', $assigned_lead_ids);
                            }
                            if($request->filter_by_campaign_assigned == 'unassigned'){
                                $leadsData->whereNotIn('leads.id', $assigned_lead_ids);
                            }
                            if ($request->filter_by_prayer_followup_date != null) {
                                $dateData4 = explode(' - ', $request->filter_by_prayer_followup_date);
                                $leadsData->whereBetween('member_issues.follow_up_date', [date("Y-m-d", strtotime($dateData4[0])), date("Y-m-d", strtotime($dateData4[1]))]);
                            }
                            if ($request->filter_by_lead_response != null) {
                                $leadsData->whereIn('leads.lead_response', $request->filter_by_lead_response);
                            }
                            if ($request->filter_by_call_type != null) {
                                $leadsData->where('manual_logged_call.call_type', $request->filter_by_call_type);
                            }

                        })

                    //->groupBy('leads.id')->pluck('leads.id');

                    ->groupBy('leads.id')->get();
                    $leads=[];
                    foreach ($leadsData as $key => $value) {
                        $leads[] .=$value->id;
                    }
                    if(count($leads) > 0){
                        return Excel::download(new LeadsExport($client_id, $leads), 'leads.xlsx');
                    }else{
                        return redirect()->back();
                    }
            
        }else{
            return Excel::download(new LeadsExport($client_id, $request->ids), 'leads.xlsx');
        }
        
    }
