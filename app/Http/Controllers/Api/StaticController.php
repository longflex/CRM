<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laralum;
use Auth;
use DB;
class StaticController extends Controller
{
    public function textsms()
    {
         return view('api/text-sms/send-sms');
    }
    
	public function xmlsendsms()
    {
         return view('api/text-sms/xml-send-sms');
    }
	
	public function errorcode()
    {
         return view('api/text-sms/error-code');
    }
	
	public function deliveryreport()
    {
         return view('api/text-sms/delivery-report');
    }
	
	#sample code method
	
	 public function php()
    {
         return view('api/sample-code/php-send-sms');
    }
    
	public function python()
    {
         return view('api/sample-code/python-send-sms');
    }
	
	public function java()
    {
         return view('api/sample-code/java-send-sms');
    }
	
	public function javaxml()
    {
         return view('api/sample-code/java-for-xml-send-sms');
    }
	 public function usingC()
    {
         return view('api/sample-code/c-send-sms');
    }
    
	public function appscript()
    {
         return view('api/sample-code/google-appscript-send-sms');
    }
	
	public function window8c()
    {
         return view('api/sample-code/windows8-c-send-sms');
    }
	
	public function android()
    {
         return view('api/sample-code/android-send-sms');
    }
	 public function ios()
    {
         return view('api/sample-code/ios-send-sms');
    }
    
	public function vb6()
    {
         return view('api/sample-code/vb6-send-sms');
    }
	
	public function oracle()
    {
         return view('api/sample-code/oracle-send-sms');
    }
	
	public function goLang()
    {
         return view('api/sample-code/send-sms-in-go-language');
    }
	
	public function mainerrorcode()
    {
         return view('api/error-code/error-code');
    }
	
	#basic code method
	
	public function route()
    {

		$get_api_key = DB::table('auth_key')->where('user_id', Laralum::loggedInUser()->id)->where('status', 1)->first(); 
		//echo '<pre>';print_r($get_api_key);die;
         return view('api/basic/route-balance',[
            'api_keys' => $get_api_key,
        ]);
    }
	
	public function changepassword()
    {
         return view('api/basic/change-password');
    }
	
	public function validation()
    {
         return view('api/basic/validation');
    }
	
	public function optout()
    {
         return view('api/basic/opt-out');
    }
	
	public function errorcodebasic()
    {
         return view('api/basic/error-code');
    }
   
}
