<?php

namespace App\Exports;

use App\CampaignLead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\DB;

class CampaignExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    use Exportable;

    public function __construct(int $client_id, $camps)
    {
        $this->client_id = $client_id;
        $this->camps_id = $camps;
    }

    public function collection()
    {
        if ($this->camps_id != null) {
            $camps = DB::table('campaign_leads')
                ->join('campaigns', 'campaigns.id', 'campaign_leads.campaign_id') 
                ->join('leads', 'campaign_leads.lead_id', '=', 'leads.id')
                ->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
                ->leftJoin('manual_logged_call', 'campaign_leads.lead_id', 'manual_logged_call.member_id')
                ->select(
                    'campaign_leads.id',
                    'campaigns.name',
                    'leads.name as lead_name',
                    'manual_logged_call.outcome',
                    'manual_logged_call.call_purpose',
                    'users.name as assigned_to'

                )->where('campaigns.client_id', $this->client_id)->whereIn('campaign_leads.id', $this->camps_id)->orderBy('campaign_leads.id', 'desc')->get();
            if (!empty($camps)) {
                foreach ($camps as $key => $camp) {


                    if ($camp->outcome==1){
                        $camps[$key]->outcome= 'in Process';
                    }elseif($camp->outcome==2){
                        $camps[$key]->outcome='Running';
                    }elseif($camp->outcome==3){
                        $camps[$key]->outcome='Both Answered';
                    }elseif($camp->outcome==4){
                        $camps[$key]->outcome='To (Customer) Answered - From (Agent) Unanswered';
                    }elseif($camp->outcome==5){
                        $camps[$key]->outcome='To (Customer) Answered';
                    }elseif($camp->outcome==6){
                        $camps[$key]->outcome='To (Customer) Unanswered - From (Agent) Answered.';
                    }elseif($camp->outcome==7){
                        $camps[$key]->outcome='From (Agent) Unanswered';
                    }elseif($camp->outcome==8){
                        $camps[$key]->outcome='To (Customer) Unanswered.';
                    }elseif($camp->outcome==9){
                        $camps[$key]->outcome='Both Unanswered';
                    }elseif($camp->outcome==10){
                        $camps[$key]->outcome='From (Agent) Answered.';
                    }elseif($camp->outcome==11){
                        $camps[$key]->outcome='Rejected Call';
                    }elseif($camp->outcome==12){
                        $camps[$key]->outcome='Skipped';
                    }elseif($camp->outcome==13){
                        $camps[$key]->outcome='From (Agent) Failed.';
                    }elseif($camp->outcome==14){
                        $camps[$key]->outcome='To (Customer) Failed - From (Agent) Answered';
                    }elseif($camp->outcome==15){
                        $camps[$key]->outcome='To (Customer) Failed';
                    }elseif($camp->outcome==16){
                        $camps[$key]->outcome='To (Customer) Answered - From (Agent) Failed';
                    }
                    else{
                        $camps[$key]->outcome='N.A';
                    }

                    // if ($lead->call_required==0){
                    //     $leads[$key]->call_required= 'No';
                    // }elseif($lead->call_required==1){
                    //     $leads[$key]->call_required='Yes';
                    // }
                    // else{
                    //     $leads[$key]->call_required='';
                    // }

                    // if ($lead->lead_status==1){
                    //     $leads[$key]->lead_status= 'Assigned';
                    // }elseif($lead->lead_status==2){
                    //     $leads[$key]->lead_status='Open';
                    // }elseif($lead->lead_status==3){
                    //     $leads[$key]->lead_status='Converted';
                    // }elseif($lead->lead_status==4){
                    //     $leads[$key]->lead_status='Follow Up';
                    // }elseif($lead->lead_status==5){
                    //     $leads[$key]->lead_status='Closed';
                    // }else{
                    //     $leads[$key]->lead_status='';
                    // }


                }
            }
            return $camps;
        } else
            return CampaignLead::query()->select('id');
    }

    public function headings(): array
    {

        return [
            'ID',
            'Campaign Name',
            'Lead Name',
            'Call Status',
            'Call Purpose',
            'Assigned To'
         
        ];
    }
}
