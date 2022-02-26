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
class IndustriesController extends Controller
{

    public function index() {
        Laralum::permissionToAccess('laralum.senderid.access');
        # Get all testimonials for admin      
        $industries = DB::table('industries')->get();				
        # Return the view
        return view('console/industries/index', ['industries' => $industries]);
    }

    public function create()
    {
        Laralum::permissionToAccess('laralum.senderid.access');

     
        # Return the view
        return view('console/industries/create');
    }

    public function store(Request $request)
    {
		
		# Check permissions
        Laralum::permissionToAccess('laralum.senderid.access');
        
	    $request->validate([
			'title' => 'required',
			'description' => 'required',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',			
	    ]);
		
		if ($files = $request->file('icon')) {		   
           $destinationPath = public_path('console_public/data/industries');
           $icon = date('YmdHis') . "." . $files->getClientOriginalExtension();
           $files->move($destinationPath, $icon);
        }
		$industry = new Industries;
		$industry->title = $request->title;
		$industry->icon = $icon;
		$industry->description = $request->description;												
		$industry->save();
		
        # Return the admin to the industries page with a success message
        return redirect()->route('console::industries')->with('success', "The industries has been created");
    }
    #update delete record
	public function edit($id)
    {
        # Check permissions to access
        Laralum::permissionToAccess('laralum.senderid.access');       
      
        # Find the industries
        $industries = Laralum::industries('id', $id);       
        # Return the edit form
        return view('console/industries/edit', ['industries'  =>  $industries ]);
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
