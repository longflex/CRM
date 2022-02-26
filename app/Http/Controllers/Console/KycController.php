<?php
namespace App\Http\Controllers\Console;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Testimonial;
use App\Industries;
use App\User;
use Laralum;
use Validator,DB,File;
class KycController extends Controller
{

    public function index() {
       
        # Get all kyc for admin      
        $kyc_info = DB::table('tbl_ivr_kyc')->orderBy('created_at', 'DESC')->get();	
		foreach ($kyc_info as $info) {
			$cinfo = DB::table('users')->where('id', $info->client_id)->first();	
			$info->client = $cinfo->name;
			$info->email = $cinfo->email;
			$info->mobile = $cinfo->mobile;
		}		
        # Return the view
        return view('console/kyc/index', ['kyc_info' => $kyc_info]);
    }

    
    #update delete record
	public function edit($id)
    {
        # Check permissions to access
        Laralum::permissionToAccess('laralum.senderid.access');       
      
        # Find the industries
        $industries = Laralum::industries('id', $id);       
        # Return the edit form
        return view('console/kyc/edit', ['industries'  =>  $industries ]);
    }
	public function Update(Request $request, $id)
	{
			
		Laralum::permissionToAccess('laralum.senderid.access');
		
		
		$request->validate([
			'title' => 'required',
			'description' => 'required'			
	    ]);
		
		if ($files = $request->file('icon')) {
		   request()->validate([
              'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           ]);
			
           $destinationPath = public_path('console_public/data/industries');
           $icon = date('YmdHis') . "." . $files->getClientOriginalExtension();
           $files->move($destinationPath, $icon);
		   $old_image = public_path('console_public/data/industries/').$request->icon_hidden;
			if (file_exists($old_image)) {
			   @unlink($old_image);
			}
        }else{
			
			$icon = $request->icon_hidden;
		}
		 		 				
        $update = DB::table('industries')
                ->where('id', $id)
                ->update([
				   'title' => $request->title, 
				   'icon' => $icon, 
				   'description' => $request->description, 
			]);

		return redirect()->route('console::industries')->with('success', "The industries has been edited");
	}

	
	public function destroy(Request $request)
    {
        Laralum::permissionToAccess('laralum.senderid.access');
            
        if($request->id){
	       DB::table('industries')->where('id', $request->id)->delete();		   
		   $returnData = array(
				'status' => 'success',
				'message' => 'Industries has been deleted!'
			); 
	   }else{		   
		   $returnData = array(
				'status' => 'error',
				'message' => 'Something went wrong, please try again.'
			); 		   
	   }
       
       return response()->json($returnData);
       
    }
	
  	
}
