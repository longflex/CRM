<?php
namespace App\Http\Controllers\Console;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use App\User;
use Laralum;
use Validator,DB,File;
class ProductController extends Controller
{

    public function index() {
        // Laralum::permissionToAccess('laralum.senderid.access');
        # Get all testimonials for admin      
        $products = DB::table('products')->get();				
        # Return the view
        return view('console/product/index', ['products' => $products]);
    }

    public function create()
    {
        // Laralum::permissionToAccess('laralum.senderid.access');

     
        # Return the view
        return view('console/product/create');
    }

    public function store(Request $request)
    {
		
		//echo '<pre>';print_r($request->all());die;
		# Check permissions
        // Laralum::permissionToAccess('laralum.senderid.access');
        
	    $request->validate([
			'product_type' => 'required',
			'product_name' => 'required',
			'product_desc' => 'required',
            'product_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'			
	    ]);
	   if($files = $request->file('product_img')) {			 
		   $destinationPath = public_path('console_public/data/products');
		   $product_image = date('YmdHis') . "." . $files->getClientOriginalExtension();
		   $files->move($destinationPath, $product_image);
	   }
	   if($sub_product_image1 = $request->file('sub_product_image1')) {			 
		   $destinationPath1 = public_path('console_public/data/products/sub_product');
		   $s_product_image1 = date('YmdHis') . "_1." . $sub_product_image1->getClientOriginalExtension();
		   $sub_product_image1->move($destinationPath1, $s_product_image1);
	   }else{
		  $s_product_image1 = ""; 
	   }
	   if($sub_product_image2 = $request->file('sub_product_image2')) {			 
		   $destinationPath2 = public_path('console_public/data/products/sub_product');
		   $s_product_image2 = date('YmdHis') . "_2." . $sub_product_image2->getClientOriginalExtension();
		   $sub_product_image2->move($destinationPath2, $s_product_image2);
	   }else{
		  $s_product_image2 = ""; 
	   }
	   if($sub_product_image3 = $request->file('sub_product_image3')) {			 
		   $destinationPath3 = public_path('console_public/data/products/sub_product');
		   $s_product_image3 = date('YmdHis') . "_3." . $sub_product_image3->getClientOriginalExtension();
		   $sub_product_image3->move($destinationPath3, $s_product_image3);
	   }else{
		  $s_product_image3 = ""; 
	   }
	    if($sub_product_image4 = $request->file('sub_product_image4')) {			 
		   $destinationPath4 = public_path('console_public/data/products/sub_product');
		   $s_product_image4 = date('YmdHis') . "_4." . $sub_product_image4->getClientOriginalExtension();
		   $sub_product_image4->move($destinationPath4, $s_product_image4);
	   }else{
		  $s_product_image4 = ""; 
	   }
		
		$product = new Product;
		$product->product_type = $request->product_type;
		$product->title = $request->product_name;
		$product->image = $product_image;
		$product->description = $request->product_desc;														
		$product->sub_product_title1 = $request->sub_product_title1;														
		$product->sub_product_title2 = $request->sub_product_title2;														
		$product->sub_product_title3 = $request->sub_product_title3;														
		$product->sub_product_title4 = $request->sub_product_title4;														
		$product->sub_product_icon1 = $s_product_image1;														
		$product->sub_product_icon2 = $s_product_image2;														
		$product->sub_product_icon3 = $s_product_image3;														
		$product->sub_product_icon4 = $s_product_image4;														
		$product->sub_product_desc1 = $request->sub_product_desc1;														
		$product->sub_product_desc2 = $request->sub_product_desc2;														
		$product->sub_product_desc3 = $request->sub_product_desc3;														
		$product->sub_product_desc4 = $request->sub_product_desc4;														
		$product->save();
		
		
        # Return the admin to the blogs page with a success message
        return redirect()->route('console::products')->with('success', "The product has been created");
    }
    #update delete record
	public function edit($id)
    {
        # Check permissions to access
        // Laralum::permissionToAccess('laralum.senderid.access');

       
      
        # Find the product
       $product = Laralum::product('id', $id);
       
        # Return the edit form
        return view('console/product/edit', ['product'  =>  $product ]);
    }
	public function Update(Request $request, $id)
	{
			
		// Laralum::permissionToAccess('laralum.senderid.access');
		
		
		$request->validate([		    
			'product_name' => 'required',
			'product_desc' => 'required'			
	    ]);
		
		if ($files = $request->file('product_img')) {
		   request()->validate([
              'product_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           ]);
			
           $destinationPath = public_path('console_public/data/products');
           $product_img = date('YmdHis') . "." . $files->getClientOriginalExtension();
           $files->move($destinationPath, $product_img);
		   $old_image = public_path('console_public/data/products/').$request->product_img_hidden;
			if (file_exists($old_image)) {
			   @unlink($old_image);
			}
        }else{
			
			$product_img = $request->product_img_hidden;
		}
		
		if($sub_product_image1 = $request->file('sub_product_image1')) {			 
		   $destinationPath1 = public_path('console_public/data/products/sub_product');
		   $s_product_image1 = date('YmdHis') . "_1." . $sub_product_image1->getClientOriginalExtension();
		   $sub_product_image1->move($destinationPath1, $s_product_image1);
	       $old_image1 = public_path('console_public/data/products/sub_product').$request->sub_product_image1_hidden;
			if (file_exists($old_image1)) {
			   @unlink($old_image1);
			}
        }else{
			
			$s_product_image1 = $request->sub_product_image1_hidden;
		}
	   if($sub_product_image2 = $request->file('sub_product_image2')) {			 
		   $destinationPath2 = public_path('console_public/data/products/sub_product');
		   $s_product_image2 = date('YmdHis') . "_2." . $sub_product_image2->getClientOriginalExtension();
		   $sub_product_image2->move($destinationPath2, $s_product_image2);
	       $old_image2 = public_path('console_public/data/products/sub_product').$request->sub_product_image2_hidden;
			if (file_exists($old_image2)) {
			   @unlink($old_image2);
			}
        }else{
			
			$s_product_image2 = $request->sub_product_image2_hidden;
		}
	   if($sub_product_image3 = $request->file('sub_product_image3')) {			 
		   $destinationPath3 = public_path('console_public/data/products/sub_product');
		   $s_product_image3 = date('YmdHis') . "_3." . $sub_product_image3->getClientOriginalExtension();
		   $sub_product_image3->move($destinationPath3, $s_product_image3);
	       $old_image3 = public_path('console_public/data/products/sub_product').$request->sub_product_image3_hidden;
			if (file_exists($old_image3)) {
			   @unlink($old_image3);
			}
        }else{
			
			$s_product_image3 = $request->sub_product_image3_hidden;
		}
	    if($sub_product_image4 = $request->file('sub_product_image4')) {			 
		   $destinationPath4 = public_path('console_public/data/products/sub_product');
		   $s_product_image4 = date('YmdHis') . "_4." . $sub_product_image4->getClientOriginalExtension();
		   $sub_product_image4->move($destinationPath4, $s_product_image4);
	       $old_image4 = public_path('console_public/data/products/sub_product').$request->sub_product_image4_hidden;
			if (file_exists($old_image4)) {
			   @unlink($old_image4);
			}
        }else{
			
			$s_product_image4 = $request->sub_product_image4_hidden;
		}
						 		 				
        $update = DB::table('products')
                ->where('id', $id)
                ->update([
				   'title' => $request->product_name, 
				   'image' => $product_img, 
				   'description' => $request->product_desc, 
				   'sub_product_title1' => $request->sub_product_title1, 
				   'sub_product_title2' => $request->sub_product_title2, 
				   'sub_product_title3' => $request->sub_product_title3, 
				   'sub_product_title4' => $request->sub_product_title4, 
				   'sub_product_icon1' => $s_product_image1, 
				   'sub_product_icon2' => $s_product_image2, 
				   'sub_product_icon3' => $s_product_image3, 
				   'sub_product_icon4' => $s_product_image4,
                   'sub_product_desc1' => $request->sub_product_desc1,				   
                   'sub_product_desc2' => $request->sub_product_desc2,				   
                   'sub_product_desc3' => $request->sub_product_desc3,				   
                   'sub_product_desc4' => $request->sub_product_desc4,				   
				  
				   
			]);

		return redirect()->route('console::products')->with('success', "The product has been edited");
	}

	
	public function destroy(Request $request)
    {
        // Laralum::permissionToAccess('laralum.senderid.access');
            
        if($request->id){
	       DB::table('products')->where('id', $request->id)->delete();		   
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
