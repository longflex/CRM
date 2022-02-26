<?php

namespace App\Http\Controllers\Crm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lead;
use App\User;
use App\IncommingLead;
use App\Leadsdata;
use App\Member_Issue;
use App\Donation;
use App\ManualLoggedCall;
use App\Exports\CallLogExport;
use App\Exports\LeadsExport;
use App\Exports\DonationExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Laralum\Laralum;
use App\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule; 
use App\Services\LeadService;
use App\Services\DonationService;
use App\Services\MemberIssueService;
use App\Services\CallLogService;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redis;
use App\Campaign;
use App\Jobs\NotifyLeadOfCompletedImport;
//use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Imports\LeadsImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
// use Illuminate\Support\Facades\Artisan;
// Artisan::call('mail:send 1 --queue=default');

class LeadsController extends Controller
{
	private $lead;
	private $issue;
	private $donation;
	private $callLog;

	public function __construct(LeadService $lead, MemberIssueService $issue, DonationService $donation, CallLogService $callLog)
    {
        $this->lead = $lead;
        $this->issue = $issue;
        $this->donation = $donation;
        $this->callLog = $callLog;
    }

	public function index(Request $request)
	{
		//Laralum::permissionToAccess('laralum.lead.access');
		Laralum::permissionToAccess('laralum.lead.list');
		$agent_id = NULL;
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
			$agent_id = Laralum::loggedInUser()->id;
		}

		$lead_types = ['0' => 'Recent Incoming'];
		$account_types = DB::table('member_accounttypes')
						->where('user_id', $client_id)
							->get();
		$member_types = DB::table('member_types')
							->where('user_id', $client_id)
							->get();
		$prayer_requests = DB::table('prayer_requests')
							->where('user_id', $client_id)
							->get();
		$departments = DB::table('departments')
						->where('client_id', $client_id)
						->get();
		$sources = DB::table('member_sources')
					->where('user_id', $client_id)
					->get();
		$agents = DB::table('users')
					->where('reseller_id', Laralum::loggedInUser()->id)
					->get();
		$agentGroup = Role::where(function ($query) {
					$query->Where('name', '!=', 'Admin');
				})->get();
		$lead_statuses = DB::table('lead_statuses')
						->where('client_id', $client_id)
						->get();
		$lead_responses = DB::table('lead_responses')
						->where('client_id', $client_id)
						->get();				
		$membertypes = DB::table('member_types')->where('user_id', $client_id)->get();
		$branches = DB::table('branch')->where('client_id', $client_id)->get();
		$donation_purposes = DB::table('donation_purpose')->where('user_id', $client_id)->get();
		$razorKey = Laralum::loggedInUser()->RAZOR_KEY;
			
		if($razorKey == '' || $razorKey == null){
			$razorKey = User::where('id', Laralum::loggedInUser()->reseller_id)->value('RAZOR_KEY');
		}
       $manual_call_logs = DB::table('manual_logged_call')->where('member_id', $client_id)->paginate(10,['*'], 'manual_logged_call')->fragment('manual_logged_call');
       //$campaigns = Campaign::where('client_id', $client_id)->get();
       $campaigns = DB::table('campaigns')
					->leftJoin('campaign_agents', 'campaigns.id', '=', 'campaign_agents.campaign_id')
					->leftJoin('campaigns_selecteds', 'campaigns.id', '=', 'campaigns_selecteds.campaign_id')
					->where('campaigns.client_id', $client_id)
					->when($agent_id, function ($query, $agent_id) {
	                    return $query->where('campaign_agents.agent_id', $agent_id);
	                })
					->orderBy('campaigns.id', 'desc')
					->groupBy('campaigns.id')
					->select('campaigns.*','campaigns_selecteds.campaign_check')
					->get();
		return view('hyper.lead.index', compact('membertypes','branches','donation_purposes','razorKey','manual_call_logs','account_types', 'member_types', 'prayer_requests', 'departments', 'sources', 'agents', 'agentGroup', 'lead_statuses','campaigns', 'lead_responses', 'lead_types'));
	}
	
	public function getLeads(Request $request)
	{
		//Laralum::permissionToAccess('laralum.lead.access');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		## Read value
		$draw = $request->get('draw');
		$start = $request->get("start");
		$rowperpage = $request->get("length"); // Rows display per page
		$columnIndex_arr = $request->get('order');
		$columnName_arr = $request->get('columns');
		$order_arr = $request->get('order');
		$search_arr = $request->get('search');
		$columnIndex = $columnIndex_arr[0]['column']; // Column index
		$columnName = $columnName_arr[$columnIndex]['data']; // Column name
		$columnSortOrder = $order_arr[0]['dir']; // asc or desc
		$searchValue = $search_arr['value']; // Search value
		// Total records
		$totalRecords = Lead::select('count(*) as allcount')->where('client_id', $client_id)->count();
		$totalRecordswithFilter = Lead::select('count(*) as allcount')->where('client_id', $client_id)->where('name', 'like', '%' .$searchValue . '%')->count();
		// Fetch records
		$records = Lead::orderBy($columnName,$columnSortOrder)
		->where('client_id', $client_id)
		->where('leads.name', 'like', '%' .$searchValue . '%')
		->select('leads.*')
		->skip($start)
		->take($rowperpage)
		->groupBy('id')
		->get();
		$data_arr = array();
		
		foreach($records as $record){
		$name = $record->name;
		$member_id = $record->member_id;
		$phone = $record->mobile;
		$created_date = $record->created_at;
		$data_arr[] = array(
			"name" => "<a href=".route('Crm::lead_details', ['id' => $record->id]).">".$name."</a>",
			"member_id" => $member_id,
			"mobile" => $phone,
			"created_at" =>  date('d/m/Y', strtotime($created_date))
		);
		}
		$response = array(
		"draw" => intval($draw),
		"iTotalRecords" => $totalRecords,
		"iTotalDisplayRecords" => $totalRecordswithFilter,
		"aaData" => $data_arr
		);
		echo json_encode($response);
		exit;
   	}
   
	public function getIssuesDatatables(Request $request, $member_id)
	{
		//Laralum::permissionToAccess('laralum.lead.view');
		$draw = $request->get('draw');
		$start = $request->get("start");
		$rowperpage = $request->get("length"); // Rows display per page
		$columnIndex_arr = $request->get('order');
		$columnName_arr = $request->get('columns');
		$order_arr = $request->get('order');
		$search_arr = $request->get('search');
		$columnIndex = $columnIndex_arr[0]['column']; // Column index
		$columnName = $columnName_arr[$columnIndex]['data']; // Column name
		$columnSortOrder = $order_arr[0]['dir']; // asc or desc
		$searchValue = $search_arr['value']; // Search value
		// Total records
		$totalRecords = Member_Issue::select('count(*) as allcount')->where('member_id', $member_id)->count();
		$totalRecordswithFilter = Member_Issue::select('count(*) as allcount')->where('member_id', $member_id)->count();
		// Fetch records
		$records = Member_Issue::orderBy($columnName,$columnSortOrder)
		->where('member_id', $member_id)
		->select('member_issues.*')
		->skip($start)
		->take($rowperpage)
		->get();
		$data_arr = array();
		foreach($records as $record){
			$issue = $record->issue;
			$created_at = date('d/m/Y', strtotime($record->created_at));
			$taken_by = $this->getName($record->created_by);
			$status = ($record->status==1) ? '<span class="badge badge-success">Resolved</span>' : '<span class="badge badge-danger">Pending</span>';
			$action = '<a href="javascript:void(0);" class="btn btn-sm btn-link font-15" id="editNoteButton" data-id="'.$record->id.'" data-text="'.$record->issue.'" data-status="'.$record->status.'"data-toggle="modal" data-target="#EditNote">
							<i class="fas fa-edit"></i></a>';
			$data_arr[] = array(
			"issue" => $issue,
			"created_at" => $created_at,
			"created_by" => $taken_by,
			"status" =>  $status,
			"action" =>  $action
			);
		}
		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordswithFilter,
			"aaData" => $data_arr
		);
		echo json_encode($response);
		exit;
	}
   
    public function getDonationDatatables(Request $request, $member_id)
	{
		//Laralum::permissionToAccess('laralum.lead.view');
		 ## Read value
		 $draw = $request->get('draw');
		 $start = $request->get("start");
		 $rowperpage = $request->get("length"); // Rows display per page

		 $columnIndex_arr = $request->get('order');
		 $columnName_arr = $request->get('columns');
		 $order_arr = $request->get('order');
		 $search_arr = $request->get('search');

		 $columnIndex = $columnIndex_arr[0]['column']; // Column index
		 $columnName = $columnName_arr[$columnIndex]['data']; // Column name
		 $columnSortOrder = $order_arr[0]['dir']; // asc or desc
		 $searchValue = $search_arr['value']; // Search value

		 // Total records
		 $totalRecords = Donation::select('count(*) as allcount')->where('donated_by', $member_id)->count();
		 $totalRecordswithFilter = Donation::select('count(*) as allcount')->where('donated_by', $member_id)->where('receipt_number', 'like', '%' .$searchValue . '%')->count();

		 // Fetch records
		 $records = Donation::orderBy($columnName,$columnSortOrder)
		   ->where('donated_by', $member_id)
		   ->where('donations.receipt_number', 'like', '%' .$searchValue . '%')
		   ->select('donations.*')
		   ->skip($start)
		   ->take($rowperpage)
		   ->get();

		 $data_arr = array();
		 
		 
		 
		 foreach($records as $record){
			$receipt_number = $record->receipt_number;
			$payment_type = $record->payment_type;
			$amount = number_format($record->amount, 2, '.', ',');
			$payment_mode = ($record->payment_mode=='OTHER') ? $record->payment_method : $record->payment_mode;
			$payment_status = ($record->payment_status) ? '<span class="badge badge-success">Paid</span>' : '<span class="badge badge-danger">Pending</span>';
			$created_date =  date('d/m/Y', strtotime($record->created_at));
			if($record->payment_status){
			    $button1='<a href="'. route('Crm::donation_details', ['id' => $record->id]) .'" class="item"><i class="print icon"></i>&nbsp; Print</a>';
			}else{
				$button1='';
			 }
			 if(!$record->payment_status && $record->payment_mode=='Razorpay'){
				$button2='<a href="javascript:void(0);" class="item" id="send_payment_link_sms" data-id="'.$record->id.'"><i class="fa fa-comment"></i>&nbsp; Send Payment Link SMS</a>';
			  }else{
				$button2='';  
			  }
			  if(!$record->payment_status && $record->payment_mode=='CASH'){
				$button3='<a href="javascript:void(0);" class="item" id="update_payment_status_paid" data-id="'.$record->id.'"><i class="fa fa-check"></i>&nbsp; Mark as Paid</a>';
			  }else{
				 $button3=''; 
			  }

			
			//if(Laralum::hasPermission('laralum.donation.view')){
			if(Laralum::hasPermission('laralum.lead.view')){
	            if($record->payment_type=='recurring'){
				$action =	'<a href="'.route('Crm::payment_detail', ['id' => $record->id]).'"
					class="ui '. Laralum::settings()->button_color .' top icon left  button">
					<i class="edit icon"></i>
					</a>';
				 }else{
				$action =	'<div class="ui '. Laralum::settings()->button_color .' top icon left pointing dropdown button toggle_menu"><i class="configure icon"></i>
					 <div class="menu">
						'.$button1.'
						'.$button2.'
						'.$button3.'
					</div>
					</div>';
				 }
			}

			$data_arr[] = array(
			  "receipt_number" => $receipt_number,
			  "payment_type" => $payment_type,
			  "amount" => $amount,
			  "payment_mode" => $payment_mode,
			  "payment_status" => $payment_status,
			  "created_at" =>  $created_date,
			  "action" =>  $action
			);
		 }

		 $response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordswithFilter,
			"aaData" => $data_arr
		 );

		 echo json_encode($response);
		 exit;
   	}

	public function dashboard(Request $request)
	{
		Laralum::permissionToAccess('laralum.lead.dashboard');
		// $prayer_request = DB::table('member_issues')->where('member_issues.created_by', Laralum::loggedInUser()->id);
			
		// 		$prayer_request->where('member_issues.client_id', 139);
		// 	//02/08/2021+-+03/27/2021
			
		// 		//$dateData4 = explode('-', '02/08/2021-03/27/2021');
		// 		//$prayer_request->whereBetween('member_issues.created_at', [date("Y-m-d", strtotime($dateData4[0])), date("Y-m-d", strtotime($dateData4[1]))]);
		
		// 	$prayer_request->count();
		// 	print_r($prayer_request);die;
		
		// Laralum::permissionToAccess('laralum.member.view');
		// if (Laralum::loggedInUser()->reseller_id == 0) {
		// 	$client_id = Laralum::loggedInUser()->id;
		// } else {
		// 	$client_id = Laralum::loggedInUser()->reseller_id;
		// }
		// # Get all leads for admin
		// if (Laralum::loggedInUser()->reseller_id == 0) {
		// 	$type = 'client_id';
		// 	$total_issues = DB::table('member_issues')->where('client_id', Laralum::loggedInUser()->id)->count();
		// 	$pending_issues = DB::table('member_issues')->where('status', 2)->where('client_id', Laralum::loggedInUser()->id)->count();
		// 	$resolved_issues = DB::table('member_issues')->where('status', 1)->where('client_id', Laralum::loggedInUser()->id)->count();
		// 	$total_members = DB::table('leads')->where('client_id', Laralum::loggedInUser()->id)->count();
		// 	$today_members = DB::table('leads')->where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d"))->count();
		// } else {
		// 	$type = 'created_by';
		// 	$total_issues = DB::table('member_issues')->where('created_by', Laralum::loggedInUser()->id)->count();
		// 	$pending_issues = DB::table('member_issues')->where('status', 2)->where('created_by', Laralum::loggedInUser()->id)->count();
		// 	$resolved_issues = DB::table('member_issues')->where('status', 1)->where('created_by', Laralum::loggedInUser()->id)->count();
		// 	$total_members = DB::table('leads')->where('created_by', Laralum::loggedInUser()->id)->count();
		// 	$today_members = DB::table('leads')->where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d"))->count();
		// }
		// $sources = DB::table('member_sources')->where('user_id', $client_id)->get();

		// $branches = DB::table('branch')->where('client_id', $client_id)->get();

		// $accounttypes = DB::table('member_accounttypes')->where('user_id', $client_id)->get();
		// $membertypes = DB::table('member_types')->where('user_id', $client_id)->get();
		// $leads_count = DB::table('leads')->where('user_id',Laralum::loggedInUser()->id)->orderBy('created_at','desc')->first();
		// $leads_count = !empty($leads_count)?(substr($leads_count->member_id,-1)+1):1;
		// $organization_profile = DB::table('organization_profile')->where('client_id', $client_id)->first();
		// $company = !empty($organization_profile->company_id) ? $organization_profile->company_id : $organization_profile->organization_name;
		// $company = strtoupper($company) . ($leads_count < 10 ? "0" . $leads_count : $leads_count);
		
		// return view('crm/leads/dashboard', [
		// 	'type' => $type,
		// 	'total_issues' => $total_issues,
		// 	'pending_issues' => $pending_issues,
		// 	'resolved_issues' => $resolved_issues,
		// 	'total_members' => $total_members,
		// 	'today_members' => $today_members,
		// 	'company' => $company,
		// 	'sources' => $sources, 
		// 	'accounttypes' => $accounttypes, 
		// 	'membertypes' => $membertypes
		// ]);
		$agent_id = NULL;
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;

		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
			$agent_id = Laralum::loggedInUser()->id;
		}

		$Check=DB::table('campaigns_selecteds')->where('agent_id', $agent_id)->first();
		if($Check){
			if (!$request->session()->has('campaigns_selected_id')) {
				session()->put('campaigns_selected_id', $Check->campaign_id);
			}
		}

		$prayer_requests = DB::table('prayer_requests')->where('user_id', $client_id)->get();
		$membertypes = DB::table('member_types')->where('user_id', $client_id)->get();
		$branches = DB::table('branch')->where('client_id', $client_id)->get();
		$donation_purposes = DB::table('donation_purpose')->where('user_id', $client_id)->get();
		$razorKey = Laralum::loggedInUser()->RAZOR_KEY;
		$agents = DB::table('users')
					->where('reseller_id', Laralum::loggedInUser()->id)
					->get();
		$prayer_request = DB::table('member_issues')
							->where('created_by', Laralum::loggedInUser()->id)
							->count();
		$reminders = DB::table('member_issues')
						->where('status', 2)
						->where('created_by', Laralum::loggedInUser()->id)
						->count();
		$campaigns = DB::table('campaigns')
					->leftJoin('campaign_agents', 'campaigns.id', '=', 'campaign_agents.campaign_id')
					->leftJoin('campaigns_selecteds', 'campaigns.id', '=', 'campaigns_selecteds.campaign_id')
					->where('campaigns.client_id', $client_id)
					->when($agent_id, function ($query, $agent_id) {
	                    return $query->where('campaign_agents.agent_id', $agent_id);
	                })

					->orderBy('campaigns.id', 'desc')
					->groupBy('campaigns.id')
					->select('campaigns.*','campaigns_selecteds.campaign_check')
					->get();
					//dd($campaigns);
		// $campaigns = DB::table('campaigns')
		// 				->orderBy('campaigns.id', 'desc')
		// 				->join('campaign_agents', 'campaigns.id', '=', 'campaign_agents.campaign_id')
		// 				->select('campaigns.id', 'campaigns.name');
		// if (Laralum::loggedInUser()->reseller_id == 0) {
		// 	$campaigns->where('campaigns.client_id', Laralum::loggedInUser()->id);
		// } else {
		// 	$campaigns->where('campaigns.client_id', Laralum::loggedInUser()->reseller_id);
		// 			// ->where('campaign_agents.agent_id', Laralum::loggedInUser()->id);
		// }
		// $campaigns->get();

		// $answered_calls_count = DB::table('manual_logged_call')
		// 					->leftJoin('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
  //                   		->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
		// 					->where('manual_logged_call.outcome', 'manual_logged_call.connected');
		// if ($request->filter_by_agent != "") {
		// 	$answered_calls_count->where('manual_logged_call.created_by', Laralum::loggedInUser()->id);
		// }
		// if ($request->filter_by_Date != "") {
		// 	$dateData = explode(' - ', $request->filter_by_Date);
		// 	$answered_calls_count->whereBetween('manual_logged_call.created_at', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
		// }else{
		// 	$answered_calls_count->whereDate('manual_logged_call.created_at', $current_date);
		// }
		// if ($request->filter_by_campaign != null) {
  //           $answered_calls_count->where('campaign_leads.campaign_id', $request->filter_by_campaign);
  //       }
  //       if(Laralum::loggedInUser()->id != 1){
  //           $answered_calls_count->where('campaign_leads.agent_id', Laralum::loggedInUser()->id);
  //       }
		// $answered_calls_count->get();
		//$total_answered_calls_count = $answered_calls_count->count();
		//Not Answerd calls count
		// $regs = DB::table('manual_logged_call')->select('created_at', DB::raw('COUNT(id) as count'))->whereDate('created_at', $current_date)->get();
		// $regs = $regs->groupBy(function($reg){
		//     return date('H',strtotime($reg->created_at));
		// });
		/*$regs = DB::table('manual_logged_call')
		->whereDate('manual_logged_call.created_at', $current_date)->get()
		->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('h');
		});*/
   // ->select(DB::raw('count(*), created_at'))
   // ->groupBy(DB::raw('DATE(created_at) as created_at'))
   //                      ->groupBy(DB::raw('hour(created_at)'))
   		$answered_calls_count = DB::table('manual_logged_call')
		    ->select(DB::raw('count(*) as count, HOUR(created_at) as hour'))
		    ->where('manual_logged_call.outcome', 'connected')
		    ->whereDate('created_at', '=', Carbon::now()->toDateString())
		    ->groupBy('hour')
		    ->get();
		$AC=array_fill(0,25,0);
		    foreach ($answered_calls_count as $key => $value) {
		    	$h = $value->hour + 1;
			    $AC[$h] = (int)$value->count;
		    }    


		$not_answered_calls_count = DB::table('manual_logged_call')
		    ->select(DB::raw('count(*) as count, HOUR(created_at) as hour'))
		    ->where('manual_logged_call.outcome', 'busy')
		    ->whereDate('created_at', '=', Carbon::now()->toDateString())
		    ->groupBy('hour')
		    ->get();
		    $NAC=array_fill(0,25,0);
		    foreach ($not_answered_calls_count as $key => $value) {
		    	$h1 = $value->hour + 1;
			    $NAC[$h1] = (int)$value->count;
		    }
		$AC = implode(', ', $AC);
		$NAC = implode(', ', $NAC);
		
		$call_purposes = DB::table('call_purposes')->where('client_id', $client_id)->get();
		return view('hyper.lead.dashboard', compact('agents', 'prayer_request', 'prayer_requests', 'reminders', 'membertypes', 'branches', 'donation_purposes', 'razorKey', 'campaigns', 'AC', 'NAC','call_purposes'));
	}

	public function get_leads_data(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $leads = $this->lead->getLeadForTable($request, $client_id);
        return $this->lead->leadDataTable($leads);
        
    }

	public function get_leads_data_lead_list(Request $request)
	{
        // $leads = $this->lead->getLeadForTableLeadList($request);
        // return $this->lead->leadDataTableLeadList($leads);
        if (Laralum::loggedInUser()->reseller_id == 0) {
		$client_id = Laralum::loggedInUser()->id;
		}else{
		$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $leads = $this->lead->getLeadForTableLeadList($request,$client_id);
		return $this->lead->leadDataTableLeadList($leads);
        // echo "<pre>";
        // print_r($leads);exit;
        //return $this->donation->donationAdminDataTable($donations);
		//return view('hyper/lead/pagination_data', ['leads' => $leads]);
    }
    
    public function lead_status_update(Request $request)
	{
		$lead = DB::table('leads')
					->where('id', $request->lead_id)
					->first();
		if($lead != null){
			DB::table('leads')->update([
				'lead_status' => $request->lead_status,
				
			]);
			$status = 'Lead Status Changed Successfully';
		} else {
			$status = 'Lead Not Found';
		}
		return response()->json($status);
    }

	public function manual_call_status(Request $request)
	{
		$lead = DB::table('leads')
					->where('id', $request->member_id)
					->first();

		if($lead != null){

			$agent_number = Laralum::loggedInUser()->mobile;
			$lead_number = $lead->mobile;

			$data = $this->lead->getCallDetails($lead_number, $agent_number);
			if($data){
				DB::table('manual_logged_call')
					->where('id', $data->id)
					->update([
						'call_status' => $request->call_status,
						'status' => 1
					]);
			}else{
				DB::table('manual_logged_call')
					->insert([
					'client_id' => $lead->client_id,
					'member_id' => $request->member_id,
					'lead_number' => $lead_number,
					'agent_number' => $agent_number,
					'campaign_id' => (isset($request->campaign_id) && $request->campaign_id) ? $request->campaign_id: '',
					'created_by' => Laralum::loggedInUser()->id,
					'call_status' => $request->call_status,
					'status' => 1,
					'call_source' => 0,
					'call_type' => 0,
					'date' => date('Y-m-d'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				]);
			}

			$status = 'Call Status Changed Successfully';
		} else {
			$status = 'Lead Not Found';
		}
		return response()->json($status);
    }


 //    public function manual_call_status_outcome_update(Request $request)
	// {
		
	// 	DB::table('manual_logged_call')->where('manual_logged_call.member_id', $request->callLogEditId)->update([
	// 		'call_outcome' => $request->call_status
	// 	]);
	// 	$status = 'Call Status Changed Successfully';
		
	// 	return response()->json($status);
 //    }
	public function leadPrayerRequest(Request $request)
	{
        $issues = $this->issue->getPrayerRequestForTable($request->id);
        return $this->issue->prayerRequestDataTable($issues);
    }

	public function leadDonation(Request $request)
	{
        $donations = $this->donation->getLeadDonationForTable($request->id);
        return $this->donation->donationDataTable($donations);
    }

	public function lead_delete(Request $request)
	{
		Laralum::permissionToAccess('laralum.lead.delete');
		//Laralum::permissionToAccess('laralum.member.delete');
		$lead = Lead::find($request->id);
		$lead->delete();
		return response()->json(array(
			'status' => 'success',
		));
    }

	public function prayer_request(Request $request)
	{
		Laralum::permissionToAccess('laralum.lead.view');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		if($request->follow_up_date ==""){
			$status="1";
		}else{
			$status="2";
		}
		DB::table('member_issues')->insert([
			'client_id' => $client_id,
			'created_by' => Laralum::loggedInUser()->id,
			'member_id' => $request->member_id,
			'issue' => $request->issue,
			'follow_up_date' => ($request->follow_up_date != '') ? date('Y-m-d', strtotime($request->follow_up_date)) : NULL,
			'description' => $request->description,
			'status' => $status,
			'created_at' => new DateTime('now'),
			'updated_at' =>	new DateTime('now'),
		]);
    }

	public function assign_lead(Request $request)
	{
		$leads=$request->leads;
		$leads_count=count($leads);
		$agents=$request->agents;
		$agents_count=count($agents);
		$lead_share=round ( ($leads_count / $agents_count) , 0 , PHP_ROUND_HALF_DOWN );
		$arr = array_chunk($leads, $lead_share);
		for ($i=0; $i <count($arr) ; $i++) {
			for ($j=0; $j <count($arr[$i]) ; $j++) { 
				DB::table('leads')
					->where('id', $arr[$i][$j])
					->update(['lead_status' => 1, 'agent_id' => $agents[$i]]);
			} 
		}
		return response()->json(array(
			'status' => 'success',
		));

    }

	public function dashboardFilter(Request $request)
	{
		$exp_requested_date = explode("-", $request->data);
		$from = $exp_requested_date[0];
		$to = $exp_requested_date[1];

		$from_date = date('Y-m-d H:i:s', strtotime($from));
		$to_date = date('Y-m-d H:i:s', strtotime($to));

		# Get all leads for admin
		if (Laralum::loggedInUser()->reseller_id == 0) {

			$total_issues = DB::table('member_issues')->where('client_id', Laralum::loggedInUser()->id)->whereBetween('created_at', [$from_date, $to_date])->count();
			$pending_issues = DB::table('member_issues')->where('status', 2)->where('client_id', Laralum::loggedInUser()->id)->whereBetween('created_at', [$from_date, $to_date])->count();
			$resolved_issues = DB::table('member_issues')->where('status', 1)->where('client_id', Laralum::loggedInUser()->id)->whereBetween('created_at', [$from_date, $to_date])->count();
			$total_members = DB::table('leads')->where('client_id', Laralum::loggedInUser()->id)->count();
		} else {

			$total_issues = DB::table('member_issues')->where('created_by', Laralum::loggedInUser()->id)->count();
			$pending_issues = DB::table('member_issues')->where('status', 2)->where('created_by', Laralum::loggedInUser()->id)->whereBetween('created_at', [$from_date, $to_date])->count();
			$resolved_issues = DB::table('member_issues')->where('status', 1)->where('created_by', Laralum::loggedInUser()->id)->whereBetween('created_at', [$from_date, $to_date])->count();
			$total_members = DB::table('leads')->where('created_by', Laralum::loggedInUser()->id)->whereBetween('created_at', [$from_date, $to_date])->count();
		}

		return response()->json(array(
			'success' => true,
			'status' => 'success',
			'total_issues' => $total_issues,
			'pending_issues' => $pending_issues,
			'resolved_issues' => $resolved_issues,
			'total_members' => $total_members
		), 200);
	}

	public function create()
	{
		Laralum::permissionToAccess('laralum.lead.create');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		//Laralum::permissionToAccess('laralum.member.create');
		$get_state = DB::table('state')->get();
		$organization_profile = DB::table('organization_profile')
								->where('client_id', $client_id)
								->first();
		$leads_count = DB::table('leads')
						//->join('campaign_lead', 'leads.id', 'campaign_lead.lead_id')
						->where('leads.client_id', $client_id)
						->select('leads.member_id')
						->orderBy('leads.created_at','DESC')
						->get();
		$leads_count=count($leads_count);				
						//dd($leads_count);
		 //dd(substr($leads_count->member_id,-1));
		$leads_count = $leads_count!=0?($leads_count+1):1;///mahdi
		//$leads_count = !empty($leads_count)?((explode('-',$leads_count->member_id,1)[1])+1):1;
		//$leads_count = !empty($leads_count->member_id)?@((explode('-',$leads_count->member_id,2)[1])+1):1;
		// dd($leads_count);
		$get_countries = DB::table('countries')->get();
		$departments = DB::table('departments')
						->where('client_id', $client_id)
						->get();
		$branches = DB::table('branch')
					->where('client_id', $client_id)
					->get();
		$sources = DB::table('member_sources')
					->where('user_id', $client_id)
					->get();
		$accounttypes = DB::table('member_accounttypes')
						->where('user_id', $client_id)
						->get();
		$membertypes = DB::table('member_types')
						->where('user_id', $client_id)
						->get();
		$preferred_languages = DB::table('preferred_languages')
						->where('client_id', $client_id)
						->get();
		$lead_responses = DB::table('lead_responses')
						->where('client_id', $client_id)
						->get();
		$lead_statuses = DB::table('lead_statuses')
						->where('client_id', $client_id)
						->get();												
		$company = !empty($organization_profile->company_id) ? $organization_profile->company_id : $organization_profile->company_id;//mahdi
		//$company = strtoupper(str_replace(' ','_', $company)) ."-". ($leads_count < 10 ? "0" . $leads_count : $leads_count);
		$company = strtoupper($company) . ($leads_count < 10 ? "0" . $leads_count : $leads_count);
		$agents = DB::table('users')
					->where('reseller_id', Laralum::loggedInUser()->id)
					->get();
		// $campaigns = DB::table('campaigns')
		// 			->where('client_id', $client_id)
		// 			->orderBy('created_at', 'desc')
		// 			->select('campaigns.id', 'campaigns.name')
		// 			->get();
		return view('hyper.lead.create', compact('agents','get_state', 'get_countries', 'company', 'sources', 'accounttypes', 'membertypes', 'departments', 'branches','preferred_languages', 'lead_responses', 'lead_statuses','client_id'));
	}

	public function store(Request $request)
	{
		Laralum::permissionToAccess('laralum.lead.create');
		//Laralum::permissionToAccess('laralum.member.create');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		// $request->validate([
		// 	'name' => 'required',
		// 	'member_id' => 'required',
		// 	'campaign_id' => 'required',
		// 	'mobile' => ['required', 'numeric','min:10',
		// 	Rule::unique('leads')->where(function ($query) use ($client_id) {
		// 		return $query->where('user_id', $client_id);
		// 	})]
		// ]);
		$validator = Validator::make($request->all(), [
			'name' => 'required',
		 	'member_id' => 'required',
		 	//'campaign_id' => 'required',
		 	'mobile' => ['required', 'numeric','min:10',
		 	Rule::unique('leads')->where(function ($query) use ($client_id) {
		 		return $query->where('user_id', $client_id);
		 	})]
			]);
	
			if ($validator->fails()) {
				$msg="Name, member id fields is required and mobile no should be unique in same business";
				return response()->json(['status' => false ,'message' => $msg]);
			}

		$lead = new Lead;
		$lead->user_id = Laralum::loggedInUser()->id;
		$lead->client_id = $client_id;
		$lead->department = $request->department;
		$lead->member_id = ($request->member_id);
		$lead->account_type = $request->account_type;
		$lead->lead_source = $request->lead_source;
		$lead->member_type = json_encode($request->member_type);
		$lead->name = $request->name;
		$lead->gender = $request->gender;
		$lead->sms_language = $request->sms_language;
		$lead->blood_group = $request->bldgrp;
		$lead->married_status = $request->marriedstatus;
		$lead->date_of_birth = ($request->dob != '') ? date('Y-m-d', strtotime($request->dob)) : NULL;
		$lead->rfid = $request->rfid;
		$lead->email = $request->email;
		$lead->mobile = $request->mobile; 
		$lead->alt_numbers = empty($request->alt_number) ? '' : implode(',', $request->alt_number);//json_encode($request->alt_number);
		$lead->address = empty($request->address) ? '' : serialize($request->address);
		$lead->state = empty($request->state) ? '' : serialize($request->state);
		$lead->country = empty($request->country) ? '' : serialize($request->country);
		$lead->district = empty($request->district) ? '' : serialize($request->district);
		$lead->pincode = empty($request->pincode) ? '' : serialize($request->pincode);
		$lead->address_type = serialize($request->address_type);
		$lead->date_of_joining = ($request->doj != '') ? date('Y-m-d', strtotime($request->doj)) : NULL;
		$lead->qualification = $request->qualification;
		$lead->branch = $request->branch;
		$lead->profession = $request->profession;
		$lead->sms_required = $request->has('sms');
		$lead->call_required = $request->has('call');
		$lead->profile_photo = $request->profile_photo_path;
		$lead->id_proof = $request->id_proof_path;
		$lead->created_by = Laralum::loggedInUser()->id;
		$lead->lead_status = $request->lead_status;
		$lead->agent_id = $request->agent;
		$lead->preferred_language = $request->preferred_language;
		$lead->lead_response = $request->lead_response;
		//$lead->last_contacted_date = ($request->last_contacted_date != '') ? date('Y-m-d',  strtotime($request->last_contacted_date)) : NULL;
		$lead->date_of_anniversary = ($request->date_of_anniversary != '') ? date('Y-m-d', strtotime($request->date_of_anniversary)) : NULL;
		$lead->save();

		$incomming_lead = new IncommingLead;
		$incomming_lead->lead_id = $lead->id;
		$incomming_lead->save();

		// if($request->campaign_id != "" || $request->campaign_id != null) {
		// 	DB::table('campaign_lead')->insert([
		// 		'agent_id' => $client_id,
		// 		'campaign_id' => $request->campaign_id,
		// 		'lead_id' => $lead->id,
		// 		'created_at' => date('YmdHis'),
		// 		'updated_at' => date('YmdHis')
		// 	]);
		// }
		// if($request->agent != "" || $request->agent != null) {
		// 	DB::table('agent_leads')->insert([
		// 		'agent_id' => $request->agent,
		// 		'lead_id' => $lead->id,
		// 		'created_at' => date('YmdHis'),
		// 		'updated_at' => date('YmdHis')
		// 	]);
		// }
		if ($request->family_member_name) {
			$name_relation = array();
			foreach ($request->family_member_name as $k => $v) {
				$name_relation[$k][] = $v;
				if ($request->family_member_relation) {
					foreach ($request->family_member_relation as $key => $val) {
						if ($k == $key) {
							$name_relation[$k][] = $val;
						}
					}
				}
				if ($request->family_member_dob) {
					foreach ($request->family_member_dob as $keys => $value) {
						if ($k == $keys) {
							$name_relation[$k][] = $value;
						}
					}
				}
				if ($request->family_member_mobile) {
					foreach ($request->family_member_mobile as $mKeys => $mValue) {
						if ($k == $mKeys) {
							$name_relation[$k][] = $mValue;
						}
					}
				}
			}
			foreach ($name_relation as $value) {
				Leadsdata::create([
					'member_id' => $lead->id,
					'member_relation' => $value[1],
					'member_relation_name' => $value[0],
					'member_relation_mobile' => $value[3],
					'member_relation_dob' =>($value[2] != '') ? date('Y-m-d', strtotime($value[2])) : NULL
				]);
			}
		}
		$msg="The lead has been created.";
		return response()->json(['status' => true ,'message' => $msg, 'id'=>$lead->id]);
	}

	public function edit($id)
	{
		Laralum::permissionToAccess('laralum.lead.edit');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		//Laralum::permissionToAccess('laralum.member.edit');
		$sources = DB::table('member_sources')->where('user_id', $client_id)->get();
		$branches = DB::table('branch')->where('client_id', $client_id)->get();
		$accounttypes = DB::table('member_accounttypes')->where('user_id', $client_id)->get();
		$membertypes = DB::table('member_types')->where('user_id', $client_id)->get();
		$departments = DB::table('departments')->where('client_id', $client_id)->get();
		$get_countries = DB::table('countries')->get();
		$get_state = DB::table('state')->get();
		$get_district = DB::table('district')->get();
		$lead = DB::table('leads')
					//->leftJoin('campaign_lead', 'leads.id', 'campaign_lead.lead_id')
					//->leftJoin('agent_leads', 'leads.id', 'agent_leads.lead_id')
					->leftJoin('users', 'leads.agent_id', 'users.id')
					->select('leads.*','users.name as assign_to')
					->orderBy('leads.updated_at','desc')
					->where('leads.id', $id)
					->first();
		$family_members = DB::table('leadsdatas')
							->where('member_id', $id)
							->get();
		// $campaigns = DB::table('campaigns')
		// 			->where('client_id', $client_id)
		// 			->orderBy('created_at', 'desc')
		// 			->select('campaigns.id', 'campaigns.name')
		// 			->get();
		$agents = DB::table('users')
				->where('reseller_id', Laralum::loggedInUser()->id)
				->get();
		$preferred_languages = DB::table('preferred_languages')
						->where('client_id', $client_id)
						->get();
		$lead_responses = DB::table('lead_responses')
						->where('client_id', $client_id)
						->get();
		$lead_statuses = DB::table('lead_statuses')
						->where('client_id', $client_id)
						->get();													
		return view('hyper.lead.edit', compact('agents','id', 'lead', 'get_state', 'get_district', 'family_members', 'departments', 'branches', 'sources', 'accounttypes', 'membertypes', 'get_countries', 'preferred_languages', 'lead_responses','lead_statuses'));
	}

	public function deleteSelected(Request $request)
	{
		Laralum::permissionToAccess('laralum.lead.delete');
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
        if($request->select_all_option_check==1){
        	foreach ($leads as $id) {
				DB::table('leads')->where('id', $id)->delete();
			}
        }else{
        	foreach ($request->ids as $id) {
				DB::table('leads')->where('id', $id)->delete();
			}
        	
        }		
		
		return response()->json(array(
			'status' => 'success', 'leads_data'=>$leads
		));
	}

	public function switchAddress(Request $request)
	{
		$types =	unserialize($request->values);
		foreach ($types as $key => $type) {
			if ($key == $request->index) {
				$types[$key] = 'permanent';
			} else {
				$types[$key] = 'temp';
			}
		}
		DB::table('leads')
			->where('id', $request->id)
			->update([
				'address_type' => serialize($types)
			]);

		$returnData = array(
			'status' => 'success',
		);



		return response()->json($returnData);
	}

	public function Update(Request $request)
	{
		Laralum::permissionToAccess('laralum.lead.access');
		//Laralum::permissionToAccess('laralum.member.edit');
		// Laralum::permissionToAccess('laralum.senderid.access');
		// $request->validate([
		// 'name' => 'required',
		// 'mobile' => 'required|min:10|numeric|unique:leads,mobile,' . $id
		// ]);

		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

		// $request->validate([
		// 'name' => 'required',
		// 'mobile' => ['required', 'numeric','min:10',Rule::unique('leads')->where(function ($query) use ($client_id) {
		// return $query->where('user_id', '==', $client_id);
		// })]
		// ]);
		$validator = Validator::make($request->all(), [
		'name' => 'required',
		'mobile' => ['required', 'numeric','min:10',Rule::unique('leads')->where(function ($query) use ($client_id) {
		return $query->where('user_id', '==', $client_id);
		})]
        ]);

        if ($validator->fails()) {
            $msg="Name field is required and mobile no should be unique in same business";
			return response()->json(['status' => false ,'message' => $msg]);
        }

		// if ($files = $request->file('profile_photo')) {
		// request()->validate([
		// 'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		// ]);

		// $destinationPath = public_path('crm/leads');
		// $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
		// $files->move($destinationPath, $profileImage);
		// $old_image = public_path('crm/leads/') . $request->hidden_profile_photo;
		// if (file_exists($old_image)) {
		// @unlink($old_image);
		// }
		// } else {

		// $profileImage = $request->hidden_profile_photo;
		// }
		// if ($files = $request->file('id_proof')) {
		// request()->validate([
		// 'id_proof' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		// ]);

		// $destinationPath = public_path('crm/leads');
		// $idProof = date('YmdHis') . "." . $files->getClientOriginalExtension();
		// $files->move($destinationPath, $idProof);
		// $old_image = public_path('crm/leads/') . $request->hidden_id_proof;
		// if (file_exists($old_image)) {
		// @unlink($old_image);
		// }
		// } else {
		// $idProof = $request->hidden_id_proof;
		// }


		$update = DB::table('leads')
			->where('id', $request->edit_id)
			->update([
			'account_type' => $request->account_type,
			'lead_source' => $request->lead_source,
			'department' => $request->department,
			'member_type' => json_encode($request->member_type),
			'name' => $request->name,
			'gender' => $request->gender,
			'date_of_birth' => ($request->dob != '') ? date('Y-m-d', strtotime($request->dob)) : NULL,
			'email' => $request->email,
			'mobile' => $request->mobile,
			'address_type' => serialize($request->address_type),
			'date_of_joining' => ($request->doj != '') ? date('Y-m-d', strtotime($request->doj)) : NULL,
			'profile_photo' =>$request->profile_photo_path,
			'id_proof' => $request->id_proof_path,
			'sms_language' => $request->sms_language,
			'call_required' => $request->has('call'),
			'sms_required' => $request->has('sms'),
			'branch' => $request->branch,
			'profession' => $request->profession,
			'qualification' => $request->qualification,
			'alt_numbers' => empty($request->alt_number) ? '' : implode(',', $request->alt_number), //json_encode($request->alt_number),
			'address' => serialize($request->address),
			'state' => serialize($request->state),
			'country' => serialize($request->country),
			'district' => serialize($request->district),
			'pincode' => serialize($request->pincode),
			'blood_group' => $request->bldgrp,
			'married_status' => $request->marriedstatus,
			'rfid' => $request->rfid,
			'lead_status' => $request->lead_status,
			'agent_id' => $request->agent,
			'preferred_language' => $request->preferred_language,
			'lead_response' => $request->lead_response,
			//'last_contacted_date' => ($request->last_contacted_date != '') ? date('Y-m-d', strtotime($request->last_contacted_date)) : NULL,
			'date_of_anniversary' => ($request->date_of_anniversary != '') ? date('Y-m-d', strtotime($request->date_of_anniversary)) : NULL
		]);

		// if($request->campaign_id !="") {
		// 	DB::table('campaign_lead')
		// 		->where('lead_id', $request->edit_id)
		// 		->update([
		// 		'agent_id' => $client_id,
		// 		'campaign_id' => $request->campaign_id,
		// 		'lead_id' => $request->edit_id,
		// 		'created_at' => date('YmdHis'),
		// 		'updated_at' => date('YmdHis')
		// 	]);
		// }
		if($request->agent !="" || $request->agent != null) {
			$agentCount=DB::table('agent_leads')
			->where('lead_id', $request->edit_id)
			->count();
			if($agentCount > 0){
				DB::table('agent_leads')
				->where('lead_id', $request->edit_id)
				->update([
				'agent_id' => $request->agent,
				'lead_id' => $request->edit_id,
				'created_at' => date('YmdHis'),
				'updated_at' => date('YmdHis')
				]);
			}else{
				DB::table('agent_leads')->insert([
					'agent_id' => $request->agent,
					'lead_id' => $request->edit_id,
					'created_at' => date('YmdHis'),
					'updated_at' => date('YmdHis')
				]);
			}
			
		}	
		
		if ($request->family_member_name) {
		DB::table('leadsdatas')->where('member_id', $request->edit_id)->delete();
		$name_relation = array();
		foreach ($request->family_member_name as $k => $v) {
		$name_relation[$k][] = $v;
		if ($request->family_member_relation) {

		foreach ($request->family_member_relation as $key => $val) {

		if ($k == $key) {

		$name_relation[$k][] = $val;
		}
		}
		}
		if ($request->family_member_dob) {

		foreach ($request->family_member_dob as $keys => $value) {

		if ($k == $keys) {

		$name_relation[$k][] = $value;
		}
		}
		}

		if ($request->family_member_mobile) {

		foreach ($request->family_member_mobile as $mKeys => $mValue) {

		if ($k == $mKeys) {

		$name_relation[$k][] = $mValue;
		}
		}
		}
		}
		foreach ($name_relation as $value) {
		Leadsdata::create([
		'member_id' => $request->edit_id,
		'member_relation' => $value[1],
		'member_relation_name' => $value[0],
		'member_relation_mobile' => $value[3],
		'member_relation_dob' => ($value[2] != '') ? date('Y-m-d', strtotime($value[2])) : NULL,
		]);
		}
		}
		//return redirect()->route('Crm::lead_details', ['id' => $id])->with('success', "The lead has been edited");
		$msg="Your request has been completed successfully.";
		return response()->json(['status' => true ,'message' => $msg]);
	}

	public function inlineUpdate(Request $request)
	{
		Laralum::permissionToAccess('laralum.lead.access');
		//Laralum::permissionToAccess('laralum.member.edit');
		$profileImage = '';
		if ($files = $request->file('data')) {
			request()->validate([
				'data' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			]);

			$destinationPath = public_path('crm/leads');
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($destinationPath, $profileImage);

			$request->data = $profileImage;
		}

		if ($request->editType == 'mobile') {
			$lead = DB::table('leads')->where('mobile', $request->data);
			if ($lead)
				return response()->json(array(
					'status' => 'failure',
				));
		}
		$update = DB::table('leads')
			->where('id', $request->id)
			->update([
				$request->editType => $request->data
			]);


		$returnData = array(
			'status' => 'success',
			'profile_image' => $profileImage
		);



		return response()->json($returnData);
	}

	public function show($id)
	{
		Laralum::permissionToAccess('laralum.lead.view');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$today = new DateTime('now');
		//echo '<pre>';print_r($_GET);die;
		//Laralum::permissionToAccess('laralum.member.view');
		$states = [];
		$districts = [];
		$countries = [];
		# Find the lead
		$lead = Laralum::lead('id', $id);
		$verification =	DB::table('mobile_verification')->where('mobile_number', $lead->mobile)->first();
		$lead->mobile_verified = $verification != null ? $verification->verify_status : false;
		$family_member = DB::table('leadsdatas')->where('member_id', $id)->where('member_relation_name', '!=', '')->orderBy('id','desc')->get();
		// $logs = $this->getCallLogs($lead->mobile);
		// $calllogs = $logs['data']['hits'];
		$prayer_requests = DB::table('prayer_requests')->where('user_id', $client_id)->get();

		$msg_list = DB::table('messages')->where('receiver', $id)->paginate(10, ['*'], 'messages')->fragment('Messages');
		$appointments = DB::table('appointments')->where('lead_id', $id)->paginate(10,['*'], 'appointments')->fragment('Appointments');
		$donations  = DB::table('donations')->where('donations.donated_by', $id)
		->orderBy('donations.id', 'desc')->paginate(10, ['*'], 'donations')->fragment('Donations');
		if($this->is_serialized($lead->state)){
			if (unserialize($lead->state) != null){
				foreach (unserialize($lead->state) as $state) {
					array_push($states, DB::table('state')->where('StCode', $state)->first());
				}
			}			
		}else{
			$states = $lead->state;
		}

		if($this->is_serialized($lead->district)){
			if (unserialize($lead->district) != null)
			{
				foreach (unserialize($lead->district) as $district) {
					array_push($districts, DB::table('district')->where('DistCode', $district)->first());
				}	
			}					
		}else{
			$districts = $lead->district;
		}

		if($this->is_serialized($lead->state)){
			if (unserialize($lead->country) != null)
			{
				foreach (unserialize($lead->country) as $country) {
					array_push($countries, DB::table('countries')->where('country_code', $country)->first());
				}
			}					
		}else{
			$countries = $lead->country;
		}			
		foreach ($msg_list as $list) {
			$user = User::find($list->sender);
			$member = Lead::find($list->receiver);
			$mobile_number=Str::startsWith($member->mobile,'91')?$member->mobile:'91'.$member->mobile;
			$roles = $user->roles->pluck('name');
			$list->sender = $user->name;
			$list->sender_mobile = $user->mobile;
			$list->sender_role = $roles[0];
			$list->status=DB::table('smsreport')->where('number',$mobile_number)->where('requestId',$list->status_code)
			->pluck('desc')->first();
			
		}
		
		$membertypes = DB::table('member_types')->where('user_id', $client_id)->get();
		$branches = DB::table('branch')->where('client_id', $client_id)->get();
		$donation_purposes = DB::table('donation_purpose')->where('user_id', $client_id)->get();
		$razorKey = Laralum::loggedInUser()->RAZOR_KEY;
			
		if($razorKey == '' || $razorKey == null){
			$razorKey = User::where('id', Laralum::loggedInUser()->reseller_id)->value('RAZOR_KEY');
		}
       $manual_call_logs = DB::table('manual_logged_call')->where('member_id', $id)->paginate(10,['*'], 'manual_logged_call')->fragment('manual_logged_call');
		# Return the view
		
		return view('hyper.lead.details', [
			'today' => $today,
			'memberId'=>$id,
			'lead' => $lead,
			'family_member' => $family_member,
			'state' => $states,
			'district' => $districts,
			// 'calllogs' => $calllogs,
			'msg_list' => $msg_list,
			'appointments' => $appointments,
			'manual_call_logs' => $manual_call_logs,
			'donations' => $donations,
			'prayer_requests'=> $prayer_requests,
			'countries' => $countries,
			'membertypes' => $membertypes,
			'branches' => $branches,
			'donation_purposes' => $donation_purposes,
			'razorKey' => $razorKey
		]);
	}

	public function destroy(Request $request, $id)
	{
		Laralum::permissionToAccess('laralum.lead.delete');
		//Laralum::permissionToAccess('laralum.member.delete');
		# Find The Lead
		$lead = Laralum::lead('id', $id);
		if ($lead) {
			DB::table('leadsdatas')->where('member_id', $id)->delete();
		}
		# Delete Lead
		$lead->delete();

		# Return a redirect
		return redirect()->route('Crm::leads')->with('success', "The Data has been deleted");
	}
	
	
	public function saveNote(Request $request)
	{
		//Laralum::permissionToAccess('laralum.lead.access');
		# Check permissions
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

		$issue = new Member_Issue;
		$issue->client_id = $client_id;
		$issue->member_id = $request->member_issue_id;
		$issue->issue = $request->issues;
		$issue->status = 2;
		$issue->created_by = Laralum::loggedInUser()->id;
		$issue->save();
		if ($issue->id) {
			$affected = DB::table('leads')
				->where('id', $request->member_id)
				->update(['issue_status' => 2, 'issue_id' => $issue->id]);
		}

		# Return the admin to the blogs page with a success message
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}

	public function updateNote(Request $request)
	{
		//Laralum::permissionToAccess('laralum.lead.access');
		# Check permissions
		$affected = DB::table('member_issues')
			->where('id', $request->issues_id)
			->update(['issue' => $request->update_issues, 'status' => $request->update_status]);

		if ($request->issues_id) {
			DB::table('leads')
				->where('issue_id', $request->issues_id)
				->update(['issue_status' => $request->update_status]);
		}

		# Return the admin to the blogs page with a success message
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}

	public function getnote(Request $request, $id, $status)
	{
		//Laralum::permissionToAccess('laralum.lead.access');
		$data = DB::table("member_issues")
			->where("member_id", $id)
			->where("status", $status)
			->get();
		foreach ($data as $d) {
			$mem_name = DB::table('users')->where('id', $d->created_by)->first();
			$d->taken_by = $mem_name->name;
		}
		return view('crm/leads/getnote', compact('data'));
	}

	public function getDistrict(Request $request)
	{
		//Laralum::permissionToAccess('laralum.lead.access');
		$states = DB::table("district")
			->where("StCode", $request->state_id)
			->pluck("DistrictName", "DistCode");
		return response()->json($states);
	}

	public function callingFunction(Request $request)
	{
		//Laralum::permissionToAccess('laralum.lead.access');
		//Laralum::permissionToAccess('laralum.member.makecall');
		$token = "e56ef939c3d5b2d51d5de13d3170a477";
		$contact_number = $request->mobile;
		$country_code = 91;
		$support_user_id = $request->uuid;
		//Prepare you post parameters
		$postData = array('token' => $token, 'customer_number' => $contact_number, 'customer_cc' => $country_code, 'support_user_id' => $support_user_id);
		//API URL
		$url = "https://developers.myoperator.co/clickOcall";
		// init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $postData
			//,CURLOPT_FOLLOWLOCATION => true
		));
		//Ignore SSL certificate verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		//get response
		$output = curl_exec($ch);
		$response = json_decode($output, true);


		//Print error if any
		if (curl_errno($ch)) {
			echo 'error:' . curl_error($ch);
		}
		curl_close($ch);

		return Response::json($response);
	}

	protected function getCallLogs($num)
	{
		$token = "e56ef939c3d5b2d51d5de13d3170a477";
		//Prepare you post parameters
		$postData = array('token' => $token, 'search_key' => $num);
		//API URL
		$url = "https://developers.myoperator.co/search";
		// init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $postData
			//,CURLOPT_FOLLOWLOCATION => true
		));
		//Ignore SSL certificate verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		//get response
		$output = curl_exec($ch);
		$response = json_decode($output, true);


		//Print error if any
		if (curl_errno($ch)) {
			echo 'error:' . curl_error($ch);
		}
		curl_close($ch);

		return $response;
	}
	
	public function sendMessage(Request $request)
	{
		Laralum::permissionToAccess('laralum.lead.access');
		//Laralum::permissionToAccess('laralum.member.sendsms');
		//send message
		$authKey = "130199AKQsRsJy581b6dd5";
		$mobileNumber = $request->receiver_mobile;
		$senderId = "CSTACK";
		$message = urlencode($request->msg);
		$route = 4;
		//Prepare you post parameters
		$postData = array('authkey' => $authKey,'country' => 91, 'mobiles' => $mobileNumber, 'message' => $message, 'sender' => $senderId, 'route' => $route);
		//API URL
		$url = "https://api.msg91.com/api/sendhttp.php";
		// init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $postData

		));
		//Ignore SSL certificate verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		//get response
		$output = curl_exec($ch);
		$err = curl_error($ch);
		curl_close($ch);

		if ($err) {
			$returnData = array(
				'status' => 'error',
				'message' => $err
			);
		} else {
			
			if(isset( $request->sender) && isset( $request->receiver)){
				DB::table('messages')->insert([
					'sender' => $request->sender,
					'receiver' => $request->receiver,
					'message' => $request->msg,
					'status' => 1,
					'status_code' => $output,
					'created_at' => date('Y-m-d H:i:s')
				]);
			}

			$returnData = array(
				'status' => 'success',
				'message' => 'Message sent successfully!'
			);
		}


		return response()->json($returnData);
	}

	public function sendBulkMessage(Request $request)
	{
		Laralum::permissionToAccess('laralum.lead.access');
		//Laralum::permissionToAccess('laralum.member.sendsms');
		$mobile_numbers=[];
		
		foreach (explode(",", $request->receiver_ids) as $id) {
			array_push($mobile_numbers, DB::table('leads')
                                ->where('id', '=', $id)
                                ->pluck('mobile')->first());
		}
		//send message
		$authKey = "130199AKQsRsJy581b6dd5";
		$mobileNumber = implode(',', $mobile_numbers);
		$senderId = "CSTACK";
		$message = urlencode($request->msg);
		$route = 4;
		//Prepare you post parameters
		$postData = array('authkey' => $authKey, 'country' => 91, 'mobiles' => $mobileNumber, 'message' => $message, 'sender' => $senderId, 'route' => $route);
		//API URL
		$url = "https://api.msg91.com/api/sendhttp.php";
		// init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $postData

		));
		//Ignore SSL certificate verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		//get response
		$output = curl_exec($ch);
		$err = curl_error($ch);
		curl_close($ch);

		if ($err) {
			return redirect()->route('Crm::leads')->with('error', "Message not sent");
		} else {
			foreach (explode(",", $request->receiver_ids) as $id) {
				DB::table('messages')->insert([
					'sender' => Laralum::loggedInUser()->id,
					'receiver' => $id,
					'message' => $request->msg,
					'status' => 1,
					'status_code' => $output,
					'created_at' => date('Y-m-d H:i:s')
				]);
			}
			

		}


		return redirect()->route('Crm::leads')->with('success', "Message has been sent");
	}

	public function verifyOtp(Request $request)
	{


		$otp = $request->otp;

		$isUpdated =	DB::table('mobile_verification')->where('mobile_number', $request->receiver_mobile)->where('otp', $otp)->update(['verify_status' => true, 'updated_at' => date('Y-m-d H:i:s')]);


		$returnData = array(
			'status' => $isUpdated ? 'success' : 'failure',
			'message' => 'Message sent successfully!'
		);

		return response()->json($returnData);
	}

	public function sendOtp(Request $request)
	{
		DB::table('mobile_verification')->where('mobile_number', $request->receiver_mobile)->delete();
		// dd($request->all());
		// die;
		//send message
		$authKey = "130199AKQsRsJy581b6dd5";
		$mobileNumber = $request->receiver_mobile;
		$otp = mt_rand(1, 999999);
		$senderId = "CSTACK";
		$message = urlencode("This is your otp to verify: " . $otp . "\n Please don't share with anyone");
		$route = 4;
		//Prepare you post parameters
		$postData = array('authkey' => $authKey, 'mobiles' => $mobileNumber, 'message' => $message, 'sender' => $senderId, 'route' => $route);
		//API URL
		$url = "http://sms.mesms.in/api/sendhttp.php";
		// init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $postData

		));
		//Ignore SSL certificate verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		//get response
		$output = curl_exec($ch);
		
		$err = curl_error($ch);
		curl_close($ch);

		if ($err) {
			$returnData = array(
				'status' => 'error',
				'message' => $err
			);
		} else {
			DB::table('mobile_verification')->insert([
				'sender' => $request->sender,
				'mobile_number' => $mobileNumber,
				'otp' => $otp,
				'verify_status' => false,
				'created_at' => date('Y-m-d H:i:s')
			]);


			$returnData = array(
				'status' => 'success',
				'message' => 'Message sent successfully!'
			);
		}


		return response()->json($returnData);
	}

	public function deleteMessage(Request $request)
	{

		if ($request->id) {
			DB::table('messages')->where('id', $request->id)->delete();
			$returnData = array(
				'status' => 'success',
				'message' => 'Message deleted successfully!'
			);
		} else {
			$returnData = array(
				'status' => 'error',
				'message' => 'Something went wrong, please try again.'
			);
		}

		return response()->json($returnData);
	}

	public function export(Request $request)
	{
		return Excel::download(new LeadsExport($request->client_id, null), 'members.xlsx');
	}
	public function donationExport(Request $request)
	{
		return Excel::download(new DonationExport($request->member_id, null), 'donations.xlsx');
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
	        			//return Excel::download(new LeadsExport($client_id, $leads), 'leads.xlsx');
	        			$export = new LeadsExport($client_id, $leads);
						$export->store('leads.xlsx');
						return back()->withSuccess('Export started!');
	        		}else{
	        			return redirect()->back();
	        		}
        	
        }else{
        	//return Excel::download(new LeadsExport($client_id, $request->ids), 'leads.xlsx');
        	$export = new LeadsExport($client_id, $request->ids);
						$export->store('leads.xlsx');
						return back()->withSuccess('Export started!');
        }
		
	}

	public function checkdonationstatus($id){
		$donations  = DB::table('donations')->select('id','payment_status')->where('donations.donated_by', $id)->orderBy('donations.id', 'desc')->get();
		return response()->json($donations);
	}
	
	public function getName($id){
		$usersdata  = DB::table('users')->select('name')->where('id', $id)->first();
		return $usersdata->name;
	}

	public static function is_serialized( $data, $strict = true ) 
	{
	    // If it isn't a string, it isn't serialized.
	    if ( ! is_string( $data ) ) {
	        return false;
	    }
	    $data = trim( $data );
	    if ( 'N;' === $data ) {
	        return true;
	    }
	    if ( strlen( $data ) < 4 ) {
	        return false;
	    }
	    if ( ':' !== $data[1] ) {
	        return false;
	    }
	    if ( $strict ) {
	        $lastc = substr( $data, -1 );
	        if ( ';' !== $lastc && '}' !== $lastc ) {
	            return false;
	        }
	    } else {
	        $semicolon = strpos( $data, ';' );
	        $brace     = strpos( $data, '}' );
	        // Either ; or } must exist.
	        if ( false === $semicolon && false === $brace ) {
	            return false;
	        }
	        // But neither must be in the first X characters.
	        if ( false !== $semicolon && $semicolon < 3 ) {
	            return false;
	        }
	        if ( false !== $brace && $brace < 4 ) {
	            return false;
	        }
	    }
	    $token = $data[0];
	    switch ( $token ) {
	        case 's':
	            if ( $strict ) {
	                if ( '"' !== substr( $data, -2, 1 ) ) {
	                    return false;
	                }
	            } elseif ( false === strpos( $data, '"' ) ) {
	                return false;
	            }
	            // Or else fall through.
	        case 'a':
	        case 'O':
	            return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
	        case 'b':
	        case 'i':
	        case 'd':
	            $end = $strict ? '$' : '';
	            return (bool) preg_match( "/^{$token}:[0-9.E+-]+;$end/", $data );
	    }
	    return false;
	}
	
	public function fetchLeads(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$lead = DB::table('leads')
					->where('client_id', $client_id)
					->where('mobile', $request->mobile)
					->first();
		return view('hyper.lead.search', ['lead' => $lead]);
	}


	
	public function campaignLeadsNumber(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

		$userId = Laralum::loggedInUser()->id;
		$arr = $this->lead->getLeadForAutoDial($request, $client_id);
		$leads = [];
		if(count($arr) > 0){
			foreach($arr as $lead){
				$leads [] = $lead->mobile;
			}
			$calling_number = $leads[0];
			//$request->session()->put('auto_dial_leads', $leads);
			$result = DB::table('agent_auto_dial')
					->where('agent_id', $userId)
					->first();

			if($result){
				DB::table('agent_auto_dial')
					->where('agent_id', $userId)
					->update(['dial_status' => 1]);

				$this->addDataToRedis();
			}else{
				$user = DB::table('agent_auto_dial')->insert([
					'agent_id' => Laralum::loggedInUser()->id,
					'dial_status' => 1,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				]);

				$this->addDataToRedis();
			}
		}else{
			DB::table('agent_auto_dial')
					->where('agent_id',Laralum::loggedInUser()->id)
					->update(['dial_status' => 0]);

			$this->addDataToRedis();

			return response()->json([
							'status' => false,
							'mobile' => null,
						]);
		}
		return response()->json([
				'status' => true,
				'mobile' => $calling_number,
			]);
	}

	public function startIncommingCall()
	{
		//$userId = Laralum::loggedInUser()->id;
		$userId = "139";
		$result = DB::table('agent_auto_dial')
					->where('agent_id', $userId)
					->first();

		if($result){
			DB::table('agent_auto_dial')
				->where('agent_id', $userId)
				->update(['dial_status' => 3]);

			$this->addDataToRedis();
		}else{
			$user = DB::table('agent_auto_dial')->insert([
				'agent_id' => $userId,
				'dial_status' => 3,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s')
			]);
			$this->addDataToRedis();
		}
	}

	private function addDataToRedis()
	{
		$userId = Laralum::loggedInUser()->id;
		$user = DB::table('agent_auto_dial')
				->where('agent_id', $userId)
				->first();
		Redis::set('auto_dial_check_user.'.$userId, json_encode($user));
	}

	private function addDataToRedisIncoming($agent_id)
	{
		$user = DB::table('agent_auto_dial')
				->where('agent_id', $agent_id)
				->first();
		Redis::set('auto_dial_check_user.'.$agent_id, json_encode($user));
	}
	
	private function addManualCallLogToRedis($manualCallLog)
	{
		$userId = Laralum::loggedInUser()->id;

		Redis::set('manual_logged_call.'.$userId, json_encode($manualCallLog));
	}

	private function addManualCallLogToRedisOne($manualCallLog)
	{
		$userId = $manualCallLog->created_by;
		Redis::set('manual_logged_call.'.$userId, json_encode($manualCallLog));
	}
	

	public function stopAutoDial(Request $request)
	{
		$result = DB::table('agent_auto_dial')
					->where('agent_id',Laralum::loggedInUser()->id)
					->update(['dial_status' => 0]);
		$this->addDataToRedis();
		return $result;
	}
	

	public function load_api(Request $request)
	{
		$agent_mobile = Laralum::loggedInUser()->mobile;
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		
		$lead = DB::table('leads')
					->where('client_id', $client_id)
					->where('mobile', $request->mobile)
					->first();
		if($lead){
			$lead_id = $lead->id;
		}else{
			$lead_id = 0;
		}
		if(isset($request->mobile) && $request->mobile){

			if(isset($request->call_type) && $request->call_type == '1'){
				$data = DB::table('manual_logged_call')
					//->join('leads', 'manual_logged_call.lead_number', 'leads.mobile')
					->select('manual_logged_call.id')
					//->where('leads.client_id', $client_id)
					->where('manual_logged_call.lead_number', $request->mobile)
					->where('manual_logged_call.agent_number', Laralum::loggedInUser()->mobile)
					->where('manual_logged_call.call_type', 1)
					->whereDate('created_at', Carbon::now())
					->orderBy('id', 'desc')
					->first();
			}else{

				$result = DB::table('agent_auto_dial')
						->where('agent_id', Laralum::loggedInUser()->id)
						->first();

				if($result){
					DB::table('agent_auto_dial')
						->where('agent_id',Laralum::loggedInUser()->id)
						->update(['dial_status' => 2]);
				}else{
					DB::table('agent_auto_dial')->insert([
						'agent_id' => Laralum::loggedInUser()->id,
						'dial_status' => 2,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')
					]);
				}
				$this->addDataToRedis();
				$data = DB::table('manual_logged_call')
					//->join('leads', 'manual_logged_call.lead_number', 'leads.mobile')
					->select('manual_logged_call.id')
					//->where('leads.client_id', $client_id)
					->where('manual_logged_call.lead_number', $request->mobile)
					->where('manual_logged_call.agent_number', Laralum::loggedInUser()->mobile)
					->whereDate('created_at', Carbon::now())
					->orderBy('id', 'desc')
					->first();
			}
			
			if($data && $request->call_type == '1'){
				return response()->json(['status' => false, 'duplicate' => true, 'msg_text' => "Invalid Call"]);
			}else{
				$manual_logged_call_data = [
					'client_id' => $client_id,
					'member_id' => $lead_id,
					'lead_number' => $request->mobile,
					'agent_number' => $agent_mobile,
					'campaign_id' => (isset($request->campaign) && $request->campaign) ? $request->campaign: '',
					'created_by' => Laralum::loggedInUser()->id,
					'call_status' => 0,
					'call_source' => 0,
					'status' => 0,
					'call_type' => isset($request->call_type)? $request->call_type : 0,
					'date' => date('Y-m-d'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				];
				$manual_logged_call = ManualLoggedCall::create($manual_logged_call_data);
				// $manual_logged_call = DB::table('manual_logged_call')
				// 	->insert([
				// 	'client_id' => $client_id,
				// 	'member_id' => $lead_id,
				// 	'lead_number' => $request->mobile,
				// 	'agent_number' => $agent_mobile,
				// 	'campaign_id' => (isset($request->campaign) && $request->campaign) ? $request->campaign: '',
				// 	'created_by' => Laralum::loggedInUser()->id,
				// 	'call_status' => 0,
				// 	'call_source' => 0,
				// 	'call_type' => isset($request->call_type)? $request->call_type : 0,
				// 	'date' => date('Y-m-d'),
				// 	'created_at' => date('Y-m-d H:i:s'),
				// 	'updated_at' => date('Y-m-d H:i:s')
				// ]);
				$manual_call = ManualLoggedCall::find($manual_logged_call->id);
				$this->addManualCallLogToRedis($manual_call);

				$ivr_details = DB::table('ivr_settings')
					->where('user_id', $client_id)
					->first();

				if(!$ivr_details){
					return response()->json(['status' => false, 'duplicate' => false, 'msg_text' => "Token not found!"]);
				}

				$curl = curl_init();

				//$USER_ID = "17231630"; // For Voc
				//$TOKEN = "g575vT9yamViSspY5QYY"; // For Voc
				$USER_ID = $ivr_details->ivr_user_id;
				$TOKEN = $ivr_details->ivr_token;				
				$FROM = $agent_mobile;
				$TO = $request->mobile;

				curl_setopt_array($curl, array(
				CURLOPT_URL => "https://s-ct3.sarv.com/clickToCall/v1/para?user_id=$USER_ID&token=$TOKEN&from=$FROM&to=$TO",
				//CURLOPT_URL => "",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => "",
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache"
				),
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);

				if ($err) {
					return response()->json($err);
				} else {
					return response()->json($response);
				}
			}
		}else{
			return response()->json(['status' => false, 'duplicate' => false, 'msg_text' => "Invalid Number"]);
		}
	}
	
	public function newApiCall(Request $request)
	{
		$Mobile = $request->Mobile;
		$status = $request->status;
		return response()->json([
								'Mobile' => $Mobile,
								'status' => $status
							]);
	}

	public function uploadFile(Request $request)
	{
		$request->validate([
		'file' => 'required|mimes:jpeg,jpg,png,pdf,doc,docs,docx|max:2048',
		]);
		$return = "";
		$dir_path=$request->dir_path;
		$time = date('his');
		$file_disc=$request->file_disc;
		$fileName = str_replace(' ', '_', $request->file->extension());
		$file = $file_disc."_".$time.".".$fileName;
		$file = str_replace(' ', '_', $file);
		
		$request->file->move(public_path('crm/'.$dir_path), $file);
		$return=url('/crm/'.$dir_path."/".$file);
		echo $return;
	}

	public function deleteSourcefile(Request $request)
	{
		$source_path = $request->source_path;
		$basepath=url('/');
		$source_paths =explode($basepath."/", $source_path);
		$image_path=$source_paths[1];
		if(File::exists($image_path)) {
		File::delete($image_path);
		$return_data = array('status' => true ,'message' => 'File Successfully Deleted.');
		echo json_encode($return_data);
		}else{
		$return_data = array('status' => false ,'message' => 'File Not Deleted.');
		echo json_encode($return_data);
		}
	}

	public function importShow(Request $request)
	{

		Laralum::permissionToAccess('laralum.lead.access');        
		return view('hyper.lead.import');
	}

	public function import(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		// Allowed mime types
		$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

		// Validate whether selected file is a CSV file
		if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {
			$file = $request->file('file')->store('leadsImport');
			//Excel::import(new LeadsImport, $file);
			$import = new LeadsImport($client_id, Laralum::loggedInUser()->id);
			$import->import($file);

			// ->chain([
			//     new NotifyLeadOfCompletedImport(),
			// ]);



			//dd($import->errors());
			//return back()->withStatus('File imported successfully');
			$msg = "File is in queue, Please wait...";
			return response()->json(['status' => true ,'message' => $msg]);

		}


	}

	// public function import(Request $request)
	// {
	// 	Laralum::permissionToAccess('laralum.lead.access');
	// 	// Allowed mime types
	// 	$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

	// 	// Validate whether selected file is a CSV file
	// 	if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {

	// 		$file = file($request->file->getRealPath());

	// 		$data = array_slice($file, 1);

	// 		$parts = (array_chunk($data, 1));

	// 		foreach ($parts as $index => $part) {
	// 			$fileName = resource_path('pending-files/'.date('y-m-d-H-i-s').$index. '.csv');

	// 			file_put_contents($fileName, $part);
	// 		}

	// 		//$this->lead->importToDb();

	// 		$path = resource_path('pending-files/*.csv');

	//         $files = glob($path);

	//         foreach ($files as $file) {

	//             ProcessCsvUpload::dispach($file);
	//         }

	// 	}

	// }
		
	/*public function import(Request $request)
	{
		Laralum::permissionToAccess('laralum.lead.access');
		// Allowed mime types
		$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

		// Validate whether selected file is a CSV file
		if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {

		// If the file is uploaded
		if (is_uploaded_file($_FILES['file']['tmp_name'])) {

		// Open uploaded CSV file with read-only mode
		$csvFile = fopen($_FILES['file']['tmp_name'], 'r');

		// Skip the first line
		fgetcsv($csvFile);//dd($csvFile);

		if (Laralum::loggedInUser()->reseller_id == 0) {
		$client_id = Laralum::loggedInUser()->id;
		} else {
		$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$rowcount = 0;
		$countrow=1;
		$row_exist=array();
		// Parse data from CSV file line by line
		while (($line = fgetcsv($csvFile)) !== FALSE) {
		if ($this->lead->mobileExistCheck($line[18],$client_id) > 0) {
		$row_exist[] .=$countrow;
		}else
		{
			if($line[6]==""){
				$status_lead=2;
			}elseif($line[6]!=""){
				$status_lead=1;
			}else{
				$status_lead=$line[4];
			}
			$member_type=explode(',', $line[2]);

			$alt_numbers=explode('-', $line[19]);

			$address_type=['permanent','temp'];
			$address=[$line[27],$line[32]];
			$country=[$line[28],$line[33]];
			$state=[$line[29],$line[34]];
			$district=[$line[30],$line[35]];
			$pincode=[$line[31],$line[36]];

			$member_relation_name=[$line[37],$line[41],$line[45]];
			$member_relation=[$line[38],$line[42],$line[46]];
			$member_relation_dob=[$line[39],$line[43],$line[47]];
			$member_relation_mobile=[$line[40],$line[44],$line[48]];


//temp address type
//account_type 1 department 2 member_type 3 lead_source 4 lead_status 5 preferred_language 6 agent 7 profile_photo_path 8 member_id 9 name 10 dob 11 doj 12 date_of_anniversary 13  rfid 14 gender 15 bldgrp 16 marriedstatus 17 email 18 mobile 19 alt_number ///// 20 address_type 21 address 22 country 23 state 24 district 25 pincode 26 id_proof_path 27 qualification 28 branch 29 profession 30 sms 31 call 32 sms_language 33 family_member_name 34 family_member_relation 35 family_member_dob 36 family_member_mobile 37

//Account Type,Department,Member Type,Lead Source,Lead Status,Preferred Language,Lead Owner,Profile Photo,Member ID,Name,Date of Birth,Date of Joining,Date Of Anniversary,RFID,Gender,Blood Group,Married Status,Email,Mobile,Alt Number,Id Proof,Qualification,Branch,Profession,Sms Requred,Call Requred,Sms Language,Address 1,Country 1,State 1,District 1,Pincode 1,Address 2,Country 2,State 2,District 2,Pincode 2,Family Member Name 1,Family Member Relation 1,Family Member DOB 1,Family Member Mobile 1,Family Member Name 2,Family Member Relation 2,Family Member DOB 2,Family Member Mobile 2,Family Member Name 3,Family Member Relation 3,Family Member DOB 3,Family Member Mobile 3			
		$lead = new Lead;
		$lead->user_id = Laralum::loggedInUser()->id;
		$lead->client_id = $client_id;
		$lead->account_type = $line[0];
		$lead->department = $line[1];

		$lead->member_type = json_encode($member_type);

		$lead->lead_source = $line[3];
		$lead->lead_status = $status_lead;
		$lead->preferred_language = $line[5];
		$lead->agent_id =$line[6];
		$lead->profile_photo = $line[7];
		$lead->member_id = $line[8];
		$lead->name = $line[9];
		$lead->date_of_birth = ($line[10] != '') ? date('Y-m-d', strtotime($line[10])) : '';
		$lead->date_of_joining = ($line[11] != '') ? date('Y-m-d', strtotime($line[11])) : '';
		$lead->date_of_anniversary = ($line[12] != '') ? date('Y-m-d', strtotime($line[12])) : '';
		$lead->rfid = $line[13];
		$lead->gender = $line[14];
		$lead->blood_group = $line[15];
		$lead->married_status = $line[16];
		$lead->email = $line[17];
		$lead->mobile = $line[18];

		$lead->alt_numbers = empty($alt_numbers) ? '' : implode(',', $alt_numbers);//json_encode($alt_numbers);

		$lead->id_proof = $line[20];
		$lead->created_by = Laralum::loggedInUser()->id;
		$lead->qualification = $line[21];
		$lead->branch = $line[22];
		$lead->profession = $line[23];
		$lead->sms_required = $line[24];
		$lead->call_required = $line[25];
		$lead->sms_language = $line[26];

		$lead->address_type = serialize($address_type);
		$lead->address = empty($address) ? '' : serialize($address);
		$lead->country = empty($country) ? '' : serialize($country);
		$lead->state = empty($state) ? '' : serialize($state);
		$lead->district = empty($district) ? '' : serialize($district);
		$lead->pincode = empty($pincode) ? '' : serialize($pincode);

		
		//$lead->last_contacted_date = ($line[5] != '') ? date('Y-m-d', strtotime($line[5])) : NULL;//campaign
		$lead->created_by = Laralum::loggedInUser()->id;
		$lead->save();

		if (!empty($member_relation_name)) {
			$name_relation = array();
			foreach ($member_relation_name as $k => $v) {
				$name_relation[$k][] = $v;
				if ($member_relation) {
					foreach ($member_relation as $key => $val) {
						if ($k == $key) {
							$name_relation[$k][] = $val;
						}
					}
				}
				if ($member_relation_dob) {
					foreach ($member_relation_dob as $keys => $value) {
						if ($k == $keys) {
							$name_relation[$k][] = $value;
						}
					}
				}
				if ($member_relation_mobile) {
					foreach ($member_relation_mobile as $mKeys => $mValue) {
						if ($k == $mKeys) {
							$name_relation[$k][] = $mValue;
						}
					}
				}
			}
			foreach ($name_relation as $value) {
				Leadsdata::create([
					'member_id' => $lead->id,
					'member_relation' => $value[1],
					'member_relation_name' => $value[0],
					'member_relation_mobile' => $value[3],
					'member_relation_dob' =>($value[2] != '') ? date('Y-m-d', strtotime($value[2])) : NULL
				]);
			}
		}

		// if($line[6] !=""){
		// $campaigns = DB::table('campaign_lead')->insert([
		// 'agent_id' => $client_id,
		// 'campaign_id' => $line[6],
		// 'lead_id' => $lead->id,
		// 'created_at' => date('YmdHis'),
		// 'updated_at' => date('YmdHis')
		// ]);
		// }

		$rowcount++;
		}
		$countrow++;
		}
		$total_row=$countrow - 1;
		// Close opened CSV file
		fclose($csvFile);
		if(count($row_exist)>0){
		$duplicate_data=json_encode($row_exist);
		$msg='Total ' . $total_row . " records found in CSV file. Total " . $rowcount . ' records imported successfully. Duplicate recods are '.$duplicate_data.'';
		}else{
		$msg='Total ' . $total_row . " records found in CSV file. Total " . $rowcount . ' records imported successfully.';
		}
		return response()->json(['status' => true ,'message' => $msg]);
		//return redirect()->route('Crm::staff')->with('success', 'Staff data has been imported successfully.');
		} else {
		$msg="Lead data has not been imported successfully.";
		return response()->json(['status' => false ,'message' => $msg]);
		//return redirect()->back()->with('error', 'Some problem occurred, please try again.');
		}
		} else {
		$msg="Please upload a valid CSV file.";
		return response()->json(['status' => false ,'message' => $msg]);
		}
	}*/
	
	public function prayer_requestStatusUpdate1(Request $request)
	{
		Laralum::permissionToAccess('laralum.lead.view');
		if ($request->id) {
			DB::table('member_issues')
				->where('id', $request->id)
				->update(['status' => 1]);
			$msg="Status updated to paid.";
			return response()->json(['status' => true ,'message' => $msg]);	
		}
	}

	public function prayer_requestStatusUpdate2(Request $request)
	{
		Laralum::permissionToAccess('laralum.lead.view');
		if ($request->id) {
			DB::table('member_issues')
				->where('id', $request->id)
				->update(['status' => 2]);
			$msg="Status updated to pending.";
			return response()->json(['status' => true ,'message' => $msg]);	
		}
	}
	
	public function prayerRequestEdit(Request $request)
	{
		Laralum::permissionToAccess('laralum.lead.view');
		$requestData = DB::table('member_issues')
						->where('id', $request->id)
						->first();
		return response()->json(['status' => true ,'message' => $requestData]);	
	}

	//edit_follow_up_date edit_issue  edit_description prayerRequestEditId
	public function prayerRequestUpdate(Request $request)
	{  
		Laralum::permissionToAccess('laralum.lead.view');
		if($request->edit_follow_up_date ==""){
			$status="1";
		}else{
			$status="2";
		}
		//dd($request->all());
		DB::table('member_issues')
			->where('id', $request->prayerRequestEditId)
			->update([

			'follow_up_date' => ($request->edit_follow_up_date != '') ? date('Y-m-d',strtotime($request->edit_follow_up_date)) : NULL,
			'issue' => $request->edit_issue,
			'status' => $status,
			 'description' => $request->edit_description
			 ]);
		$msg="Request updated .";
		return response()->json(['status' => true ,'message' => $msg]);	

	}

	public function destroyPrayerRequest(Request $request)
	{//echo $id;die;
		//Laralum::permissionToAccess('laralum.member.delete');
		Laralum::permissionToAccess('laralum.lead.view');
		# Find The Lead
		$prCount = DB::table('member_issues')
				->where('id', $request->id)->count();
		if ($prCount) {
			DB::table('member_issues')->where('id', $request->id)->delete();
		}

		# Return a redirect
		return redirect()->back()->with('success', "The Prayer Request has been deleted");
	}

	#new function for leadDonationDetail by vikash

	public function leadDonationDetail(Request $request){
        $donations = $this->donation->getLeadDonationDetailForTable($request->id);
        return $this->donation->donationDetailDataTable($donations);
	}
	
	public function adminDonation(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
		$client_id = Laralum::loggedInUser()->id;
		}else{
		$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $donations = $this->donation->getAdminDonationForTable($request,$client_id);
        return $this->donation->donationAdminDataTable($donations);
		//return view('hyper/donation/pagination_data', ['donations' => $donations]);
    }

	public function leadDetail_uploadFile (Request $request)
	{
		$request->validate([
		'file' => 'required|mimes:jpeg,jpg,png,pdf,doc,docs,docx|max:2048',
		]);
		$return = "";
		$dir_path=$request->dir_path;
		$time = date('his');
		$file_disc=$request->file_disc;
		$fileName = str_replace(' ', '_', $request->file->extension());
		$file = $file_disc."_".$time.".".$fileName;
		$file = str_replace(' ', '_', $file);
		
		$request->file->move(public_path('crm/'.$dir_path), $file);
		$return=url('/crm/'.$dir_path."/".$file);
		
		DB::table('leads')
				->where('id', $request->id)
				->update(['profile_photo' => $return]);
		
		echo $return;
	}

	public function leadConvertedStatusUpdate(Request $request)
	{
		if ($request->id) {
			DB::table('leads')
				->where('id', $request->id)
				->update(['lead_status' => 3]);
			$msg="Status updated to Converted.";
			return response()->json(['status' => true ,'message' => $msg]);	
		}
	}

	public function load_call(Request $request)
	{
		$query = DB::table('pause_breaks')
					->where('agent_id', Laralum::loggedInUser()->id)
					->whereDate('created_at', Carbon::now())
					->first();
		if ($query == null) {
			$result = DB::table('pause_breaks')
				->insert([
					'agent_id' => Laralum::loggedInUser()->id,
					'pause_limit' => '40',
					'pause_status' => '1',
					'pause_time' => '59:60',
					'created_at' => date('YmdHis'),
					'updated_at' => date('YmdHis')
				]);
		} else {
			$result = $query;
		}
		return response()->json($result);
    }

	public function load_pause(Request $request)
	{
		$query = DB::table('pause_breaks')
					->where('agent_id', Laralum::loggedInUser()->id)
					->whereDate('created_at', Carbon::now())
					->first();
		
		if ($query != null) {
			if ($request->pause_time) {
				if ($query->pause_limit > 0) {
					$result = DB::table('pause_breaks')
						->where('agent_id', Laralum::loggedInUser()->id)
						->whereDate('created_at', Carbon::now())
						->update([
							'pause_limit' => $query->pause_limit - 1,
							'pause_status' => '0',
							'pause_time' => $request->pause_time,
							'updated_at' => date('YmdHis')
						]);
					$result = DB::table('pause_breaks')
						->where('agent_id', Laralum::loggedInUser()->id)
						->whereDate('created_at', Carbon::now())
						->first();
					return response()->json($result);
				} else {
					$result = '00';
				}
			} else {
				$result = $query;
			}
		} else {
			$result = 'Error occured';
		}
		return response()->json($result);
	}

	public function load_resume(Request $request)
	{
		$agentData = DB::table('pause_breaks')
			->where('agent_id', Laralum::loggedInUser()->id)
			->whereDate('created_at', Carbon::now())
			->first();
		if($agentData){
			if($agentData->pause_status == '1'){
				$update = [ 'pause_status' => 0 ];
			}else{
				$update = [ 'pause_status' => 1 ];
			}
			DB::table('pause_breaks')
				->where('agent_id', Laralum::loggedInUser()->id)
				->whereDate('created_at', Carbon::now())
				->update($update);
		}else{
			DB::table('pause_breaks')->insert([
				'agent_id' => Laralum::loggedInUser()->id, 
				'pause_status' => '1',
				'created_at' => date('Y-m-d H:i:s'),	   
				'updated_at' => date('Y-m-d H:i:s')	   
		 	]);
		}

		$result = DB::table('pause_breaks')
					->where('agent_id', Laralum::loggedInUser()->id)
					->whereDate('created_at', Carbon::now())
					->first();
		return response()->json($result);
	}

	public function dashbordCountData(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		//Total Calls Count
		$current_date = date('Y-m-d');
		$calls_count = DB::table('manual_logged_call');
		if ($request->filter_by_agent != "") {
			$calls_count->where('manual_logged_call.created_by', $request->filter_by_agent);
		}

		if ($request->filter_by_Date != "") {
			$dateData = explode(' - ', $request->filter_by_Date);
			if($dateData[0] == $dateData[1]){
				$calls_count->whereDate('manual_logged_call.updated_at', date("Y-m-d", strtotime($dateData[0])));
			}else{
				$calls_count->whereBetween('manual_logged_call.updated_at', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
			}
		}else{
			$calls_count->whereDate('manual_logged_call.updated_at', $current_date);
		}

		if ($request->filter_by_campaign != null && $request->filter_by_campaign != 0 && $request->filter_by_campaign_enable != null) {
            $calls_count->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
        }
        if(Laralum::loggedInUser()->reseller_id != 0){
            $calls_count->where('manual_logged_call.created_by', Laralum::loggedInUser()->id);
        }		
		if(Laralum::loggedInUser()->reseller_id == 0 && Laralum::loggedInUser()->su != 1){
            $calls_count->where('manual_logged_call.client_id', Laralum::loggedInUser()->id);
        }

		$calls_count->get();
		$total_calls_count = $calls_count->count();

		// All Calls
		// $all_calls_count = DB::table('manual_logged_call');
		// if ($request->filter_by_agent != "") {
		// 	$all_calls_count->where('manual_logged_call.created_by', $request->filter_by_agent);
		// }
		// if ($request->filter_by_Date != "") {
		// 	$dateData = explode(' - ', $request->filter_by_Date);
		// 	if($dateData[0] == $dateData[1]){
		// 		$all_calls_count->whereDate('manual_logged_call.created_at', date("Y-m-d", strtotime($dateData[0])));
		// 	}else{
		// 		$all_calls_count->whereBetween('manual_logged_call.created_at', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
		// 	}
		// }else{
		// 	$all_calls_count->whereDate('manual_logged_call.created_at', $current_date);
		// }
        // if(Laralum::loggedInUser()->id != 1){
        //     $all_calls_count->where('manual_logged_call.created_by', Laralum::loggedInUser()->id);
        // }
		// $all_calls_count->get();
		// $all_count = $all_calls_count->count();


		//incomming calls count
		$incoming_calls_count = DB::table('manual_logged_call')
							->where('manual_logged_call.call_source', '1');
		if ($request->filter_by_agent != "") {
			$incoming_calls_count->where('manual_logged_call.created_by', $request->filter_by_agent);
		}
		if ($request->filter_by_Date != "") {
			$dateData = explode(' - ', $request->filter_by_Date);
			if($dateData[0] == $dateData[1]){
				$incoming_calls_count->whereDate('manual_logged_call.updated_at', date("Y-m-d", strtotime($dateData[0])));
			}else{
				$incoming_calls_count->whereBetween('manual_logged_call.updated_at', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
			}
		}else{
			$incoming_calls_count->whereDate('manual_logged_call.updated_at', $current_date);
		}
		if ($request->filter_by_campaign != null && $request->filter_by_campaign != 0  && $request->filter_by_campaign_enable != null) {
            $incoming_calls_count->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
        }
        if(Laralum::loggedInUser()->reseller_id != 0){
            $incoming_calls_count->where('manual_logged_call.created_by', Laralum::loggedInUser()->id);
        }
		if(Laralum::loggedInUser()->reseller_id == 0 && Laralum::loggedInUser()->su != 1){
            $incoming_calls_count->where('manual_logged_call.client_id', Laralum::loggedInUser()->id);
        }
		$incoming_calls_count->get();
		$total_incoming_calls_count = $incoming_calls_count->count();


		//outgoing calls count
		$outgoing_calls_count = DB::table('manual_logged_call')
							->where('manual_logged_call.call_source', '0');
		if ($request->filter_by_agent != "") {
			$outgoing_calls_count->where('manual_logged_call.created_by', $request->filter_by_agent);
		}
		if ($request->filter_by_Date != "") {
			$dateData = explode(' - ', $request->filter_by_Date);
			if($dateData[0] == $dateData[1]){
				$outgoing_calls_count->whereDate('manual_logged_call.updated_at', date("Y-m-d", strtotime($dateData[0])));
			}else{
				$outgoing_calls_count->whereBetween('manual_logged_call.updated_at', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
			}
		}else{
			$outgoing_calls_count->whereDate('manual_logged_call.updated_at', $current_date);
		}
		if ($request->filter_by_campaign != null && $request->filter_by_campaign != 0   && $request->filter_by_campaign_enable != null) {
            $outgoing_calls_count->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
        }

        if(Laralum::loggedInUser()->reseller_id != 0){
            $outgoing_calls_count->where('manual_logged_call.created_by', Laralum::loggedInUser()->id);
        }
		if(Laralum::loggedInUser()->reseller_id == 0 && Laralum::loggedInUser()->su != 1){
            $outgoing_calls_count->where('manual_logged_call.client_id', Laralum::loggedInUser()->id);
        }

		$outgoing_calls_count->get();
		$total_outgoing_calls_count = $outgoing_calls_count->count();

		//bothAnswered calls count
		$bothAnswered_calls_count = DB::table('manual_logged_call')
							->where('manual_logged_call.outcome', 3);
		if ($request->filter_by_agent != "") {
			$bothAnswered_calls_count->where('manual_logged_call.created_by', $request->filter_by_agent);
		}
		if ($request->filter_by_Date != "") {
			$dateData = explode(' - ', $request->filter_by_Date);
			if($dateData[0] == $dateData[1]){
				$bothAnswered_calls_count->whereDate('manual_logged_call.updated_at', date("Y-m-d", strtotime($dateData[0])));
			}else{
				$bothAnswered_calls_count->whereBetween('manual_logged_call.updated_at', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
			}
		}else{
			$bothAnswered_calls_count->whereDate('manual_logged_call.updated_at', $current_date);
		}
		if ($request->filter_by_campaign != null && $request->filter_by_campaign != 0   && $request->filter_by_campaign_enable != null) {
            $bothAnswered_calls_count->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
        }
        if(Laralum::loggedInUser()->reseller_id != 0){
            $bothAnswered_calls_count->where('manual_logged_call.created_by', Laralum::loggedInUser()->id);
        }
		if(Laralum::loggedInUser()->reseller_id == 0 && Laralum::loggedInUser()->su != 1){
            $bothAnswered_calls_count->where('manual_logged_call.client_id', Laralum::loggedInUser()->id);
        }
		$bothAnswered_calls_count->get();
		$total_bothAnswered_calls_count = $bothAnswered_calls_count->count();


		//Agent not Answered calls count
		$agentNotAnswered_calls_count = DB::table('manual_logged_call')
							->where('manual_logged_call.outcome', 7);
		if ($request->filter_by_agent != "") {
			$agentNotAnswered_calls_count->where('manual_logged_call.created_by', $request->filter_by_agent);
		}
		if ($request->filter_by_Date != "") {
			$dateData = explode(' - ', $request->filter_by_Date);
			if($dateData[0] == $dateData[1]){
				$agentNotAnswered_calls_count->whereDate('manual_logged_call.updated_at', date("Y-m-d", strtotime($dateData[0])));
			}else{
				$agentNotAnswered_calls_count->whereBetween('manual_logged_call.updated_at', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
			}
		}else{
			$agentNotAnswered_calls_count->whereDate('manual_logged_call.created_at', $current_date);
		}
		if ($request->filter_by_campaign != null && $request->filter_by_campaign != 0  && $request->filter_by_campaign_enable != null) {
            $agentNotAnswered_calls_count->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
        }
        if(Laralum::loggedInUser()->reseller_id != 0){
            $agentNotAnswered_calls_count->where('manual_logged_call.created_by', Laralum::loggedInUser()->id);
        }
		if(Laralum::loggedInUser()->reseller_id == 0 && Laralum::loggedInUser()->su != 1){
            $agentNotAnswered_calls_count->where('manual_logged_call.client_id', Laralum::loggedInUser()->id);
        }
		$agentNotAnswered_calls_count->get();
		$total_agentNotAnswered_calls_count = $agentNotAnswered_calls_count->count();

		//Customer Ans Agent not Answered calls count
		$customer_answered_agent_not_answered_calls_count = DB::table('manual_logged_call')
							->where('manual_logged_call.outcome', 4);
		if ($request->filter_by_agent != "") {
			$customer_answered_agent_not_answered_calls_count->where('manual_logged_call.created_by', $request->filter_by_agent);
		}
		if ($request->filter_by_Date != "") {
			$dateData = explode(' - ', $request->filter_by_Date);
			if($dateData[0] == $dateData[1]){
				$customer_answered_agent_not_answered_calls_count->whereDate('manual_logged_call.updated_at', date("Y-m-d", strtotime($dateData[0])));
			}else{
				$customer_answered_agent_not_answered_calls_count->whereBetween('manual_logged_call.updated_at', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
			}
		}else{
			$customer_answered_agent_not_answered_calls_count->whereDate('manual_logged_call.created_at', $current_date);
		}
		if ($request->filter_by_campaign != null && $request->filter_by_campaign != 0  && $request->filter_by_campaign_enable != null) {
            $customer_answered_agent_not_answered_calls_count->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
        }
        if(Laralum::loggedInUser()->reseller_id != 0){
            $customer_answered_agent_not_answered_calls_count->where('manual_logged_call.created_by', Laralum::loggedInUser()->id);
        }
		if(Laralum::loggedInUser()->reseller_id == 0 && Laralum::loggedInUser()->su != 1){
            $customer_answered_agent_not_answered_calls_count->where('manual_logged_call.client_id', Laralum::loggedInUser()->id);
        }
		$customer_answered_agent_not_answered_calls_count->get();
		$total_customer_answered_agent_not_answered_calls_count = $customer_answered_agent_not_answered_calls_count->count();


		//customer not Answered calls count
		$custNotAnswered_calls_count = DB::table('manual_logged_call')
							->where('manual_logged_call.outcome', 6);
		if ($request->filter_by_agent != "") {
			$custNotAnswered_calls_count->where('manual_logged_call.created_by', $request->filter_by_agent);
		}
		if ($request->filter_by_Date != "") {
			$dateData = explode(' - ', $request->filter_by_Date);
			if($dateData[0] == $dateData[1]){
				$custNotAnswered_calls_count->whereDate('manual_logged_call.updated_at', date("Y-m-d", strtotime($dateData[0])));
			}else{
				$custNotAnswered_calls_count->whereBetween('manual_logged_call.updated_at', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
			}
		}else{
			$custNotAnswered_calls_count->whereDate('manual_logged_call.updated_at', $current_date);
		}
		if ($request->filter_by_campaign != null && $request->filter_by_campaign != 0  && $request->filter_by_campaign_enable != null) {
            $custNotAnswered_calls_count->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
        }
        if(Laralum::loggedInUser()->reseller_id != 0){
            $custNotAnswered_calls_count->where('manual_logged_call.created_by', Laralum::loggedInUser()->id);
        }
		if(Laralum::loggedInUser()->reseller_id == 0 && Laralum::loggedInUser()->su != 1){
            $custNotAnswered_calls_count->where('manual_logged_call.client_id', Laralum::loggedInUser()->id);
        }
		$custNotAnswered_calls_count->get();
		$total_custNotAnswered_calls_count = $custNotAnswered_calls_count->count();

		//Prayer Request member_id
		// $prayer_request = DB::table('member_issues')
		// 					->leftJoin('campaign_leads', 'member_issues.member_id', 'campaign_leads.lead_id')
  //                   		->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
		// 					->where('client_id', $client_id);
		// if ($request->filter_by_agent != "") {
		// 	$prayer_request->where('member_issues.created_by', Laralum::loggedInUser()->id);
		// }
		// if ($request->filter_by_Date != "") {
		// 	$dateData = explode(' - ', $request->filter_by_Date);
		// 	$prayer_request->whereBetween('member_issues.created_at', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
		// }else{
		// 	$prayer_request->whereDate('member_issues.created_at', $current_date);
		// }
		// if ($request->filter_by_campaign != null) {
  //           $prayer_request->where('campaign_leads.campaign_id', $request->filter_by_campaign);
  //       }
  //       if(Laralum::loggedInUser()->id != 1){
  //           $prayer_request->where('campaign_leads.agent_id', Laralum::loggedInUser()->id);
  //       }
		// $prayer_request->get();
		// $prayer_request_count = $prayer_request->count();
		//Reminders Count
		$prayer_request = DB::table('member_issues')
							//->leftJoin('campaign_leads', 'member_issues.member_id', 'campaign_leads.lead_id')
                    		//->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
                    		->leftJoin('manual_logged_call', function ($prayer_request) use ($request) {
		                        $prayer_request->on('member_issues.member_id', '=', 'manual_logged_call.member_id');
		                        if ($request->filter_by_campaign != null && $request->filter_by_campaign != 0  && $request->filter_by_campaign_enable != null) {
		                            $prayer_request->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
		                        }
		                    })
							->where('member_issues.client_id', $client_id)
							->where('manual_logged_call.call_purpose', 'Add Prayer Request');
		if ($request->filter_by_agent != "") {
			$prayer_request->where('member_issues.created_by', Laralum::loggedInUser()->id);
		}
		if ($request->filter_by_Date != "") {
			$dateData = explode(' - ', $request->filter_by_Date);
			if($dateData[0] == $dateData[1]){
				$prayer_request->whereDate('manual_logged_call.updated_at', date("Y-m-d", strtotime($dateData[0])));
			}else{
				$prayer_request->whereBetween('manual_logged_call.updated_at', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
			}
		}else{
			$prayer_request->whereDate('manual_logged_call.updated_at', $current_date);
		}
		if ($request->filter_by_campaign != null && $request->filter_by_campaign != 0  && $request->filter_by_campaign_enable != null) {
            $prayer_request->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
        }
        if(Laralum::loggedInUser()->reseller_id != 0){
            $prayer_request->where('member_issues.created_by', Laralum::loggedInUser()->id);
        }
		if(Laralum::loggedInUser()->reseller_id == 0 && Laralum::loggedInUser()->su != 1){
            $prayer_request->where('member_issues.client_id', Laralum::loggedInUser()->id);
        }
		$prayer_result=$prayer_request->groupBy('manual_logged_call.id')->get();
		$prayer_request_count = count($prayer_result);

		$reminders = DB::table('donations')
	                ->leftJoin('manual_logged_call', function ($reminders) use ($request) {
                        $reminders->on('donations.donated_by', '=', 'manual_logged_call.member_id');
                        if ($request->filter_by_campaign != null && $request->filter_by_campaign != 0  && $request->filter_by_campaign_enable != null) {
                            $reminders->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
                        }
                    })
	                ->where('donations.client_id', $client_id)
	                ->where('manual_logged_call.call_purpose', 'Add Donation')
					->select('donations.id')
					->where(function ($reminders) use ($request, $current_date) {
						if ($request->filter_by_agent != "") {
							$reminders->where('donations.created_by', $request->filter_by_agent);
						}
						if ($request->filter_by_Date != "") {
							$dateData = explode(' - ', $request->filter_by_Date);
							if($dateData[0] == $dateData[1]){
								$reminders->whereDate('manual_logged_call.updated_at', date("Y-m-d", strtotime($dateData[0])));
							}else{
								$reminders->whereBetween('manual_logged_call.updated_at', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
							}
						}else{
							$reminders->whereDate('manual_logged_call.updated_at', $current_date);
						}
						if ($request->filter_by_campaign != null && $request->filter_by_campaign != 0  && $request->filter_by_campaign_enable != null) {
							$reminders->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
						}
						if(Laralum::loggedInUser()->reseller_id != 0){
							$reminders->where('donations.created_by', Laralum::loggedInUser()->id);
						}
						if(Laralum::loggedInUser()->reseller_id == 0 && Laralum::loggedInUser()->su != 1){
							$reminders->where('donations.client_id', Laralum::loggedInUser()->id);
						}
					})
					->groupBy('manual_logged_call.id')->get();
		////print_r($reminders);die;
		// $remaindersArr = [];
		// if(!empty($reminders)){
		// 	foreach ($reminders as $key => $value) {
		// 		$remaindersArr[] .= $value->id;	
		// 	}
		// }
		//$reminders_count = $reminders->count();
		$reminders_count = count($reminders);
		$will_donates = 0;
		$will_donates = DB::table('donations')
							//->leftJoin('campaign_leads', 'donations.donated_by', 'campaign_leads.lead_id')
                    		//->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
                    		->leftJoin('manual_logged_call', function ($will_donates) use ($request) {
	                        	$will_donates->on('donations.donated_by', '=', 'manual_logged_call.member_id');
		                        if ($request->filter_by_campaign != null && $request->filter_by_campaign != 0  && $request->filter_by_campaign_enable != null) {
		                            $will_donates->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
		                        }
		                    })
							->select('donations.id')
                    		->where('donations.donation_decision', 1)
							->where('donations.client_id', $client_id)
							->where('manual_logged_call.call_purpose', 'Will Donate')
							->select('donations.id')
							->where(function ($will_donates) use ($request, $current_date) {
								if ($request->filter_by_agent != "") {
									$will_donates->where('donations.created_by', $request->filter_by_agent);
								}
								
								if ($request->filter_by_Date != "") {
									$dateData = explode(' - ', $request->filter_by_Date);
									if($dateData[0] == $dateData[1]){
										$will_donates->whereDate('manual_logged_call.updated_at', date("Y-m-d", strtotime($dateData[0])));
									}else{
										$will_donates->whereBetween('manual_logged_call.updated_at', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
									}
								}else{
									$will_donates->whereDate('manual_logged_call.updated_at', $current_date);
								}
								if ($request->filter_by_campaign != null && $request->filter_by_campaign != 0  && $request->filter_by_campaign_enable != null) {
									$will_donates->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
								}
								if(Laralum::loggedInUser()->reseller_id != 0){
									$will_donates->where('donations.created_by', Laralum::loggedInUser()->id);
								}
								if(Laralum::loggedInUser()->reseller_id == 0 && Laralum::loggedInUser()->su != 1){
									$will_donates->where('donations.client_id', Laralum::loggedInUser()->id);
								}
							})
							->groupBy('manual_logged_call.id')->get();
		$will_donate_count = count($will_donates);
	//Leads Count
		// $leads = DB::table('leads')
		// 			->leftJoin('users', 'leads.agent_id', 'users.id')
  //                ->leftJoin('manual_logged_call', 'leads.id', 'manual_logged_call.member_id')
		// 			->where('leads.client_id', $client_id)
		// 			->where('leads.lead_status', '!=', 3)
		// 			->select('leads.id');
		// $manual = DB::table('manual_logged_call')
		// ->join('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
		// ->select('manual_logged_call.member_id')->get();
		$manual = DB::table('manual_logged_call')
			->join('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
			->select('member_id')
			->where(function ($manual) use ($request) {
				if ($request->filter_by_campaign != null && $request->filter_by_campaign != 0) {
					$manual->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
				}
			})->where('manual_logged_call.status','1');
			//->get();
        $manuarray = $manual;
        // foreach($manual as $manu){
        //     $manuarray[] = $manu->member_id;
        // }
		$leads = DB::table('leads')
                    ->join('campaign_leads', 'leads.id', 'campaign_leads.lead_id')
                    ->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
                    //->leftJoin('manual_logged_call', 'leads.id', 'manual_logged_call.member_id')
					->leftJoin('manual_logged_call', function ($leads) use ($request) {
                        $leads->on('leads.id', '=', 'manual_logged_call.member_id');
                        if ($request->filter_by_campaign != null && $request->filter_by_campaign != 0) {
                            $leads->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
                        }
                    })
                    ->select('leads.id');
        //$leads->where('leads.lead_status', '!=', 3);
        if (Laralum::loggedInUser()->reseller_id == 0) {
            $leads->where('leads.client_id', Laralum::loggedInUser()->id);
        } else {
            $leads->where('leads.client_id', Laralum::loggedInUser()->reseller_id);
        }
        if ($request->filter_by_campaign != null && $request->filter_by_campaign != 0) {
            $leads->where('campaign_leads.campaign_id', $request->filter_by_campaign);
        }else{
			$campaignarray = DB::table('campaign_agents')
			->select('campaign_id')
			->where(function ($manual){
				if(Laralum::loggedInUser()->reseller_id != 0){
					$manual->where('agent_id', Laralum::loggedInUser()->id);
				}
			})
			->groupBy('campaign_id');
			$leads->whereIn('campaign_leads.campaign_id', $campaignarray);
		}

        if ($request->filter_by_call_status == 1) {
            $leads->whereNotIn('leads.id', $manuarray);
        } elseif($request->filter_by_call_status == 2) {
            $leads->where('manual_logged_call.call_status', 2);
            if ($request->filter_by_campaign != null && $request->filter_by_campaign != 0) {
	            $leads->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
	        }
        } elseif($request->filter_by_call_status == 3) {
            $leads->where('manual_logged_call.call_status', 3);
			$leads->where('manual_logged_call.call_status', 2);
            if ($request->filter_by_campaign != null && $request->filter_by_campaign != 0) {
	            $leads->where('manual_logged_call.campaign_id', $request->filter_by_campaign);
	        }
        }  elseif($request->filter_by_call_status == 0) {
            $leads->where('manual_logged_call.call_status', 2);
            $leads->orWhere('manual_logged_call.call_status', 3);
        } else {
            $leads->whereNotIn('leads.id', $manuarray);
        }
		if ($request->filter_by_agent != null) {
            $leads->where('campaign_leads.agent_id', $request->filter_by_agent);
        }
        if(Laralum::loggedInUser()->reseller_id != 0){
            $leads->where('campaign_leads.agent_id', Laralum::loggedInUser()->id);
        }

		// if ($request->filter_by_Date != "") {
		// 	$dateData = explode(' - ', $request->filter_by_Date);
		// 	$leads->whereBetween('campaign_leads.created_at', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
		// }else{
		// 	$leads->whereDate('created_at', $current_date);
		// }
        $leads->groupBy('leads.id');
		$leads_rows=$leads->get();
		
		$total_leads_count =0;
		if(!empty($leads_rows)){
			$total_leads_count = count($leads_rows);
		}
		return response()->json([
							'prayer_request_count' => $prayer_request_count,
							'reminders_count' => $reminders_count,
							'will_donate_count' => $will_donate_count,
							'total_leads_count' => $total_leads_count,
							'total_calls_count' => $total_calls_count,
							'total_bothAnswered_calls_count' => $total_bothAnswered_calls_count,
							'total_incoming_calls_count' => $total_incoming_calls_count,
							'total_custNotAnswered_calls_count' => $total_custNotAnswered_calls_count,
							'total_outgoing_calls_count' => $total_outgoing_calls_count,
							'total_agentNotAnswered_calls_count' => $total_agentNotAnswered_calls_count,
							'customer_answered_agent_not_answered_calls_count' => $total_customer_answered_agent_not_answered_calls_count
							
						]);	
	}

	public function totalAmount(Request $request)
	{
		$total_amount = DB::table("donations")->where('donated_by', $request->id)->sum('amount');
		return $total_amount;
	}

	public function callLog(Request $request)
	{
		$callLog = $this->lead->getLeadForTable($request);
		return $this->lead->leadDataTable($callLog);
	}

	public function leadCallLog(Request $request)
	{
        $callLog = $this->callLog->getLeadCallForTable($request->id);
        return $this->callLog->callLogDataTable($callLog);
    }
    public function leadDashboardCallLog(Request $request)
	{
        $callLog = $this->callLog->getLeadCallDashboard($request->id);
        return $this->callLog->callLogDashboard($callLog);
    }

	public function addCallLog(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
		    $client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		DB::table('manual_logged_call')->insert([
			   'client_id' => $client_id, 
			   'member_id' => $request->member_id, 
			   'created_by' => Laralum::loggedInUser()->id, 
			   'outcome' => $request->outcome, 
			   'date' => $request->log_date, 
			   'duration' => $request->log_duration, 
			   'description' => $request->log_description, 
			   'created_at' => date('Y-m-d H:i:s'),	   
			   'updated_at' => date('Y-m-d H:i:s')	   
		]);
		# Return the admin to the call log page with a success message
		return response()->json(array('success' => true, 'status' => 'success'), 200);
    }

	public function get_account_type_data(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
		    $client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$accounttypes = DB::table('member_accounttypes')
						->where('user_id', $client_id)
						->get();
		return response()->json(['status' => true ,'message' => $accounttypes]);
	}
	
	// public function incoming_call(Request $request)
	// {
	// 	if(isset($request->Type) && $request->Type == 'Outgoing'){
	// 		DB::table('manual_logged_call')
	// 			->where('id', $request->ref_id)
	// 			->update([ 'status' => 1, 'outcome' =>  $request->call_status, 'call_initiation' =>  $request->Time]);
	// 			return response()->json('Record has been updated');
	// 	}else{
	// 		DB::table('incoming_calls')->insert([
	// 			'lead_number' => $request->lead_number, 
	// 			'agent_number' => $request->agent_number, 
	// 			'ref_number' => $request->ref_number, 
	// 			'created_at' => date('Y-m-d H:i:s'),	   
	// 			'updated_at' => date('Y-m-d H:i:s')	   
	// 		 ]);
	// 		return response()->json('God Bless U');
	// 	}
	// }

	
	public function callingLeadDetails(Request $request)
	{
		$mobile = trim($request->mobile);
		$lead = DB::table('leads')
					->where('mobile', $mobile)
					->first();

		$calls = DB::table('manual_logged_call')
					->where('lead_number', $mobile)
					->where('status', 0)
					->orderBy('id', 'desc')
					->first();
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}


		$sources = DB::table('member_sources')
					->where('user_id', $client_id)
					->get();
		$lead_statuses = DB::table('lead_statuses')
						->where('client_id', $client_id)
						->get();				
		$recent_calls = DB::table('manual_logged_call') 
                ->leftJoin('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
                //->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
                //->leftJoin('manual_logged_call', 'leads.id', 'manual_logged_call.member_id')
                //->leftJoin('member_issues', 'leads.id', 'member_issues.member_id')
                ->select('manual_logged_call.*')
                //->where('leads.lead_status', '!=', 3)
                ->where('manual_logged_call.client_id', $client_id)
                ->where('lead_number', $mobile)
                ->where(function ($recent_calls) {
			        if(Laralum::loggedInUser()->id != 1){
			            $recent_calls->where('manual_logged_call.created_by', Laralum::loggedInUser()->id);
			        } 

			    })
			    ->groupBy('manual_logged_call.id')->get();	
				if($client_id == '12'){
					return view('hyper.lead.incoming_realstate', compact('lead','mobile','calls','recent_calls','sources','lead_statuses'));
				}else{
					return view('hyper.lead.incoming', compact('lead','mobile','calls','recent_calls','sources','lead_statuses'));
				}
	}


	public function incomingCallRegister(Request $request)
	{
		if($request->agent_number){
			$lead = DB::table('leads')
						->where('mobile', $request->lead_number)
						->first();
			if($lead){
				$lead_id = $lead->id;
			}else{
				$lead_id = 0;
			}

			$agent = DB::table('users')
						->where('mobile', $request->agent_number)
						->first();
			if($agent){
				$agent_id = $agent->id;
				$client_id = $agent->reseller_id;
				$result = DB::table('agent_auto_dial')
							->where('agent_id', $agent_id)
							->first();
				if($result){
					DB::table('agent_auto_dial')
						->where('agent_id', $agent_id)
						->update(['dial_status' => 3]);

					$this->addDataToRedisIncoming($agent_id);
				}else{
					$user = DB::table('agent_auto_dial')->insert([
						'agent_id' => $agent_id,
						'dial_status' => 3,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')
					]);
					$this->addDataToRedisIncoming($agent_id);
				}
			}else{
				$agent_id = 0;
				$client_id = 2;
			}

			$manual_logged_call_data = [
				'client_id' => $client_id,
				'member_id' => $lead_id,
				'lead_number' => $request->lead_number,
				'agent_number' => $request->agent_number,
				'campaign_id' => '',
				'created_by' => $agent_id,
				'call_source' => 1,
				'status' => 0,
				'call_type' => 0,
				'date' => date('Y-m-d')
			];
			$manual_logged_call = ManualLoggedCall::create($manual_logged_call_data);
			if($agent){
				$manual_call = ManualLoggedCall::find($manual_logged_call->id);
				$this->addManualCallLogToRedisOne($manual_call);
			}
			return response()->json('GODBLESSYOU');
		}else{
			return response()->json('ERROR');
		}
		
	}

	public function auto_call_logs(Request $request)
	{
		$json_encode = $request->push_report;
		$request = json_decode($json_encode);
		$data = [];

		//$agent_number = isset($request->CTC->from) ? $request->CTC->from : '';
		$cNumber = isset($request->cNumber) ? substr($request->cNumber, 2) : '';
		$lead_number = isset($request->CTC->to) ? $request->CTC->to : $cNumber;
		//$agent_number_CTC = isset($request->CTC->from) ? $request->CTC->from : '';
		//$lead_number = substr($request->cNumber, 2);
		//$agent_number = substr($request->masterAgentNumber, 2);
		//$agent_number_CTC = substr($request->masterNumCTC, 2);
		if($lead_number){
			$data = $this->lead->getOngoingCallDetails($lead_number);
			if($data){
				$this->lead->updateCall($data, $request);
				//$this->lead->addCallLog($data, $request);
				$manual_logged_call = ManualLoggedCall::find($data->id);
				if($manual_logged_call->created_by > 0){
					$this->addManualCallLogToRedisOne($manual_logged_call);
				}				
			}else{
				$data = $this->lead->addUnanswerIncomingCall($request);
			}
			$this->lead->addCallLog($data, $request);
			return 'GODBLESSYOU';
		}else{
			return 'ERROR';
		}		
	}
	
	public function searchLead(Request $request, $lead_number)
	{
		$data = DB::table('manual_logged_call')
					->where('lead_number', $lead_number)
					->where('status', 0)
					->orderBy('id', 'desc')
					->first();
		if ($data) {
			$ref_number = $data->id;
		} else {
			$ref_number = null;
		}
		return $ref_number;
	}

	public function incoming_call_check(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$check = DB::table('incoming_calls')
					->where('agent_number', Laralum::loggedInUser()->mobile)
					->where('status', 0)
					->first();
		if ($check != null) {
			$data = DB::table('incoming_calls')
					->join('leads', 'incoming_calls.lead_number', 'leads.mobile')
					->select('leads.id as lead', 'incoming_calls.id')
					->where('leads.client_id', $client_id)
					->where('incoming_calls.lead_number', $check->lead_number)
					->where('incoming_calls.agent_number', Laralum::loggedInUser()->mobile)
					->where('incoming_calls.status', 0)
					->first();
			if ($data != null) {
				$call = true;
				$lead = $data->lead;
			} else {
				$call = false;
				$lead = $check->lead_number;
			} 
		} else {
			$call = null;
			$lead = null;
		}
		return response()->json([ 'call' => $call, 'lead' => $lead ]);
	}

	public function autodialCallCheck1(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$check = DB::table('agent_auto_dial')
					->where('agent_id', Laralum::loggedInUser()->id)
					->first();
		
		if ($check && $check->dial_status == '1') {
			$data = DB::table('manual_logged_call')
					//->join('leads', 'manual_logged_call.lead_number', 'leads.mobile')
					->select('manual_logged_call.lead_number as lead', 'manual_logged_call.id', 'manual_logged_call.status')
					//->where('leads.client_id', $client_id)
					//->where('manual_logged_call.lead_number', $check->lead_number)
					->where('manual_logged_call.agent_number', Laralum::loggedInUser()->mobile)
					//->where('manual_logged_call.status', 0)
					//->where('manual_logged_call.call_type', 1)
					->whereDate('manual_logged_call.created_at', Carbon::now())
					->orderBy('id', 'desc')
					->first();
					
			if ($data && $data->status == 0) {
				if ($request->session()->has('lead_number')) {
					$request->session()->forget('lead_number');
				}
				$request->session()->put('lead_number', $data->lead);
				$call = true;
				$lead = $data->lead;
				$auto = true;
			}elseif($data && $data->status == 1){
				$request->session()->forget('lead_number');
				$call = false;
				$lead = null;
				$auto = true;
			} else {
				if ($request->session()->has('lead_number')) {
					$call = true;
					$lead = $request->session()->get('lead_number');
					$auto = true;
				}else{
					$call = null;
					$lead = null;
					$auto = true;
				}
			} 
			return response()->json([ 'call' => $call, 'lead' => $lead, 'auto_dial' => $auto ]);
		}if ($check && $check->dial_status == '2') {
			$data = DB::table('manual_logged_call')
					//->join('leads', 'manual_logged_call.lead_number', 'leads.mobile')
					->select('manual_logged_call.lead_number as lead', 'manual_logged_call.id', 'manual_logged_call.status')
					//->where('leads.client_id', $client_id)
					//->where('manual_logged_call.lead_number', $check->lead_number)
					->where('manual_logged_call.agent_number', Laralum::loggedInUser()->mobile)
					//->where('manual_logged_call.status', 0)
					//->where('manual_logged_call.call_type', 1)
					->whereDate('manual_logged_call.created_at', Carbon::now())
					->orderBy('id', 'desc')
					->first();
			if ($data && $data->status == 0) {
				if ($request->session()->has('lead_number')) {
					$request->session()->forget('lead_number');
				}
				$request->session()->put('lead_number', $data->lead);
				$call = true;
				$lead = $data->lead;
				$auto = false;
			}elseif($data && $data->status == 1){
				$request->session()->forget('lead_number');
				$call = false;
				$lead = null;
				$auto = false;
			} else {
				if ($request->session()->has('lead_number')) {
					$call = true;
					$lead = $request->session()->get('lead_number');
					$auto = false;
				}else{
					$call = null;
					$lead = null;
					$auto = false;
				}
			}
		} else {
			if ($request->session()->has('lead_number')) {
				$request->session()->forget('lead_number');
			}
			$call = null;
			$lead = null;
			$auto = false;
		}
		return response()->json([ 'call' => $call, 'lead' => $lead, 'auto_dial' => $auto ]);
	}

	public function autodialCallCheck(Request $request)
	{
		$userId = Laralum::loggedInUser()->id;
		$details = Redis::get('auto_dial_check_user.'.$userId);
		$check = json_decode($details);
		if ($check && $check->dial_status == '1') {
			$data = Redis::get('manual_logged_call.'.$userId);
			$data = json_decode($data);		
			if ($data && $data->status == 0) {
				$call = true;
				$lead = $data->lead_number;
				$auto = true;
				$incoming = false;
			}elseif($data && $data->status == 1){
				$call = false;
				$lead = null;
				$auto = true;
				$incoming = false;
			} else {
					$call = true;
					$lead = $data->lead_number;
					$auto = true;
					$incoming = false;
			} 
			return response()->json([ 'call' => $call, 'lead' => $lead, 'auto_dial' => $auto, 'incoming' => $incoming ]);
		}if ($check && $check->dial_status == '2') {
			$data = Redis::get('manual_logged_call.'.$userId);
			$data = json_decode($data);	
			if ($data && $data->status == 0) {
				$call = true;
				$lead = $data->lead_number;
				$auto = false;
				$incoming = false;
			}elseif($data && $data->status == 1){
				$call = false;
				$lead = null;
				$auto = false;
				$incoming = false;
			} else {
				$call = true;
				$lead = $data->lead_number;
				$auto = false;
				$incoming = false;
			}
			return response()->json([ 'call' => $call, 'lead' => $lead, 'auto_dial' => $auto, 'incoming' => $incoming ]);
		}if ($check && $check->dial_status == '3') {
			$data = Redis::get('manual_logged_call.'.$userId);
			$data = json_decode($data);
			if ($data && $data->status == 0) {
				$call = true;
				$lead = $data->lead_number;
				$auto = false;
				$incoming = true;
			}elseif($data && $data->status == 1){
				$call = false;
				$lead = null;
				$auto = false;
				$incoming = true;
			} else {
				$call = true;
				$lead = $data->lead_number;
				$auto = false;
				$incoming = true;
			}
		} else {
			$call = null;
			$lead = null;
			$auto = false;
			$incoming = false;
		}
		return response()->json([ 'call' => $call, 'lead' => $lead, 'auto_dial' => $auto, 'incoming' => $incoming ]);
	}

	public function userBreakCheck(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$result = DB::table('pause_breaks')
					->where('agent_id', Laralum::loggedInUser()->id)
					->whereDate('created_at', Carbon::now())
					->first();
		
		//return response()->json([ 'call' => $call, 'lead' => $lead ]);
	}

	public function incoming_call_log(Request $request)
	{
		$data = DB::table('incoming_calls')
					->where('agent_number', Laralum::loggedInUser()->mobile)
					->where('lead_number', $request->mobile)
					->where('status', 0)
					->first();
		if ($data != null) {
			DB::table('incoming_calls')
				->where('id', $data->id)
				->update([ 'status' => 1 ]);
			$call = true;
			$number = $request->mobile;
		} else {
			$call = false;
			$number = null;
		}
		return response()->json([ 'call' => $call, 'number' => $number ]);
	}

	public function incoming_call_new(Request $request)
	{
		$data = DB::table('incoming_calls')
					->where('agent_number', Laralum::loggedInUser()->mobile)
					->where('status', 0)
					->first();
		if ($data != null) {
			DB::table('incoming_calls')
				->where('id', $data->id)
				->update([ 'status' => 1 ]);
			$call = true;
			$number = $data->lead_number;
		} else {
			$call = false;
			$number = null;
		}
		return response()->json([ 'call' => $call, 'number' => $number ]);
	}

	public function get_agentids_by_agent_group(Request $request)
	{
		$agents_ids = DB::table('role_user')->where('role_id', $request->group_id)->pluck('user_id');
		return response()->json(['status' => true ,'agent_datas' => $agents_ids]);
	} 
	public function get_all_lead_id(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$data_ids = DB::table('leads')->where('client_id', $client_id)->select('id')->get();
		return response()->json(['status' => true ,'data_ids' => $data_ids]);
	} 

	public function assign_lead_campaign(Request $request)
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
		$filter_by_lead_incoming = $request->input('filter_by_lead_incoming');
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
                    if(Laralum::loggedInUser()->id != 1){
                        $manual->where('campaign_leads.agent_id', Laralum::loggedInUser()->id);
                    }
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
				            $dateData4 = explode(' - ', $data->filter_by_prayer_followup_date);
				            $leadsData->whereBetween('member_issues.follow_up_date', [date("Y-m-d", strtotime($dateData4[0])), date("Y-m-d", strtotime($dateData4[1]))]);
				        }
				        if ($request->filter_by_lead_response != null) {
				            $leadsData->whereIn('leads.lead_response', $request->filter_by_lead_response);
				        }
				        if ($request->filter_by_call_type != null) {
				            $leadsData->where('manual_logged_call.call_type', $request->filter_by_call_type);
				        }

	                })

        		->groupBy('leads.id')->get();
        	    $leads=[];
        		foreach ($leadsData as $key => $value) {
        			$leads[] .= $value->id;
        		}
        		$leads_count = count($leads);
				$campaigns = $request->campaigns;
				$agentDatas = DB::table('campaign_agents')->where('campaign_id', $campaigns)->select('campaign_agents.agent_id')->get();
				$agent_ids=[];
        		foreach ($agentDatas as $key => $value) {
        			$agent_ids[] .=$value->agent_id;
        		}
				//$campaigns_count=count($campaigns);
        		$agent_count = count($agent_ids);
				//$lead_share = round ( ($leads_count / $agent_count) , 0 , PHP_ROUND_HALF_UP );
        		$lead_share = ceil($leads_count / $agent_count);
        		$arr = [];
        		if ($leads_count > 0 && $agent_count > 0) {
        			$arr = array_chunk($leads, $lead_share);
				
					// foreach ($leadsData as $key => $value) {
					// 	$leadCheck = DB::table('campaign_leads')->where('campaign_id', $campaigns)->where('lead_id', $value->id)->first();
					// 	if(empty($leadCheck)){
					// 		DB::table('campaign_leads')
					// 			->insert(['campaign_id' => $campaigns, 'lead_id' =>$value->id, 'created_at'=>date('Y-m-d H:i'), 'updated_at'=>date('Y-m-d H:i') ]);
					// 	}
	        			
	    //     		}
					for ($i=0; $i <count($arr) ; $i++) {
						for ($j=0; $j <count($arr[$i]) ; $j++) { 
							$leadCheck = DB::table('campaign_leads')->where('campaign_id', $campaigns)->where('lead_id', $arr[$i][$j])->first();
							if(empty($leadCheck)){
								DB::table('campaign_leads')
									->insert(['campaign_id' => $campaigns, 'lead_id' =>$arr[$i][$j], 'agent_id' =>$agent_ids[$i],'created_at'=>date('Y-m-d H:i'), 'updated_at'=>date('Y-m-d H:i') ]);
								DB::table('leads')
									->where('leads.id', $arr[$i][$j])
									->update(['lead_status' => 1, 'updated_at'=>date('Y-m-d H:i') ]);
							}
							$leadCampaignCheck = DB::table('manual_logged_call')->where('campaign_id', $campaigns)->where('member_id', $arr[$i][$j])->first();	
								if($leadCampaignCheck){
									DB::table('manual_logged_call')
									->where('member_id', $arr[$i][$j])
									->update(
										['outcome' => Null,
										'call_status' => 0,
										'duration' => Null,
										'description' => Null,
										'status' => 0,
										'call_purpose' => Null,
										'call_outcome' => Null,
										'recordings_file' => Null,
									 	'updated_at'=>date('Y-m-d H:i') ]
									);
								}
						} 
					}
        		}
				


        }else{
        	$arr = [];
        	$leads=$request->leads;
			$leads_count=count($leads);
			$campaigns=$request->campaigns;
			$agentDatas = DB::table('campaign_agents')->where('campaign_id', $campaigns)->select('campaign_agents.agent_id')->get();

				$agent_ids=[];
        		foreach ($agentDatas as $key => $value) {
        			$agent_ids[] .=$value->agent_id;
        		}

				if($filter_by_lead_incoming != null){
					DB::table('incomming_leads')->whereIn('lead_id', $leads)->delete();
				}
				//$campaigns_count=count($campaigns);
        		$agent_count = count($agent_ids);
				//$lead_share = round ( ($leads_count / $agent_count) , 0 , PHP_ROUND_HALF_UP );
        		$lead_share = ceil($leads_count / $agent_count);
        		if ($leads_count > 0 && $agent_count > 0) {
        			$arr = array_chunk($leads, $lead_share);

					for ($i=0; $i <count($arr) ; $i++) {
						for ($j=0; $j <count($arr[$i]) ; $j++) { 
							$leadCheck = DB::table('campaign_leads')->where('campaign_id', $campaigns)->where('lead_id', $arr[$i][$j])->first();
							if(empty($leadCheck)){

								DB::table('campaign_leads')
									->insert(['campaign_id' => $campaigns, 'lead_id' =>$arr[$i][$j], 'agent_id' =>$agent_ids[$i],'created_at'=>date('Y-m-d H:i'), 'updated_at'=>date('Y-m-d H:i') ]);
								DB::table('leads')
									->where('leads.id', $arr[$i][$j])
									->update(['lead_status' => 1, 'updated_at'=>date('Y-m-d H:i') ]);    	
							}
							$leadCampaignCheck = DB::table('manual_logged_call')->where('campaign_id', $campaigns)->where('member_id', $arr[$i][$j])->first();	
								if($leadCampaignCheck){
									DB::table('manual_logged_call')
									->where('member_id', $arr[$i][$j])
									->update(
										['outcome' => Null,
										'call_status' => 0,
										'duration' => Null,
										'description' => Null,
										'status' => 0,
										'call_purpose' => Null,
										'call_outcome' => 0,
										'recordings_file' => 0,
									 	'updated_at'=>date('Y-m-d H:i') ]
									);
								}  
						} 
					}
        		}
				
        }
		return response()->json(array(
			'status' => 'success','leads'=>$leads,'leads_count'=>$leads_count,'campaigns'=>$campaigns,'agent_ids'=>$agent_ids,'agent_count'=>$agent_count,'lead_share'=>$lead_share,'arr'=>$arr
		));

    }

	public function campaignSelectedAdd(Request $request)
	{
		$agent_id = NULL;
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;

		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
			$agent_id = Laralum::loggedInUser()->id;
		}
		if($agent_id != NULL){
			$Check=DB::table('campaigns_selecteds')->where('campaign_id', $request->campaign_id)->where('agent_id', $agent_id)->first();
			if(empty($Check)){
				DB::table('campaigns_selecteds')
				->insert(['campaign_id' => $request->campaign_id, 'agent_id' =>$agent_id, 'campaign_check' => 1, 'created_at'=>date('Y-m-d H:i'), 'updated_at'=>date('Y-m-d H:i') ]);
				DB::table('campaigns_selecteds')
				->where('campaigns_selecteds.agent_id', $agent_id)
				->where('campaigns_selecteds.campaign_id', '!=', $request->campaign_id)
				->update(['agent_id' =>$agent_id, 'campaign_check' => 0, 'created_at'=>date('Y-m-d H:i'), 'updated_at'=>date('Y-m-d H:i') ]);
			}else{
				DB::table('campaigns_selecteds')
				->where('campaigns_selecteds.id', $Check->id)
				->update(['agent_id' =>$agent_id, 'campaign_check' => 1, 'created_at'=>date('Y-m-d H:i'), 'updated_at'=>date('Y-m-d H:i') ]);
				DB::table('campaigns_selecteds')
				->where('campaigns_selecteds.agent_id', $agent_id)
				->where('campaigns_selecteds.campaign_id', '!=', $request->campaign_id)
				->update(['agent_id' =>$agent_id, 'campaign_check' => 0, 'created_at'=>date('Y-m-d H:i'), 'updated_at'=>date('Y-m-d H:i') ]);
			}

			if ($request->session()->has('campaigns_selected_id')) {
				$request->session()->forget('campaigns_selected_id');
				session()->put('campaigns_selected_id', $request->campaign_id);
			}else{
				session()->put('campaigns_selected_id', $request->campaign_id);
			}
		}

		

		return response()->json(['status' => true ]);
	}


	public function get_userSession_data(Request $request)
	{
        $userSession = $this->lead->getUserSessionForTable($request);
        return $this->lead->userSessionDataTable($userSession);
    }



	public function call_log_reports(Request $request)
	{
		//Laralum::permissionToAccess('laralum.lead.access');
		Laralum::permissionToAccess('laralum.lead.list');
		$agent_id = NULL;
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
			$agent_id = Laralum::loggedInUser()->id;
		}

		$agents = DB::table('users')
					->where('reseller_id', Laralum::loggedInUser()->id)
					->get();

       	$campaigns = DB::table('campaigns')
					->leftJoin('campaign_agents', 'campaigns.id', '=', 'campaign_agents.campaign_id')
					->leftJoin('campaigns_selecteds', 'campaigns.id', '=', 'campaigns_selecteds.campaign_id')
					->where('campaigns.client_id', $client_id)
					->when($agent_id, function ($query, $agent_id) {
	                    return $query->where('campaign_agents.agent_id', $agent_id);
	                })
					->orderBy('campaigns.id', 'desc')
					->groupBy('campaigns.id')
					->select('campaigns.*','campaigns_selecteds.campaign_check')
					->get();
					
		$call_purposes = DB::table('call_purposes')->where('client_id', $client_id)->get();			
		return view('hyper.activity.call_log_reports', compact('agents', 'campaigns', 'call_purposes'));
	}



	public function get_call_log_report_data(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $callLogReport = $this->lead->getCallLogReportForTable($request,$client_id);
        return $this->lead->callLogReportDataTable($callLogReport);
    }


    public function activeInactiveSessionCount(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$active_count = DB::table('users as u')
	                    ->join('sessions as s', 'u.id', '=', 's.user_id')
	                    ->leftJoin('campaign_leads', 'campaign_leads.agent_id', 'u.id')
	                    //->leftJoin('campaigns', 'campaigns.id', 'campaign_leads.campaign_id')
	                    ->where('u.reseller_id', $client_id)
	                    ->when(Laralum::loggedInUser()->id != 1, function ($query) {
			                return $query->where('u.id', Laralum::loggedInUser()->id);
			            })
	                    ->groupBy('u.id')->get();
	    $total_count = DB::table('users as u')
	                    ->leftJoin('sessions as s', 'u.id', '=', 's.user_id')
	                    ->leftJoin('campaign_leads', 'campaign_leads.agent_id', 'u.id')
	                    //->leftJoin('campaigns', 'campaigns.id', 'campaign_leads.campaign_id')
	                    ->where('u.reseller_id', $client_id)
	                    ->when(Laralum::loggedInUser()->id != 1, function ($query) {
			                return $query->where('u.id', Laralum::loggedInUser()->id);
			            })
	                    ->groupBy('u.id')->get();                
	    $active = $active_count->count();
	    $total_count = $total_count->count();
	    $inactiveCount = $total_count - $active;
	    return response()->json(array(
			'status' => 'success','active'=>$active,'inactiveCount'=>$inactiveCount
		));                
		
	}

	public function call_log_edit(Request $request)
	{
		Laralum::permissionToAccess('laralum.lead.view');
		if ($request->id) {
			$logData=DB::table('manual_logged_call')
						//->leftJoin('call_purposes', 'call_purposes.purpose', 'manual_logged_call.call_purpose')
				->where('manual_logged_call.id', $request->id)
				->first();
			return response()->json(['status' => true ,'logData' => $logData]);	
		}
	}

	public function call_log_edit_radio(Request $request)
	{
		Laralum::permissionToAccess('laralum.lead.view');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		if ($request->mobile) {

			$logData=DB::table('manual_logged_call')
					->where('manual_logged_call.client_id', $client_id)
					->where('manual_logged_call.lead_number', $request->mobile)
					->where('manual_logged_call.agent_number', Laralum::loggedInUser()->mobile)
					->orderBy('id', 'desc')
					->first();
			if($logData){
				return response()->json(['status' => true ,'logData' => $logData]);
			}else{
				return response()->json(['status' => false ,'logData' => $logData]);
			}		
			
		}
	}



	public function callLogUpdateData(Request $request)
	{
		Laralum::permissionToAccess('laralum.lead.view');
		if ($request->callLogEditId) {
			$logData=DB::table('manual_logged_call')->where('manual_logged_call.id', $request->callLogEditId)->update(
					['call_outcome' => $request->call_outcome, 'call_purpose' => $request->call_purpose, 'description' => $request->call_description, 'updated_at' => date('Y-m-d H:i:s')]
				);

			return response()->json(['status' => true ,'message' => 'Call log updated successfully.']);	
		}
	}


public function exportSelectedCallLogReport(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

		$filter_by_call = $request->input('filter_by_call');
		$filter_by_agent = $request->input('filter_by_agent');
		$filter_by_call_type = $request->input('filter_by_call_type');
		$filter_by_campaign_status = $request->input('filter_by_campaign_status');
		$date_range_filter = $request->input('date_range_filter');	
		$filter_by_call_purpose = $request->input('filter_by_call_purpose');
		if(Laralum::loggedInUser()->id != 1){
            $agent_check=Laralum::loggedInUser()->id;
        }else{
        	$agent_check="";
        }
        $callLogReport = DB::table('manual_logged_call') 
                    ->leftJoin('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')
                    ->select('manual_logged_call.id')
                    ->where('manual_logged_call.client_id', $client_id)
			        ->when($filter_by_campaign_status == 1, function ($query) {
			        	$manual = DB::table('manual_logged_call')->join('campaign_leads', 'manual_logged_call.member_id', 'campaign_leads.lead_id')->select('member_id')->get();
				        $manuarray = [];
				        foreach($manual as $manu){
				            $manuarray[] = $manu->member_id;
				        }
	                    return $query->whereNotIn('manual_logged_call.member_id', $manuarray);
	                })

	                ->when($filter_by_campaign_status == 2, function ($query) {
	                    return $query->where('manual_logged_call.call_status', $filter_by_call);
	                })
	                ->when($filter_by_campaign_status == 3, function ($query) {
	                    return $query->where('manual_logged_call.call_status', $filter_by_call);
	                })

					->when($filter_by_call, function ($query, $filter_by_call) {
	                    return $query->where('manual_logged_call.status', $filter_by_call);
	                })
	                ->when($filter_by_agent, function ($query, $filter_by_agent) {
	                    return $query->where('manual_logged_call.created_by', $filter_by_agent);
	                })
	                
	                ->when($date_range_filter, function ($query, $date_range_filter) {
	                	$dateData1 = explode(' - ', $date_range_filter);
	                    return $query->whereBetween('manual_logged_call.created_at', [date("Y-m-d", strtotime($dateData1[0])), date("Y-m-d", strtotime($dateData1[1]))]);
	                })
	                ->when($filter_by_call_type, function ($query, $filter_by_call_type) {
	                    return $query->where('manual_logged_call.call_status', $filter_by_call_type);
	                })
	                ->when($filter_by_campaign_status, function ($query, $filter_by_campaign_status) {
	                    return $query->where('manual_logged_call.call_status', $filter_by_campaign_status);
	                })
	                ->when($agent_check, function ($query, $agent_check) {
	                    return $query->where('manual_logged_call.created_by', $agent_check);
	                })
	                ->when($filter_by_call_purpose, function ($query, $filter_by_call_purpose) {
	                    return $query->where('manual_logged_call.call_purpose', $filter_by_call_purpose);
	                })
        		->groupBy('manual_logged_call.id')->get();
        		$leads=[];
        		foreach ($callLogReport as $key => $value) {
        			$leads[] .=$value->id;
        		}
        if($request->select_all_option_check==1){
        	return Excel::download(new CallLogExport($client_id, $leads), 'callLog.xlsx');
        }else{
        	return Excel::download(new CallLogExport($client_id, $request->ids), 'callLog.xlsx');
        }
		
	}




	public function incoming_prayer_request(Request $request)
	{
		//Laralum::permissionToAccess('laralum.lead.view');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		if($request->follow_up_date ==""){
			$status="1";
		}else{
			$status="2";
		}
		DB::table('member_issues')->insert([
			'client_id' => $client_id,
			'created_by' => Laralum::loggedInUser()->id,
			'member_id' => $request->member_id,
			'issue' => $request->issue,
			'follow_up_date' => ($request->follow_up_date != '') ? date('Y-m-d', strtotime($request->follow_up_date)) : NULL,
			'description' => $request->description,
			'status' => $status,
			'created_at' => new DateTime('now'),
			'updated_at' =>	new DateTime('now'),
		]);

		if($request->incoming_manual_callLog_id !=""){
			DB::table('manual_logged_call')
					->where('id', $request->incoming_manual_callLog_id)
					->update(
						[
							'call_purpose' => $request->call_purpose,
					 		'updated_at'=>date('Y-m-d H:i') 
					 	]
					);
		}

		if(isset($request->call_sourse) && $request->call_sourse == '1'){
			$IncommingLead = IncommingLead::where('lead_id', $request->member_id)->first();
			if(!$IncommingLead){
				$incomming_lead = new IncommingLead;
				$incomming_lead->lead_id = $request->member_id;
				$incomming_lead->save();
			}
		}

		return response()->json(array('success' => true, 'status' => true), 200);
    }


//recent_call_log







public function incoming_lead_create(Request $request)
{
	Laralum::permissionToAccess('laralum.lead.create');
		//Laralum::permissionToAccess('laralum.member.create');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

		$validator = Validator::make($request->all(), [
			'name' => 'required',
		 	'mobile' => ['required', 'numeric','min:10',
		 	Rule::unique('leads')->where(function ($query) use ($client_id) {
		 		return $query->where('user_id', $client_id);
		 	})]
			]);
	
			if ($validator->fails()) {
				$msg="Name, member id fields is required and mobile no should be unique in same business";
				return response()->json(['status' => false ,'message' => $msg]);
			}

		$lead = new Lead;
		$lead->user_id = Laralum::loggedInUser()->id;
		$lead->client_id = $client_id;
		$lead->name = $request->name;
		$lead->mobile = $request->mobile; 
		$lead->created_by = Laralum::loggedInUser()->id;

		$lead->save();

		$incomming_lead = new IncommingLead;
		$incomming_lead->lead_id = $lead->id;
		$incomming_lead->save();

		return response()->json(['lead_id' => $lead->id, 'status' => true]);
}


public function incoming_realstate_lead_create(Request $request)
{
	Laralum::permissionToAccess('laralum.lead.create');
		//Laralum::permissionToAccess('laralum.member.create');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

		

		if($request->lead_id == ""){
			$validator = Validator::make($request->all(), [
				//'name' => 'required',
			 	'mobile' => ['required', 'numeric','min:10',
			 	Rule::unique('leads')->where(function ($query) use ($client_id) {
			 		return $query->where('user_id', $client_id);
			 	})]
			]);
	
			if ($validator->fails()) {
				$msg="Mobile no should be unique in same business";
				return response()->json(['status' => false ,'message' => $msg]);
			}
			$lead = new Lead;
			$lead->user_id = Laralum::loggedInUser()->id;
			$lead->client_id = $client_id;
			$lead->name = $request->name;
			$lead->mobile = $request->mobile; 
			$lead->created_by = Laralum::loggedInUser()->id;
			$lead->lead_source = $request->lead_source;
			$lead->lead_status = $request->lead_status;
			$lead->priority = $request->priority;

			$lead->save();
			$id = $lead->id;
			$incomming_lead = new IncommingLead;
			$incomming_lead->lead_id = $lead->id;
			$incomming_lead->save();
		}else{
			$id = $request->lead_id;
			DB::table('leads')
			->where('id', $request->lead_id)
			->update(
				['name' => $request->lead_id,
				'created_by' => Laralum::loggedInUser()->id,
				'lead_source' => $request->lead_source,
				'lead_status' => $request->lead_status,
				'priority' => $request->priority,
			 	'updated_at'=>date('Y-m-d H:i') ]
			);
		}	
		

		return response()->json(['lead_id' => $id, 'status' => true]);
}

public function incoming_realstate_call_log_update(Request $request)
{
	//Laralum::permissionToAccess('laralum.lead.view');
	if ($request->incoming_realstate_manual_callLog_id != "") {
		$logData=DB::table('manual_logged_call')->where('manual_logged_call.id', $request->incoming_realstate_manual_callLog_id)->update(
				['call_purpose' => $request->incoming_realstate_call_purpose,'updated_at' => date('Y-m-d H:i:s')]
			);

		return response()->json(['status' => true ,'message' => 'Call log updated successfully.']);	
	}
}












}
