<?php

namespace App\Http\Controllers\Console;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Organization;
use Illuminate\Support\Str;
use App\Bank;
use App\Http\Controllers\Laralum\Laralum as LaralumLaralum;
use App\Permission;
use App\Role;
use App\Role_User;
use App\TimeSlot;
use App\User;
use Hash;
use Auth;
use Laralum;
use App\Users_Settings;

use DB;
use Response;

class ProfileController extends Controller
{
	/**
	 * Show the profile edit page
	 */
	public function index()
	{

		$allcountry = Laralum::countries();
		$industry = Laralum::getIndustries();
		# Get all the data
		$data = DB::table('users')->where('id', Laralum::loggedInUser()->id)->first();
		$staffs = DB::table('users')
			->where('users.reseller_id', Laralum::loggedInUser()->id)
			->join('role_user', 'users.id', '=', 'role_user.user_id')
			->select('users.*', 'role_user.role_id')
			->get();
		foreach ($staffs as $staff) {
			$staff->department =  $this->getDepartment($staff->department);
			$staff->role = $this->getRole($staff->role_id);
		}
		$branches = DB::table('branch')->where('client_id', Laralum::loggedInUser()->id)->get();
		$requests = DB::table('prayer_requests')->where('user_id', Laralum::loggedInUser()->id)->get();
		$sources = DB::table('member_sources')->where('user_id', Laralum::loggedInUser()->id)->get();
		$accounttypes = DB::table('member_accounttypes')->where('user_id', Laralum::loggedInUser()->id)->get();
		$membertypes = DB::table('member_types')->where('user_id', Laralum::loggedInUser()->id)->get();
		$donationtypes = DB::table('donation_type')->where('user_id', Laralum::loggedInUser()->id)->get();
		$donationpurposes = DB::table('donation_purpose')->where('user_id', Laralum::loggedInUser()->id)->get();
		$departments = DB::table('departments')->where('client_id', Laralum::loggedInUser()->id)->get();
		$org_profile = DB::table('organization_profile')->where('client_id', Laralum::loggedInUser()->id)->first();
		$bank_details = DB::table('bank_details')->where('user_id', Laralum::loggedInUser()->id)->get();
		$apt_staff = DB::table('users')->where('reseller_id', Laralum::loggedInUser()->id)->where('isAptMeet', 1)->get();
		$templates = DB::table('sms_templates')->get();

		$apt_time_slot = DB::table('time_slots')
			->where('time_slots.client_id', Laralum::loggedInUser()->id)
			->join('users', 'users.id', '=', 'time_slots.staff_id')
			->select('time_slots.*', 'users.name')
			->paginate(6);


		if(Laralum::loggedInUser()->id == 1){
			# Get all the roles
			$roles = Role::whereNotIn('id', [1])->get();
		}else{
			# Get current user role
			$roles = Role::where('created_by', Laralum::loggedInUser()->id)->orWhere('id', [2])->get();
		}
		// echo "<pre>";
		// print_r($roles);die;
		//dd($roles);
		
		$permissions = Permission::all();
		# Get Default Role
		$default_role = Role::findOrFail(Users_Settings::first()->default_role);
		return view('hyper.organize.profile.index', [
			'datas' => $data,
			'org_profile' => $org_profile,
			'bank_details' => $bank_details,
			'branches' => $branches,
			'templates' => $templates,
			'requests' => $requests,
			'membertypes' => $membertypes,
			'donationtypes' => $donationtypes,
			'donationpurposes' => $donationpurposes,
			'accounttypes' => $accounttypes,
			'sources' => $sources,
			'departments' => $departments,
			'countries'  => $allcountry,
			'industries'  => $industry,
			'permissions' => $permissions,
			'roles'  => $roles,
			'default_role' => $default_role,
			'staffs'  => $staffs,
			'apt_staffs'  => $apt_staff,
			'apt_time_slots'  => $apt_time_slot,
		]);
	}
	/**
	 * Update the user profile
	 *
	 * @param $request
	 */
	public function showStaff(Request $request, $id)
	{
		$roles = Role::whereNotIn('id', [1, 2])->get();
		$branches = DB::table('branch')->where('client_id', Laralum::loggedInUser()->id)->get();
		$departments = DB::table('departments')->where('client_id', Laralum::loggedInUser()->id)->get();
		$staff = DB::table('users')
			->where('users.id', $id)
			->join('role_user', 'users.id', '=', 'role_user.user_id')
			->select('users.*', 'role_user.role_id')
			->first();
		return view('console/profile/staff_view', [
			'branches' => $branches,
			'departments' => $departments,
			'roles'  => $roles,
			'staff'  => $staff,

		]);
	}
	public function showRoleUser(Request $request, $id)
	{

		$staff = DB::table('roles')
			->where('roles.id', $id)
			->join('role_user', 'roles.id', '=', 'role_user.role_id')
			->join('users', 'users.id', '=', 'role_user.user_id')
			->select('users.*', 'role_user.role_id', 'roles.name as Role')
			->get();
		return view('console/profile/role_user', [
			'staff'  => $staff,

		]);
	}

	public function generalData(Request $request)
	{
		$fullname = $request->fullname;
		$altemail = $request->altemail;
		$altcontact = $request->altcontact;
		# update the data
		DB::table('users')->where('id', Laralum::loggedInUser()->id)->update(['name' => $fullname, 'alt_email' => $altemail, 'alt_mobile' => $altcontact]);
		# Return the view
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}

	public function createStaffData(Request $request)
	{


		$validator = \Validator::make($request->all(), [
			'staff_name' => 'required',
			'email' => 'required|email|max:255|unique:users',
			'staff_phone' => 'required|max:10',
			'staff_password' => 'required',
			'staff_branch' => 'required',
			'staff_department' => 'required',
			'staff_role' => 'required',
		]);

		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()->all(), 'status' => 'error']);
		} else {
			# Setup a random activation key
			$activation_key = Str::random(25);
			# Get the register IP
			$register_ip = Laralum::getIP();

			#staff data the data
			$staff = new User;
			$staff->branch = $request->staff_branch;
			$staff->department = $request->staff_department;
			$staff->name = $request->staff_name;
			$staff->email = $request->email;
			$staff->password = bcrypt($request->staff_password);
			$staff->active = 1;
			$staff->activation_key = $activation_key;
			$staff->register_ip = $register_ip;
			$staff->country_code = 'IN';
			$staff->reseller_id = Laralum::loggedInUser()->id;
			$staff->mobile = $request->staff_phone;
			$staff->isAptMeet = $request->appointment_meet;
			$staff->save();
			if ($staff->id) {
				$staffrole = new Role_User;
				$staffrole->role_id = $request->staff_role;
				$staffrole->user_id = $staff->id;
				$staffrole->save();
			}


			# Return the view
			return response()->json(array('success' => true, 'status' => 'success'), 200);
		}
	}

	#staff-edit-form
	public function updateStaffData(Request $request)
	{
		DB::table('users')->where('id', $request->staff_id)->update([
			'name' => $request->staff_name,
			'email' => $request->staff_email,
			'mobile' => $request->staff_phone,
			'branch' => $request->staff_branch,
			'department' => $request->staff_department,
			'isAptMeet' => $request->appointment_meet
		]);
		DB::table('role_user')->where('user_id', $request->staff_id)->update([
			'role_id' => $request->staff_role,
		]);
		# Return the view
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}
	#staff-edit-form

	#time-slot-store-data
	public function timeSlotData(Request $request)
	{
		#staff data the data
		for ($i = 0; $i < count($request->slot_time); $i++) {
			$data[] = [
				'client_id' => Laralum::loggedInUser()->id,
				'staff_id' => $request->apt_staff,
				'slot_date' => $request->slot_date,
				'slot_time' => $request->slot_time[$i],
				'created_at' => date('Y-m-d H:i:s')
			];
		}
		TimeSlot::insert($data);

		# Return the view
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}
	#time-slot-store-data

	#time-slot-update-data
	public function UpdateTimeSlotData(Request $request)
	{

		DB::table('time_slots')
			->where('id', $request->edit_timeslot_id)
			->update([
				'slot_date' => $request->edit_timeslot_date,
				'slot_time' => $request->edit_timeslot_time,
				'updated_at' => date('Y-m-d H:i:s')
			]);

		# Return the view
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}
	#time-slot-update-data

	#org-data-store-data
	public function orgData(Request $request)
	{

		if ($files = $request->file('org_logo')) {
			$destinationPath = public_path('console_public/data/organization');
			$org_logo = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($destinationPath, $org_logo);
			$old_image = public_path('console_public/data/organization/') . $request->org_logo_hidden;
			if (file_exists($old_image)) {
				@unlink($old_image);
			}
		} else {

			$org_logo = $request->org_logo_hidden;
		}

		$checkClient = [
			"client_id" => Laralum::loggedInUser()->id,
		];

		$clientdata = [
			"organization_name" => $request->organization_name,
			"company_id" => $request->company_id,
			"industry" => $request->industry,
			"business_location" => $request->business_location,
			"organization_logo" => $org_logo,
			"company_address_line1" => $request->address1,
			"company_address_line2" => $request->address2
		];

		Organization::updateOrCreate($checkClient, $clientdata);


		# Return the view
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}

	public function callPurposeData(Request $request)
	{
        if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		# insert the data
		$id = DB::table('call_purposes')->insertGetId(
			['client_id' => $client_id, 'purpose' => $request->call_purpose, 'created_at' => date('Y-m-d H:i:s')]
		);
		return response()->json(array('success' => true, 'status' => true, 'id'=> $id), 200);
		
		
	}

	public function branchData(Request $request)
	{
        if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		# insert the data
		$id = DB::table('branch')->insertGetId(
			['client_id' => $client_id, 'branch' => $request->branch, 'created_at' => date('Y-m-d H:i:s')]
		);
		
		# Return the view
		if($request->module=='member'){
			$branches = DB::table('branch')->where('client_id', $client_id)->get();
			$list="";
			foreach($branches as $branch){
				$list .= "<option value='" . $branch->branch . "'>" . $branch->branch . "</option>";
			}
			return response()->json($list);
		}else{
			$msg=DB::table('branch')->where('client_id', $client_id)->get();
			return response()->json(array('success' => true, 'status' => true, 'id'=> $id, 'message'=>$msg), 200);
		}
	}
	public function memberData(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$msg="";
		# insert the data
		if ($request->type == 0) {
			if ($request->account_type == null)
				$request->account_type = $request->detail;
			DB::table('member_accounttypes')->insert(
				['user_id' => $client_id, 'type' => $request->account_type, 'created_at' => date('Y-m-d H:i:s')]
			);
			$msg= DB::table('member_accounttypes')->where('user_id', $client_id)->get();
		} else if ($request->type == 1) {
			if ($request->member_type == null)
				$request->member_type = $request->detail;
			DB::table('member_types')->insert(
				['user_id' => $client_id, 'type' => $request->member_type, 'created_at' => date('Y-m-d H:i:s')]
			);
			$msg= DB::table('member_types')->where('user_id', $client_id)->get();
		} else if ($request->type == 2) {
			if ($request->source == null)
				$request->source = $request->detail;
			DB::table('member_sources')->insert(
				['user_id' => $client_id, 'source' => $request->source, 'created_at' => date('Y-m-d H:i:s')]
			);
			$msg= DB::table('member_sources')->where('user_id', $client_id)->get();
		}
		
		# Return the view
		if($request->module=='member'){
			$membertypes = DB::table('member_types')->where('user_id', $client_id)->get();
			$list="";
			foreach($membertypes as $type){
				$list .= "<option value='" . $type->type . "'>" . $type->type . "</option>";
			}
			return response()->json($list);
		}else{
			
			return response()->json(array('success' => true, 'status' => true , 'message'=>$msg), 200);
		}
		
	}

	public function donationData(Request $request)
	{
		# insert the data
		if ($request->type == 0) {

			DB::table('donation_type')->insert(
				['user_id' => Laralum::loggedInUser()->id, 'type' => $request->data, 'created_at' => date('Y-m-d H:i:s')]
			);
		} else if ($request->type == 1) {
			DB::table('donation_purpose')->insert(
				['user_id' => Laralum::loggedInUser()->id, 'purpose' => $request->data, 'created_at' => date('Y-m-d H:i:s')]
			);
		} else if ($request->type == 2) {
			if ($request->source == null)
				$request->source = $request->detail;
			DB::table('member_sources')->insert(
				['user_id' => Laralum::loggedInUser()->id, 'source' => $request->source, 'created_at' => date('Y-m-d H:i:s')]
			);
		}
		# Return the view
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}
	public function updateMemberData(Request $request)
	{
		# insert the data
		if ($request->type == 0)
			DB::table('member_accounttypes')->where('id', $request->id)->update(['type' => $request->editAccountType, 'updated_at' => date('Y-m-d H:i:s')]);

		else if ($request->type == 1)
			DB::table('member_types')->where('id', $request->id)->update(['type' => $request->editMemberType, 'updated_at' => date('Y-m-d H:i:s')]);

		else if ($request->type == 2)
			DB::table('member_sources')->where('id', $request->id)->update(['source' => $request->editSource, 'updated_at' => date('Y-m-d H:i:s')]);

		# Return the view
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}

	public function updateDonationData(Request $request)
	{
		# insert the data
		if ($request->type == 0)
			DB::table('donation_type')->where('id', $request->id)->update(['type' => $request->editDonationType, 'updated_at' => date('Y-m-d H:i:s')]);
		else if ($request->type == 1)
			DB::table('donation_purpose')->where('id', $request->id)->update(['purpose' => $request->editDonationPurpose, 'updated_at' => date('Y-m-d H:i:s')]);

		else if ($request->type == 2)
			DB::table('member_sources')->where('id', $request->id)->update(['source' => $request->editSource, 'updated_at' => date('Y-m-d H:i:s')]);

		# Return the view
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}

	public function updateBranchData(Request $request)
	{
		# update the data
		DB::table('branch')->where('id', $request->editbranchid)->update(['branch' => $request->editbranch, 'updated_at' => date('Y-m-d H:i:s')]);
		# Return the view
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}

	public function departmentData(Request $request)
	{

		# insert the data
		$id = DB::table('departments')->insertGetId(
			['client_id' => Laralum::loggedInUser()->id, 'department' => $request->department, 'created_at' => date('Y-m-d H:i:s')]
		);
		$msg=DB::table('departments')->where('client_id',Laralum::loggedInUser()->id)->get();
		# Return the view
		return response()->json(array('success' => true, 'status' => true, 'id'=> $id, 'message' => $msg), 200);
	}

	public function insertDonationpurpose(Request $request)
	{   
	    if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		# insert the data
		$id = DB::table('donation_purpose')->insertGetId(
			['user_id' => Laralum::loggedInUser()->id, 'purpose' => $request->purpose, 'created_at' => date('Y-m-d H:i:s')]
		);
		# Return the view
		if($request->module=='member'){
			$donation_purposes = DB::table('donation_purpose')->where('user_id', $client_id)->get();
			$list="";
			foreach($donation_purposes as $purpose){
				$list .= "<option value='" . $purpose->id . "'>" . $purpose->purpose . "</option>";
			}
			return response()->json($list);
		}else{
			return response()->json(array('success' => true, 'status' => true, 'id'=> $id), 200);
		}
	}


	public function requestData(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		# insert the data
		DB::table('prayer_requests')->insert(
			['user_id' => $client_id, 'prayer_request' => $request->prayer_request, 'created_at' => date('Y-m-d H:i:s')]
		);
		# Return the view
		return response()->json(array('success' => true, 'status' => true), 200);
	}

	public function updateDepartmentData(Request $request)
	{

		# update the data
		DB::table('departments')->where('id', $request->editdepartmentid)->update(['department' => $request->editdepartment, 'updated_at' => date('Y-m-d H:i:s')]);
		# Return the view
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}

	public function updateRequestData(Request $request)
	{

		# update the data
		DB::table('prayer_requests')->where('id', $request->editrequestid)->update(['prayer_request' => $request->editrequest, 'updated_at' => date('Y-m-d H:i:s')]);
		# Return the view
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}

	public function delDepartmentBranchData(Request $request)
	{

		# delete the data
		if ($request->dtype == "branch") {
			DB::table('branch')->where('id', $request->id)->delete();
		} else if ($request->dtype == "staff") {
			DB::table('users')->where('id', $request->id)->delete();
		} else if ($request->dtype == "timeslot") {
			DB::table('time_slots')->where('id', $request->id)->delete();
		} else if ($request->dtype == "source") {
			DB::table('member_sources')->where('id', $request->id)->delete();
		} else if ($request->dtype == "member_type") {
			DB::table('member_types')->where('id', $request->id)->delete();
		} else if ($request->dtype == "account_type") {
			DB::table('member_accounttypes')->where('id', $request->id)->delete();
		} else if ($request->dtype == "donation_type") {
			DB::table('donation_type')->where('id', $request->id)->delete();
		} else if ($request->dtype == "donation_purpose") {
			DB::table('donation_purpose')->where('id', $request->id)->delete();
		} else if ($request->dtype == "request") {
			DB::table('prayer_requests')->where('id', $request->id)->delete();
		} else {
			DB::table('departments')->where('id', $request->id)->delete();
		}
		# Return the view
		return response()->json(array('success' => true, 'status' => true), 200);
	}

	public function bankDetailsData(Request $request)
	{

		$checkClient = [
			"id" => $request->details_id,
		];

		$clientdata = [
			"user_id" => Laralum::loggedInUser()->id,
			"bank" => $request->bank_name,
			"ifsc_code" => $request->ifsc_code,
			"ac_number" => $request->account_no,
			"ac_name" => $request->account_holder_name,
			"address" => $request->bank_branch
		];

		Bank::updateOrCreate($checkClient, $clientdata);


		# Return the view
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}

	public function razorPayData(Request $request)
	{
		$user = Laralum::loggedInUser();
		$user->RAZOR_KEY = $request->razorpay_key;
		$user->RAZOR_SECRET = $request->razorpay_secrey_key;
		$user->save();


		# Return the view
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}

	public function changePassword(Request $request)
	{

		$row = Laralum::loggedInUser();


		if (Hash::check($request->current_password, $row->password)) {
			# Password correct, setup the new password and redirect with confirmation
			$password = bcrypt($request->new_password);
			DB::table('users')->where('id', Laralum::loggedInUser()->id)->update(['password' => $password]);

			return response()->json(array('success' => true, 'status' => 'password_changed'), 200);
		} else {
			# Password not correct, redirect back with error
			return response()->json(array('error' => true, 'status' => 'incurrect_password'), 200);
		}
	}
	public function getBranch($id)
	{

		$branch_name = DB::table('branch')->select('branch')->where('id', $id)->first();
		if ($branch_name != null) {
			return $branch_name->branch;
		} else {
			return '';
		}
	}

	public function getDepartment($id)
	{

		$department_name = DB::table('departments')->select('department')->where('id', $id)->first();
		if ($department_name != null) {
			return $department_name->department;
		} else {
			return '';
		}
	}

	public function getRole($id)
	{

		$role_name = DB::table('roles')->select('name')->where('id', $id)->first();
		if ($role_name != null) {
			return $role_name->name;
		} else {
			return '';
		}
	}

	public function callingAccess(Request $request)
	{

		if ($request->access_user_id) {
			$token = "e56ef939c3d5b2d51d5de13d3170a477";
			$name = $request->access_user_name;
			$contact_number = $request->access_user_mobile;
			$country_code = 91;
			$extension = $request->ext_no;
			//Prepare you post parameters
			$postData = array('token' => $token, 'name' => $name, 'contact_number' => $contact_number, 'country_code' => $country_code, 'extension' => $extension);
			//API URL
			$url = "https://developers.myoperator.co/user";
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
			if ($response['status'] == 'success') {
				DB::table('users')
					->where('id', $request->access_user_id)
					->update(['ivr_access' => 1, 'ivr_uuid' => $response['uuid'], 'ivr_extension' => $extension]);
			}


			//Print error if any
			if (curl_errno($ch)) {
				echo 'error:' . curl_error($ch);
			}
			curl_close($ch);
		}

		return Response::json($response);
	}

	#update_sms_fields_data
	public function updateSMSFieldData(Request $request)
	{
		
		$data = $request->all();
		
		foreach ($data as $key => $value) {
			
			$id = explode('_', $key, 2);
			if(str_contains($key,'status_')){
				DB::table('sms_templates')->where('id',$id[1])->update(['status' => 1]);
			}
			
			if (str_contains($key,'template_'))
				DB::table('sms_templates')->where('id', $id[1])->update(['template' => $value]);

			 if (str_contains($key,'period_')&& $value != 'Select') {
				DB::table('sms_templates')->where('id', $id[1])->update(['period' => $value]);
			}
			
		}
		# Return the view
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}
	#update_sms_fields_data


	#faruk

	public function hireOfSource(Request $request)
	{
		// dd($request->all());
		# insert the data
		$id = DB::table('hiresource')->insertGetId(
			['client_id' => Laralum::loggedInUser()->id, 'hire_source' => $request->source_hire, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
		);
		$msg=DB::table('hiresource')->where('client_id', Laralum::loggedInUser()->id)->get();
		# Return the view
		return response()->json(array('success' => true, 'status' => true, 'id'=> $id, 'message' => $msg), 200);
	}

	public function workStatusAdd(Request $request)
	{
		// dd($request->all());
		# insert the data
		$id = DB::table('staffstatus')->insertGetId(
			['client_id' => Laralum::loggedInUser()->id, 'status' => $request->work_status, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
		);
		$msg=DB::table('staffstatus')->where('client_id', Laralum::loggedInUser()->id)->get();
		# Return the view
		return response()->json(array('success' => true, 'status' => true, 'id'=> $id, 'message' => $msg), 200);
	}

	public function staffTypeAdd(Request $request)
	{
		// dd($request->all());
		# insert the data
		$id = DB::table('stafftype')->insertGetId(
			['client_id' => Laralum::loggedInUser()->id, 'type' => $request->staff_type, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
		);
		$msg=DB::table('stafftype')->where('client_id', Laralum::loggedInUser()->id)->get();
		# Return the view
		return response()->json(array('success' => true, 'status' => true, 'id'=> $id, 'message' => $msg), 200);
	}

	public function designationAdd(Request $request)
	{
		// dd($request->all());
		# insert the data
		$id = DB::table('designation')->insertGetId(
			['client_id' => Laralum::loggedInUser()->id, 'designation' => $request->designation, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
		);
		$msg=DB::table('designation')->where('client_id', Laralum::loggedInUser()->id)->get();
		# Return the view
		return response()->json(array('success' => true, 'status' => true, 'id'=> $id, 'message' => $msg), 200);
	}

	public function workLocationAdd(Request $request)
	{
		// dd($request->all());
		# insert the data
		$id = DB::table('work_location')->insertGetId(
			['client_id' => Laralum::loggedInUser()->id, 'work_location' => $request->work_location, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
		);
		$msg=DB::table('work_location')->where('client_id', Laralum::loggedInUser()->id)->get();
		# Return the view
		return response()->json(array('success' => true, 'status' => true, 'id'=> $id, 'message' => $msg), 200);
	}
	public function preferredLanguageAdd(Request $request)
	{
		// dd($request->all());
		# insert the data
		$id = DB::table('preferred_languages')->insertGetId(
			['client_id' => Laralum::loggedInUser()->id, 'preferred_language' => $request->preferred_language, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
		);
		$msg=DB::table('preferred_languages')->where('client_id', Laralum::loggedInUser()->id)->get();
		# Return the view
		return response()->json(array('success' => true, 'status' => true, 'id'=> $id, 'message' => $msg), 200);
	}
	public function leadResponseAdd(Request $request)
	{
		// dd($request->all());
		# insert the data
		$id = DB::table('lead_responses')->insertGetId(
			['client_id' => Laralum::loggedInUser()->id, 'lead_response' => $request->lead_response, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
		);
		$msg=DB::table('lead_responses')->where('client_id', Laralum::loggedInUser()->id)->get();
		# Return the view
		return response()->json(array('success' => true, 'status' => true, 'id'=> $id, 'message' => $msg), 200);
	}
	public function leadStatusAdd(Request $request)
	{
		// dd($request->all());
		$lead_data=DB::table('lead_statuses')->where('client_id', Laralum::loggedInUser()->id)->orderBy('id', 'desc')->first();
		//dd($lead_data);
		if($lead_data){//echo 1;die;
			$status_no=$lead_data->lead_status + 1;
		}else{//echo 123;die;
			$status_no=1;
		}
		
		# insert the data
		$id = DB::table('lead_statuses')->insertGetId(
			['client_id' => Laralum::loggedInUser()->id, 'lead_status' => $status_no, 'description' => $request->lead_status,'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
		);
		$msg=DB::table('lead_statuses')->where('client_id', Laralum::loggedInUser()->id)->orderBy('id', 'desc')->first();
		# Return the view
		return response()->json(array('success' => true, 'status' => true, 'id'=> $id, 'message' => $msg), 200);
	}
}
