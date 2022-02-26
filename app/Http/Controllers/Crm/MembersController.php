<?php

namespace App\Http\Controllers\Crm;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Lead;
use App\Donation;
use Carbon\Carbon;
use App\Members;
use App\User;
use App\Leadsdata;
use App\Member_Issue;
use App\Exports\LeadsExport;
use App\Exports\DonationExport;
use App\Permission;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Laralum\Laralum;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule; 
use App\Services\MemberService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use App\Role;
use Illuminate\Support\Facades\Validator;

class MembersController extends Controller
{
	private $member;

	public function __construct(MemberService $member)
    {
        $this->member = $member;
    }





	public function index(Request $request)
	{
		$agent_id = NULL;
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
			$agent_id = Laralum::loggedInUser()->id;
		}
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

		return view('hyper.member.index',  compact('membertypes','branches','donation_purposes','razorKey','manual_call_logs','account_types', 'member_types', 'prayer_requests', 'departments', 'sources', 'agents', 'agentGroup', 'lead_statuses','campaigns', 'lead_responses'));
	}//hyper.member.index
	
	public function get_members_data(Request $request){
		if (Laralum::loggedInUser()->reseller_id == 0) {
		$client_id = Laralum::loggedInUser()->id;
		}else{
		$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $members = $this->member->getMemberForTable($request,$client_id);
        return $this->member->memberDataTable($members);
    }

	public function getMembersDatatables(Request $request){
		
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
		 $account_type = $request->get('account_type');
		 $member_type = $request->get('member_type');
		 $departments = $request->get('departments');
		 $issue_status = $request->get('issue_status');
		 $call_type = $request->get('call_type');
		 $lead_source = $request->get('lead_source');
		 $gender = $request->get('gender');
		 $blood_group = $request->get('blood_group');
		 $married_status = $request->get('married_status');
		 $from_date =  $request->get('from_date');
		 $to_date =  $request->get('to_date');
		 $from_dob =  $request->get('from_dob');
		 $to_dob =  $request->get('to_dob');

		 $columnIndex = $columnIndex_arr[0]['column']; // Column index
		 $columnName = $columnName_arr[$columnIndex]['data']; // Column name
		 $columnSortOrder = $order_arr[0]['dir']; // asc or desc
		 $searchValue = $search_arr; // Search value

		 // Total records
		 $totalRecords = Lead::select('count(*) as allcount')->where('client_id', $client_id)->where('lead_status', 1)->count();
		 $totalRecordswithFilter = Lead::select('count(*) as allcount')
		 ->when($searchValue, function ($query, $searchValue) {
				return $query->where('name', 'like', '%' .$searchValue . '%');
		  })
		 ->when($account_type, function ($query, $account_type) {
				return $query->where('account_type', $account_type);
		  })
		  ->when($member_type, function ($query, $member_type) {
				return $query->where('member_type', $member_type);
		  })
		 ->when($departments, function ($query, $departments) {
				return $query->where('department', $departments);
		  })
		  ->when($lead_source, function ($query, $lead_source) {
				return $query->where('lead_source', $lead_source);
		  })
		  ->when($gender, function ($query, $gender) {
				return $query->where('gender', $gender);
		  })
		  ->when($blood_group, function ($query, $blood_group) {
				return $query->where('blood_group', $blood_group);
		  })
		  ->when($married_status, function ($query, $married_status) {
				return $query->where('married_status', $married_status);
		  })
		  ->when($from_date, function ($query, $from_date) {
				return $query->whereDate('created_at', '>=', $from_date);
		   })
		  ->when($to_date, function ($query, $to_date) {
				return $query->whereDate('created_at', '<=', $to_date);
		  })
		  ->when($from_dob, function ($query, $from_dob) {
				return $query->whereDate('date_of_birth', '>=', $from_dob);
		  })
		  ->when($to_dob, function ($query, $to_dob) {
				return $query->whereDate('date_of_birth', '<=', $to_dob);
		  })
		 ->where('lead_status', 1)
		 ->where('client_id', $client_id)
		 ->count();

		 // Fetch records
		 $records = Lead::orderBy($columnName,$columnSortOrder)
		  ->when($searchValue, function ($query, $searchValue) {
				return $query->where('name', 'like', '%' .$searchValue . '%')->orWhere('member_id', $searchValue)->orWhere('mobile', $searchValue);
		   })
		  ->when($account_type, function ($query, $account_type) {
				return $query->where('account_type', $account_type);
		  })
		  ->when($member_type, function ($query, $member_type) {
				return $query->where('member_type', $member_type);
		  })
		  ->when($departments, function ($query, $departments) {
		 		return $query->where('department', $departments);
		  })
		 ->when($lead_source, function ($query, $lead_source) {
				return $query->where('lead_source', $lead_source);
		  })
		  ->when($gender, function ($query, $gender) {
				return $query->where('gender', $gender);
		  })
		  ->when($blood_group, function ($query, $blood_group) {
				return $query->where('blood_group', $blood_group);
		  })
		  ->when($married_status, function ($query, $married_status) {
				return $query->where('married_status', $married_status);
		  })
		   ->when($from_date, function ($query, $from_date) {
				return $query->whereDate('created_at', '>=', $from_date);
		   })
		  ->when($to_date, function ($query, $to_date) {
				return $query->whereDate('created_at', '<=', $to_date);
		  })
		  ->when($from_dob, function ($query, $from_dob) {
				return $query->whereDate('date_of_birth', '>=', $from_dob);
		  })
		  ->when($to_dob, function ($query, $to_dob) {
				return $query->whereDate('date_of_birth', '<=', $to_dob);
		  })
		   ->where('lead_status', 1)
		   ->where('client_id', $client_id)
		   ->select('leads.*')
		   ->skip($start)
		   ->take($rowperpage)
		   ->get();

		 $data_arr = array();
		 
		 
		 
		 foreach($records as $record){
			 
			    $count_pending = DB::table('member_issues')->where('member_id', $record->id)->where('status', 2)->count();
				$count_resolved = DB::table('member_issues')->where('member_id', $record->id)->where('status', 1)->count();
				$record->count_pending = $count_pending;
				$record->count_resolved = $count_resolved;
				$name = $record->name;
				$member_id = $record->member_id;
				$email = $record->email;
				$account_type = $record->account_type;
				$phone = $record->mobile;
				$created_date = $record->created_at;

				$data_arr[] = array(
				  "id" => $record->id,
				  "member_id" => $member_id,
				  "name" => (Laralum::hasPermission('laralum.member.view')) ? "<a href=".route('Crm::member_details', ['id' => $record->id]).">".$name."</a>" : $name,
				  "email" => $email,
				  "mobile" => $phone,
				  "account_type" => "<span class='badge badge-info'>".$account_type."</span>",
				  "requests" => "<a href=". route('Crm::getnote', ['id' => $record->id, 'status' => '1'])." data-fancybox='data-fancybox' data-type='iframe' class='text-success'>Resolved&nbsp;(".$record->count_resolved.")</a></br>
				                 <a href=". route('Crm::getnote', ['id' => $record->id, 'status' => '2'])." data-fancybox='data-fancybox' data-type='iframe' class='text-danger'>Pending&nbsp;(".$record->count_pending.")</a>", 
				  "action" =>  '<a href="javascript:void(0);" onclick="$(".dimmer").removeClass("dimmer")" title="Add Request" id="addNotePopup" class="item" data-id="'.$record->id.'" data-toggle="modal" data-target="#AddNote">
							     <i class="add icon"></i>
								 </a>'
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
   
   public function getIssuesDatatables(Request $request, $member_id){
		
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
			$created_at = date('d/m/Y', strtotime($record->due_date));
			$taken_by = $this->getName($record->created_by);
			$status = ($record->status==1) ? '<span class="badge badge-success">Resolved</span>' : '<span class="badge badge-danger">Pending</span>';
			$action = '<a href="javascript:void(0);" class="btn btn-sm btn-link font-15" id="editNoteButton" data-id="'.$record->id.'" data-text="'.$record->issue.'" data-status="'.$record->status.'" data-date="'.$record->due_date.'" data-desc="'.$record->description.'" data-toggle="modal" data-target="#EditNote">
			                <i class="fas fa-edit"></i></a>';

			$data_arr[] = array(
			  "issue" => $issue,
			  "due_date" => $created_at,
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


	public function dashboard(Request $request)
	{
		
        if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $total_members = Lead::select('count(*) as allcount')->where('lead_status', 3)->where('client_id', $client_id)->count();
        $total_temporary_members = Lead::select('count(*) as allcount')->where('lead_status', 3)->where('account_type', 'Temporary')->where('client_id', $client_id)->count();
        $total_permanent_members = Lead::select('count(*) as allcount')->where('lead_status', 3)->where('account_type', 'Permanent')->where('client_id', $client_id)->count();
    	
        // $temporary_members = Lead::select(DB::raw('count(*) as member'))->where('lead_status', 3)->where('account_type', 'Temporary')->where('client_id', $client_id)->groupBy(DB::raw('MONTH(created_at)'))->get();
        // $permanent_members = Lead::select(DB::raw('count(*) as member'), DB::raw('MONTHNAME(created_at) as monthname'))->where('lead_status', 3)->where('account_type', 'Permanent')->where('client_id', $client_id)->groupBy(DB::raw('MONTH(created_at)'))->get();
        $temporary_members = Lead::select(DB::raw('count(*) as member'),DB::raw('MONTHNAME(created_at) as monthname'))
                        ->where('lead_status', 3)
                        ->where('account_type', 'Temporary')
                        ->where('client_id', $client_id)
                        ->groupBy(DB::raw('MONTH(created_at)'))
                        ->get();

                        
        $permanent_members = Lead::select(DB::raw('count(*) as member'), 
                        DB::raw('MONTHNAME(created_at) as monthname'))
                        ->where('lead_status', 3)
                        ->where('account_type', 'Permanent')
                        ->where('client_id', $client_id)
                        ->groupBy(DB::raw('MONTH(created_at)'))
                        ->get();

        $partners = Lead::select(DB::raw('count(*) as member'))->where('lead_status', 3)->where('account_type', 'Temporary')->where('client_id', $client_id)->groupBy(DB::raw('MONTH(created_at)'))->get();
        $sponsors = Lead::select(DB::raw('count(*) as member'), DB::raw('MONTHNAME(created_at) as monthname'))->where('lead_status', 3)->where('account_type', 'Permanent')->where('client_id', $client_id)->groupBy(DB::raw('MONTH(created_at)'))->get();
        
        $partners = Lead::select('count(*) as allcount')->where('lead_status', 3)->where('member_type', 'like','%Partner%')->where('client_id', $client_id)->count();
        $sponsors = Lead::select('count(*) as allcount')->where('lead_status', 3)->where('member_type', 'like', '%Sponsor%')->where('client_id', $client_id)->count();
        $investor = Lead::select('count(*) as allcount')->where('lead_status', 3)->where('member_type', 'like','%investor%')->where('client_id', $client_id)->count();
        
        $donations = Donation::whereMonth('donation_date', Carbon::now()->month)->where('client_id', $client_id)->sum('amount');
        
        $date = \Carbon\Carbon::today()->subDays(7);
        $weekly_donations = Donation::where('donation_date','>=',$date)->where('client_id', $client_id)->sum('amount');

        $temporary_member_c=array_fill(0,12,0);
        if(!empty($temporary_members)){    
            foreach ($temporary_members as $key => $value) {
                if($value->monthname == 'January'){
                    $temporary_member_c[0] = (int)$value->member;
                }elseif($value->monthname == 'February'){
                    $temporary_member_c[1] = (int)$value->member;
                }elseif($value->monthname == 'March'){
                    $temporary_member_c[2] = (int)$value->member; 
                }elseif($value->monthname == 'April'){
                    $temporary_member_c[3] = (int)$value->member;
                }elseif($value->monthname == 'May'){
                    $temporary_member_c[4] = (int)$value->member;
                }elseif($value->monthname == 'June'){
                    $temporary_member_c[5] = (int)$value->member;
                }elseif($value->monthname == 'July'){
                    $temporary_member_c[6] = (int)$value->member;
                }elseif($value->monthname == 'August'){
                    $temporary_member_c[7] = (int)$value->member;
                }elseif($value->monthname == 'September'){
                    $temporary_member_c[8] = (int)$value->member;
                }elseif($value->monthname == 'October'){
                    $temporary_member_c[9] = (int)$value->member;
                }elseif($value->monthname == 'November'){
                    $temporary_member_c[10] = (int)$value->member;
                }elseif($value->monthname == 'December'){
                    $temporary_member_c[11] = (int)$value->member;
                }
            }
            $temporary_member_c = implode(', ', $temporary_member_c);
        }else{
            $temporary_member_c = "";
        }  
        //$permanent_member_c = [];
        //$month_name = [];

        $permanent_member_c=array_fill(0,12,0);
        if(!empty($permanent_members)){    
            foreach ($permanent_members as $key => $value) {
                if($value->monthname == 'January'){
                    $permanent_member_c[0] = (int)$value->member;
                }elseif($value->monthname == 'February'){
                    $permanent_member_c[1] = (int)$value->member;
                }elseif($value->monthname == 'March'){
                    $permanent_member_c[2] = (int)$value->member; 
                }elseif($value->monthname == 'April'){
                    $permanent_member_c[3] = (int)$value->member;
                }elseif($value->monthname == 'May'){
                    $permanent_member_c[4] = (int)$value->member;
                }elseif($value->monthname == 'June'){
                    $permanent_member_c[5] = (int)$value->member;
                }elseif($value->monthname == 'July'){
                    $permanent_member_c[6] = (int)$value->member;
                }elseif($value->monthname == 'August'){
                    $permanent_member_c[7] = (int)$value->member;
                }elseif($value->monthname == 'September'){
                    $permanent_member_c[8] = (int)$value->member;
                }elseif($value->monthname == 'October'){
                    $permanent_member_c[9] = (int)$value->member;
                }elseif($value->monthname == 'November'){
                    $permanent_member_c[10] = (int)$value->member;
                }elseif($value->monthname == 'December'){
                    $permanent_member_c[11] = (int)$value->member;
                }
            }
            $permanent_member_c = implode(', ', $permanent_member_c);
        }else{
            $permanent_member_c = "";
        }
        // $temporary_member_c = [];
        // foreach($temporary_members as $k){
        //     $temporary_member_c[] = $k->member;
        // }  
        
        // $permanent_member_c = [];
        // $month_name = [];
        // foreach($permanent_members as $k){
        //     $permanent_member_c[] = $k->member;
        //     $month_name[] = $k->monthname;
        // } 
        // echo "<pre>"; print_r($temporary_member_c);
        // exit;
        return view('hyper.member.dashboard', [
            'total_members' => $total_members, 
            'total_temporary_members' => $total_temporary_members, 
            'total_permanent_members' => $total_permanent_members,
            'temporary_member_c' => $temporary_member_c,
            'permanent_member_c' => $permanent_member_c,
            //'month_name' => $month_name,
            'partners' => $partners,
            'sponsors' => $sponsors,
            'investor' => $investor,
            'donations' => $donations,
            'weekly_donations' => $weekly_donations

            ]);
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
	
	public function getMembers(Request $request){
		
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
		 $totalRecords = Members::select('count(*) as allcount')->where('client_id', $client_id)->count();
		 $totalRecordswithFilter = Members::select('count(*) as allcount')->where('client_id', $client_id)->where('name', 'like', '%' .$searchValue . '%')->count();

		 // Fetch records
		 $records = Members::orderBy($columnName,$columnSortOrder)
		   ->where('client_id', $client_id)
		   ->where('leads.name', 'like', '%' .$searchValue . '%')
		   ->select('leads.*')
		   ->skip($start)
		   ->take($rowperpage)
		   ->get();

		 $data_arr = array();
		 
		 
		 
		 foreach($records as $record){
			$name = $record->name;
			$member_id = $record->member_id;
			$phone = $record->mobile;
			$created_date = $record->created_at;

			$data_arr[] = array(
			  "name" => "<a href=".route('Crm::member_details', ['id' => $record->id]).">".$name."</a>",
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


	public function create()
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		Laralum::permissionToAccess('laralum.member.create');
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
		//$leads_count = !empty($leads_count)? $leads_count->id: 0;
		$leads_count = $leads_count!=0?($leads_count+1):1;///mahdi				

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
						
		// $company = !empty($organization_profile->company_id) ? $organization_profile->company_id : $organization_profile->company_id;
		// $company = strtoupper($company) . ((int)$leads_count + 1);
		$agents = DB::table('users')
					->where('reseller_id', Laralum::loggedInUser()->id)
					->get();			
		return view('hyper.member.create', compact('agents','get_state', 'get_countries', 'company', 'sources', 'accounttypes', 'membertypes', 'departments', 'branches','preferred_languages', 'lead_responses', 'lead_statuses'));
	}

	public function store(Request $request)
	{
		Laralum::permissionToAccess('laralum.member.create');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
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
		$lead->alt_numbers = json_encode($request->alt_number);
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
		$lead->preferred_language = $request->preferred_language;
		$lead->lead_response = $request->lead_response;
		$lead->last_contacted_date = ($request->last_contacted_date != '') ? date('Y-m-d', strtotime($request->last_contacted_date)) : NULL;
		$lead->date_of_anniversary = ($request->date_of_anniversary != '') ? date('Y-m-d', strtotime($request->date_of_anniversary)) : NULL;
		$lead->save();
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
					'member_relation_dob' => $value[2]
				]);
			}
		}
		$msg="The Member has been created.";
		return response()->json(['status' => true ,'message' => $msg]);
	}
	
	#update delete record
	// public function edit($id)
	// {
	// 	if (Laralum::loggedInUser()->reseller_id == 0) {
	// 		$client_id = Laralum::loggedInUser()->id;
	// 	} else {
	// 		$client_id = Laralum::loggedInUser()->reseller_id;
	// 	}
	// 	Laralum::permissionToAccess('laralum.member.edit');
	// 	# Check permissions to access
	// 	// Laralum::permissionToAccess('laralum.senderid.access');

	// 	$sources = DB::table('member_sources')->where('user_id', $client_id)->get();

	// 	$branches = DB::table('branch')->where('client_id', $client_id)->get();

	// 	$accounttypes = DB::table('member_accounttypes')->where('user_id', $client_id)->get();
	// 	$membertypes = DB::table('member_types')->where('user_id', $client_id)->get();
	// 	$departments = DB::table('departments')->where('client_id', $client_id)->get();
	// 	$get_countries = DB::table('countries')->get();
	// 	$get_state = DB::table('state')->get();
	// 	$get_district = DB::table('district')->get();
	// 	$lead = Laralum::lead('id', $id);

	// 	$family_members = DB::table('leadsdatas')->where('member_id', $id)->get();

	// 	# Return the edit form
	// 	return view('crm/leads/edit', [
	// 		'lead'  =>  $lead,
	// 		'get_state'  =>  $get_state,
	// 		'get_district'  =>  $get_district,
	// 		'family_members'  =>  $family_members,
	// 		'departments' => $departments,
	// 		'branches' => $branches,
	// 		'sources' => $sources, 'accounttypes' => $accounttypes, 'membertypes' => $membertypes, 'get_countries' => $get_countries
	// 	]);
	// }
	public function edit($id)
	{
		
		Laralum::permissionToAccess('laralum.member.edit');
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
		return view('hyper.member.edit', compact('agents','id', 'lead', 'get_state', 'get_district', 'family_members', 'departments', 'branches', 'sources', 'accounttypes', 'membertypes', 'get_countries', 'preferred_languages', 'lead_responses','lead_statuses'));
	}	
	// public function deleteSelected(Request $request)
	// {
	// 	Laralum::permissionToAccess('laralum.member.delete');
	// 	foreach ($request->ids as $id) {
	// 		DB::table('leads')->where('id', $id)->delete();
	// 	}
	// 	return response()->json(array(
	// 		'status' => 'success',
	// 	));
	// }

	public function deleteSelected(Request $request)
	{
		Laralum::permissionToAccess('laralum.member.delete');
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
                    ->where('leads.lead_status','=',3)
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

	public function Update(Request $request, $id)
	{
		
		Laralum::permissionToAccess('laralum.member.edit');

		if (Laralum::loggedInUser()->reseller_id == 0) {
            $client_id = Laralum::loggedInUser()->id;
        } else {
            $client_id = Laralum::loggedInUser()->reseller_id;
        }

        $request->validate([
            'name' => 'required',
            'mobile' => ['required', 'numeric','min:10',Rule::unique('leads')->where(function ($query) use ($client_id) {
                return $query->where('user_id', '==', $client_id);
            })]
		]);
		

		if ($files = $request->file('profile_photo')) {
			request()->validate([
				'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			]);

			$destinationPath = public_path('crm/leads');
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($destinationPath, $profileImage);
			$old_image = public_path('crm/leads/') . $request->hidden_profile_photo;
			if (file_exists($old_image)) {
				@unlink($old_image);
			}
		} else {

			$profileImage = $request->hidden_profile_photo;
		}
		if ($files = $request->file('id_proof')) {
			request()->validate([
				'id_proof' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			]);

			$destinationPath = public_path('crm/leads');
			$idProof = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($destinationPath, $idProof);
			$old_image = public_path('crm/leads/') . $request->hidden_id_proof;
			if (file_exists($old_image)) {
				@unlink($old_image);
			}
		} else {
			$idProof = $request->hidden_id_proof;
		}



		$update = DB::table('leads')
			->where('id', $id)
			->update([
				'account_type' => $request->account_type,
				'lead_source' => $request->lead_source,
				'department' => $request->department,
				'member_type' => empty($request->member_type) ? '' : serialize($request->member_type),
				'name' => $request->name,
				'gender' => $request->gender,
				'date_of_birth' => $request->dob,
				'email' => $request->email,
				'mobile' => $request->mobile,
				'address_type' => serialize($request->address_type),
				'date_of_joining' => $request->doj,
				'profile_photo' => $profileImage,
				'id_proof' => $idProof,
				'sms_language' => $request->sms_language,
				'call_required' => $request->has('call'),
				'sms_required' => $request->has('sms'),
				'branch' => $request->branch,
				'profession' => $request->profession,
				'qualification' => $request->qualification,
				'alt_numbers' => serialize($request->alt_number),
				'address' => serialize($request->address),
				'state' => serialize($request->state),
				'country' => serialize($request->country),
				'district' => serialize($request->district),
				'pincode' => serialize($request->pincode),
				'blood_group' => $request->bldgrp,
				'married_status' => $request->marriedstatus,
				'rfid' => $request->rfid,
				'agent_id' => $request->agent
				
			]);

		if ($request->family_member_name) {
			DB::table('leadsdatas')->where('member_id', $id)->delete();
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
					'member_id' => $id,
					'member_relation' => $value[1],
					'member_relation_name' => $value[0],
					'member_relation_mobile' => $value[3],
					'member_relation_dob' => $value[2]
				]);
			}
		}
		return redirect()->route('Crm::member_details', ['id' => $id])->with('success', "The member has been edited");
	}

	public function inlineUpdate(Request $request)
	{
		Laralum::permissionToAccess('laralum.member.edit');
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
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		Laralum::permissionToAccess('laralum.member.view');
		$states = [];
		$districts = [];
		$countries = [];
		# Find the lead
		$lead = Laralum::lead('id', $id);
		$verification =	DB::table('mobile_verification')->where('mobile_number', $lead->mobile)->first();
		$lead->mobile_verified = $verification != null ? $verification->verify_status : false;

		//$family_member = DB::table('leadsdatas')->where('member_id', $id)->where('member_relation_dob', '!=', '1970-01-01')->where('member_relation_dob', '!=', '0000-00-00')->get();
		$family_member = DB::table('leadsdatas')->where('member_id', $id)->where('member_relation_name', '!=', '')->orderBy('id','desc')->get();
		$logs = $this->getCallLogs($lead->mobile);
		$calllogs = $logs['data']['hits'];
		$prayer_requests = DB::table('prayer_requests')->where('user_id', $client_id)->get();

		$msg_list = DB::table('messages')->where('receiver', $id)->paginate(10, ['*'], 'messages')->fragment('Messages');
		$appointments = DB::table('appointments')->where('lead_id', $id)->paginate(10,['*'], 'appointments')->fragment('Appointments');
		$donations  = DB::table('donations')->where('donations.donated_by', $id)->orderBy('donations.id', 'desc')->paginate(10, ['*'], 'donations')->fragment('Donations');

		$issues = DB::table('member_issues')->where('member_id', $id)->paginate(10,['*'], 'issues')->fragment('Issues');
		
		//echo $this->is_serialized($lead->state);die;
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

		foreach ($issues as $issue) {
			$mem_name = DB::table('users')->where('id', $issue->created_by)->first();
			$issue->taken_by = $mem_name->name;
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
		return view('crm/members/show', [
			'memberId'=>$id,
			'lead' => $lead,
			'family_member' => $family_member,
			'state' => $states,
			'district' => $districts,
			'calllogs' => $calllogs,
			'msg_list' => $msg_list,
			'appointments' => $appointments,
			'manual_call_logs' => $manual_call_logs,
			'donations' => $donations,
			'issues' => $issues,
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
		Laralum::permissionToAccess('laralum.member.delete');
		# Find The Lead
		$lead = Laralum::lead('id', $id);
		if ($lead) {
			DB::table('leadsdatas')->where('member_id', $id)->delete();
		}
		# Delete Lead
		$lead->delete();

		# Return a redirect
		return redirect()->route('Crm::members')->with('success', "The member has been deleted");
	}
    public function customRequest(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		
		# insert the data
		DB::table('prayer_requests')->insert(
			['user_id' => Laralum::loggedInUser()->id, 'prayer_request' => $request->prayer_request, 'created_at' => date('Y-m-d H:i:s')]
		);
		$prayer_requests = DB::table('prayer_requests')->where('user_id', $client_id)->get();
		$list="";
		foreach($prayer_requests as $request){
			$list .= "<option value='" . $request->prayer_request . "'>" . $request->prayer_request . "</option>";
		}
		# Return the view
		return response()->json($list);
	}
	
	public function saveNote(Request $request)
	{
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
		$issue->due_date = $request->prayer_request_due_date;
		$issue->description = $request->prayer_request_desc;
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
		# Check permissions
		$affected = DB::table('member_issues')
			->where('id', $request->issues_id)
			->update([ 
					'issue' => $request->update_issues, 
					'due_date' => $request->due_date, 
					'description' => $request->update_comments, 
					'status' => $request->update_status,
					'updated_at' => date('Y-m-d H:i:s')
				 ]);

		if ($request->issues_id) {
			DB::table('leads')
				->where('issue_id', $request->issues_id)
				->update(['issue_status' => $request->update_status]);
		}

		# Return the admin to the blogs page with a success message
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}
	
	public function logActivity(Request $request)
	{
		# Check permissions
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

	public function getnote(Request $request, $id, $status)
	{

		$data = DB::table("member_issues")
			->where("member_id", $id)
			->where("status", $status)
			->get();
		foreach ($data as $d) {
			$mem_name = DB::table('users')->where('id', $d->created_by)->first();
			$d->taken_by = $mem_name->name;
		}
		return view('crm/members/getnote', compact('data'));
	}

	public function getDistrict(Request $request)
	{
		$states = DB::table("district")
			->where("StCode", $request->state_id)
			->pluck("DistrictName", "DistCode");
		return response()->json($states);
	}

	public function callingFunction(Request $request)
	{
		Laralum::permissionToAccess('laralum.member.makecall');
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
		Laralum::permissionToAccess('laralum.member.sendsms');
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
		Laralum::permissionToAccess('laralum.member.sendsms');
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
			return redirect()->route('Crm::members')->with('error', "Message not sent");
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


		return redirect()->route('Crm::members')->with('success', "Message has been sent");
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

	public function deleteManualCallLog(Request $request)
	{

		if ($request->id) {
			DB::table('manual_logged_call')->where('id', $request->id)->delete();
			$returnData = array(
				'status' => 'success',
				'message' => 'The call log has been successfully deleted!'
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

	// public function exportSelected(Request $request)
	// {
	// 	if (Laralum::loggedInUser()->reseller_id == 0) {
	// 		$client_id = Laralum::loggedInUser()->id;
	// 	} else {
	// 		$client_id = Laralum::loggedInUser()->reseller_id;
	// 	}
	// 	return Excel::download(new LeadsExport($client_id, $request->ids), 'members.xlsx');
	// }
	public function exportSelected(Request $request)
	{
		//dd($request->all());
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
	                    ->where('leads.lead_status','=',3)
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
	public function import(Request $request)
	{

		if (isset($_POST['importSubmit'])) {
			// Allowed mime types
			$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

			// Validate whether selected file is a CSV file
			if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {

				// If the file is uploaded
				if (is_uploaded_file($_FILES['file']['tmp_name'])) {

					// Open uploaded CSV file with read-only mode
					$csvFile = fopen($_FILES['file']['tmp_name'], 'r');

					// Skip the first line
					fgetcsv($csvFile);

					// Parse data from CSV file line by line
					while (($line = fgetcsv($csvFile)) !== FALSE) {
						// Get row data
						$lead = new Lead;
						$lead->user_id = Laralum::loggedInUser()->id;
						$lead->client_id = $request->import_leads_client_id;
						$lead->account_type = $line[0];
						$lead->lead_source = $line[2];
						$lead->department = $line[1];
						$lead->name = $line[3];
						$lead->gender = $line[6];
						$lead->date_of_birth = ($line[7] != '') ? date('Y-m-d', strtotime($line[7])) : '';
						$lead->email = $line[4];
						$lead->mobile = $line[5];
						$lead->date_of_joining = date('Y-m-d H:i:s');
						$lead->created_by = Laralum::loggedInUser()->id;
						$lead->save();
					}

					// Close opened CSV file
					fclose($csvFile);

					return redirect()->route('Crm::members')->with('success', 'Members data has been imported successfully.');
				} else {

					return redirect()->route('Crm::members')->with('error', 'Some problem occurred, please try again.');
				}
			} else {

				return redirect()->route('Crm::members')->with('error', 'Please upload a valid CSV file.');
			}
		}
	}


	public function checkdonationstatus($id){
		$donations  = DB::table('donations')->select('id','payment_status')->where('donations.donated_by', $id)->orderBy('donations.id', 'desc')->get();
		return response()->json($donations);
	}

	/*check string is serialize or not*/
	public static function is_serialized( $data, $strict = true ) {
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
	
	public function getName($id){
		$usersdata  = DB::table('users')->select('name')->where('id', $id)->first();
		return $usersdata->name;
	}

	public function importShow()
	{
		return view('hyper/member/import');
	}

	public function get_memberOccasion_data(Request $request){
        $occasions = $this->member->getMemberOccasionForTable($request);
        return $this->member->memberOccasionDataTable($occasions); 
    }
    public function get_memberUpcomingOccation_data(Request $request){
        $occasions = $this->member->getMemberUpcomingOccasionForTable($request);
        return $this->member->memberUpcomingOccasionDataTable($occasions);
    }

    public function assign_member_campaign(Request $request)
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
                    ->where('leads.lead_status','=',3)
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
    
}
