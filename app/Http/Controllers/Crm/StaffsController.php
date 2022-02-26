<?php

namespace App\Http\Controllers\Crm;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Lead;
use App\User;
use App\UserDetail;
use App\StaffExperience;
use App\Education;
use App\StaffData;
use App\Leadsdata;
use App\Member_Issue;
use App\Exports\LeadsExport;
use App\Exports\UsersExport;
use App\Http\Controllers\Laralum\Laralum;
use App\Permission;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Role;
use App\Services\StaffService;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class StaffsController extends Controller
{
	private $staff;

	public function __construct(StaffService $staff)
    {
        $this->staff = $staff;
    }

	public function index(Request $request){
		Laralum::permissionToAccess('laralum.staff.list');
		$departments = DB::table('departments')
						->where('client_id', Laralum::loggedInUser()->id)
						->get();
		return view('hyper/staff/index', compact('departments'));	
	}

	public function get_staffs_data(Request $request){
        $staffs = $this->staff->getStaffForTable($request);
        return $this->staff->staffDataTable($staffs);
    }

   	public function quickAdd(Request $request)
	{
		Laralum::permissionToAccess('laralum.staff.create');
		$validator = Validator::make($request->all(), [
			'name' => 'required',
            'mobile' => 'required|min:10|numeric|unique:users,mobile'
        ]);
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        if ($validator->fails()) {
            return redirect()
				->route('Crm::staff_create')
				->withErrors($validator)
				->withInput();
        }
		$user = new User;
		$user->name = $request->name;
		$user->email = $request->email;
		$user->mobile = $request->mobile;
		$user->reseller_id = $client_id;
		$user->save();
		return redirect()->route('Crm::staff')->with('success', "Account detail has been submited");
	}

	public function exportSelected(Request $request)
	{
		Laralum::permissionToAccess('laralum.staff.list');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		return Excel::download(new UsersExport($client_id,$request->ids), 'staffs.xlsx');
	}

	public function importShow()
	{
		Laralum::permissionToAccess('laralum.staff.create');
		// Family Details  family_member_name  family_member_relation  family_member_dob  family_member_mobile
		// `educations` `id``staff_id``edu_school_name``edu_degree``edu_branch``edu_completion_date``edu_add_note``edu_interest``created_at``updated_at`

		//`staff_experience``exp_id``exp_staff_id``exp_company_name``exp_job_title``exp_from_date``exp_to_date` exp_job_desc `created_at``updated_at`
					
		//`staffdatas``id``staff_id``staff_relation``staff_relation_name``staff_relation_mobile``staff_relation_dob``created_at``updated_at` --}}

		////`user_details``id``user_id``nick_name``location``reporting_to``work_title``hire_source``joining_date``seating_location``work_status``staff_type``work_phone``extension``work_role``experience``pan_no``adhar_no``tags``married_status``age``job_desc``about_me``exit_date``expertise``gender`
	
		
		# Return the view Filter By, Department, Location, Gender, Reporting to, Hiring Source, Staff Status, Staff type, Role, Date of Joining, Date of Exit (With Date Range)
		return view('hyper/staff/import');
	}

	public function import(Request $request)
	{
		Laralum::permissionToAccess('laralum.staff.create');
		//dd($request->all());

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


					$rowcount = 0;
			          $countrow=1;
			          $row_exist=array();
					// Parse data from CSV file line by line
					while (($line = fgetcsv($csvFile)) !== FALSE) {
						if ($this->staff->emailExistCheck($line[1]) > 0) {
			              $row_exist[] .=$countrow;
			            }else
			            {
							$user = new User;
							$user->name = $line[0];
							$user->email = $line[1];
							$user->department = $line[2];
							$user->mobile = $line[3];
							$user->address = $line[4];
							//$user->alt_mobile = json_encode($request->alt_mobile);
							$user->save();

							$user_detail = new UserDetail;
							$user_detail->user_id = $user->id;
							$user_detail->nick_name = $line[5];
							$user_detail->location = $line[6];
							$user_detail->reporting_to = $line[7];
							$user_detail->work_title = $line[8];
							$user_detail->hire_source = $line[9];
							$user_detail->joining_date = ($line[10] != '') ? date('Y-m-d', strtotime($line[10])) : '';
							$user_detail->seating_location = $line[11];
							$user_detail->work_status = $line[12];
							$user_detail->staff_type = $line[13];
							$user_detail->work_phone = $line[14];
							$user_detail->extension = $line[15];
							$user_detail->work_role = $line[16];
							$user_detail->experience = $line[17];	
							$user_detail->pan_no = $line[18];
							$user_detail->adhar_no = $line[19];
							$user_detail->tags = $line[20];
							$user_detail->married_status = $line[21];
							$user_detail->age = $line[22];
							$user_detail->job_desc = $line[23];
							$user_detail->about_me = $line[24];
							$user_detail->exit_date = ($line[25] != '') ? date('Y-m-d', strtotime($line[25])) : NULL;
							$user_detail->expertise = ($line[26] != '') ? date('Y-m-d', strtotime($line[26])) : '';
							$user_detail->gender = $line[27];
							$user_detail->save();

							$education = new Education;
							$education->staff_id = $user->id;
							$education->edu_school_name = $line[28];
							$education->edu_degree = $line[29];
							$education->edu_branch = $line[30];
							$education->edu_completion_date = ($line[31] != '') ? date('Y-m-d', strtotime($line[31])) : '';
							$education->edu_add_note = $line[32];
							$education->edu_interest = $line[33];
							$education->save();

							$relation = new StaffData;
							$relation->staff_id = $user->id;
							$relation->staff_relation = $line[34];
							$relation->staff_relation_name = $line[35];
							$relation->staff_relation_mobile = $line[36];
							$relation->staff_relation_dob = ($line[37] != '') ? date('Y-m-d', strtotime($line[37])) : '';
							$relation->save();
							$experience = new StaffExperience;
							$experience->exp_staff_id = $user->id;
							$experience->exp_company_name = $line[38];
							$experience->exp_job_title = $line[39];
							$experience->exp_from_date = ($line[40] != '') ? date('Y-m-d', strtotime($line[40])) : '';
							$experience->exp_to_date = ($line[41] != '') ? date('Y-m-d', strtotime($line[41])) : '';
							$experience->exp_job_desc = $line[42];
							$experience->save();

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
					$msg="Staff data has not been imported successfully.";
					return response()->json(['status' => false ,'message' => $msg]);
					//return redirect()->back()->with('error', 'Some problem occurred, please try again.');
				}
			} else {
				$msg="Please upload a valid CSV file.";
				return response()->json(['status' => false ,'message' => $msg]);
		
		}
	}

	public function show($id)
	{
		Laralum::permissionToAccess('laralum.staff.view');
		$states = [];
		$districts = [];
		$countries = [];
		# Find the lead
		$user = DB::table('users')->where('users.id', $id)->leftJoin('departments', 'users.department', '=', 'departments.id')->select('users.*','departments.department as department_name')->first();
		//$verification =	DB::table('mobile_verification')->where('mobile_number', $lead->mobile)->first();
		//$lead->mobile_verified = $verification != null ? $verification->verify_status : false;


		// Family Details  family_member_name  family_member_relation  family_member_dob  family_member_mobile
		// `educations` `id``staff_id``edu_school_name``edu_degree``edu_branch``edu_completion_date``edu_add_note``edu_interest``created_at``updated_at`

		//`staff_experience``exp_id``exp_staff_id``exp_company_name``exp_job_title``exp_from_date``exp_to_date` exp_job_desc `created_at``updated_at`
					
		//`staffdatas``id``staff_id``staff_relation``staff_relation_name``staff_relation_mobile``staff_relation_dob``created_at``updated_at` --}}

		$user_detail = DB::table('user_details')->where('user_id', $id)->first();
		$family_member = DB::table('staffdatas')->where('staff_id', $id)->where('staff_relation_dob', '!=', '1970-01-01')->where('staff_relation_dob', '!=', '0000-00-00')->get();

		$staff_experience = DB::table('staff_experience')->where('exp_staff_id', $id)->get();

		$educations = DB::table('educations')->where('staff_id', $id)->get();
		$payslips = DB::table('payslips')->where('employee_id', $id)->get();
		//$logs = $this->getCallLogs($lead->mobile); 
		//$calllogs = $logs['data']['hits'];
		//$prayer_requests = DB::table('prayer_requests')->where('user_id', Laralum::loggedInUser()->id)->get();

		//$msg_list = DB::table('messages')->where('receiver', $id)->get();
		//$appointments = DB::table('appointments')->where('lead_id', $id)->get();
		//$donations  = DB::table('donations')
			//->where('donations.donated_by', $id)
			//->orderBy('donations.id', 'desc')->get();

		// $issues = DB::table('member_issues')->where('member_id', $id)->get();
		// if (unserialize($lead->state) != null)
		// 	foreach (unserialize($lead->state) as $state) {
		// 		array_push($states, DB::table('state')->where('StCode', $state)->first());
		// 	}
		// if (unserialize($lead->district) != null)
		// 	foreach (unserialize($lead->district) as $district) {
		// 		array_push($districts, DB::table('district')->where('DistCode', $district)->first());
		// 	}
		// if (unserialize($lead->country) != null)
		// 	foreach (unserialize($lead->country) as $country) {
		// 		array_push($countries, DB::table('countries')->where('country_code', $country)->first());
		// 	}
		// foreach ($issues as $issue) {
		// 	$mem_name = DB::table('users')->where('id', $issue->created_by)->first();
		// 	$issue->taken_by = $mem_name->name;
		// }
		// foreach ($msg_list as $list) {
		// 	$user = User::find($list->sender);
		// 	$member = Lead::find($list->receiver);
		// 	$mobile_number = Str::startsWith($member->mobile, '91') ? $member->mobile : '91' . $member->mobile;
		// 	$roles = $user->roles->pluck('name');
		// 	$list->sender = $user->name;
		// 	$list->sender_mobile = $user->mobile;
		// 	$list->sender_role = $roles[0];
		// 	$list->status = DB::table('smsreport')->where('number', $mobile_number)->where('requestId', $list->status_code)
		// 		->pluck('desc')->first();
		// }

		# Return the view
		return view('hyper/staff/show', [
			'user_detail' => $user_detail,
			'user' => $user,
			'family_member' => $family_member,
			'staff_experience' => $staff_experience,
			'educations' => $educations,
			'payslips' => $payslips,
		]);
	}

	public function getDepartment($id)
	{
		Laralum::permissionToAccess('laralum.staff.access');
		$department_name = DB::table('departments')
							->select('department')
							->where('id', $id)
							->first();
		if ($department_name != null) {
			return $department_name->department;
		} else {
			return '';
		}
	}

	public function getRole($id)
	{
		//Laralum::permissionToAccess('laralum.staff.access');
		$role_name = DB::table('roles')->select('name')->where('id', $id)->first();
		if ($role_name != null) {
			return $role_name->name;
		} else {
			return '';
		}
	}

	public function dashboard(Request $request)
	{
		Laralum::permissionToAccess('laralum.staff.view');
		# Get all leads for admin
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$type = 'client_id';
			$total_issues = DB::table('member_issues')->where('client_id', Laralum::loggedInUser()->id)->count();
			$pending_issues = DB::table('member_issues')->where('status', 2)->where('client_id', Laralum::loggedInUser()->id)->count();
			$resolved_issues = DB::table('member_issues')->where('status', 1)->where('client_id', Laralum::loggedInUser()->id)->count();
			$total_members = DB::table('leads')->where('client_id', Laralum::loggedInUser()->id)->count();
			$today_members = DB::table('leads')->where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d"))->count();
		} else {
			$type = 'created_by';
			$total_issues = DB::table('member_issues')->where('created_by', Laralum::loggedInUser()->id)->count();
			$pending_issues = DB::table('member_issues')->where('status', 2)->where('created_by', Laralum::loggedInUser()->id)->count();
			$resolved_issues = DB::table('member_issues')->where('status', 1)->where('created_by', Laralum::loggedInUser()->id)->count();
			$total_members = DB::table('leads')->where('created_by', Laralum::loggedInUser()->id)->count();
			$today_members = DB::table('leads')->where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d"))->count();
		}
		$account_types = DB::table('account_types')->get();
		# Return the view
		return view('crm/staffs/dashboard', [
			'type' => $type,
			'total_issues' => $total_issues,
			'pending_issues' => $pending_issues,
			'resolved_issues' => $resolved_issues,
			'total_members' => $total_members,
			'today_members' => $today_members,
			'account_types' => $account_types
		]);
	}

	public function dashboardFilter(Request $request)
	{
		Laralum::permissionToAccess('laralum.staff.access');
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
		Laralum::permissionToAccess('laralum.staff.create');
		//Laralum::permissionToAccess('laralum.member.create');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$departments = DB::table('departments')
						->where('client_id', Laralum::loggedInUser()->id)
						->get();
		$users = DB::table('users')
				->select('id', 'name')
				->where('reseller_id', $client_id)
				->get();
		if(Laralum::loggedInUser()->id == 1){
			# Get all the roles
			$roles = Role::whereNotIn('id', [1])->get();
		}else{
			# Get current user role
			$roles = Role::where('created_by', Laralum::loggedInUser()->id)->orWhere('id', [2])->get();
		}						
		//$roles = DB::table('roles')->select('name','id')->get();
		$hire_sources = DB::table('hiresource')->where('client_id', Laralum::loggedInUser()->id)->get();
		$stafftypes = DB::table('stafftype')->where('client_id', Laralum::loggedInUser()->id)->get();
		$staffstatus = DB::table('staffstatus')->where('client_id', Laralum::loggedInUser()->id)->get();
		$designations = DB::table('designation')->where('client_id', Laralum::loggedInUser()->id)->get();
		$work_locations = DB::table('work_location')->where('client_id', Laralum::loggedInUser()->id)->get();			
		return view('hyper/staff/create', compact('departments','roles','users','hire_sources','stafftypes','staffstatus','designations','work_locations'));
	}

	public function store(Request $request)
	{ ///dd($request->all());
		Laralum::permissionToAccess('laralum.staff.create');
		if (Laralum::loggedInUser()->reseller_id == 0) {
				$client_id = Laralum::loggedInUser()->id;
			} else {
				$client_id = Laralum::loggedInUser()->reseller_id;
			}
		if($request->form_name == 'staff_update_personal_details'){
			$validator = Validator::make($request->all(), [
			'name' => 'required',
            //'mobile' => 'required|min:10|numeric|unique:users,mobile'
	        ]);
	        if ($validator->fails()) {
	            return redirect()
					->route('Crm::staff_create')
					->withErrors($validator)
					->withInput();
	        }
	        $emailcheck = DB::table('users')->where('email', $request->email)->count();
	        if($emailcheck >0){
	        	return redirect()->back()->withInput()->with('error', "This email allready exist.");
	        }//email mobile alt_mobile

			DB::beginTransaction();
			try {
				$user = new User;
				$user->reseller_id = $client_id;
				$user->name = $request->name;
				$user->address = $request->address;
				$user->email = $request->email;
				$user->mobile = $request->mobile;
				$user->alt_mobile = json_encode($request->alt_mobile);
				$user->password = bcrypt($request->password);
				//bcrypt($data['password']),
				$user->save();
				//name  nick_name pan_no adhar_no tags gender marriedstatus address age
				//staff_share work_email dob father_name portal_access provident_fund pf_ac_no uan pension_scheme professional_tax

				$user_detail = new UserDetail;
				$user_detail->user_id = $user->id;
				$user_detail->nick_name = $request->nick_name;
				$user_detail->pan_no = $request->pan_no;
				$user_detail->adhar_no = $request->adhar_no;
				$user_detail->tags = json_encode($request->tags);
				$user_detail->gender = $request->gender;
				$user_detail->married_status = $request->marriedstatus;
				$user_detail->age = $request->age;
				

			    $user_detail->staff_share =$request->has('staff_share');
				$user_detail->dob =($request->dob != '') ? date('Y-m-d', strtotime($request->dob)) : NULL;
				$user_detail->father_name =$request->father_name;
				$user_detail->portal_access =$request->has('portal_access');
				$user_detail->provident_fund =$request->has('provident_fund');
				$user_detail->pf_ac_no =$request->pf_ac_no;
				$user_detail->uan =$request->uan;
				$user_detail->pension_scheme =$request->has('pension_scheme');
				$user_detail->professional_tax =$request->has('professional_tax');
				//manual_diposit cheque_diposit ac_holder_name ac_no ifsc ac_type

				

				$user_detail->save();

				if ($request->edu_school_name) {
					DB::table('educations')->where('staff_id', $request->add_id)->delete();
					$education_data = array();
					foreach ($request->edu_school_name as $k => $v) {
						$education_data[$k][] = $v;
						if ($request->edu_degree) {

							foreach ($request->edu_degree as $key => $val) {

								if ($k == $key) {

									$education_data[$k][] = $val;
								}
							}
						}
						if ($request->edu_branch) {

							foreach ($request->edu_branch as $key => $val) {

								if ($k == $key) {

									$education_data[$k][] = $val;
								}
							}
						}
						if ($request->edu_completion_date) {

							foreach ($request->edu_completion_date as $keys => $value) {

								if ($k == $keys) {

									$education_data[$k][] = $value;
								}
							}
						}
						if ($request->edu_add_note) {

							foreach ($request->edu_add_note as $keys => $value) {

								if ($k == $keys) {

									$education_data[$k][] = $value;
								}
							}
						}

						if ($request->edu_interest) {

							foreach ($request->edu_interest as $mKeys => $mValue) {

								if ($k == $mKeys) {

									$education_data[$k][] = $mValue;
								}
							}
						}
					} 
					foreach ($education_data as $value) {
						Education::create([
							'staff_id' => $request->add_id,
							'edu_degree' => $value[1],
							'edu_school_name' => $value[0],
							'edu_completion_date' => ($value[3] != '') ? date('Y-m-d', strtotime($value[3])) : NULL,
							'edu_branch' => $value[2],
							'edu_add_note' => $value[4],
							'edu_interest' => $value[5]
						]);
					}
				}
			    DB::commit();
			    # Return the admin to the blogs page with a success message
			    return response()->json(['status' => true ,'id' => $user->id]);
				//return redirect()->route('Crm::staff')->with('success', "The staff has been created");
			} catch (\Exception $e) {
			    DB::rollback();
			    return response()->json(['status' => false ,'id' => ""]);
			    //return response()->json(['error' => $ex->getMessage()], 500);
			    //return redirect()->route('Crm::staff_create')->withInput()->with('error', "The staff has not been created");
			}
		}elseif($request->form_name == 'staff_update_work_details'){//dd($request->all());
			// $validator = Validator::make($request->all(), [
			// //'name' => 'required',
			DB::beginTransaction();
			try {
				$update = DB::table('users')
				->where('id', $request->add_id)
				->update([
					'department' => $request->department	
				]);
				$role_det=DB::table('role_user')->where('user_id', $request->add_id)->count();
				if($role_det > 0 && $request->work_role !=""){
					DB::table('role_user')->where('user_id', $request->add_id)
					->update([
						'role_id' => $request->work_role,
						'updated_at' => date('Y-m-d H:i:s')
						
					]);
				}elseif($role_det== 0 && $request->work_role !=""){
					DB::table('role_user')
					->insert([
						'role_id' => $request->work_role,
						'user_id' => $request->add_id,
						'updated_at' => date('Y-m-d H:i:s'),
						'created_at' => date('Y-m-d H:i:s')
						
					]);
				}
				$usr_det=DB::table('user_details')->where('user_id', $request->add_id)->first();
				if($usr_det){
					$update_details = DB::table('user_details')
					->where('user_id', $request->add_id)
					->update([
					//department location reporting_to work_title hire_source joining_date seating_location work_status staff_type work_phone extension work_role experience
						'work_email' => $request->work_email,
						'location' => $request->location,
						'reporting_to' => $request->reporting_to,
						'work_title' => $request->work_title,
						'hire_source' => $request->hire_source,
						'joining_date' => ($request->joining_date != '') ? date('Y-m-d', strtotime($request->joining_date)) : NULL,
						'experience' => $request->experience,
						'seating_location' => $request->seating_location,
						'work_status' => $request->work_status,
						'staff_type' => $request->staff_type,
						'work_phone' => $request->work_phone,
						'extension' => $request->extension,
						'work_role' => $request->work_role,

						'job_desc' => $request->job_desc,
						'about_me' => $request->about_me,
						'expertise' => $request->expertise,
						'exit_date' => ($request->exit_date != '') ? date('Y-m-d', strtotime($request->exit_date)) : NULL
					]);	
				}else{

					UserDetail::create([
						'user_id' => $request->add_id,
						'work_email' => $request->work_email,
						'location' => $request->location,
						'reporting_to' => $request->reporting_to,
						'work_title' => $request->work_title,
						'hire_source' => $request->hire_source,
						'joining_date' => ($request->joining_date != '') ? date('Y-m-d', strtotime($request->joining_date)) : NULL,
						'experience' => $request->experience,
						'seating_location' => $request->seating_location,
						'work_status' => $request->work_status,
						'staff_type' => $request->staff_type,
						'work_phone' => $request->work_phone,
						'extension' => $request->extension,
						'work_role' => $request->work_role,

						'job_desc' => $request->job_desc,
						'about_me' => $request->about_me,
						'expertise' => $request->expertise,
						'exit_date' => ($request->exit_date != '') ? date('Y-m-d', strtotime($request->exit_date)) : NULL
					]);

				}
				if ($request->exp_company_name) {
					DB::table('staff_experience')->where('exp_staff_id', $request->add_id)->delete();
					$exp_name_relation = array();
					foreach ($request->exp_company_name as $k => $v) {
						$exp_name_relation[$k][] = $v;
						if ($request->exp_job_title) {

							foreach ($request->exp_job_title as $key => $val) {

								if ($k == $key) {

									$exp_name_relation[$k][] = $val;
								}
							}
						}
						if ($request->exp_from_date) {

							foreach ($request->exp_from_date as $keys => $value) {

								if ($k == $keys) {

									$exp_name_relation[$k][] = $value;
								}
							}
						}
						if ($request->exp_to_date) {

							foreach ($request->exp_to_date as $keys => $value) {

								if ($k == $keys) {

									$exp_name_relation[$k][] = $value;
								}
							}
						}

						if ($request->exp_job_desc) {

							foreach ($request->exp_job_desc as $mKeys => $mValue) {

								if ($k == $mKeys) {

									$exp_name_relation[$k][] = $mValue;
								}
							}
						}
					} 
					foreach ($exp_name_relation as $value) {
						StaffExperience::create([
							'exp_staff_id' => $request->add_id,
							'exp_job_title' => $value[1],
							'exp_company_name' => $value[0],
							'exp_to_date' => ($value[3] != '') ? date('Y-m-d', strtotime($value[3])) : NULL,
							'exp_from_date' => ($value[2] != '') ? date('Y-m-d', strtotime($value[2])) : NULL,
							'exp_job_desc' => $value[4]
						]);
					}
				}
			    DB::commit();//echo 1;die;
			    # Return the admin to the blogs page with a success message
			    return response()->json(['status' => true ,'id' => $request->add_id]);
				//return redirect()->route('Crm::staff')->with('success', "The staff has been created");
			} catch (\Exception $e) {//echo 1;die;
			    DB::rollback();
			    return response()->json(['status' => false ,'id' => ""]);
			    //return response()->json(['error' => $ex->getMessage()], 500);
			    //return redirect()->route('Crm::staff_create')->withInput()->with('error', "The staff has not been created");
			}
		}elseif($request->form_name == 'staff_update_salary_details'){
			//job_desc about_me expertise exit_date
			DB::beginTransaction(); 
			try {
				$usr_det=DB::table('user_details')->where('user_id', $request->add_id)->first();
				if($usr_det){
					$update_details = DB::table('user_details')
					->where('user_id', $request->add_id)
					->update([
					//department location reporting_to work_title hire_source joining_date seating_location work_status staff_type work_phone extension work_role experience
						'anual_ctc' => $request->anual_ctc,
						'basic_perc' => $request->basic_ctc_percentage,
						'hra_perc' => $request->hra_percentage,
						'special_allowance_per' => $request->special_allowance_percentage,
						'pf_percentage' => $request->pf_percentage,
						'esi_percentage' => $request->esi_percentage,
						'advance_percentage' => $request->advance_percentage,
						'pt_percentage' => $request->pt_percentage,
					
					]);	
				}else{
 
					UserDetail::create([
						'user_id' => $request->add_id,
						'anual_ctc' => $request->anual_ctc,
						'basic_perc' => $request->basic_ctc_percentage,
						'hra_perc' => $request->hra_percentage,
						'special_allowance_per' => $request->special_allowance_percentage,
						'pf_percentage' => $request->pf_percentage,
						'esi_percentage' => $request->esi_percentage,
						'advance_percentage' => $request->advance_percentage,
						'pt_percentage' => $request->pt_percentage,
					]);

				}

			    DB::commit();//echo 1;die;
			    # Return the admin to the blogs page with a success message
			    return response()->json(['status' => true ,'id' => $request->add_id]);
				//return redirect()->route('Crm::staff')->with('success', "The staff has been created");
			} catch (\Exception $e) {
			    DB::rollback();
			    return response()->json(['status' => false ,'id' => ""]);
			    //return response()->json(['error' => $ex->getMessage()], 500);
			    //return redirect()->route('Crm::staff_create')->withInput()->with('error', "The staff has not been created");
			}
		}elseif($request->form_name == 'staff_update_payment_info'){

			DB::beginTransaction();
			try {
				$usr_det=DB::table('user_details')->where('user_id', $request->add_id)->first();
				if($usr_det){
					$update_details = DB::table('user_details')
					->where('user_id', $request->add_id)
					->update([
					//department location reporting_to work_title hire_source joining_date seating_location work_status staff_type work_phone extension work_role experience
						'manual_diposit' => $request->manual_diposit,
						'cheque_diposit' => $request->cheque_diposit,
						'ac_holder_name' => $request->ac_holder_name,
						'bank_name' => $request->bank_name,
						'ac_no' => $request->ac_no,
						'ifsc' => $request->ifsc,
						'ac_type' => $request->ac_type
						
					]);	
				}else{

					UserDetail::create([
						'user_id' => $request->add_id,
						'manual_diposit' => $request->manual_diposit,
						'cheque_diposit' => $request->cheque_diposit,
						'ac_holder_name' => $request->ac_holder_name,
						'bank_name' => $request->bank_name,
						'ac_no' => $request->ac_no,
						'ifsc' => $request->ifsc,
						'ac_type' => $request->ac_type
					]);

				}
				
			    DB::commit();//echo 1;die;
			    # Return the admin to the blogs page with a success message
			    return response()->json(['status' => true ,'id' => $request->add_id]);
				//return redirect()->route('Crm::staff')->with('success', "The staff has been created");
			} catch (\Exception $e) {
			    DB::rollback();
			    return response()->json(['status' => false ,'id' => ""]);
			    //return response()->json(['error' => $ex->getMessage()], 500);
			    //return redirect()->route('Crm::staff_create')->withInput()->with('error', "The staff has not been created");
			}
		}elseif($request->form_name == 'staff_update_family_details'){
			DB::beginTransaction();
			try {
				if ($request->staff_relation_name) {
					DB::table('staffdatas')->where('staff_id', $request->add_id)->delete();
					$name_relation = array();
					foreach ($request->staff_relation_name as $k => $v) {
						$name_relation[$k][] = $v;
						if ($request->staff_relation) {

							foreach ($request->staff_relation as $key => $val) {

								if ($k == $key) {

									$name_relation[$k][] = $val;
								}
							}
						}
						if ($request->staff_relation_dob) {

							foreach ($request->staff_relation_dob as $keys => $value) {

								if ($k == $keys) {

									$name_relation[$k][] = $value;
								}
							}
						}

						if ($request->staff_relation_mobile) {

							foreach ($request->staff_relation_mobile as $mKeys => $mValue) {

								if ($k == $mKeys) {

									$name_relation[$k][] = $mValue;
								}
							}
						}
					}
					foreach ($name_relation as $value) {
						StaffData::create([
							'staff_id' => $request->add_id,
							'staff_relation' => $value[1],
							'staff_relation_name' => $value[0],
							'staff_relation_mobile' => $value[3],
							'staff_relation_dob' => ($value[2] != '') ? date('Y-m-d', strtotime($value[2])) : NULL,
						]);
					}
				}

			    DB::commit();//echo 1;die;
			    # Return the admin to the blogs page with a success message
			    return response()->json(['status' => true ,'id' => $request->add_id]);
				//return redirect()->route('Crm::staff')->with('success', "The staff has been created");
			} catch (\Exception $e) {
			    DB::rollback();
			    return response()->json(['status' => false ,'id' => ""]);
			    //return response()->json(['error' => $ex->getMessage()], 500);
			    //return redirect()->route('Crm::staff_create')->withInput()->with('error', "The staff has not been created");
			}
		}

		

		
	}


	public function edit($id)
	{
		Laralum::permissionToAccess('laralum.staff.edit');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		//Laralum::permissionToAccess('laralum.member.edit');
		# Check permissions to access
		// Laralum::permissionToAccess('laralum.senderid.access');
		$departments = DB::table('departments')->where('client_id', Laralum::loggedInUser()->id)->get();

		$users = DB::table('users')
				->select('id', 'name')
				->where('reseller_id', $client_id)
				->get();

		$user = Laralum::user('id', $id);

		$family_member = DB::table('staffdatas')->where('staff_id', $id)->where('staff_relation_dob', '!=', '1970-01-01')->where('staff_relation_dob', '!=', '0000-00-00')->get();

		$hire_sources = DB::table('hiresource')->where('client_id', Laralum::loggedInUser()->id)->get();
		$stafftypes = DB::table('stafftype')->where('client_id', Laralum::loggedInUser()->id)->get();
		$staffstatus = DB::table('staffstatus')->where('client_id', Laralum::loggedInUser()->id)->get();
		$designations = DB::table('designation')->where('client_id', Laralum::loggedInUser()->id)->get();
		$work_locations = DB::table('work_location')->where('client_id', Laralum::loggedInUser()->id)->get();

		$staff_experience = DB::table('staff_experience')->where('exp_staff_id', $id)->get();

		$educations = DB::table('educations')->where('staff_id', $id)->get();

		$user_detail = DB::table('user_details')->where('user_id', $id)->first();
		//$roles = DB::table('roles')->select('name','id')->get();
		if(Laralum::loggedInUser()->id == 1){
			# Get all the roles
			$roles = Role::whereNotIn('id', [1])->get();
		}else{
			# Get current user role
			$roles = Role::where('created_by', Laralum::loggedInUser()->id)->orWhere('id', [2])->get();
		}
		# Return the edit form
		return view('hyper/staff/edit', [
			'id' =>$id,
			'family_member'  =>  $family_member,
			'staff_experience'  =>  $staff_experience,
			'educations'  =>  $educations,
			'user'  =>  $user,
			'users' => $users,
			'user_detail'  =>  $user_detail,
			'departments' => $departments,
			'roles' => $roles,
			'hire_sources' => $hire_sources,
			'stafftypes' =>$stafftypes,
			'staffstatus' =>$staffstatus,
			'designations' =>$designations,
			'work_locations'=>$work_locations
		]);
	}

	public function Update(Request $request)
	{
		
		//  dd($request->all());
		// die;
		Laralum::permissionToAccess('laralum.staff.edit');
		// Laralum::permissionToAccess('laralum.senderid.access');
		// $request->validate([
		// 	'name' => 'required',
		// 	'mobile' => 'required|min:10|numeric|unique:users,mobile,' . $id
		// ]);

		
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

		$usr_det=DB::table('user_details')->where('user_id', $request->edit_id)->first();
		
		
			if($usr_det){
				if($request->form_id == 1){


					$emailcheck = DB::table('users')->where('email', $request->email)->where('id','!=',$request->edit_id)->count();
					if($emailcheck >0){
						return redirect()->back()->withInput()->with('error', "This email allready exist.");
					}



					$update_details = DB::table('user_details')
					->where('user_id', $request->edit_id)
					->update([
						
						'nick_name' => $request->nick_name,
						'pan_no' => $request->pan_no,
						'adhar_no' => $request->adhar_no,
						'tags' => json_encode($request->tags),
						'gender' => $request->gender,
						'married_status' => $request->married_status,
						'father_name' => $request->father_name,
						'age' => $request->age,
						'dob' => ($request->dob != '') ? date('Y-m-d', strtotime($request->dob)) : NULL,

						'staff_share' => $request->has('staff_share'),
						'dob' => ($request->dob != '') ? date('Y-m-d', strtotime($request->dob)) : NULL,
						'father_name' => $request->father_name,
						'portal_access' => $request->age,
						'portal_access' => $request->has('portal_access'),
						'provident_fund' => $request->has('provident_fund'),
						'pf_ac_no' => $request->pf_ac_no,
						'uan' => $request->uan,
						'pension_scheme' => $request->has('pension_scheme'),
						'professional_tax' => $request->has('professional_tax')
						
					]);
					$update = DB::table('users')
					->where('id', $request->edit_id)
					->update([
						'name' => $request->name,
						'address' => $request->address,

						'email' => $request->email,
						'mobile' => $request->mobile,
						'alt_mobile' => json_encode($request->alt_mobile)
					]);

					if ($request->edu_school_name) {
						DB::table('educations')->where('staff_id', $request->edit_id)->delete();
						$education_data = array();
						foreach ($request->edu_school_name as $k => $v) {
							$education_data[$k][] = $v;
							if ($request->edu_degree) {
			
								foreach ($request->edu_degree as $key => $val) {
			
									if ($k == $key) {
			
										$education_data[$k][] = $val;
									}
								}
							}
							if ($request->edu_branch) {
			
								foreach ($request->edu_branch as $key => $val) {
			
									if ($k == $key) {
			
										$education_data[$k][] = $val;
									}
								}
							}
							if ($request->edu_completion_date) {
			
								foreach ($request->edu_completion_date as $keys => $value) {
			
									if ($k == $keys) {
			
										$education_data[$k][] = $value;
									}
								}
							}
							if ($request->edu_add_note) {
			
								foreach ($request->edu_add_note as $keys => $value) {
			
									if ($k == $keys) {
			
										$education_data[$k][] = $value;
									}
								}
							}
			
							if ($request->edu_interest) {
			
								foreach ($request->edu_interest as $mKeys => $mValue) {
			
									if ($k == $mKeys) {
			
										$education_data[$k][] = $mValue;
									}
								}
							}
						} 
						foreach ($education_data as $value) {
							Education::create([
								'staff_id' => $request->edit_id,
								'edu_degree' => $value[1],
								'edu_school_name' => $value[0],
								'edu_completion_date' => $value[3],
								'edu_branch' => $value[2],
								'edu_add_note' => $value[4],
								'edu_interest' => $value[5]
							]);
						}
					}
					return response()->json(['status' => true ,'form_id' => $request->form_id]);
				}elseif($request->form_id == 2){
					$update_details = DB::table('user_details')
					->where('user_id', $request->edit_id)
					->update([
						'location' => $request->work_location,
						'reporting_to' => $request->reporting_to,
						'work_title' => $request->designation,
						'hire_source' => $request->hire_source,
						'joining_date' => $request->joining_date,
						'experience' => $request->experience,
						'seating_location' => $request->seating_location,
						'work_status' => $request->work_status,
						'staff_type' => $request->staff_type,
						'work_phone' => $request->work_phone,
						'extension' => $request->extension,
						'work_role' => $request->work_role,

						'job_desc' => $request->job_desc,
						'about_me' => $request->about_me,
						'expertise' => $request->expertise,
						'exit_date' => ($request->exit_date != '') ? date('Y-m-d', strtotime($request->exit_date)) : NULL,
						
					]);	

					$update = DB::table('users')
					->where('id', $request->edit_id)
					->update([
						'department' => $request->department,
					]);
					$role_det=DB::table('role_user')->where('user_id', $request->edit_id)->count();
					if($role_det > 0 && $request->work_role !=""){
						DB::table('role_user')->where('user_id', $request->edit_id)
						->update([
							'role_id' => $request->work_role,
							'updated_at' => date('Y-m-d H:i:s')
							
						]);
					}elseif($role_det== 0 && $request->work_role !=""){
						DB::table('role_user')
						->insert([
							'role_id' => $request->work_role,
							'user_id' => $request->edit_id,
							'updated_at' => date('Y-m-d H:i:s'),
							'created_at' => date('Y-m-d H:i:s')
							
						]);
					}
					if ($request->exp_company_name) {
						DB::table('staff_experience')->where('exp_staff_id', $request->edit_id)->delete();
						$exp_name_relation = array();
						foreach ($request->exp_company_name as $k => $v) {
							$exp_name_relation[$k][] = $v;
							if ($request->exp_job_title) {
			
								foreach ($request->exp_job_title as $key => $val) {
			
									if ($k == $key) {
			
										$exp_name_relation[$k][] = $val;
									}
								}
							}
							if ($request->exp_from_date) {
			
								foreach ($request->exp_from_date as $keys => $value) {
			
									if ($k == $keys) {
			
										$exp_name_relation[$k][] = $value;
									}
								}
							}
							if ($request->exp_to_date) {
			
								foreach ($request->exp_to_date as $keys => $value) {
			
									if ($k == $keys) {
			
										$exp_name_relation[$k][] = $value;
									}
								}
							}
			
							if ($request->exp_job_desc) {
			
								foreach ($request->exp_job_desc as $mKeys => $mValue) {
			
									if ($k == $mKeys) {
			
										$exp_name_relation[$k][] = $mValue;
									}
								}
							}
						} 
						foreach ($exp_name_relation as $value) {
							StaffExperience::create([
								'exp_staff_id' => $request->edit_id,
								'exp_job_title' => $value[1],
								'exp_company_name' => $value[0],
								'exp_to_date' => $value[3],
								'exp_from_date' => $value[2],
								'exp_job_desc' => $value[4]
							]);
						}
					}
					return response()->json(['status' => true ,'form_id' => $request->form_id]);
				}elseif($request->form_id == 3){
					DB::table('staffdatas')->where('staff_id', $request->edit_id)->delete();
						$name_relation = array();
						foreach ($request->staff_relation_name as $k => $v) {
							$name_relation[$k][] = $v;
							if ($request->staff_relation) {
			
								foreach ($request->staff_relation as $key => $val) {
			
									if ($k == $key) {
			
										$name_relation[$k][] = $val;
									}
								}
							}
							if ($request->staff_relation_dob) {
			
								foreach ($request->staff_relation_dob as $keys => $value) {
			
									if ($k == $keys) {
			
										$name_relation[$k][] = $value;
									}
								}
							}
			
							if ($request->staff_relation_mobile) {
			
								foreach ($request->staff_relation_mobile as $mKeys => $mValue) {
			
									if ($k == $mKeys) {
			
										$name_relation[$k][] = $mValue;
									}
								}
							}
						}
						foreach ($name_relation as $value) {
							StaffData::create([
								'staff_id' => $request->edit_id,
								'staff_relation' => $value[1],
								'staff_relation_name' => $value[0],
								'staff_relation_mobile' => $value[3],
								'staff_relation_dob' => $value[2]
							]);
						}
						return response()->json(['status' => true ,'form_id' => $request->form_id]);	
				}elseif($request->form_id == 4){
					$update_details = DB::table('user_details')
					->where('user_id', $request->edit_id)
					->update([
					//department location reporting_to work_title hire_source joining_date seating_location work_status staff_type work_phone extension work_role experience
						'anual_ctc' => $request->anual_ctc,
						'basic_perc' => $request->basic_ctc_percentage,
						'hra_perc' => $request->hra_percentage,
						'special_allowance_per' => $request->special_allowance_percentage,
						'pf_percentage' => $request->pf_percentage,
						'esi_percentage' => $request->esi_percentage,
						'advance_percentage' => $request->advance_percentage,
						'pt_percentage' => $request->pt_percentage,
					
					]);
					return response()->json(['status' => true ,'form_id' => $request->form_id]);
				}elseif($request->form_id == 5){
					$update_details = DB::table('user_details')
					->where('user_id', $request->edit_id)
					->update([
					//department location reporting_to work_title hire_source joining_date seating_location work_status staff_type work_phone extension work_role experience
						'manual_diposit' => $request->manual_diposit,
						'cheque_diposit' => $request->cheque_diposit,
						'ac_holder_name' => $request->ac_holder_name,
						'bank_name' => $request->bank_name,
						'ac_no' => $request->ac_no,
						'ifsc' => $request->ifsc,
						'ac_type' => $request->ac_type
						
					]);	
					return response()->json(['status' => true ,'form_id' => $request->form_id]);
					//return redirect()->route('Crm::staff')->with('success', "The staff has been edited");
				}else{
					return "You Have Nothing To Update";
				}
				
			}else{

				UserDetail::create([
					'user_id' => $request->edit_id,
					'nick_name' => $request->nick_name,
					'pan_no' => $request->pan_no,
					'adhar_no' => $request->adhar_no,
					'tags' => $request->tags,
					'gender' => $request->gender,
					'married_status' => $request->married_status,
					'job_desc' => $request->job_desc,
					'about_me' => $request->about_me,
					'expertise' => $request->expertise,
					'exit_date' => ($request->exit_date != '') ? date('Y-m-d', strtotime($request->exit_date)) : NULL,

					'location' => $request->location,
					'reporting_to' => $request->reporting_to,
					'work_title' => $request->work_title,
					'hire_source' => $request->hire_source,
					'joining_date' => $request->joining_date,
					'experience' => $request->experience,
					'seating_location' => $request->seating_location,
					'work_status' => $request->work_status,
					'staff_type' => $request->staff_type,
					'work_phone' => $request->work_phone,
					'extension' => $request->extension,
					'work_role' => $request->work_role,
					'age' => $request->age
				]);


			}
			return response()->json(['status' => true ,'form_id' => $request->form_id]);
		//return redirect()->route('Crm::staff')->with('success', "The staff has been edited");
		//return response()->json(array('status' => 'false', 'message'=>'Staff Updated'));
	}

	public function deleteSelected(Request $request)
	{
		Laralum::permissionToAccess('laralum.staff.delete');
		$ids=$request->ids;
		//Laralum::permissionToAccess('laralum.member.delete');
		DB::beginTransaction();
		try {
		    $staff_user=User::whereIn('id', $ids)->delete();
			$staff_education=Education::whereIn('staff_id', $ids)->delete();
			$staff_staff_experience=StaffExperience::whereIn('exp_staff_id', $ids)->delete();
			$staff_staffdata=StaffData::whereIn('staff_id', $ids)->delete();
		    DB::commit();
		    return response()->json(array('status' => 'success',));
		} catch (\Exception $e) {
		    DB::rollback();
		    //return response()->json(['error' => $ex->getMessage()], 500);
		    return response()->json(array('status' => 'false',));
		}
	}

	public function destroy(Request $request)
	{
		Laralum::permissionToAccess('laralum.staff.delete');
		//Laralum::permissionToAccess('laralum.member.delete');
		# Find The Lead
		if ($request->ajax()){
			DB::beginTransaction();
		try {
			$countEducation = Education::where('staff_id','=', $request->id)->count();
			$countStaffExperience = StaffExperience::where('exp_staff_id','=', $request->id)->count();
			$countStaffData = StaffData::where('staff_id','=', $request->id)->count();
			$countUser_detail = UserDetail::where('user_id','=', $request->id)->count();
		    $staff_user=User::where('id', $request->id)->delete();
		    if($countEducation > 0){
		    	$staff_education=Education::where('staff_id', $request->id)->delete();
		    }
		    if($countStaffExperience > 0){
		    	$staff_staff_experience=StaffExperience::where('exp_staff_id', $request->id)->delete();
		    }
		    if($countStaffData > 0){
		    	$staff_staffdata=StaffData::where('staff_id', $request->id)->delete();
		    }
		    if($countUser_detail > 0){
		    	$staff_details=UserDetail::where('user_id', $request->id)->delete();
		    }			
		    DB::commit();
		    return redirect()->route('Crm::staff')->with('success', "The staff has been deleted");
		} catch (\Exception $e) {
		    DB::rollback();
		    //return response()->json(['error' => $ex->getMessage()], 500);
		    //return redirect()->route('Crm::staff')->with('error', 'Some problem occurred, please try again.');
		}		
		}
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
	
	public function inlineUpdate(Request $request)
	{
		Laralum::permissionToAccess('laralum.staff.edit');
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
		$states = DB::table("district")
			->where("StCode", $request->state_id)
			->pluck("DistrictName", "DistCode");
		return response()->json($states);
	}

	public function callingFunction(Request $request)
	{
		Laralum::permissionToAccess('laralum.staff.access');
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
		Laralum::permissionToAccess('laralum.staff.access');
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
		Laralum::permissionToAccess('laralum.staff.access');
		Laralum::permissionToAccess('laralum.member.sendsms');
		//send message
		$authKey = "130199AKQsRsJy581b6dd5";
		$mobileNumber = $request->receiver_mobile;
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
			$returnData = array(
				'status' => 'error',
				'message' => $err
			);
		} else {
			DB::table('messages')->insert([
				'sender' => $request->sender,
				'receiver' => $request->receiver,
				'message' => $request->msg,
				'status' => 1,
				'status_code' => $output,
				'created_at' => date('Y-m-d H:i:s')
			]);


			$returnData = array(
				'status' => 'success',
				'message' => 'Message sent successfully!'
			);
		}


		return response()->json($returnData);
	}

	public function sendBulkMessage(Request $request)
	{
		Laralum::permissionToAccess('laralum.staff.access');
		Laralum::permissionToAccess('laralum.member.sendsms');
		$mobile_numbers = [];

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
	public function get_tags_data(Request $request)
	{
		//dd($request->all());
		$user_detail = DB::table('user_details')->where('user_id', $request->id)->pluck("tags");
		return response()->json(array('status' => 'true','detail'=>$user_detail));
	}


	public function update_provident_fund(Request $request)
	{
		Laralum::permissionToAccess('laralum.staff.edit');
		if ($request->provident_fund == 1) {
			DB::table('user_details')
				->where('user_id', $request->user_id)
				->update([
					'provident_fund' => $request->provident_fund,
					'pf_ac_no' => $request->pf_ac_no,
					'uan' => $request->uan,
					'pension_scheme' => $request->pension_scheme,
				]);
		}else{
			DB::table('user_details')
				->where('user_id', $request->user_id)
				->update([
					'provident_fund' => $request->provident_fund,
					'pf_ac_no' => NULL,
					'uan' => NULL,
					'pension_scheme' => 0,
				]);
		}
		# Return the admin to the blogs page with a success message
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}


	public function update_professional_tax(Request $request)
	{
		Laralum::permissionToAccess('laralum.staff.edit');
		if ($request->professional_tax == 1) {
			DB::table('user_details')
				->where('user_id', $request->user_id)
				->update([
					'professional_tax' => 1,
				]);
		}else{
			DB::table('user_details')
				->where('user_id', $request->user_id)
				->update([
					'professional_tax' => 0
				]);
		}
		# Return the admin to the blogs page with a success message
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}


	public function update_portal_access(Request $request)
	{
		Laralum::permissionToAccess('laralum.staff.edit');
		if ($request->portal_access == 1) {
			DB::table('user_details')
				->where('user_id', $request->user_id)
				->update([
					'portal_access' => 1,
				]);
		}else{
			DB::table('user_details')
				->where('user_id', $request->user_id)
				->update([
					'portal_access' => 0
				]);
		}
		# Return the admin to the blogs page with a success message
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}

	public function edit_basic_information($id)
	{
		Laralum::permissionToAccess('laralum.staff.edit');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		//Laralum::permissionToAccess('laralum.member.edit');
		# Check permissions to access
		// Laralum::permissionToAccess('laralum.senderid.access');
		$departments = DB::table('departments')->where('client_id', Laralum::loggedInUser()->id)->get();

		$users = DB::table('users')
				->select('id', 'name')
				->where('reseller_id', $client_id)
				->get();

		$user = Laralum::user('id', $id);

		$family_member = DB::table('staffdatas')->where('staff_id', $id)->where('staff_relation_dob', '!=', '1970-01-01')->where('staff_relation_dob', '!=', '0000-00-00')->get();

		$hire_sources = DB::table('hiresource')->where('client_id', Laralum::loggedInUser()->id)->get();
		$stafftypes = DB::table('stafftype')->where('client_id', Laralum::loggedInUser()->id)->get();
		$staffstatus = DB::table('staffstatus')->where('client_id', Laralum::loggedInUser()->id)->get();
		$designations = DB::table('designation')->where('client_id', Laralum::loggedInUser()->id)->get();
		$work_locations = DB::table('work_location')->where('client_id', Laralum::loggedInUser()->id)->get();

		$staff_experience = DB::table('staff_experience')->where('exp_staff_id', $id)->get();

		$educations = DB::table('educations')->where('staff_id', $id)->get();

		$user_detail = DB::table('user_details')->where('user_id', $id)->first();
		$roles = DB::table('roles')->select('name','id')->get();
		# Return the edit form
		return view('hyper/staff/edit_basic_information', [
			'id' =>$id,
			'family_member'  =>  $family_member,
			'staff_experience'  =>  $staff_experience,
			'educations'  =>  $educations,
			'user'  =>  $user,
			'users' => $users,
			'user_detail'  =>  $user_detail,
			'departments' => $departments,
			'roles' => $roles,
			'hire_sources' => $hire_sources,
			'stafftypes' =>$stafftypes,
			'staffstatus' =>$staffstatus,
			'designations' =>$designations,
			'work_locations'=>$work_locations
		]);
	}

	public function Update_basic_information(Request $request)
	{
		
		//  

		//dd($request->all());
		// die;
		//Laralum::permissionToAccess('laralum.member.edit');
		// Laralum::permissionToAccess('laralum.senderid.access');
		// $request->validate([
		// 	'name' => 'required',
		// 	'mobile' => 'required|min:10|numeric|unique:users,mobile,' . $id
		// ]);

		Laralum::permissionToAccess('laralum.staff.edit');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

		$usr_det=DB::table('user_details')->where('user_id', $request->edit_id)->first();
			if($usr_det){
				if($request->form_id == 1){

					$update_details = DB::table('user_details')
					->where('user_id', $request->edit_id)
					->update([
						
						'nick_name' => $request->nick_name,
						//'pan_no' => $request->pan_no,
						//'adhar_no' => $request->adhar_no,
						//'tags' => json_encode($request->tags),
						'gender' => $request->gender,
						//'married_status' => $request->married_status,
						//'father_name' => $request->father_name,
						//'age' => $request->age,
						//'dob' => ($request->dob != '') ? date('Y-m-d', strtotime($request->dob)) : NULL,

						'staff_share' => $request->has('staff_share'),
						//'dob' => ($request->dob != '') ? date('Y-m-d', strtotime($request->dob)) : NULL,
						//'father_name' => $request->father_name,
						'location' => $request->work_location,
						//'reporting_to' => $request->reporting_to,
						//'work_title' => $request->designation,
						//'hire_source' => $request->hire_source,
						//'joining_date' => ($request->joining_date != '') ? date('Y-m-d', strtotime($request->joining_date)) : NULL, 
						'work_email' => $request->work_email,
						'portal_access' => $request->has('portal_access'),
						'provident_fund' => $request->has('provident_fund'),
						'pf_ac_no' => $request->pf_ac_no,
						'uan' => $request->uan,
						'pension_scheme' => $request->has('pension_scheme'),
						'professional_tax' => $request->has('professional_tax')
						
					]);

					$update = DB::table('users')
					->where('id', $request->edit_id)
					->update([
						'name' => $request->name,
						//'address' => $request->address,
						'department' => $request->department,
						'email' => $request->email,
						'mobile' => $request->mobile,
						'alt_mobile' => json_encode($request->alt_mobile)
					]);

				}
				
			}
		//return redirect()->route('Crm::staff')->with('success', "The staff basic information has been updated");
		return response()->json(array('status' => 'true', 'message'=>'The staff basic information has been updated'));
	}

public function edit_persional_information($id)
	{
		Laralum::permissionToAccess('laralum.staff.edit');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		//Laralum::permissionToAccess('laralum.member.edit');
		# Check permissions to access
		// Laralum::permissionToAccess('laralum.senderid.access');
		$departments = DB::table('departments')->where('client_id', Laralum::loggedInUser()->id)->get();

		$users = DB::table('users')
				->select('id', 'name')
				->where('reseller_id', $client_id)
				->get();

		$user = Laralum::user('id', $id);

		$family_member = DB::table('staffdatas')->where('staff_id', $id)->where('staff_relation_dob', '!=', '1970-01-01')->where('staff_relation_dob', '!=', '0000-00-00')->get();

		$hire_sources = DB::table('hiresource')->where('client_id', Laralum::loggedInUser()->id)->get();
		$stafftypes = DB::table('stafftype')->where('client_id', Laralum::loggedInUser()->id)->get();
		$staffstatus = DB::table('staffstatus')->where('client_id', Laralum::loggedInUser()->id)->get();
		$designations = DB::table('designation')->where('client_id', Laralum::loggedInUser()->id)->get();
		$work_locations = DB::table('work_location')->where('client_id', Laralum::loggedInUser()->id)->get();

		$staff_experience = DB::table('staff_experience')->where('exp_staff_id', $id)->get();

		$educations = DB::table('educations')->where('staff_id', $id)->get();

		$user_detail = DB::table('user_details')->where('user_id', $id)->first();
		$roles = DB::table('roles')->select('name','id')->get();
		# Return the edit form
		return view('hyper/staff/edit_persional_information', [
			'id' =>$id,
			'family_member'  =>  $family_member,
			'staff_experience'  =>  $staff_experience,
			'educations'  =>  $educations,
			'user'  =>  $user,
			'users' => $users,
			'user_detail'  =>  $user_detail,
			'departments' => $departments,
			'roles' => $roles,
			'hire_sources' => $hire_sources,
			'stafftypes' =>$stafftypes,
			'staffstatus' =>$staffstatus,
			'designations' =>$designations,
			'work_locations'=>$work_locations
		]);
	}

	public function Update_persional_information(Request $request)
	{
		//dd($request->all());
		// die;
		//Laralum::permissionToAccess('laralum.member.edit');
		// Laralum::permissionToAccess('laralum.senderid.access');
		// $request->validate([
		// 	'name' => 'required',
		// 	'mobile' => 'required|min:10|numeric|unique:users,mobile,' . $id
		// ]);	
		Laralum::permissionToAccess('laralum.staff.edit');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

		$usr_det=DB::table('user_details')->where('user_id', $request->edit_id)->first();		
			if($usr_det){
				$update_details = DB::table('user_details')
					->where('user_id', $request->edit_id)
					->update([
						'father_name' => $request->father_name,
						'pan_no' => $request->pan_no,
						'age' => $request->age,
						'dob' => ($request->dob != '') ? date('Y-m-d', strtotime($request->dob)) : NULL,
						//'location' => $request->work_location,
						//'reporting_to' => $request->reporting_to,
						//'work_title' => $request->designation,
						//'hire_source' => $request->hire_source,
						//'joining_date' => $request->joining_date,
						//'experience' => $request->experience,
						//'seating_location' => $request->seating_location,
						//'work_status' => $request->work_status,
						//'staff_type' => $request->staff_type,
						//'work_phone' => $request->work_phone,
						//'extension' => $request->extension,
						//'work_role' => $request->work_role,

						//'job_desc' => $request->job_desc,
						//'about_me' => $request->about_me,
						//'expertise' => $request->expertise,
						//'exit_date' => $request->exit_date,
						
					]);	

					$update = DB::table('users')
					->where('id', $request->edit_id)
					->update([
						'address' => $request->address,
						'email' => $request->email,
						'mobile' => $request->mobile,
						'alt_mobile' => json_encode($request->alt_mobile)
					]);
					// $role_det=DB::table('role_user')->where('user_id', $request->edit_id)->count();
					// if($role_det > 0 && $request->work_role !=""){
					// 	DB::table('role_user')->where('user_id', $request->edit_id)
					// 	->update([
					// 		'role_id' => $request->work_role,
					// 		'updated_at' => date('Y-m-d H:i:s')
							
					// 	]);
					// }elseif($role_det== 0 && $request->work_role !=""){
					// 	DB::table('role_user')
					// 	->insert([
					// 		'role_id' => $request->work_role,
					// 		'user_id' => $request->edit_id,
					// 		'updated_at' => date('Y-m-d H:i:s'),
					// 		'created_at' => date('Y-m-d H:i:s')
							
					// 	]);
					// }
					// if ($request->exp_company_name) {
					// 	DB::table('staff_experience')->where('exp_staff_id', $request->edit_id)->delete();
					// 	$exp_name_relation = array();
					// 	foreach ($request->exp_company_name as $k => $v) {
					// 		$exp_name_relation[$k][] = $v;
					// 		if ($request->exp_job_title) {
			
					// 			foreach ($request->exp_job_title as $key => $val) {
			
					// 				if ($k == $key) {
			
					// 					$exp_name_relation[$k][] = $val;
					// 				}
					// 			}
					// 		}
					// 		if ($request->exp_from_date) {
			
					// 			foreach ($request->exp_from_date as $keys => $value) {
			
					// 				if ($k == $keys) {
			
					// 					$exp_name_relation[$k][] = $value;
					// 				}
					// 			}
					// 		}
					// 		if ($request->exp_to_date) {
			
					// 			foreach ($request->exp_to_date as $keys => $value) {
			
					// 				if ($k == $keys) {
			
					// 					$exp_name_relation[$k][] = $value;
					// 				}
					// 			}
					// 		}
			
					// 		if ($request->exp_job_desc) {
			
					// 			foreach ($request->exp_job_desc as $mKeys => $mValue) {
			
					// 				if ($k == $mKeys) {
			
					// 					$exp_name_relation[$k][] = $mValue;
					// 				}
					// 			}
					// 		}
					// 	} 
					// 	foreach ($exp_name_relation as $value) {
					// 		StaffExperience::create([
					// 			'exp_staff_id' => $request->edit_id,
					// 			'exp_job_title' => $value[1],
					// 			'exp_company_name' => $value[0],
					// 			'exp_to_date' => $value[3],
					// 			'exp_from_date' => $value[2],
					// 			'exp_job_desc' => $value[4]
					// 		]);
					// 	}
					// }
				
			}
		return response()->json(['status' => true , 'message'=>'The staff persional information has been updated']);	
	}


public function edit_payment_information($id)
	{
		Laralum::permissionToAccess('laralum.staff.edit');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		//Laralum::permissionToAccess('laralum.member.edit');
		# Check permissions to access
		// Laralum::permissionToAccess('laralum.senderid.access');
		$departments = DB::table('departments')->where('client_id', Laralum::loggedInUser()->id)->get();

		$users = DB::table('users')
				->select('id', 'name')
				->where('reseller_id', $client_id)
				->get();

		$user = Laralum::user('id', $id);

		$family_member = DB::table('staffdatas')->where('staff_id', $id)->where('staff_relation_dob', '!=', '1970-01-01')->where('staff_relation_dob', '!=', '0000-00-00')->get();

		$hire_sources = DB::table('hiresource')->where('client_id', Laralum::loggedInUser()->id)->get();
		$stafftypes = DB::table('stafftype')->where('client_id', Laralum::loggedInUser()->id)->get();
		$staffstatus = DB::table('staffstatus')->where('client_id', Laralum::loggedInUser()->id)->get();
		$designations = DB::table('designation')->where('client_id', Laralum::loggedInUser()->id)->get();
		$work_locations = DB::table('work_location')->where('client_id', Laralum::loggedInUser()->id)->get();

		$staff_experience = DB::table('staff_experience')->where('exp_staff_id', $id)->get();

		$educations = DB::table('educations')->where('staff_id', $id)->get();

		$user_detail = DB::table('user_details')->where('user_id', $id)->first();
		$roles = DB::table('roles')->select('name','id')->get();
		# Return the edit form
		return view('hyper/staff/edit_payment_information', [
			'id' =>$id,
			'family_member'  =>  $family_member,
			'staff_experience'  =>  $staff_experience,
			'educations'  =>  $educations,
			'user'  =>  $user,
			'users' => $users,
			'user_detail'  =>  $user_detail,
			'departments' => $departments,
			'roles' => $roles,
			'hire_sources' => $hire_sources,
			'stafftypes' =>$stafftypes,
			'staffstatus' =>$staffstatus,
			'designations' =>$designations,
			'work_locations'=>$work_locations
		]);
	}

	public function Update_payment_information(Request $request)
	{
		//dd($request->all());
		// die;
		//Laralum::permissionToAccess('laralum.member.edit');
		// Laralum::permissionToAccess('laralum.senderid.access');
		// $request->validate([
		// 	'name' => 'required',
		// 	'mobile' => 'required|min:10|numeric|unique:users,mobile,' . $id
		// ]);
		Laralum::permissionToAccess('laralum.staff.edit');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

		$usr_det=DB::table('user_details')->where('user_id', $request->edit_id)->first();
		
		
			if($usr_det){
				$update_details = DB::table('user_details')
					->where('user_id', $request->edit_id)
					->update([
					//department location reporting_to work_title hire_source joining_date seating_location work_status staff_type work_phone extension work_role experience
						'manual_diposit' => $request->manual_diposit,
						'cheque_diposit' => $request->cheque_diposit,
						'ac_holder_name' => $request->ac_holder_name,
						'bank_name' => $request->bank_name,
						'ac_no' => $request->ac_no,
						'ifsc' => $request->ifsc,
						'ac_type' => $request->ac_type
						
					]);
			}
		//return redirect()->route('Crm::staff')->with('success', "The staff basic information has been updated");
		return response()->json(array('status' => 'true', 'message'=>'The staff payment information has been updated'));
	}




	public function salary_preview(Request $request)
	{
		Laralum::permissionToAccess('laralum.staff.view');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$id=$request->id;
		//Laralum::permissionToAccess('laralum.member.edit');
		# Check permissions to access
		// Laralum::permissionToAccess('laralum.senderid.access');
		$departments = DB::table('departments')->where('client_id', Laralum::loggedInUser()->id)->get();

		$users = DB::table('users')
				->select('id', 'name')
				->where('reseller_id', $client_id)
				->get();

		$user = Laralum::user('id', $id);

		$hire_sources = DB::table('hiresource')->where('client_id', Laralum::loggedInUser()->id)->get();
		$stafftypes = DB::table('stafftype')->where('client_id', Laralum::loggedInUser()->id)->get();
		$staffstatus = DB::table('staffstatus')->where('client_id', Laralum::loggedInUser()->id)->get();
		$designations = DB::table('designation')->where('client_id', Laralum::loggedInUser()->id)->get();
		$work_locations = DB::table('work_location')->where('client_id', Laralum::loggedInUser()->id)->get();


		$user_detail = DB::table('user_details')->where('user_id', $id)->first();
		$roles = DB::table('roles')->select('name','id')->get();

		$org_profile = DB::table('organization_profile')
			->where('client_id', $client_id)
			->first();
		//print_r($org_profile);die;	
		# Return the edit form
		return view('hyper/staff/salary_print_preview', [
			'id' =>$id,
			'user'  =>  $user,
			'users' => $users,
			'user_detail'  =>  $user_detail,
			'departments' => $departments,
			'roles' => $roles,
			'hire_sources' => $hire_sources,
			'stafftypes' =>$stafftypes,
			'staffstatus' =>$staffstatus,
			'designations' =>$designations,
			'work_locations'=>$work_locations,
			'org_profile'  =>  $org_profile
		]);
	}


public function edit_salary_information($id)
	{
		Laralum::permissionToAccess('laralum.staff.edit');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		//Laralum::permissionToAccess('laralum.member.edit');
		$departments = DB::table('departments')->where('client_id', Laralum::loggedInUser()->id)->get();

		$users = DB::table('users')
				->select('id', 'name')
				->where('reseller_id', $client_id)
				->get();

		$user = Laralum::user('id', $id);

		$family_member = DB::table('staffdatas')->where('staff_id', $id)->where('staff_relation_dob', '!=', '1970-01-01')->where('staff_relation_dob', '!=', '0000-00-00')->get();

		$hire_sources = DB::table('hiresource')->where('client_id', Laralum::loggedInUser()->id)->get();
		$stafftypes = DB::table('stafftype')->where('client_id', Laralum::loggedInUser()->id)->get();
		$staffstatus = DB::table('staffstatus')->where('client_id', Laralum::loggedInUser()->id)->get();
		$designations = DB::table('designation')->where('client_id', Laralum::loggedInUser()->id)->get();
		$work_locations = DB::table('work_location')->where('client_id', Laralum::loggedInUser()->id)->get();

		$staff_experience = DB::table('staff_experience')->where('exp_staff_id', $id)->get();

		$educations = DB::table('educations')->where('staff_id', $id)->get();

		$user_detail = DB::table('user_details')->where('user_id', $id)->first();
		$roles = DB::table('roles')->select('name','id')->get();
		# Return the edit form
		return view('hyper/staff/edit_salary_information', [
			'id' =>$id,
			'family_member'  =>  $family_member,
			'staff_experience'  =>  $staff_experience,
			'educations'  =>  $educations,
			'user'  =>  $user,
			'users' => $users,
			'user_detail'  =>  $user_detail,
			'departments' => $departments,
			'roles' => $roles,
			'hire_sources' => $hire_sources,
			'stafftypes' =>$stafftypes,
			'staffstatus' =>$staffstatus,
			'designations' =>$designations,
			'work_locations'=>$work_locations
		]);
	}

	public function Update_salary_information(Request $request)
	{
		Laralum::permissionToAccess('laralum.staff.edit');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

		$usr_det=DB::table('user_details')->where('user_id', $request->edit_id)->first();
			if($usr_det){

				$update_details = DB::table('user_details')
				->where('user_id', $request->edit_id)
				->update([				
					'anual_ctc' => $request->anual_ctc,
					'basic_perc' => $request->basic_ctc_percentage,
					'hra_perc' => $request->hra_percentage,
					'special_allowance_per' => $request->special_allowance_percentage,
					'pf_percentage' => $request->pf_percentage,
					'esi_percentage' => $request->esi_percentage,
					'advance_percentage' => $request->advance_percentage,
					'pt_percentage' => $request->pt_percentage,
					
				]);				
			}
		return response()->json(array('status' => 'true', 'message'=>'The staff basic information has been updated'));
	}



	public function generatePayslip(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		//dd($request->all());
		$id = $request->id;
		$users = DB::table('users')->select('id', 'name')->where('id', $id)->first();
		$usr_det=DB::table('user_details')->where('user_id', $request->id)->first();
			if($usr_det){

				$update_details = DB::table('payslips')
				->insert([	
					'employee_id' => $request->id,
					'name' => $users->name,
					'anual_ctc' => $usr_det->anual_ctc,
					'basic_percentage' => $usr_det->basic_perc,
					'hra_percentage' => $usr_det->hra_perc,
					'special_allowance_per' => $usr_det->special_allowance_per,
					'pf_percentage' => $usr_det->pf_percentage,
					'esi_percentage' => $usr_det->esi_percentage,
					'advance_percentage' => $usr_det->advance_percentage,
					'pt_percentage' => $usr_det->pt_percentage,
					'payment_date' => $request->payment_date,
					'joining_date' => $usr_det->joining_date,
					
				]);				
			}
		return response()->json(array('status' => 'true', 'message'=>'The staff basic information has been updated'));
	}


	public function payslip_preview($id)
	{
		//Laralum::permissionToAccess('laralum.staff.access');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

		$users = DB::table('users')
				->select('id', 'name')
				->where('id', $id)
				->get();//echo 1;die;
		//$user = Laralum::user('id', $id);
		$user_detail = DB::table('user_details')->where('user_id', $id)->first();
		$payslips = DB::table('payslips')->where('id', $id)->first();
		$org_profile = DB::table('organization_profile')
			->where('client_id', $client_id)
			->first();
		if($payslips){
			$gross_earning = (($payslips->anual_ctc)*($payslips->basic_percentage)/(1200)) + (($payslips->anual_ctc)*($payslips->hra_percentage)/(1200)) + (($payslips->anual_ctc)*($payslips->special_allowance_per)/(1200));
       
       		$total_deduction = ((($payslips->anual_ctc)*($payslips->advance_percentage)/(1200)) + (($payslips->anual_ctc)*($payslips->pf_percentage)/(1200)) + (($payslips->anual_ctc)*($payslips->esi_percentage)/(1200)) + (($payslips->anual_ctc)*($payslips->pt_percentage)/(1200)) );
       		$net_pay = $gross_earning - $total_deduction;
       		$net_pay_word = $this->getIndianCurrency((int)($net_pay));

       		//$amount = $this->getIndianCurrency((int)($gross_earning - $total_deduction));
		}	
			//$this->number_format_short($sponser)
		//print_r($org_profile);die;	
		# Return the edit form

		return view('hyper/staff/payslip_print_preview', [
			'id' =>$id,
			//'user'  =>  $user,
			'users' => $users,
			'user_detail'  =>  $user_detail,
			'payslips'=>$payslips,
			'net_pay'=>$net_pay,
			'net_pay_word'=>$net_pay_word,
			'gross_earning'=>$gross_earning,
			'total_deduction'=>$total_deduction,
			'org_profile'  =>  $org_profile
		]);
	}



	public function getIndianCurrency(float $number)
	{
		$decimal = round($number - ($no = floor($number)), 2) * 100;
		$hundred = null;
		$digits_length = strlen($no);
		$i = 0;
		$str = array();
		$words = array(
			0 => '', 1 => 'One', 2 => 'Two',
			3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
			7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
			10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
			13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
			16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
			19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
			40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
			70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
		);
		$digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
		while ($i < $digits_length) {
			$divider = ($i == 2) ? 10 : 100;
			$number = floor($no % $divider);
			$no = floor($no / $divider);
			$i += $divider == 10 ? 1 : 2;
			if ($number) {
				$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
				$hundred = ($counter == 1 && $str[0]) ? ' And ' : null;
				$str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
			} else $str[] = null;
		}
		$Rupees = implode('', array_reverse($str));
		$paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
		return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
	}

	function number_format_short($n, $precision = 1)
	{
		if ($n < 900) {
			// 0 - 900
			$n_format = number_format($n, $precision);
			$suffix = '';
		} else if ($n < 900000) {
			// 0.9k-850k
			$n_format = number_format($n / 1000, $precision);
			$suffix = 'K';
		} else if ($n < 900000000) {
			// 0.9m-850m
			$n_format = number_format($n / 1000000, $precision);
			$suffix = 'M';
		} else if ($n < 900000000000) {
			// 0.9b-850b
			$n_format = number_format($n / 1000000000, $precision);
			$suffix = 'B';
		} else {
			// 0.9t+
			$n_format = number_format($n / 1000000000000, $precision);
			$suffix = 'T';
		}

		// Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
		// Intentionally does not affect partials, eg "1.50" -> "1.50"
		if ($precision > 0) {
			$dotzero = '.' . str_repeat('0', $precision);
			$n_format = str_replace($dotzero, '', $n_format);
		}

		return $n_format . $suffix;
	}

	public function staff_change_password(Request $request)
	{
		Laralum::permissionToAccess('laralum.staff.edit');
		// $validator = Validator::make($request->all(), [
		// 	'name' => 'required',
  //           'mobile' => 'required|min:10|numeric|unique:users,mobile'
  //       ]);
		
    //     if ($validator->fails()) {
    //         return redirect()
				// ->route('Crm::staff_create')
				// ->withErrors($validator)
				// ->withInput();
    //     }
		$update_pass = DB::table('users')
			->where('id', $request->staff_user_id)
			->update([				
				'password' => bcrypt($request->new_password),
			]);	
		return response()->json(array('status' => 'true', 'message'=>'Pass Changed'));
	}


	public function payruns(Request $request)
	{
		Laralum::permissionToAccess('laralum.staff.view');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$states = [];
		$districts = [];
		$countries = [];
		$id="";
		# Find the lead
		
		$ids = DB::table('users')->where('users.reseller_id', $client_id)->leftJoin('user_details', 'users.id', '=', 'user_details.user_id')->where('user_details.anual_ctc', '!=', 0 )->pluck('users.id');
		$payment_date = Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString();
		$net_monthly_comp_cost = 0;
		$employee_count = 0;
		foreach ($ids as $key => $value) {
			$users = DB::table('users')->select('id', 'name')->where('id', $value)->first();
			$usr_det=DB::table('user_details')->where('user_id', $value)->first();
			if($usr_det){
				$check=DB::table('payslips')->where('payment_date', $payment_date)->where('employee_id', $value)->count();
				$monthly_comp_cost = (($usr_det->anual_ctc)*($usr_det->basic_perc)/(1200)) + (($usr_det->anual_ctc)*($usr_det->hra_perc)/(1200)) + (($usr_det->anual_ctc)*($usr_det->special_allowance_per)/(1200)) - ((($usr_det->anual_ctc)*($usr_det->advance_percentage)/(1200)) + (($usr_det->anual_ctc)*($usr_det->pf_percentage)/(1200)) + (($usr_det->anual_ctc)*($usr_det->esi_percentage)/(1200)) + (($usr_det->anual_ctc)*($usr_det->pt_percentage)/(1200)) );
				$net_monthly_comp_cost = $net_monthly_comp_cost + $monthly_comp_cost;
				$employee_count = $employee_count + 1;

				if($check==0){
					$update_details = DB::table('payslips')
					->insert([
						'client_id' => $client_id,	
						'employee_id' => $users->id,
						'name' => $users->name,
						'anual_ctc' => $usr_det->anual_ctc,
						'basic_percentage' => $usr_det->basic_perc,
						'hra_percentage' => $usr_det->hra_perc,
						'special_allowance_per' => $usr_det->special_allowance_per,
						'pf_percentage' => $usr_det->pf_percentage,
						'esi_percentage' => $usr_det->esi_percentage,
						'advance_percentage' => $usr_det->advance_percentage,
						'pt_percentage' => $usr_det->pt_percentage,
						'payment_date' => $payment_date,
						'joining_date' => $usr_det->joining_date,
						
					]);		
				}else{
					$update_details = DB::table('payslips')
					->where('employee_id', $value)
					->update([	
						'client_id' => $client_id,
						'employee_id' => $users->id,
						'name' => $users->name,
						'anual_ctc' => $usr_det->anual_ctc,
						'basic_percentage' => $usr_det->basic_perc,
						'hra_percentage' => $usr_det->hra_perc,
						'special_allowance_per' => $usr_det->special_allowance_per,
						'pf_percentage' => $usr_det->pf_percentage,
						'esi_percentage' => $usr_det->esi_percentage,
						'advance_percentage' => $usr_det->advance_percentage,
						'pt_percentage' => $usr_det->pt_percentage,
						'payment_date' => $payment_date,
						'joining_date' => $usr_det->joining_date,
						
					]);
				}
							
			}
		}
		$payslips = DB::table('payslips')
					->groupBy('payment_date')
					->orderBy('payment_date', 'desc')
					->get();
//echo $net_monthly_comp_cost;die;
		# Return the view
		return view('hyper/payrun/index', [
			'payment_date' => $payment_date,
			'payslips' => $payslips,
			'net_monthly_comp_cost' => $net_monthly_comp_cost,
			'employee_count' => $employee_count,
			//'payslips' => $payslips,
			//'payslips' => $payslips,
		]);
	}


	public function payruns_preview(Request $request)
	{
		Laralum::permissionToAccess('laralum.staff.view');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$states = [];
		$districts = [];
		$countries = [];
		$id="";
		# Find the lead
		
		$ids = DB::table('users')->where('users.reseller_id', $client_id)->leftJoin('user_details', 'users.id', '=', 'user_details.user_id')->where('user_details.anual_ctc', '!=', 0 )->pluck('users.id');
		$payment_date = $request->payment_date;
		$no_of_days = Carbon::now()->subMonthsNoOverflow()->daysInMonth;

		$net_monthly_comp_cost = 0;
		$payroll_cost = 0;
		$total_deduction = 0;
		$employee_count = 0;
		foreach ($ids as $key => $value) {
			$users = DB::table('users')->select('id', 'name')->where('id', $value)->first();
			$usr_det=DB::table('user_details')->where('user_id', $value)->first();
			if($usr_det){
				$check=DB::table('payslips')->where('payment_date', $payment_date)->where('employee_id', $value)->count();
				$monthly_comp_cost = (($usr_det->anual_ctc)*($usr_det->basic_perc)/(1200)) + (($usr_det->anual_ctc)*($usr_det->hra_perc)/(1200)) + (($usr_det->anual_ctc)*($usr_det->special_allowance_per)/(1200)) - ((($usr_det->anual_ctc)*($usr_det->advance_percentage)/(1200)) + (($usr_det->anual_ctc)*($usr_det->pf_percentage)/(1200)) + (($usr_det->anual_ctc)*($usr_det->esi_percentage)/(1200)) + (($usr_det->anual_ctc)*($usr_det->pt_percentage)/(1200)) );
				$net_monthly_comp_cost = $net_monthly_comp_cost + $monthly_comp_cost;
				$payroll_cost = $payroll_cost + (($usr_det->anual_ctc)*($usr_det->basic_perc)/(1200)) + (($usr_det->anual_ctc)*($usr_det->hra_perc)/(1200)) + (($usr_det->anual_ctc)*($usr_det->special_allowance_per)/(1200));
				$total_deduction = $total_deduction + ((($usr_det->anual_ctc)*($usr_det->advance_percentage)/(1200)) + (($usr_det->anual_ctc)*($usr_det->pf_percentage)/(1200)) + (($usr_det->anual_ctc)*($usr_det->esi_percentage)/(1200)) + (($usr_det->anual_ctc)*($usr_det->pt_percentage)/(1200)) );
				$employee_count = $employee_count + 1;

				// if($check==0){
				// 	$update_details = DB::table('payslips')
				// 	->insert([
				// 		'client_id' => $client_id,	
				// 		'employee_id' => $users->id,
				// 		'name' => $users->name,
				// 		'anual_ctc' => $usr_det->anual_ctc,
				// 		'basic_percentage' => $usr_det->basic_perc,
				// 		'hra_percentage' => $usr_det->hra_perc,
				// 		'special_allowance_per' => $usr_det->special_allowance_per,
				// 		'pf_percentage' => $usr_det->pf_percentage,
				// 		'esi_percentage' => $usr_det->esi_percentage,
				// 		'advance_percentage' => $usr_det->advance_percentage,
				// 		'pt_percentage' => $usr_det->pt_percentage,
				// 		'payment_date' => $payment_date,
				// 		'joining_date' => $usr_det->joining_date,
						
				// 	]);		
				// }else{
				// 	$update_details = DB::table('payslips')
				// 	->where('employee_id', $value)
				// 	->update([	
				// 		'client_id' => $client_id,	
				// 		'employee_id' => $users->id,
				// 		'name' => $users->name,
				// 		'anual_ctc' => $usr_det->anual_ctc,
				// 		'basic_percentage' => $usr_det->basic_perc,
				// 		'hra_percentage' => $usr_det->hra_perc,
				// 		'special_allowance_per' => $usr_det->special_allowance_per,
				// 		'pf_percentage' => $usr_det->pf_percentage,
				// 		'esi_percentage' => $usr_det->esi_percentage,
				// 		'advance_percentage' => $usr_det->advance_percentage,
				// 		'pt_percentage' => $usr_det->pt_percentage,
				// 		'payment_date' => $payment_date,
				// 		'joining_date' => $usr_det->joining_date,
						
				// 	]);
				// }
							
			}
		}

		$payslips = DB::table('payslips')
			//->leftJoin('users','users.id', '=', 'payslips.employee_id')
			//->leftJoin('user_details', 'payslips.employee_id', '=', 'user_details.user_id')
			->where('payment_date', $payment_date)
			->where('client_id', $client_id)
			->orderBy('id', 'desc')
			->get();
			
			//echo "<pre>";
			//print_r($payslips);die;
//`payslips` `id``employee_id``name``payment_date``joining_date``anual_ctc``basic_percentage``hra_percentage``special_allowance_per``pf_percentage``esi_percentage``advance_percentage``pt_percentage`			
//echo $no_of_days;die;
		# Return the view
		return view('hyper/payrun/preview', [
			'payment_date' => $payment_date,
			'payslips' => $payslips,
			'net_monthly_comp_cost' => $net_monthly_comp_cost,
			'employee_count' => $employee_count,
			'no_of_days' => $no_of_days,
			'payroll_cost' => $payroll_cost,
			'total_deduction' => $total_deduction,
		]);
	}


	public function payrun_delete(Request $request)
	{
		Laralum::permissionToAccess('laralum.staff.delete');
		//Laralum::permissionToAccess('laralum.member.delete');
		# Find The Lead
		if ($request->ajax()){
			DB::beginTransaction();
		try {
			DB::table('payslips')->where('payment_date', $request->payment_date)->delete();			
		    DB::commit();
		    return response()->json(array('status' => 'true'));
		    //return redirect()->route('Crm::staff')->with('success', "The staff has been deleted");
		} catch (\Exception $e) {
		    DB::rollback();
		    //return response()->json(['error' => $ex->getMessage()], 500);
		    //return redirect()->route('Crm::staff')->with('error', 'Some problem occurred, please try again.');
		    return response()->json(array('status' => 'false'));
		}		
		}
	}

















}
