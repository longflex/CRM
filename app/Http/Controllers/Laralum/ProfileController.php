<?php

namespace App\Http\Controllers\laralum;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Hash;
use Auth;
use Laralum;
use DB;

class ProfileController extends Controller
{
    /**
     * Show the profile edit page
     */
	 public function index() {
		 
        $allcountry = Laralum::countries();
		$industry = Laralum::getIndustries();
        # Get all the data
        $data = DB::table('users')->where('id', Laralum::loggedInUser()->id)->first();   
        
        return view('laralum/profile/index', [
            'datas' => $data,
			'countries'  => $allcountry,  
            'industries'  => $industry, 
        ]);
    } 
	 /**
     * Update the user profile
     *
     * @param $request
     */ 
	 
    public function generalData(Request $request){
		
	    $fullname = $request->fname;
	    $altemail = $request->altemail;
	    $altcontact = $request->altcontact;
        # update the data
		DB::table('users')->where('id', Laralum::loggedInUser()->id)->update(['name' => $fullname, 'alt_email' => $altemail, 'alt_mobile' => $altcontact]);
    	# Return the view
    	 return response()->json(array('success' => true, 'status' => 'success'), 200);
    }
    
	 public function billingData(Request $request){
		 
	    $company = $request->company;
	    $address = $request->address;
	    $city = $request->city;
		$zipcode = $request->zipcode;
	    $country = $request->country;
	    $gstno = $request->gstno;
        # update the data
		DB::table('users')->where('id', Laralum::loggedInUser()->id)->update(['company' => $company, 'address' => $address, 'city' => $city, 'zip' => $zipcode, 'country_code' => $country, 'gst_no' => $gstno]);
    	# Return the view
    	 return response()->json(array('success' => true, 'status' => 'success'), 200);
    }
	
	 public function accountData(Request $request){
		 
	    $senderid = $request->senderid;
	    $industry = $request->industry;
	    $timezon = $request->timezon;
        # update the data
		DB::table('users')->where('id', Laralum::loggedInUser()->id)->update(['default_senderid' => $senderid, 'industry' => $industry, 'timezone' => $timezon]);
    	# Return the view
    	 return response()->json(array('success' => true, 'status' => 'success'), 200);
    }

     public function changePassword(Request $request){
		 
	   $row = Laralum::loggedInUser();


        if (Hash::check($request->current_password, $row->password )){
            # Password correct, setup the new password and redirect with confirmation
             $password = bcrypt($request->new_password);
            DB::table('users')->where('id', Laralum::loggedInUser()->id)->update(['password' => $password]);

           return response()->json(array('success' => true, 'status' => 'password_changed'), 200);
        } else {
            # Password not correct, redirect back with error
			return response()->json(array('error' => true, 'status' => 'incurrect_password'), 200);
           
        }
		
    	 
    }
   
    
}
