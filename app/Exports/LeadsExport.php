<?php

namespace App\Exports;

use App\Lead;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromQuery;

class LeadsExport implements FromQuery, WithHeadings, ShouldQueue
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

    public function query()
    {
        if ($this->members != null) {
            //$leads = Leads


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
                )->where('leads.client_id', $this->client)->whereIn('leads.id', $this->members)->orderBy('leads.updated_at', 'desc');
            if (!empty($leads)) {
                foreach ($leads as $key => $lead) {
                    // $get_state = DB::table('state')->get();
                    // $get_district = DB::table('district')->get();
                    // $get_countries = DB::table('countries')->get();
                    //$family_members = DB::table('leadsdatas')->where('member_id', $id)->get();

                    /*if(!empty($lead->alt_numbers)){
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
                    }*/


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
