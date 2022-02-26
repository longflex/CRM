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

class ManageController extends Controller
{
    public function index()
    {
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$kyc_info = DB::table('tbl_ivr_kyc')->where('client_id', $client_id)->first();
		$get_countries = DB::table('countries')->get();
		$get_state = DB::table('state')->get();
		$get_city = DB::table('district')->get();
		$industries = Laralum::getIndustries();
		$staffs = DB::table('users')
			->where('users.reseller_id', Laralum::loggedInUser()->id)
			->join('role_user', 'users.id', '=', 'role_user.user_id')
			->select('users.*', 'role_user.role_id')
			->get();
		foreach ($staffs as $staff) {
			$staff->department =  $this->getDepartment($staff->department);
			$staff->role = $this->getRole($staff->role_id);
		}
        # Return the view
        return view('ivr/manage/index', compact('get_state', 'get_city', 'get_countries', 'kyc_info', 'industries', 'staffs'));
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
	
	
}
