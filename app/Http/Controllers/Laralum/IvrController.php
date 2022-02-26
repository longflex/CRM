<?php
namespace App\Http\Controllers\Laralum;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laralum;
use DB;

class IvrController extends Controller
{
   
	
	
    public function index() {
		Laralum::permissionToAccess('laralum.ivr.dashboard');
        # Return the view
        return view('ivr/index');
    }
	
	 public function rSetting() {
        Laralum::permissionToAccess('laralum.ivr.dashboard');

		#check access permission
        // Laralum::permissionToAccess('laralum.reports.access');
		
        # Return the view
        return view('laralum/reseller-setting/index');
    }
	
	 public function myWebsite() {
        Laralum::permissionToAccess('laralum.ivr.dashboard');

		#check access permission
        // Laralum::permissionToAccess('laralum.reports.access');
		
        # Return the view
        return view('laralum/my-website/index');
    }
	
}
