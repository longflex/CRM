<?php

namespace App\Http\Controllers\Crm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\Campaign;
use App\Http\Controllers\Laralum\Laralum;
use Illuminate\Support\Facades\DB;
use App\Services\CampaignService;


//use Illuminate\Http\Request;
//use App\Http\Requests;
//use App\Http\Controllers\Controller;
use App\User;
use App\Lead;
//use App\Role;
//use App\Campaign;
use App\Donation;
use App\Exports\CampaignExport;
use App\Permission;
use Maatwebsite\Excel\Facades\Excel;
//use App\Http\Controllers\Laralum\Laralum;
use Validator, File;
use Illuminate\Support\Str;
use Response;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Auth;
use App\CampaignLead;
use Illuminate\Pagination\Paginator;
use Datatables;
//use Illuminate\Support\Facades\DB;
use App\Imports\CampaignImport;

class CampaignController extends Controller
{
	private $camp;

	public function __construct(CampaignService $camp)
    {
        $this->camp = $camp;
    }

	public function index(Request $request)
	{
		Laralum::permissionToAccess('laralum.campaign.list');
		//hyper.campaign.index
		//return view('hyper.campaign.index');
		//$campaign = Campaign::where('created_by', Auth::user()->id)->paginate(2);
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		
		// Campaign::where('campaigns.client_id', $client_id)
		// 			->leftJoin('campaign_leads', 'campaigns.id', 'campaign_leads.campaign_id')
        //          ->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
        //          ->leftJoin('manual_logged_call', 'campaign_leads.lead_id', 'manual_logged_call.member_id')
        //          ->groupBy('campaigns.id')
		// 			->paginate(2);
		//DB::raw("(SELECT COUNT(manual_logged_call.id) AS dialed FROM campaign_leads  JOIN manual_logged_call ON campaign_leads.lead_id=manual_logged_call.member_id JOIN campaigns ON campaign_leads.campaign_id=campaigns.id WHERE manual_logged_call.status='0' GROUP BY campaigns.id) as dialed")
		// ->leftJoin('campaign_leads', function ($join) {
		// 	            $join->on('campaign_leads.campaign_id', 'campaigns.id');
		// 	                 //->where('contacts.user_id', '>', 5);
		// 	        })
		$campaigns = DB::table('campaigns')
					->leftJoin('campaign_leads', 'campaign_leads.campaign_id', 'campaigns.id')
					->leftJoin('leads', 'leads.id', 'campaign_leads.lead_id')
					//->leftJoin('manual_logged_call', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
					->leftJoin('manual_logged_call', function($join)
                         {
                             $join->on('campaign_leads.lead_id', '=', 'manual_logged_call.member_id');
							 $join->on('campaign_leads.campaign_id', '=', 'manual_logged_call.campaign_id');
                         })
					//->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
                    ->select('campaigns.*', DB::raw("SUM(CASE WHEN manual_logged_call.status = '1' THEN 1 ELSE 0 END) AS dialed"),DB::raw("SUM(CASE WHEN manual_logged_call.outcome = '3' THEN 1 ELSE 0 END) AS connected"),DB::raw("SUM(CASE WHEN manual_logged_call.outcome = '9' THEN 1 ELSE 0 END) AS busy"),DB::raw("SUM(CASE WHEN manual_logged_call.call_status = '2' THEN 1 ELSE 0 END) AS completed_leads"), DB::raw("SUM(CASE WHEN manual_logged_call.call_status = '3' THEN 1 ELSE 0 END) AS follow_up_leads"),DB::raw("count(campaign_leads.lead_id) as total_record")  )
                    
                    ->groupBy('campaigns.id')
                    //->where('campaigns.id', 'desc')
					->paginate(2);

					
		// $campaignDialed = DB::table('campaigns')
		// 			->leftJoin('campaign_leads', 'campaign_leads.campaign_id', 'campaigns.id')
		// 			//->leftJoin('manual_logged_call', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
		// 			->leftJoin('manual_logged_call', function($join)
  //                        {
  //                            $join->on('campaign_leads.lead_id', '=', 'manual_logged_call.member_id');
		// 					 $join->on('campaign_leads.campaign_id', '=', 'manual_logged_call.campaign_id');
  //                        })
		// 			//->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
  //                   ->select('campaigns.*', DB::raw("SUM(CASE WHEN manual_logged_call.status = '1' THEN 1 ELSE 0 END) AS dialed") )
  //                   ->groupBy('campaigns.id')
		// 			->paginate(2);
		// $campaignConnected = DB::table('campaigns')
		// 			->leftJoin('campaign_leads', 'campaign_leads.campaign_id', 'campaigns.id')
		// 			//->leftJoin('manual_logged_call', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
		// 			->leftJoin('manual_logged_call', function($join)
  //                        {
  //                            $join->on('campaign_leads.lead_id', '=', 'manual_logged_call.member_id');
		// 					 $join->on('campaign_leads.campaign_id', '=', 'manual_logged_call.campaign_id');
  //                        })
		// 			//->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
  //                   ->select('campaigns.id',DB::raw("SUM(CASE WHEN manual_logged_call.outcome = '3' THEN 1 ELSE 0 END) AS connected") )
  //                   //->where('manual_logged_call.outcome', 3)
  //                   ->groupBy('campaigns.id')
		// 			->paginate(2);

		// $campaignBusy = DB::table('campaigns')
		// 			->leftJoin('campaign_leads', 'campaign_leads.campaign_id', 'campaigns.id')
		// 			//->leftJoin('manual_logged_call', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
		// 			->leftJoin('manual_logged_call', function($join)
  //                        {
  //                            $join->on('campaign_leads.lead_id', '=', 'manual_logged_call.member_id');
		// 					 $join->on('campaign_leads.campaign_id', '=', 'manual_logged_call.campaign_id');
  //                        })
		// 			//->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
  //                   ->select('campaigns.id',DB::raw("SUM(CASE WHEN manual_logged_call.outcome = '9' THEN 1 ELSE 0 END) AS busy") )
  //                   //->where('manual_logged_call.outcome', 'busy')
  //                   ->groupBy('campaigns.id')
		// 			->paginate(2);
		$manual = DB::table('manual_logged_call')
			->join('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
			->select('member_id')
			->where('manual_logged_call.status','1');
			//->get();
			$manuarray = $manual;
        // foreach($manual as $manu){
        //     $manuarray[] = $manu->member_id;
        // }
			// print_r($manuarray);die;
			//dd($manual);						
		$campaignTotalLeads = DB::table('campaigns')
					->leftJoin('campaign_leads', 'campaign_leads.campaign_id', 'campaigns.id', 'right outer')
					//->leftJoin('manual_logged_call', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
					->leftJoin('manual_logged_call', function ($join) {
                        $join->on('campaign_leads.lead_id', '=', 'manual_logged_call.member_id');
                        $join->on('campaign_leads.campaign_id', '=', 'manual_logged_call.campaign_id');
                    })
					// ->leftJoin('manual_logged_call', function($join)
     //                     {
     //                         $join->on('campaign_leads.lead_id', '=', 'manual_logged_call.member_id');
					// 		 $join->on('campaign_leads.campaign_id', '=', 'manual_logged_call.campaign_id');
     //                     })
					//->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
                    ->select('campaigns.id',DB::raw("count(campaign_leads.lead_id) as total_leads") )
                    ->whereNotIn('campaign_leads.lead_id', $manuarray)
                    ->groupBy('campaigns.id')
					->paginate(2);
	// 	$campaignCompletedLeads = DB::table('campaigns')
	// 				->leftJoin('campaign_leads', 'campaign_leads.campaign_id', 'campaigns.id')
	// 				->join('leads', 'leads.id', 'campaign_leads.lead_id')
	// 				->leftJoin('manual_logged_call', function($join)
 //                         {
 //                             $join->on('campaign_leads.lead_id', '=', 'manual_logged_call.member_id');
	// 						 $join->on('campaign_leads.campaign_id', '=', 'manual_logged_call.campaign_id');
 //                         })
	// 				//->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
 //                    ->select('campaigns.id',DB::raw("SUM(CASE WHEN manual_logged_call.call_status = '2' THEN 1 ELSE 0 END) AS completed_leads") )
 //                    //->where('manual_logged_call.call_status', 2)
 //                    ->groupBy('campaigns.id')
	// 				->paginate(2);


	// 				// echo "<pre>";
	// 				//  print_r($campaignCompletedLeads);die;
	// 	$campaignFollowupLeads = DB::table('campaigns')
	// 				->leftJoin('campaign_leads', 'campaign_leads.campaign_id', 'campaigns.id')
	// 				//->leftJoin('manual_logged_call', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
	// 				->leftJoin('manual_logged_call', function($join)
 //                         {
 //                             $join->on('campaign_leads.lead_id', '=', 'manual_logged_call.member_id');
	// 						 $join->on('campaign_leads.campaign_id', '=', 'manual_logged_call.campaign_id');
 //                         })
	// 				//->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
 //                    ->select('campaigns.id', DB::raw("SUM(CASE WHEN manual_logged_call.call_status = '3' THEN 1 ELSE 0 END) AS follow_up_leads"))
 //                    //->where('manual_logged_call.call_status', 3)
 //                    ->groupBy('campaigns.id')
	// 				->paginate(2);
	// $campaignTotalRecords = DB::table('campaigns')
	// 				->leftJoin('campaign_leads', 'campaign_leads.campaign_id', 'campaigns.id', 'right outer')
	// 				->leftJoin('manual_logged_call', function ($join) {
 //                        $join->on('campaign_leads.lead_id', '=', 'manual_logged_call.member_id');
 //                        $join->on('campaign_leads.campaign_id', '=', 'manual_logged_call.campaign_id');
 //                    })
 //                    ->select('campaigns.id',DB::raw("count(campaign_leads.lead_id) as total_record") )
 //                    ->groupBy('campaigns.id')
	// 				->paginate(2);				
				// if(!empty($campaigns))	{			
				// 	foreach ($campaigns as $key => $value) {
				// 		foreach ($campaignDialed as $keys => $val) {
				// 			if($value->id == $val->id){
				// 				$campaigns[$key]->dialed = $val->dialed;
				// 			}
				// 		}
				// 	}
				// }										
				// if(!empty($campaigns))	{			
				// 	foreach ($campaigns as $key => $value) {
				// 		foreach ($campaignConnected as $keys => $val) {
				// 			if($value->id == $val->id){
				// 				$campaigns[$key]->connected = $val->connected;
				// 			}
				// 		}
				// 	}
				// }
				if(!empty($campaigns))	{			
					foreach ($campaigns as $key => $value) {
						foreach ($campaignTotalLeads as $keys => $val) {
							if($value->id == $val->id){
								$campaigns[$key]->total_leads = $val->total_leads;
							}
						}
					}
				}
				// if(!empty($campaigns))	{			
				// 	foreach ($campaigns as $key => $value) {
				// 		foreach ($campaignCompletedLeads as $keys => $val) {
				// 			if($value->id == $val->id){
				// 				$campaigns[$key]->completed = $val->completed_leads;
				// 			}
				// 		}
				// 	}
				// }
				// if(!empty($campaigns))	{			
				// 	foreach ($campaigns as $key => $value) {
				// 		foreach ($campaignFollowupLeads as $keys => $val) {
				// 			if($value->id == $val->id){
				// 				$campaigns[$key]->follow_up = $val->follow_up_leads;
				// 			}
				// 		}
				// 	}
				// }
				// if(!empty($campaigns))	{			
				// 	foreach ($campaigns as $key => $value) {
				// 		foreach ($campaignBusy as $keys => $val) {
				// 			if($value->id == $val->id){
				// 				$campaigns[$key]->busy = $val->busy;
				// 			}
				// 		}
				// 	}
				// }
				// if(!empty($campaigns))	{			
				// 	foreach ($campaigns as $key => $value) {
				// 		foreach ($campaignTotalRecords as $keys => $val) {
				// 			if($value->id == $val->id){
				// 				$campaigns[$key]->total_record = $val->total_record;
				// 			}
				// 		}
				// 	}
				// }
//dd($campaigns);
				 //echo "<pre>";
				 //print_r($campaigns);die;
		return view('hyper/campaign/index', compact('campaigns'));
	}


	public function get_campaign_table(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $camps = $this->camp->getCampaignForTable($request,$client_id);
        return $this->camp->campaignDataTable($camps);
    }

	public function create(Request $request)
	{
		Laralum::permissionToAccess('laralum.campaign.create');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$agents = DB::table('users')
					->where('reseller_id', $client_id)
					->get();
		$agentGroup = Role::where(function ($query) {
			$query->Where('name', '!=', 'Admin');
		})->get();
		return view('hyper.campaign.create', compact('agents', 'agentGroup'));
	}

	public function store(Request $request)
	{
		Laralum::permissionToAccess('laralum.campaign.create');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$campaign = new Campaign();
		$campaign->client_id = $client_id;
		$campaign->type = $request->type;
		$campaign->name = $request->name;
		$campaign->status = $request->status;

		$campaign->start_date = ($request->start_date != '') ? date('Y-m-d', strtotime($request->start_date)) : NULL;
		$campaign->end_date = ($request->end_date != '') ? date('Y-m-d', strtotime($request->end_date)) : NULL;
		$campaign->call_to_call_gap = $request->call_to_call_gap;
		$campaign->break_time = $request->break_time;

		
		if ($campaign->save()) {
			if ($request->agent != null) {
				foreach ($request->agent as $ag) {
					DB::table('campaign_agents')->insert([ 
						'campaign_id' => $campaign->id,
						'agent_id' => $ag,
						'created_at' => date('YmdHis'),
						'updated_at' => date('YmdHis')
					]);
				}
			}
			if ($request->agentGroup != null) {
				//$agentGroup = DB::table('role_user')
								//->where('role_id', $request->agentGroup)
								//->first();
				$agentGroupId =DB::table('role_user')->where('role_id', $request->agentGroup)->pluck('user_id');	
				//$agentGroupId = $agentGroup->user_id;
				// dd($agentGroupId);
				if (!empty($agentGroupId)) {
					foreach ($agentGroupId as $id) {
						// $agentG = DB::table('role_user')
						// 			->where('role_id', $agent)
						// 			->first();
						DB::table('campaign_agents')->insert([ 
							'campaign_id' => $campaign->id,
							'agent_id' => $id,
							'created_at' => date('YmdHis'),
							'updated_at' => date('YmdHis')
						]);
					}
				}
			}
			return redirect()->route('Crm::campaign');
		} else {
			return redirect()->back();
		}
	}

	public function edit(Request $request)
	{
		Laralum::permissionToAccess('laralum.campaign.edit');
		$campaign = Campaign::where('id', $request->id)->first();
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$agents = DB::table('users')
					->where('reseller_id', $client_id)
					->get();
		$agentselected = DB::table('campaign_agents')
							->leftJoin('users', 'campaign_agents.agent_id', 'users.id')
							->select('campaign_agents.agent_id as id', 'users.name')
							->where('campaign_agents.campaign_id', $request->id)
							->get();
		$agentGroup = Role::where(function ($query) {
			$query->Where('name', '!=', 'Admin');
		})->get();
		return view('hyper.campaign.edit', compact('campaign','agents', 'agentselected', 'agentGroup'));
	}
	
	public function update(Request $request)
	{ 
		Laralum::permissionToAccess('laralum.campaign.edit');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$campaign = Campaign::find($request->id);
		$campaign->client_id = $client_id;
		$campaign->type = $request->type;
		$campaign->name = $request->name;
		$campaign->status = $request->status;
		$campaign->start_date = ($request->start_date != '') ? date('Y-m-d', strtotime($request->start_date)) : NULL;
		$campaign->end_date = ($request->end_date != '') ? date('Y-m-d', strtotime($request->end_date)) : NULL;
		$campaign->call_to_call_gap = $request->call_to_call_gap;
		$campaign->break_time = $request->break_time;
		if ($campaign->save()){
			if ($request->agent != null) {

				$manual = DB::table('manual_logged_call')
                ->join('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
                ->select('member_id')
                ->where(function ($manual) use ($request) {
                    if ($request->id != null) {
                        $manual->where('manual_logged_call.campaign_id', $request->id);
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
		                    ->leftJoin('manual_logged_call', function ($leads) use ($request) {
		                        $leads->on('leads.id', '=', 'manual_logged_call.member_id');
		                        if ($request->id != null) {
		                            $leads->where('manual_logged_call.campaign_id', $request->id);
		                        }
		                    })
		                    ->select('leads.id')
		                    ->where('leads.lead_status', '!=', 3)
		                    ->where('leads.client_id', $client_id)
		                    ->where(function ($leads) use ($request, $manuarray) {
		                    	if ($request->id != null) {
		                            $leads->where('campaign_leads.campaign_id', $request->id);
		                        }
		                        $leads->whereNotIn('leads.id', $manuarray);

		                    })
		                    ->groupBy('leads.id')->get();
		                    $leads_dattaa = [];
			        		foreach ($leads as $key => $value) {
			        			$leads_dattaa[] .=$value->id;
			        		}

				DB::table('campaign_agents')
						->where('campaign_id', '=', $campaign->id)
						->delete();
				foreach ($request->agent as $ag) {
					DB::table('campaign_agents')
						->insert([ 
							'campaign_id' => $campaign->id,
							'agent_id' => $ag,
							'created_at' => date('YmdHis'),
							'updated_at' => date('YmdHis')
						]);
				}

				$arr = [];
	        	//$leads=$request->leads;
				$leads_count=count($leads_dattaa);
				$campaigns=$request->id;
				$agentDatas = DB::table('campaign_agents')->where('campaign_id', $request->id)->select('campaign_agents.agent_id')->get();
					$agent_ids=[];
	        		foreach ($agentDatas as $key => $value) {
	        			$agent_ids[] .=$value->agent_id;
	        		}
					//$campaigns_count=count($campaigns);
	        		$agent_count = count($agent_ids);
					//$lead_share = round ( ($leads_count / $agent_count) , 0 , PHP_ROUND_HALF_UP );
	        		$lead_share = ceil($leads_count / $agent_count);
	        		
	        		if ($leads_count > 0 && $agent_count > 0) {
	        			$arr = array_chunk($leads_dattaa, $lead_share);

	        			DB::table('campaign_leads')->where('campaign_id', $request->id)->delete();

						for ($i=0; $i <count($arr) ; $i++) {
							for ($j=0; $j <count($arr[$i]) ; $j++) { 
								$leadCheck = DB::table('campaign_leads')->where('campaign_id', $request->id)->where('lead_id', $arr[$i][$j])->first();
								if(empty($leadCheck)){
									DB::table('campaign_leads')
										->insert(['campaign_id' => $request->id, 'lead_id' =>$arr[$i][$j], 'agent_id' =>$agent_ids[$i],'created_at'=>date('Y-m-d H:i'), 'updated_at'=>date('Y-m-d H:i') ]);
									DB::table('leads')
										->where('leads.id', $arr[$i][$j])
										->update(['lead_status' => 1, 'updated_at'=>date('Y-m-d H:i') ]);
								}
							} 
						}
	        		}

			}
			if ($request->agentGroup != null) {

				$manual = DB::table('manual_logged_call')
                ->join('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
                ->select('member_id')
                ->where(function ($manual) use ($request) {
                    if ($request->id != null) {
                        $manual->where('manual_logged_call.campaign_id', $request->id);
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
		                    ->leftJoin('manual_logged_call', function ($leads) use ($request) {
		                        $leads->on('leads.id', '=', 'manual_logged_call.member_id');
		                        if ($request->id != null) {
		                            $leads->where('manual_logged_call.campaign_id', $request->id);
		                        }
		                    })
		                    ->select('leads.id')
		                    ->where('leads.lead_status', '!=', 3)
		                    ->where('leads.client_id', $client_id)
		                    ->where(function ($leads) use ($request, $manuarray) {
		                    	if ($request->id != null) {
		                            $leads->where('campaign_leads.campaign_id', $request->id);
		                        }
		                        $leads->whereNotIn('leads.id', $manuarray);

		                    })
		                    ->groupBy('leads.id')->get();
		                    $leads_datta = [];
			        		foreach ($leads as $key => $value) {
			        			$leads_datta[] .=$value->id;
			        		}
			    $agentGroupId =DB::table('role_user')->where('role_id', $request->agentGroup)->pluck('user_id');
			    

			    $arr = [];
	        	//$leads=$request->leads;
				$leads_count=count($leads_datta);
				$campaigns=$request->id;

					//$campaigns_count=count($campaigns);
	        		$agent_count = count($agentGroupId);
					//$lead_share = round ( ($leads_count / $agent_count) , 0 , PHP_ROUND_HALF_UP );
	        		$lead_share = ceil($leads_count / $agent_count);

	        		if ($leads_count > 0 && $agent_count > 0) {
	        			$arr = array_chunk($leads_datta, $lead_share);

	        			DB::table('campaign_leads')->where('campaign_id', $request->id)->delete();

						for ($i=0; $i <count($arr) ; $i++) {
							for ($j=0; $j <count($arr[$i]) ; $j++) { 
								$leadCheck = DB::table('campaign_leads')->where('campaign_id', $request->id)->where('lead_id', $arr[$i][$j])->first();
								if(empty($leadCheck)){
									DB::table('campaign_leads')
										->insert(['campaign_id' => $request->id, 'lead_id' =>$arr[$i][$j], 'agent_id' =>$agentGroupId[$i],'created_at'=>date('Y-m-d H:i'), 'updated_at'=>date('Y-m-d H:i') ]);
									DB::table('leads')
										->where('leads.id', $arr[$i][$j])
										->update(['lead_status' => 1, 'updated_at'=>date('Y-m-d H:i') ]);
								}
							} 
						}
	        		}    		

				DB::table('campaign_agents')
						->where('campaign_id', '=', $campaign->id)
						->delete();
				// $agentGroup = DB::table('role_user')
				// 				->where('role_id', $request->agentGroup)
				// 				->first();
				// $agentGroupId = $agentGroup->user_id;
						
				if (!empty($agentGroupId)) {
					foreach ($agentGroupId as $id) {
						DB::table('campaign_agents')->insert([ 
							'campaign_id' => $campaign->id,
							'agent_id' => $id,
							'created_at' => date('YmdHis'),
							'updated_at' => date('YmdHis')
						]);
					}
				}
			}
			return redirect()->route('Crm::campaign');
		} else {
			return redirect()->back();
		}
	}
	
	public function delete(Request $request)
	{
		Laralum::permissionToAccess('laralum.campaign.delete');
		if(Campaign::find($request->id)->delete()){
			DB::table('campaign_agents')
						->where('campaign_id', '=', $request->id)
						->delete();
			DB::table('campaign_leads')
						->where('campaign_id', '=', $request->id)
						->delete();
			return response()->json([ 'campaign_delete' => true ]);
		}
		return response()->json([ 'campaign_delete' => false ]);
	}

	public function campaignAssignedLeadDestroy(Request $request)
	{//campaign_id


		Laralum::permissionToAccess('laralum.campaign.delete');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

		if($request->id){
			DB::table('campaign_leads')
						->where('id', '=', $request->id)
						->delete();

			$manual = DB::table('manual_logged_call')
                ->join('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
                ->select('member_id')
                ->where(function ($manual) use ($request) {
                    if ($request->campaign_id != null) {
                        $manual->where('manual_logged_call.campaign_id', $request->campaign_id);
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
		                    ->leftJoin('manual_logged_call', function ($leads) use ($request) {
		                        $leads->on('leads.id', '=', 'manual_logged_call.member_id');
		                        if ($request->campaign_id != null) {
		                            $leads->where('manual_logged_call.campaign_id', $request->campaign_id);
		                        }
		                    })
		                    ->select('leads.id')
		                    ->where('leads.lead_status', '!=', 3)
		                    ->where('leads.client_id', $client_id)
		                    ->where(function ($leads) use ($request, $manuarray) {
		                    	if ($request->campaign_id != null) {
		                            $leads->where('campaign_leads.campaign_id', $request->campaign_id);
		                        }
		                        $leads->whereNotIn('leads.id', $manuarray);

		                    })
		                    ->groupBy('leads.id')->get();
		                    $leads_datta = [];
        		foreach ($leads as $key => $value) {
        			$leads_datta[] .=$value->id;
        		}	
        		
        		$arr = [];
	        	//$leads=$request->leads;
				$leads_count=count($leads_datta);
				$campaigns=$request->campaign_id;
				$agentDatas = DB::table('campaign_agents')->where('campaign_id', $request->campaign_id)->select('campaign_agents.agent_id')->get();
					$agent_ids=[];
	        		foreach ($agentDatas as $key => $value) {
	        			$agent_ids[] .=$value->agent_id;
	        		}
					//$campaigns_count=count($campaigns);
	        		$agent_count = count($agent_ids);
					//$lead_share = round ( ($leads_count / $agent_count) , 0 , PHP_ROUND_HALF_UP );
	        		$lead_share = ceil($leads_count / $agent_count);
	        		
	        		if ($leads_count > 0 && $agent_count > 0) {
	        			$arr = array_chunk($leads_datta, $lead_share);

	        			DB::table('campaign_leads')->where('campaign_id', $request->campaign_id)->delete();

						for ($i=0; $i <count($arr) ; $i++) {
							for ($j=0; $j <count($arr[$i]) ; $j++) { 
								$leadCheck = DB::table('campaign_leads')->where('campaign_id', $request->campaign_id)->where('lead_id', $arr[$i][$j])->first();
								if(empty($leadCheck)){
									DB::table('campaign_leads')
										->insert(['campaign_id' => $request->campaign_id, 'lead_id' =>$arr[$i][$j], 'agent_id' =>$agent_ids[$i],'created_at'=>date('Y-m-d H:i'), 'updated_at'=>date('Y-m-d H:i') ]);
									DB::table('leads')
										->where('leads.id', $arr[$i][$j])
										->update(['lead_status' => 1, 'updated_at'=>date('Y-m-d H:i') ]);
								}
							} 
						}
	        		}


			return response()->json([ 'campaign_delete' => true ]);
		}
		
	}


	public function view($id)
	{
		Laralum::permissionToAccess('laralum.campaign.view');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$agents = DB::table('users')
					->where('reseller_id', $client_id)
					->get();
		$agentGroups = Role::where(function ($query) {
			$query->Where('name', '!=', 'Admin');
		})->get();
		$campaigns = Campaign::all();
		//$campaign = Campaign::where('id', $id)->first();

		//dd($campaigns);
		# Return the view
		return view('hyper.campaign.details', [
			'id'=>$id,
			'campaigns' => $campaigns,
			'agents' => $agents,
			'agentGroups' => $agentGroups
		]);
	}

	public function deleteSelected(Request $request)
	{

		Laralum::permissionToAccess('laralum.campaign.delete');
		//Laralum::permissionToAccess('laralum.member.delete');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		
        if($request->select_all_option_check==1){
        	$campsData = DB::table('campaign_leads')
                    ->join('campaigns', 'campaigns.id', 'campaign_leads.campaign_id') 
                    ->join('leads', 'campaign_leads.lead_id', '=', 'leads.id')
                    ->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
                    ->leftJoin('manual_logged_call', function ($camps) use ($request) {
                        $camps->on('campaign_leads.lead_id', '=', 'manual_logged_call.member_id');
                        if ($request->filter_by_campaign != null) {
                            $camps->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
                        }
                    })
                    ->select('campaign_leads.id', 'campaign_leads.campaign_id', 'campaigns.type', 'campaigns.status','leads.name','manual_logged_call.outcome','manual_logged_call.call_purpose','users.name as assigned_to')
                    ->where('campaigns.client_id', $client_id)
                    
                    ->where(function ($camps) use ($request) {
                        $manual = DB::table('manual_logged_call')
                            ->join('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
                            ->select('member_id')
                            ->where(function ($manual) use ($request) {
                                if ($request->filter_by_campaign != null) {
                                    $manual->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
                                }
                            })
                            ->where('manual_logged_call.status','1')
                            ->get();
                        $manuarray = [];
                        foreach($manual as $manu){
                            $manuarray[] = $manu->member_id;
                        }
                        if ($request->filter_by_campaign != null) {
                            $camps->where('campaign_leads.campaign_id', $request->filter_by_campaign);
                        }
                        if ($request->filter_by_agent != null) {
                            $camps->where('campaign_leads.agent_id', $request->filter_by_agent);
                        }
                        if ($request->filter_by_campaign_status == 1) {
                            $camps->whereNotIn('leads.id', $manuarray);
                        } elseif($request->filter_by_campaign_status == 2) {
                            $camps->where('manual_logged_call.call_status', 2)
                                ->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
                        } elseif($request->filter_by_campaign_status == 3) {
                            $camps->where('manual_logged_call.call_status', 3)
                                ->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
                        }  elseif($request->filter_by_campaign_status == 0) {
                        }
                        if ($request->filter_by_agentGroup != null && $request->filter_by_agentGroup != "") {
                            $agentGroupId =DB::table('role_user')->where('role_id', $request->filter_by_agentGroup)->pluck('user_id');
                            $camps->whereIn('campaign_leads.agent_id', $agentGroupId);
                        }
                        //to do
                        if(Laralum::loggedInUser()->id != 1){
                            $camps->where('campaign_leads.agent_id', Laralum::loggedInUser()->id);
                        }
                    })
        		->get();


        		$camps=[];
        		foreach ($campsData as $key => $value) {
        			$camps[] .=$value->id;
        		}

        	foreach ($camps as $id) {
				DB::table('campaign_leads')->where('id', $id)->delete();
			}
        }else{
        	foreach ($request->ids as $id) {
				DB::table('campaign_leads')->where('id', $id)->delete();
			}
        	
        }

        $manual = DB::table('manual_logged_call')
                ->join('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
                ->select('member_id')
                ->where(function ($manual) use ($request) {
                    if ($request->filter_by_campaign != null) {
                        $manual->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
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
		                    ->leftJoin('manual_logged_call', function ($leads) use ($request) {
		                        $leads->on('leads.id', '=', 'manual_logged_call.member_id');
		                        if ($request->filter_by_campaign != null) {
		                            $leads->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
		                        }
		                    })
		                    ->select('leads.id')
		                    ->where('leads.lead_status', '!=', 3)
		                    ->where('leads.client_id', $client_id)
		                    ->where(function ($leads) use ($request, $manuarray) {
		                    	if ($request->filter_by_campaign != null) {
		                            $leads->where('campaign_leads.campaign_id', $request->filter_by_campaign);
		                        }
		                        $leads->whereNotIn('leads.id', $manuarray);

		                    })
		                    ->groupBy('leads.id')->get();
		                    $leads_dattas = [];
        		foreach ($leads as $key => $value) {
        			$leads_dattas[] .=$value->id;
        		}	
        		
        		$arr = [];
	        	//$leads=$request->leads;
				$leads_count=count($leads_dattas);
				$campaigns=$request->campaign_id;
				$agentDatas = DB::table('campaign_agents')->where('campaign_id', $request->filter_by_campaign)->select('campaign_agents.agent_id')->get();
					$agent_ids=[];
	        		foreach ($agentDatas as $key => $value) {
	        			$agent_ids[] .=$value->agent_id;
	        		}
					//$campaigns_count=count($campaigns);
	        		$agent_count = count($agent_ids);
					//$lead_share = round ( ($leads_count / $agent_count) , 0 , PHP_ROUND_HALF_UP );
	        		$lead_share = ceil($leads_count / $agent_count);
	        		
	        		if ($leads_count > 0 && $agent_count > 0) {
	        			$arr = array_chunk($leads_dattas, $lead_share);

	        			DB::table('campaign_leads')->where('campaign_id', $request->filter_by_campaign)->delete();

						for ($i=0; $i <count($arr) ; $i++) {
							for ($j=0; $j <count($arr[$i]) ; $j++) { 
								$leadCheck = DB::table('campaign_leads')->where('campaign_id', $request->filter_by_campaign)->where('lead_id', $arr[$i][$j])->first();
								if(empty($leadCheck)){
									DB::table('campaign_leads')
										->insert(['campaign_id' => $request->filter_by_campaign, 'lead_id' =>$arr[$i][$j], 'agent_id' =>$agent_ids[$i],'created_at'=>date('Y-m-d H:i'), 'updated_at'=>date('Y-m-d H:i') ]);
									DB::table('leads')
										->where('leads.id', $arr[$i][$j])
										->update(['lead_status' => 1, 'updated_at'=>date('Y-m-d H:i') ]);
								}
							} 
						}
	        		}		
		
		return response()->json(array(
			'status' => 'success'
		));
	}


	public function exportSelected(Request $request)
	{
		Laralum::permissionToAccess('laralum.campaign.reportdownload');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

        if($request->select_all_option_check==1){
        	$campsData = DB::table('campaign_leads')
                    ->join('campaigns', 'campaigns.id', 'campaign_leads.campaign_id') 
                    ->join('leads', 'campaign_leads.lead_id', '=', 'leads.id')
                    ->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
                    ->leftJoin('manual_logged_call', function ($camps) use ($request) {
                        $camps->on('campaign_leads.lead_id', '=', 'manual_logged_call.member_id');
                        if ($request->filter_by_campaign != null) {
                            $camps->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
                        }
                    })
                    ->select('campaign_leads.id', 'campaign_leads.campaign_id', 'campaigns.type', 'campaigns.status','leads.name','manual_logged_call.outcome','manual_logged_call.call_purpose','users.name as assigned_to')
                    ->where('campaigns.client_id', $client_id)
                    
                    ->where(function ($camps) use ($request) {
                        $manual = DB::table('manual_logged_call')
                            ->join('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
                            ->select('member_id')
                            ->where(function ($manual) use ($request) {
                                if ($request->filter_by_campaign != null) {
                                    $manual->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
                                }
                            })
                            ->where('manual_logged_call.status','1')
                            ->get();
                        $manuarray = [];
                        foreach($manual as $manu){
                            $manuarray[] = $manu->member_id;
                        }
                        if ($request->filter_by_campaign != null) {
                            $camps->where('campaign_leads.campaign_id', $request->filter_by_campaign);
                        }
                        if ($request->filter_by_agent != null) {
                            $camps->where('campaign_leads.agent_id', $request->filter_by_agent);
                        }
                        if ($request->filter_by_campaign_status == 1) {
                            $camps->whereNotIn('leads.id', $manuarray);
                        } elseif($request->filter_by_campaign_status == 2) {
                            $camps->where('manual_logged_call.call_status', 2)
                                ->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
                        } elseif($request->filter_by_campaign_status == 3) {
                            $camps->where('manual_logged_call.call_status', 3)
                                ->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
                        }  elseif($request->filter_by_campaign_status == 0) {
                        }
                        if ($request->filter_by_agentGroup != null && $request->filter_by_agentGroup != "") {
                            $agentGroupId =DB::table('role_user')->where('role_id', $request->filter_by_agentGroup)->pluck('user_id');
                            $camps->whereIn('campaign_leads.agent_id', $agentGroupId);
                        }
                        //to do
                        if(Laralum::loggedInUser()->id != 1){
                            $camps->where('campaign_leads.agent_id', Laralum::loggedInUser()->id);
                        }
                    })
        		->get();

        		$camps=[];
        		foreach ($campsData as $key => $value) {
        			$camps[] .=$value->id;
        		}
        	return Excel::download(new CampaignExport($client_id, $camps), 'campaignAssignedLeads.xlsx');
        }else{
        	return Excel::download(new CampaignExport($client_id, $request->ids), 'campaignAssignedLeads.xlsx');
        }
		
	}


	public function importShow($id)
	{	
		Laralum::permissionToAccess('laralum.campaign.view'); 
		$id = $id;      
		return view('hyper.campaign.import',compact('id'));
	}

	public function import(Request $request)
	{
		//dd($request->all());die;
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		// Allowed mime types
		$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

		// Validate whether selected file is a CSV file
		if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {
			$file = $request->file('file')->store('campaignImport');

			$manual = DB::table('manual_logged_call')
                ->join('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
                ->select('member_id')
                ->where(function ($manual) use ($request) {
                    if ($request->campaign_id != null) {
                        $manual->where('manual_logged_call.campaign_id', $request->campaign_id);
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
		                    ->leftJoin('manual_logged_call', function ($leads) use ($request) {
		                        $leads->on('leads.id', '=', 'manual_logged_call.member_id');
		                        if ($request->campaign_id != null) {
		                            $leads->where('manual_logged_call.campaign_id', $request->campaign_id);
		                        }
		                    })
		                    ->select('leads.id')
		                    ->where('leads.lead_status', '!=', 3)
		                    ->where('leads.client_id', $client_id)
		                    ->where(function ($leads) use ($request, $manuarray) {
		                    	if ($request->campaign_id != null) {
		                            $leads->where('campaign_leads.campaign_id', $request->campaign_id);
		                        }
		                        $leads->whereNotIn('leads.id', $manuarray);

		                    })
		                    ->groupBy('leads.id')->get();
		                    $leads_datta = [];
			        		foreach ($leads as $key => $value) {
			        			$leads_datta[] .=$value->id;
			        		}
			//Excel::import(new LeadsImport, $file);
			$import = new CampaignImport($client_id, Laralum::loggedInUser()->id, $request->campaign_id, $leads_datta);
			$import->import($file);
			//dd($import->errors());
			//return back()->withStatus('File imported successfully');
			$msg = "File is in queue, Please wait...";
			return response()->json(['status' => true ,'message' => $msg]);

		}


	}
	// public function getCampaign(Request $request)
	// {
	// 	$campaign = Campaign::where('created_by', Auth::user()->id)->paginate(2);
	// 	if ($request->ajax()) {
 //           return view('hyper/campaign/page', compact('campaign'));
	// 	}
	// 	return view('hyper/campaign/page', compact('campaign'));
	// }

	// public function view(Request $request)
	// {
	// 	$campValue = Campaign::where('id', $request->id)->first(); 
	// 	$LeadsData = Lead::where(function($q) {
	//          $q->where('client_id', '1')
	//            ->orWhere('user_id', '1');
	//     })->get();
	// 	return view('hyper/campaign/view',compact('campValue','LeadsData'));
	// }

	// public function create(Request $request)
	// {
	// 	if (Laralum::loggedInUser()->reseller_id == 0) {
	// 		$client_id = Laralum::loggedInUser()->id;
	// 	} else {
	// 		$client_id = Laralum::loggedInUser()->reseller_id;
	// 	}
	// 	$agents = User::whereHas('roles', function($q) {
	// 			$q->where('name', 'Agent');
	// 		})->get();
	// 	$agentGroup= Role::where(function ($query) {
	// 			$query->Where('name', '!=', 'Admin');
	// 		})->get();
	// 	$account_types = DB::table('account_types')
	// 						->get();
	// 	$member_types = DB::table('member_types')
	// 					->where('user_id', $client_id)
	// 					->get();
	// 	$prayer_requests = DB::table('prayer_requests')
	// 						->where('user_id', $client_id)
	// 						->get();
	// 	$departments = DB::table('departments')
	// 					->where('client_id', $client_id)
	// 					->get();
	// 	$sources = DB::table('member_sources')
	// 				->where('user_id', $client_id)
	// 				->get();
	// 	$campaigns = DB::table('campaigns')
	// 					->where('client_id', $client_id)
	// 					->orderBy('created_at', 'desc')
	// 					->select('campaigns.id', 'campaigns.name')
	// 					->get();
	// 	return view('hyper.campaign.create', compact('agents','agentGroup','account_types', 'member_types', 'prayer_requests', 'departments', 'sources', 'campaigns'));
	// }

	// public function store(Request $request)
	// {
	// 	if($request->input('step') == 1) {
	// 		$campaign = new Campaign();
	// 		$campaign->type = $request->input('rad');
	// 		$campaign->status = 0;
	// 		$campaign->created_by = Auth::user()->id;
	// 		$campaign->save();
	// 		return 'First step completed';
	// 	}
	// 	if($request->input('step') == 2) {
	// 		$lastCampaign = Campaign::orderBy('id', 'DESC')->first();
	// 		$lastCampaign->name = $request->input('name');
	// 		$lastCampaign->start_time = $request->input('start_time');
	// 		$lastCampaign->end_time = $request->input('end_time');
	// 		$lastCampaign->start_date = $request->input('start_date');
	// 		$lastCampaign->end_date = $request->input('end_date');
	// 		$lastCampaign->days = implode(",",$request->input('days'));
	// 		$lastCampaign->save();
	// 		return 'Second step completed';
	// 	}
	// 	if($request->input('step') == 3) {
	// 		$lastCampaign= Campaign::orderBy('id', 'DESC')->first();
	// 		$lastCampaign->contact_list = $request->input('leads');
	// 		$lastCampaign->contact_list_member = $request->input('members');
	// 		$lastCampaign->save();
	// 		$last_id=$lastCampaign->id;
	// 		if(!empty($request->input('members'))){
	// 			$val1=$request->input('members');
	// 		}
	// 		if(!empty($request->input('leads'))){
	// 			$val2=$request->input('leads');
	// 		}
	// 		$val=$val1+$val2;
	// 		$leads= Lead::where(function($q) {
 //                   $q->where('client_id', '1');
 //                  })->take($val)->get();
	// 		//dd($leads);
	// 		foreach ($leads as $lead) {
	// 			$campaign_leads= new CampaignLead();
	// 			$campaign_leads->campaign_id=$last_id;
	// 			$campaign_leads->lead_id=$lead->id;
	// 			$campaign_leads->save();
	// 		}
	// 		return 'third step completed';
	// 	}
	// 	if($request->input('step') == 4) {
	// 		$lastCampaign= Campaign::orderBy('id', 'DESC')->first();
	// 		//dd($request->input('agents'));
	// 		$lastCampaign->agent = $request->input('agent');
	// 		$lastCampaign->save();
 //            $onlyagent[] = $request->input('agents');
 //            $agentGroup[] = $request->input('agentGroup');
			
	// 		//$onlyagent=explode(" ",$onlyAgent);
	// 		//dd($onlyagent);
	// 		// $last_id=$lastCampaign->id;
	// 		// $rows=CampaignLead::where('campaign_id',$last_id)->count();
	// 		// $dRows=$rows%2;
	// 		// $campaign_leads=CampaignLead::where('campaign_id',$last_id)->get()->toArray();

	// 		// if(!empty($onlyagent)){
	// 		// 	$count=count($onlyagent);
	// 		// 	$i=0;
	// 		// 	if($count>1){
	// 		// 		$campaign_agents=array_slice($campaign_leads,0,$dRows);
	// 		// 		//dd($campaign_agents);
	// 		// 		foreach($campaign_agents as $row){
	// 		// 			//dd($row['campaign_id']);
	// 		// 			$campaign_lead=CampaignLead::where('campaign_id',$row['campaign_id'])->first();
	// 		// 			$campaign_lead->agent_id=$onlyagent[$i];
	// 		// 			 $campaign_lead->save(); 
	// 		// 			$i++;
	// 		// 		}

					
	// 		// 		$campaign_agents=array_slice($campaign_leads,$dRows,$rows);
	// 		// 		foreach($campaign_agents as $row){
	// 		// 			$campaign_lead=CampaignLead::where('campaign_id',$row['campaign_id'])->first();
	// 		// 			$campaign_lead->agent_id=$onlyagent[$i];
	// 		// 			 $campaign_lead->save(); 
						
						
	// 		// 			$i++;
	// 		// 		}
					
					
	// 		// 	}
	// 		// 	else{
	// 		// 		$campaign_leads->agent_id=$onlyagent;
	// 		// 		$campaign_leads->save();
					
	// 		// 	}
				
	// 		// }
	// 		// if(!empty($agentGroup)){
	// 		// 	$count=count($agentGroup);
	// 		// 	if($count>1){
	// 		// 		$campaign_agents=array_slice($campaign_leads,0,$dRows);
	// 		// 		foreach($campaign_agents as $row){
	// 		// 			$campaign_leads->agent_id= $row;
	// 		// 		}
	// 		// 		$campaign_leads->update();
	// 		// 		$campaign_agents=array_slice($campaign_leads,$dRows,$rows);
	// 		// 		foreach($campaign_agents as $row){
	// 		// 			$campaign_leads->agent_id= $row;
	// 		// 		}
					
	// 		// 	}
	// 		// 	else{
	// 		// 		$campaign_leads->agent_id=$agentGroup;
					
	// 		// 	}
	// 		// }

		
	// 		return 'Fourth step completed';
	// 	}
	// 	if($request->input('step') == 5) {
	// 		$lastCampaign= Campaign::orderBy('id', 'DESC')->first();
	// 		$lastCampaign->ivr = $request->input('ivr');
	// 		$lastCampaign->save();
	// 		return 'Fifth step completed';
	// 	}
	// 	if($request->input('step') == 6) {
	// 		$lastCampaign= Campaign::orderBy('id', 'DESC')->first();
	// 		$lastCampaign->show_content = $request->input('show_content');
	// 		$lastCampaign->max_attempt = $request->input('max_attempt');
	// 		$lastCampaign->max_time = $request->input('max_time');
	// 		$lastCampaign->gap_bet_call = $request->input('gap_bet_calls');
	// 		$lastCampaign->save();
	// 		return 'Sixth step completed';
	// 	}
	// 	if($request->input('step') == 7) {
	// 		$lastCampaign= Campaign::orderBy('id', 'DESC')->first();
	// 		$lastCampaign->first_name = $request->input('firstname');
	// 		$lastCampaign->mobile = $request->input('mobile');
	// 		$lastCampaign->address = $request->input('address');
	// 		$lastCampaign->save();
	// 		return 'Seventh step completed';
	// 	}
	// 	if($request->input('step') == 8) {
	// 		$lastCampaign= Campaign::orderBy('id', 'DESC')->first();
	// 		$lastCampaign->status = 1;
	// 		$lastCampaign->save();
	// 	}
	// }
	
	// public function delete(Request $request)
	// {
 //        if ($request->ajax()){
 //        	$data = Campaign::find($request->id);
 //            $data->delete();
 //            return redirect()->route('Crm::campaign')->with('success',' deleted successfully');
 //        }
	// }

	// public function deleteLead(Request $request){
	// 	$id = $request->id;
	// 	if($id) {
	// 		$flight = CampaignLead::where('id', $id)->delete();
	// 		return 'Deleted Successfully';
	// 	}
	// }

	// public function addLead(Request $request)
	// {
	// 	$id = $request->campId;
	// 	$val = $request->username;
	// 	$leads = Lead::where(function($q) {
 //                   $q->where('client_id', '1');
 //                  })->take($val)->get();
	// 	foreach ($leads as $lead) {
	// 			$campaign_leads = new CampaignLead();
	// 			$campaign_leads->campaign_id = $id;
	// 			$campaign_leads->lead_id = $lead->id;
	// 			$campaign_leads->save();
	// 		}
	// 		$camp= Campaign::where('id' ,$id)->first();
	// 		//$campaign_leads=CampaignLead::where('campaign_id',$camp->id)->get();
	// 		$output = DB::table('campaigns')
	// 		                ->join('campaign_lead',  'campaigns.id', '=','campaign_lead.campaign_id' )
	// 		                ->where('campaign_lead.campaign_id','=',$camp->id)
	// 						->join('leads',  'leads.id', '=','campaign_lead.lead_id' )
	// 						->select('campaign_lead.*', 'leads.name','leads.member_id','leads.mobile' )
	// 			        ->get();
	// 		echo json_encode($output);
	// }

	// public function edit(Request $request)
	// {
	// 	$id=$request->id;
	// 	$camp= Campaign::where('id' ,$id)->first();
	// 	$campaign_leads=CampaignLead::where('campaign_id',$camp->id)->get()->toArray();
	// 	$LeadsData = DB::table('campaigns')
	// 	                ->join('campaign_lead',  'campaigns.id', '=','campaign_lead.campaign_id' )
	// 	                ->where('campaign_lead.campaign_id', '=', $camp->id)
	// 					->join('leads',  'leads.id', '=', 'campaign_lead.lead_id' )
	// 					->select('campaign_lead.*', 'leads.name','leads.member_id', 'leads.mobile' )
	// 		        ->paginate(2);
	//     if ($request->ajax()) {
 //            return view('crm/campaign/pull', ['LeadsData' => $LeadsData])->render();  
 //        }
	// 	if($camp){
 //        	$str=($camp->days);
	// 	    $data=(explode(",",$str));
	// 	}
	// 	else{
	// 		$data='';
	// 	}
 //        $agents = User::whereHas(
	// 	'roles', function($q){
	// 		$q->where('name', 'Agent');
	// 	}
	// 	)->get();
	// 	$agentGroup= Role::where(function ($query) {
 //            $query->Where('name', '!=', 'Admin');
 //        })->get();
	// 	return view('crm/campaign/edit',compact('camp','data','agents','campaign_leads','LeadsData','agentGroup'));
	// }
	
	// public function update(Request $request)
	// { 
	// 	$id = $request->id;
 //        $campaign = new Campaign();
 //        $campaign->type = $request->get('rad'); 
 //        $campaign->created_by = Auth::user()->id;
 //        $campaign->name = $request->get('campaign_name');
 //        $campaign->start_time = $request->get('start_time');
 //        $campaign->end_time = $request->get('end_time');
 //        $campaign->start_date = $request->get('start_date');
 //        $campaign->end_date = $request->get('end_date');
 //        $checkbox = implode(",", $request->get('days'));
 //        $campaign->days = $checkbox;
 //        $campaign->contact_list = $request->get('contact_list');
 //        $campaign->contact_list_member = $request->get('leads');
 //        $campaign->agent = $request->get('agent');
 //        $campaign->ivr = '';
 //        $campaign->show_content = $request->get('show_content');
 //        $campaign->max_attempt = $request->get('max_attempt');
 //        $campaign->max_time = $request->get('max_time');
 //        $campaign->gap_bet_call = $request->get('gap_bet_calls');
 //        $campaign->first_name = $request->get('firstname');
 //        $campaign->mobile = $request->get('mobile');
 //        $campaign->address = $request->get('address');
 //        $campaign->status = 1;
 //        $campaign->save();
 //        return redirect()->route('Crm::campaign')->withSuccess('Updated Successfully!');
	// }

	// public function pullLead(Request $request)
	// {
	// 	$id=$request->lead_id;
	// 	$camp= Campaign::where('id' ,$id)->first();
	// 	$LeadsData = DB::table('campaigns')
	// 	                ->join('campaign_lead',  'campaigns.id', '=','campaign_lead.campaign_id' )
	// 	                ->where('campaign_lead.campaign_id','=',$camp->id)
	// 					->join('leads',  'leads.id', '=','campaign_lead.lead_id' )
	// 					->select('campaign_lead.*', 'leads.name','leads.member_id','leads.mobile' )
	// 		        ->paginate(2);
			 

 //        // return view('crm/campaign/pull',compact('$output'));
 //        return view('crm/campaign/pull',compact('LeadsData'));
 //    }






	
}
