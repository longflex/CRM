<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use App\Enquiry;

class ContactController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {	
		
		$content = DB::table('pages')->where('type', 7)->first();
		return view('contacts', compact('content')); 

    	
    }
	
	public function sendEmail(Request $request)
    {
		
		
		$request->validate([
			'name_field' => 'required',
			'email_field' => 'required|email',
			'mobile_field' => 'required|min:10|numeric',
			'msg_field' => 'required',
		]);
		
		$enquiry = new Enquiry;
		$enquiry->name = $request->name_field;
		$enquiry->email = $request->email_field;
		$enquiry->phone = $request->mobile_field;
		$enquiry->message = $request->msg_field;						
		$enquiry->save();
		
		return redirect()->route('contact_us')->with('success', "The Request has been submitted");
		
		 
    }
	
	
}
