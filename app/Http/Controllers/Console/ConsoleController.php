<?php
namespace App\Http\Controllers\Console;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laralum;
use DB;
class ConsoleController extends Controller
{
    public function index()
    {
		$get_api_key = DB::table('auth_key')->where('user_id', Laralum::loggedInUser()->id)->where('status', 1)->first(); 
		$org_profile_exist = DB::table('organization_profile')->where('client_id', Laralum::loggedInUser()->id)->first();
		$org_profile_branch_exist = DB::table('branch')->where('client_id', Laralum::loggedInUser()->id)->get();
		$org_profile_department_exist = DB::table('departments')->where('client_id', Laralum::loggedInUser()->id)->get();
		
		$org_progress = isset($org_profile_exist)? 10 : 0;
		$org_branch_progress = count($org_profile_branch_exist)>0 ? 10 : 0;
		$org_department_progress = count($org_profile_department_exist)>0 ? 10 : 0;
		$total_progress = $org_progress+$org_branch_progress+$org_department_progress;
		# Return the view
         return view('console/index',[
            'total_progress' => $total_progress,
            'api_keys' => $get_api_key,
        ]);
    }
}
