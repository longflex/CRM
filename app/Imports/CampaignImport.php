<?php

namespace App\Imports;

use App\Lead;
use App\Leadsdata;
use App\Http\Controllers\Laralum\Laralum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use App\Services\LeadService;
use Throwable;

HeadingRowFormatter::default('none');

class CampaignImport implements 
	ToCollection, 
    WithHeadingRow, 
    SkipsOnError, 
    SkipsOnFailure,
    WithChunkReading,
    ShouldQueue,
    WithEvents 
{
	use Importable, SkipsErrors, SkipsFailures, RegistersEventListeners;

    public function __construct($client_id, $user_id, $campaign_id, $leads_datta)
    {
        $this->client_id = $client_id;
        $this->user_id = $user_id;
        $this->campaign_id = $campaign_id;
        $this->lead_ids = $leads_datta;
        $this->mobiles = [];
        $this->campaignData = [];
    }

    public function collection(Collection $rows)
    {
        
    	foreach ($rows as $row) {
            if($row['Mobile'] != "" && preg_match('/^[0-9]\d{9}$/', $row['Mobile'])){
                $this->mobiles[] .= $row['Mobile'];
            }
        }

        $q_lead_ids = DB::table('leads')
                ->whereIn('mobile', $this->mobiles)
                ->pluck('id');     
        foreach ($q_lead_ids as $k => $v) {
                $this->lead_ids[] .= $v;
        }

        // Lead::whereIn('id', $this->lead_ids)->update([
        //     'lead_status' => 1
        // ]);

        
        $lead_ids  = array_values((array)$this->lead_ids);
        if(!empty($this->lead_ids)){
        	$arr = [];
			$leads_count=count($this->lead_ids);
			$agentDatas = DB::table('campaign_agents')->where('campaign_id', $this->campaign_id)->select('campaign_agents.agent_id')->get();

				$agent_ids=[];
	    		foreach ($agentDatas as $key => $value) {
	    			$agent_ids[] .=$value->agent_id;
	    		}
	    		$agent_count = count($agent_ids);
	    		$lead_share = ceil($leads_count / $agent_count);
	    		if ($leads_count > 0 && $agent_count > 0) {
	    			$arr = array_chunk($lead_ids, $lead_share);
                    //dd($arr);
					for ($i=0; $i <count($arr) ; $i++) {
						for ($j=0; $j <count($arr[$i]) ; $j++) { 
							$leadCheckss = DB::table('campaign_leads')->where('campaign_id', $this->campaign_id)->where('lead_id', $arr[$i][$j])->first();
							if(empty($leadCheckss)){
                                //$this->campaignData[] .= ['campaign_id' => $this->campaign_id, 'lead_id' =>$arr[$i][$j], 'agent_id' =>$agent_ids[$i],'created_at'=>date('Y-m-d H:i'), 'updated_at'=>date('Y-m-d H:i') ];	
                                DB::table('campaign_leads')
									->insert(['campaign_id' => $this->campaign_id, 'lead_id' =>$arr[$i][$j], 'agent_id' =>$agent_ids[$i],'created_at'=>date('Y-m-d H:i'), 'updated_at'=>date('Y-m-d H:i') ]);							
							}
						} 
					}

                    // DB::table('campaign_leads')
					// 				->insert($this->campaignData);
	    		}
        }

    }
    
    // public function collection(Collection $rows)
    // {
        
    // 	foreach ($rows as $row) {

    //         if($row['Lead Owner']==""){
    //             $status_lead=2;
    //         }elseif($row['Lead Owner']!=""){
    //             $status_lead=1;
    //         }else{
    //             $status_lead=$row['Lead Status'];
    //         }

    //         if($row['Mobile'] != "" && preg_match('/^[0-9]\d{9}$/', $row['Mobile'])){
    //             $this->leadCheck = DB::table('leads')
    //             ->where('mobile', $row['Mobile'])
    //             ->where('user_id', $this->user_id)
    //             ->where('client_id', $this->client_id)
    //             ->count();

    //             if($this->leadCheck > 0){
    //             	$leadCheckData = DB::table('leads')
	// 						                ->where('mobile', $row['Mobile'])
	// 						                ->where('user_id', $this->user_id)
	// 						                ->where('client_id', $this->client_id)
	// 						                ->pluck('id');
	// 				$this->lead_ids[] .= $leadCheckData[0];

    //                 $member_type=explode(',', $row['Member Type']);

    //                 $alt_numbers=explode('-', $row['Alt Number']);

    //                 $address_type=['permanent','temp'];
    //                 $address=[$row['Address 1'],$row['Address 2']];
    //                 $country=[$row['Country 1'],$row['Country 2']];
    //                 $state=[$row['State 1'],$row['State 2']];
    //                 $district=[$row['District 1'],$row['District 2']];
    //                 $pincode=[$row['Pincode 1'],$row['Pincode 2']];
           
    //                 Lead::where('id', $leadCheckData[0])->update([ 

    //                     'user_id' => $this->user_id,
    //                     'client_id' => $this->client_id,
    //                     'account_type' => $row['Account Type'],
    //                     'department' => $row['Department'],
    //                     'member_type' => json_encode($member_type),
    //                     'lead_source' => $row['Lead Source'],
    //                     'preferred_language' => $row['Preferred Language'],
    //                     'agent_id' => $row['Lead Owner'],
    //                     'profile_photo' => $row['Profile Photo'],
    //                     'member_id' => $row['Member ID'],
    //                     'name' => $row['Name'],
    //                     'date_of_birth' => ($row['Date of Birth'] != '') ? date('Y-m-d', strtotime($row['Date of Birth'])) : NULL,
    //                     'date_of_joining' => ($row['Date of Joining'] != '') ? date('Y-m-d', strtotime($row['Date of Joining'])) : NULL,
    //                     'date_of_anniversary' => ($row['Date Of Anniversary'] != '') ? date('Y-m-d', strtotime($row['Date Of Anniversary'])) : NULL,
    //                     'rfid' => $row['RFID'],
    //                     'gender' => $row['Gender'],
    //                     'blood_group' => $row['Blood Group'],
    //                     'married_status' => $row['Married Status'],
    //                     'email' => $row['Email'],
    //                     'mobile' => $row['Mobile'],
    //                     'alt_numbers' => empty($alt_numbers) ? '' : implode(',', $alt_numbers),
    //                     'id_proof' => $row['Id Proof'],
    //                     'created_by' => $this->user_id,
    //                     'qualification' => $row['Qualification'],
    //                     'branch' => $row['Branch'],
    //                     'profession' => $row['Profession'],
    //                     'sms_required' => $row['Sms Requred'],
    //                     'call_required' => $row['Call Requred'],
    //                     'sms_language' => $row['Sms Language'],
    //                     'lead_response' => $row['Lead Response'],
    //                     'address_type' => serialize($address_type),
    //                     'address' => empty($address) ? '' : serialize($address),
    //                     'country' => empty($country) ? '' : serialize($country),
    //                     'state' => empty($state) ? '' : serialize($state),
    //                     'district' => empty($district) ? '' : serialize($district),
    //                     'pincode' => empty($pincode) ? '' : serialize($pincode),
    //                     'lead_status' => 1

    //                 ]);		                

    //             }else{
    //                 $member_type=explode(',', $row['Member Type']);

    //                 $alt_numbers=explode('-', $row['Alt Number']);

    //                 $address_type=['permanent','temp'];
    //                 $address=[$row['Address 1'],$row['Address 2']];
    //                 $country=[$row['Country 1'],$row['Country 2']];
    //                 $state=[$row['State 1'],$row['State 2']];
    //                 $district=[$row['District 1'],$row['District 2']];
    //                 $pincode=[$row['Pincode 1'],$row['Pincode 2']];
                    
    //                 $lead = new Lead;
    //                 $lead->user_id = $this->user_id;
    //                 $lead->client_id = $this->client_id;
    //                 $lead->account_type = preg_match('/^[0-9][0-9]{9}$/', $row['Mobile']);
    //                 $lead->department = strlen($row['Mobile']);

    //                 $lead->member_type = json_encode($member_type);
    //                 $lead->lead_source = $row['Lead Source'];
    //                 $lead->preferred_language = $row['Preferred Language'];
    //                 $lead->agent_id =$row['Lead Owner'];
    //                 $lead->profile_photo = $row['Profile Photo'];
    //                 $lead->member_id = $row['Member ID'];
    //                 $lead->name = $row['Name'];

    //                 $lead->date_of_birth = ($row['Date of Birth'] != '') ? date('Y-m-d', strtotime($row['Date of Birth'])) : NULL;
    //                 $lead->date_of_joining = ($row['Date of Joining'] != '') ? date('Y-m-d', strtotime($row['Date of Joining'])) : NULL;
    //                 $lead->date_of_anniversary = ($row['Date Of Anniversary'] != '') ? date('Y-m-d', strtotime($row['Date Of Anniversary'])) : NULL;
    //                 $lead->rfid = $row['RFID'];
    //                 $lead->gender = $row['Gender'];
    //                 $lead->blood_group = $row['Blood Group'];
    //                 $lead->married_status = $row['Married Status'];
    //                 $lead->email = $row['Email'];
    //                  $lead->mobile = $row['Mobile'];

    //                 $lead->alt_numbers = empty($alt_numbers) ? '' : implode(',', $alt_numbers);//json_encode($alt_numbers);

    //                 $lead->id_proof = $row['Id Proof'];
    //                 $lead->created_by = $this->user_id;
    //                 $lead->qualification = $row['Qualification'];
    //                 $lead->branch = $row['Branch'];
    //                 $lead->profession = $row['Profession'];
    //                 $lead->sms_required = $row['Sms Requred'];
    //                 $lead->call_required = $row['Call Requred'];
    //                 $lead->sms_language = $row['Sms Language'];
    //                 $lead->lead_response = $row['Lead Response'];
    //                 $lead->address_type = serialize($address_type);
    //                 $lead->address = empty($address) ? '' : serialize($address);
    //                 $lead->country = empty($country) ? '' : serialize($country);
    //                 $lead->state = empty($state) ? '' : serialize($state);
    //                 $lead->district = empty($district) ? '' : serialize($district);
    //                 $lead->pincode = empty($pincode) ? '' : serialize($pincode);
    //                  $lead->lead_status = 1;
    //                 // $lead->updated_at = date('Y-m-d H:i');
    //                 $lead->save();

    //                 $this->lead_ids[] .= $lead->id;

    //             }
    //         }

    //     }

    //     if(!empty($this->lead_ids)){
    //     	$arr = [];
	//     	//$leads=$request->leads;
	// 		$leads_count=count($this->lead_ids);
	// 		//$campaigns=$this->campaign_id;
	// 		$agentDatas = DB::table('campaign_agents')->where('campaign_id', $this->campaign_id)->select('campaign_agents.agent_id')->get();

	// 			$agent_ids=[];
	//     		foreach ($agentDatas as $key => $value) {
	//     			$agent_ids[] .=$value->agent_id;
	//     		}
	// 			//$campaigns_count=count($campaigns);
	//     		$agent_count = count($agent_ids);
	// 			//$lead_share = round ( ($leads_count / $agent_count) , 0 , PHP_ROUND_HALF_UP );
	//     		$lead_share = ceil($leads_count / $agent_count);
	//     		if ($leads_count > 0 && $agent_count > 0) {
	//     			$arr = array_chunk($this->lead_ids, $lead_share);
	//     				//DB::table('campaign_leads')->where('campaign_id', $this->campaign_id)->delete();
	// 				for ($i=0; $i <count($arr) ; $i++) {
	// 					for ($j=0; $j <count($arr[$i]) ; $j++) { 
	// 						$leadCheckss = DB::table('campaign_leads')->where('campaign_id', $this->campaign_id)->where('lead_id', $arr[$i][$j])->first();
	// 						if(empty($leadCheckss)){
	// 							DB::table('campaign_leads')
	// 								->insert(['campaign_id' => $this->campaign_id, 'lead_id' =>$arr[$i][$j], 'agent_id' =>$agent_ids[$i],'created_at'=>date('Y-m-d H:i'), 'updated_at'=>date('Y-m-d H:i') ]);
	// 						}
	// 					} 
	// 				}
	//     		}
    //     }
       


    // }

    

    public function chunkSize(): int
    {
        return 500;
    }




}
