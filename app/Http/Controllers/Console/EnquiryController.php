<?php
namespace App\Http\Controllers\Console;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Enquiry;
use Laralum;
use Validator,DB,File;
class EnquiryController extends Controller
{

    public function index() {
       
        # Get all enquiry for admin      
        $enquires = DB::table('enquiry')->orderBy('id', 'DESC')->get();				
        # Return the view
        return view('console/enquiry/index', ['enquires' => $enquires]);
    }
	
	public function show($id)
     {
		 if($id){			 
			$affected = DB::table('enquiry')
              ->where('id', $id)
              ->update(['is_new' => 0]);
		 }
		 
       $enquiry = Enquiry::findOrFail($id);		
    	# Return the view
    	return view('console/enquiry/show', compact('enquiry'));
     }
	

   
	
  	
}
