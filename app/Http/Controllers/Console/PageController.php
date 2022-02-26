<?php
namespace App\Http\Controllers\Console;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Page;
use App\User;
use Laralum;
use Validator,DB,File;
class PageController extends Controller
{

    public function index() {
        // Laralum::permissionToAccess('laralum.senderid.access');
        # Get all testimonials for admin      
        $pages = DB::table('pages')->get();				
        # Return the view
        return view('console/page/index', ['pages' => $pages]);
    }

    public function create()
    {
        // Laralum::permissionToAccess('laralum.senderid.access');

     
        # Return the view
        return view('console/page/create');
    }

    public function store(Request $request)
    {
		
		# Check permissions
        // Laralum::permissionToAccess('laralum.senderid.access');
        
	    $request->validate([
			'page_type' => 'required',
			'page_title' => 'required',
            'page_desc' => 'required'			
	    ]);
		
		if ($files = $request->file('home_page_image')) {
            $request->validate([					
			'home_page_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'			
	        ]);			
           $destinationPath = public_path('console_public/data/page');
           $home_page_image = date('YmdHis') . "." . $files->getClientOriginalExtension();
           $files->move($destinationPath, $home_page_image);
        }else{
			$home_page_image ="";
		}
	   
		$page = new Page;
		$page->type = $request->page_type;
		$page->title = $request->page_title;
		$page->image = $home_page_image;
		$page->description = $request->page_desc;														
		$page->save();
		
        # Return the admin to the page  with a success message
        return redirect()->route('console::pages')->with('success', "The page has been created");
    }
    #update delete record
	public function edit($id)
    {
        # Check permissions to access
        // Laralum::permissionToAccess('laralum.senderid.access');
           
        # Find the product
       $page = Laralum::page('id', $id);
       
        # Return the edit form
        return view('console/page/edit', ['page'  =>  $page ]);
    }
	public function Update(Request $request, $id)
	{
			
		// Laralum::permissionToAccess('laralum.senderid.access');
		
		
		$request->validate([
			'page_type' => 'required',
			'page_title' => 'required',
            'page_desc' => 'required'			
	    ]);
		
		if($files = $request->file('home_page_image')) {
		   request()->validate([
              'home_page_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           ]);
			
           $destinationPath = public_path('console_public/data/page');
           $home_page_image = date('YmdHis') . "." . $files->getClientOriginalExtension();
           $files->move($destinationPath, $home_page_image);
		   $old_image = public_path('console_public/data/page/').$request->home_page_image_hidden;
		   if (file_exists($old_image)) {
			   @unlink($old_image);
		   }
        }else{
			
			$home_page_image = $request->home_page_image_hidden;
		}
				
        $update = DB::table('pages')
                ->where('id', $id)
                ->update([
				   'type' => $request->page_type, 
				   'title' => $request->page_title, 
				   'image' => $home_page_image, 
				   'description' => $request->page_desc, 
				   
			]);

		return redirect()->route('console::pages')->with('success', "The page has been edited");
	}

		 	
}
