<?php
namespace App\Http\Controllers\Ivr;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator, File;
use Illuminate\Support\Str;
use Response;
use Illuminate\Validation\Rule; 
use Laralum;
use DB;
use App\Kyc;
use App\Working_Days;
use App\Role;
use App\Role_User;
use App\User;
use Hash;
use Auth;
use App\Users_Settings;

class CompleteSetupController extends Controller
{
   
	
	
    public function index() {
		
	    if(Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$get_countries = DB::table('countries')->get();
		$get_state = DB::table('state')->get();
		$industries = Laralum::getIndustries();
		$roles = Role::where('created_by', $client_id)->orWhere('id', [2])->get();
		$departments = DB::table('departments')->where('client_id', $client_id)->get();
		//echo '<pre>';print_r($roles);die;
        # Return the view
        return view('ivr/index', compact('get_state', 'get_countries', 'departments', 'industries', 'roles'));
    }
	
	public function getCity(Request $request)
	{
		$states = DB::table("district")
			->where("StCode", $request->state_id)
			->pluck("DistrictName", "DistCode");
		return response()->json($states);
	}
	
	#kyc-store-data
	public function kycStore(Request $request)
	{

		if ($IDPROOF = $request->file('id_proof')) {
			$destinationPath = public_path('ivr_public/data/id_proof');
			$id_proof = date('YmdHis') . "." . $IDPROOF->getClientOriginalExtension();
			$IDPROOF->move($destinationPath, $id_proof);
			$old_id_proof = public_path('ivr_public/data/id_proof/') . $request->id_proof_hidden;
			if (file_exists($old_id_proof)) {
				@unlink($old_id_proof);
			}
		}else{
			$id_proof = $request->id_proof_hidden;
		}
		
		if ($ADDPROOF = $request->file('address_proof')) {
			$destinationPath = public_path('ivr_public/data/address_proof');
			$address_proof = date('YmdHis') . "." . $ADDPROOF->getClientOriginalExtension();
			$ADDPROOF->move($destinationPath, $address_proof);
			$old_address_proof = public_path('ivr_public/data/address_proof/') . $request->address_proof_hidden;
			if (file_exists($old_address_proof)) {
				@unlink($old_address_proof);
			}
		}else{
			$address_proof = $request->address_proof_hidden;
		}
		
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

		$checkClient = [
			"client_id" => $client_id,
		];

		$clientdata = [
			"business_type" => $request->business_type,
			"business_name" => $request->business_name,
			"business_pan" => $request->business_pan,
			"gst_state" => $request->gst_state,
			"gstin" => $request->gstin,
			"billing_address" => $request->billing_address,
			"billing_country" => $request->billing_country,
			"billing_state" => $request->billing_state,
			"billing_city" => $request->billing_city,
			"billing_pincode" => $request->billing_pincode,
			"primary_contact_name" => $request->primary_contact_name,
			"primary_contact_email" => $request->primary_contact_email,
			"primary_contact_mobile" => $request->primary_contact_mobile,
			"designation_country" => $request->designation_country,
			"verification_type" => $request->verification_type,
			"kyc_id_proof_type" => $request->kyc_id_proof_type,
			"id_proof_doc" => $id_proof,
			"kyc_address_proof_type" => $request->kyc_address_proof_type,
			"address_proof_doc" => $address_proof
		];

       
		Kyc::updateOrCreate($checkClient, $clientdata);


		# Return the view
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}
	
	public function agentStore(Request $request)
	{
	

		$validator = \Validator::make($request->all(), [
			'full_name' => 'required',
			'email' => 'required|email|max:255|unique:users',
			'mobile_number' => 'required|max:10',
			'address' => 'required',
			'staff_status' => 'required',
			'staff_password' => 'required',
			'from_time' => 'required',
			'to_time' => 'required',
			'department' => 'required',
			'role' => 'required',
			'working_days' => 'required|min:2',
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
			$staff->department = $request->department;
			$staff->name = $request->full_name;
			$staff->email = $request->email;
			$staff->password = bcrypt($request->staff_password);
			$staff->active = 1;
			$staff->activation_key = $activation_key;
			$staff->register_ip = $register_ip;
			$staff->country_code = 'IN';
			$staff->reseller_id = Laralum::loggedInUser()->id;
			$staff->mobile = $request->mobile_number;
			$staff->address = $request->address;
			$staff->module = 'IVR';
			$staff->save();
			if ($staff->id) {
				$staffrole = new Role_User;
				$staffrole->role_id = $request->role;
				$staffrole->user_id = $staff->id;
				$staffrole->save();
				if(!empty($request->working_days)) {
					
					foreach($request->working_days as $days){
						$staffwdays = new Working_Days;
						$staffwdays->user_id = $staff->id;
						$staffwdays->work_days = $days;
						$staffwdays->from_time = $request->from_time;
						$staffwdays->to_time = $request->to_time;
						$staffwdays->save();
						
					}
					
					
				}
			}


			# Return the view
			return response()->json(array('success' => true, 'status' => 'success'), 200);
		}
	}
	
	public function departmentStore(Request $request)
	{

		# insert the data
		DB::table('departments')->insert(
			['client_id' => Laralum::loggedInUser()->id, 'department' => $request->department_name, 'created_at' => date('Y-m-d H:i:s')]
		);
		# Return the view
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}
	
	
}
