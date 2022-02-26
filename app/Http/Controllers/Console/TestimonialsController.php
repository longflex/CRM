<?php
namespace App\Http\Controllers\Console;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Testimonial;
use App\User;
use Laralum;
use Validator,DB,File;
class TestimonialsController extends Controller
{

    public function index() {
        // Laralum::permissionToAccess('laralum.senderid.access');
        # Get all testimonials for admin      
        $testimonials = DB::table('testimonials')->get();				
        # Return the view
        return view('console/testimonial/index', ['testimonials' => $testimonials]);
    }

    public function create()
    {
        // Laralum::permissionToAccess('laralum.senderid.access');

     
        # Return the view
        return view('console/testimonial/create');
    }

    public function store(Request $request)
    {
		
		# Check permissions
        // Laralum::permissionToAccess('laralum.senderid.access');
        
	    $request->validate([
			'company_name' => 'required',
			'company_comment' => 'required'			
	    ]);
		
		if ($files = $request->file('company_logo')) {
		   request()->validate([
              'company_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           ]);
			
           $destinationPath = public_path('console_public/data/testimonial');
           $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
           $files->move($destinationPath, $profileImage);
        }else{
			$profileImage ="";
		}
		
		$testimonial = new Testimonial;
		$testimonial->company_name = $request->company_name;
		$testimonial->company_logo = $profileImage;
		$testimonial->company_url = $request->company_url;						
		$testimonial->comments = $request->company_comment;						
		$testimonial->save();
		
        # Return the admin to the blogs page with a success message
        return redirect()->route('console::testimonials')->with('success', "The testimonial has been created");
    }
    #update delete record
	public function edit($id)
    {
        # Check permissions to access
        // Laralum::permissionToAccess('laralum.senderid.access');

       
      
        # Find the Testimonial
       $testimonial = Laralum::Testimonial('id', $id);
       
        # Return the edit form
        return view('console/testimonial/edit', ['testimonial'  =>  $testimonial ]);
    }
	public function Update(Request $request, $id)
	{
			
		// Laralum::permissionToAccess('laralum.senderid.access');
		
		
		$request->validate([
			'company_name' => 'required',
			'company_comment' => 'required'			
	    ]);
		
		if ($files = $request->file('company_logo')) {
		   request()->validate([
              'company_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           ]);
			
           $destinationPath = public_path('console_public/data/testimonial');
           $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
           $files->move($destinationPath, $profileImage);
		   $old_image = public_path('console_public/data/testimonial/').$request->company_logo_hidden;
			if (file_exists($old_image)) {
			   @unlink($old_image);
			}
        }else{
			
			$profileImage = $request->company_logo_hidden;
		}
		 		 				
        $update = DB::table('testimonials')
                ->where('id', $id)
                ->update([
				   'company_name' => $request->company_name, 
				   'company_logo' => $profileImage, 
				   'company_url' => $request->company_url, 
				   'comments' => $request->company_comment, 
			]);

		return redirect()->route('console::testimonials')->with('success', "The testimonial has been edited");
	}

	
	public function destroy(Request $request)
    {
        // Laralum::permissionToAccess('laralum.senderid.access');
            
        if($request->id){
	       DB::table('testimonials')->where('id', $request->id)->delete();		   
		   $returnData = array(
				'status' => 'success',
				'message' => 'Testimonial deleted successfully!'
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
