<?php
namespace App\Http\Controllers\Ivr;
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
	
	 
	
}
