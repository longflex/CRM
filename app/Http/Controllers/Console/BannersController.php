<?php
namespace App\Http\Controllers\Console;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Banner;
use App\User;
use Laralum;
use Validator,DB,File;
class BannersController extends Controller
{

    public function index() {
        Laralum::permissionToAccess('laralum.senderid.access');
        # Get all testimonials for admin      
        $banners = DB::table('banners')->get();				
        # Return the view
        return view('console/banner/index', ['banners' => $banners]);
    }

    public function create()
    {
        Laralum::permissionToAccess('laralum.senderid.access');

     
        # Return the view
        return view('console/banner/create');
    }

    public function store(Request $request)
    {
		
		# Check permissions
        Laralum::permissionToAccess('laralum.senderid.access');
        
	    $request->validate([
			'title' => 'required',
			'banner_desc' => 'required',			
			'banner_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'			
	    ]);
		
		if ($files = $request->file('banner_img')) {		 
           $destinationPath = public_path('console_public/data/banner');
           $banner_image = date('YmdHis') . "." . $files->getClientOriginalExtension();
           $files->move($destinationPath, $banner_image);
        }else{
			$banner_image ="";
		}
		
		$banner = new Banner;
		$banner->title = $request->title;
		$banner->description = $request->banner_desc;
		$banner->image = $banner_image;													
		$banner->save();
		
        # Return the admin to the blogs page with a success message
        return redirect()->route('console::banners')->with('success', "The banner has been created");
    }
    #update delete record
	public function edit($id)
    {
        # Check permissions to access
        Laralum::permissionToAccess('laralum.senderid.access');
      
        # Find the Banner
       $banner = Laralum::Banner('id', $id);
       
        # Return the edit form
        return view('console/banner/edit', ['banner'  =>  $banner ]);
    }
	public function Update(Request $request, $id)
	{
			
		Laralum::permissionToAccess('laralum.senderid.access');
		
		
		$request->validate([
			'title' => 'required',
			'banner_desc' => 'required'	
	    ]);
		
		if($files = $request->file('banner_img')) {
		   request()->validate([
              'banner_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           ]);
			
           $destinationPath = public_path('console_public/data/banner');
           $banner_img = date('YmdHis') . "." . $files->getClientOriginalExtension();
           $files->move($destinationPath, $banner_img);
		   $old_image = public_path('console_public/data/banner/').$request->banner_img_hidden;
		   if (file_exists($old_image)) {
			   @unlink($old_image);
		   }
        }else{
			
			$banner_img = $request->banner_img_hidden;
		}
		 		 				
        $update = DB::table('banners')
                ->where('id', $id)
                ->update([
				   'title' => $request->title, 
				   'description' => $request->banner_desc,
				   'image' => $banner_img, 				  
			]);

		return redirect()->route('console::banners')->with('success', "The banner has been edited");
	}

	
	public function destroy(Request $request)
    {
        Laralum::permissionToAccess('laralum.senderid.access');
            
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
