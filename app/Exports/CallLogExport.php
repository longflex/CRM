<?php

namespace App\Exports;

use App\Lead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\DB;

class CallLogExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    use Exportable;

    public function __construct(int $client_id, $callLog_id)
    {
        $this->client = $client_id;
        $this->callLog_id = $callLog_id;
    }

    public function collection()
    {
        if ($this->callLog_id != null) {
            $callLog = DB::table('manual_logged_call')
                ->leftJoin('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
                ->leftJoin('users', 'manual_logged_call.created_by', 'users.id')
//`id``client_id``member_id``lead_number``agent_number``created_by``outcome``call_status``call_initiation``date``duration``description``status``call_type``call_purpose``call_outcome``created_at``updated_at``campaign_id`            
                ->select(
                    'manual_logged_call.id',
                    'manual_logged_call.lead_number',
                    'manual_logged_call.agent_number',
                    'manual_logged_call.call_status',
                    'manual_logged_call.duration',
                    'manual_logged_call.description',
                    //'manual_logged_call.status',
                    'manual_logged_call.call_type',
                    'manual_logged_call.call_purpose',
                    'manual_logged_call.call_outcome',
                    'manual_logged_call.created_at',
                    'users.name as agent_name',
                )->where('manual_logged_call.client_id', $this->client)->whereIn('manual_logged_call.id', $this->callLog_id)->orderBy('manual_logged_call.id', 'desc')->groupBy('manual_logged_call.id')->get();
            if (!empty($callLog)) {
                foreach ($callLog as $key => $logdata) {
                    

                    if ($logdata->call_status==2){
                        $callLog[$key]->call_status= 'Completed';
                    }elseif($logdata->call_status==3){
                        $callLog[$key]->call_status='Follow Up';
                    }
                    else{
                        $callLog[$key]->call_status='';
                    }

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
            return $callLog;
        } 
            //continue;
            //return Lead::query()->select('id', 'lead_number', 'agent_number', 'call_status', 'duration', 'description', 'status', 'call_type', 'call_purpose', 'call_outcome', 'created_at','agent_name')->where('client_id', $this->client);
    }

    function headings(): array
    {

        return [
            'ID',
            'Lead Number',
            'Agent Number',
            'Campaign Status',
            'Duration',
            'Description',
            //'Status',
            'Call Type',
            'Call Purpose',
            'Call Outcome',
            'Created Date',
            'Agent Name'
            
        ];
    }
}
