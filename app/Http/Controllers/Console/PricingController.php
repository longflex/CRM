<?php
namespace App\Http\Controllers\Console;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Pricing;
use App\PriceList;
use App\User;
use Laralum;
use Validator,DB,File;
class PricingController extends Controller
{

    public function index() {
        // Laralum::permissionToAccess('laralum.senderid.access');
        # Get all testimonials for admin      
        $pricing = DB::table('pricing')->get();
        foreach($pricing as $price){
			$ptype = DB::table('product_type')->where('id', $price->product)->first();
			$price->product_type = $ptype->title;
			$price->flat = ($price->flat_price) ? $price->flat_price.' /Credit INR' : '';
		}		
		
		
        # Return the view
        return view('console/pricing/index', ['pricing' => $pricing]);
    }

    public function create()
    {
        // Laralum::permissionToAccess('laralum.senderid.access');    
        # Return the view
        return view('console/pricing/create');
    }

    public function store(Request $request)
    {
		
		# Check permissions
        // Laralum::permissionToAccess('laralum.senderid.access');
      
	    if($request->product_type == 2){			
			$request->validate([
				'product_type' => 'required',
				'sms_type' => 'required',
				'flat_price' => 'required',			
		     ]);
			
		}else{
			$request->validate([
				'product_type' => 'required',
				'flat_price' => 'required',			
		     ]);
		}
		
		$pricing = new Pricing;
		$pricing->product = $request->product_type;
		$pricing->sms_type = $request->sms_type;											
		$pricing->flat_price = $request->flat_price;												
		$pricing->gst_extra = $request->gst_extra;												
		$pricing->min_purchase = $request->min_purchase;												
		$pricing->save();
		
		if($request->from_qty)
         {
		  $qty_relation=array();
          foreach($request->from_qty as $k=>$v){
			  $qty_relation[$k][] = $v;
			  if($request->to_qty){
				  
				  foreach($request->to_qty as $key=>$val) {
					  
					  if($k==$key){
						  
						   $qty_relation[$k][] = $val;
					  }
				  }
			  }
			  if($request->price){
				  
				  foreach($request->price as $keys=>$value) {
					  
					  if($k==$keys){
						  
						   $qty_relation[$k][] = $value;
					  }
				  }
			  }
			  
		  }
		  foreach ($qty_relation as $value) {			     
				PriceList::create([
					'price_id' => $pricing->id,
					'sms_type' => $request->sms_type,
					'from_qty' => $value[0],
					'to_qty' => $value[1],
					'price' => $value[2]							
				]);

			}
		
         }
		
        # Return the admin to the pricing page with a success message
        return redirect()->route('console::pricing')->with('success', "The pricing range has been created");
    }
    #update delete record
	public function edit($id)
    {
        # Check permissions to access
        // Laralum::permissionToAccess('laralum.senderid.access');       
      
        # Find the pricing
        $pricing = Laralum::pricing('id', $id); 
        $price_list = DB::table('price_lists')->where('price_id', $id)->orderBy('from_qty', 'ASC')->get();		
        # Return the edit form
        return view('console/pricing/edit', ['pricing'  =>  $pricing, 'price_list'  =>  $price_list]);
    }
	public function Update(Request $request, $id)
	{
			
		// Laralum::permissionToAccess('laralum.senderid.access');
		
		 if($request->product_type == 2){			
			$request->validate([
				'product_type' => 'required',
				'sms_type' => 'required',
				'flat_price' => 'required',			
		     ]);
			
		}else{
			$request->validate([
				'product_type' => 'required',
				'flat_price' => 'required',			
		     ]);
		}
		
        $update = DB::table('pricing')
                ->where('id', $id)
                ->update([
				   'product' => $request->product_type, 
				   'sms_type' => $request->sms_type, 
				   'flat_price' => $request->flat_price, 
				   'gst_extra' => $request->gst_extra, 
				   'min_purchase' => $request->min_purchase, 
			]);
			
	   if($request->from_qty){
		  DB::table('price_lists')->where('price_id', $id)->delete();  
		  $qty_relation=array();
          foreach($request->from_qty as $k=>$v){
			  $qty_relation[$k][] = $v;
			  if($request->to_qty){
				  
				  foreach($request->to_qty as $key=>$val) {
					  
					  if($k==$key){
						  
						   $qty_relation[$k][] = $val;
					  }
				  }
			  }
			  if($request->price){
				  
				  foreach($request->price as $keys=>$value) {
					  
					  if($k==$keys){
						  
						   $qty_relation[$k][] = $value;
					  }
				  }
			  }
			  
		  }
		  foreach ($qty_relation as $value) {			     
				PriceList::create([
					'price_id' => $id,
					'sms_type' => $request->sms_type,
					'from_qty' => $value[0],
					'to_qty' => $value[1],
					'price' => $value[2]							
				]);

			}
		
         }

		return redirect()->route('console::pricing')->with('success', "The pricing range has been edited");
	}

	
	public function destroy(Request $request)
    {
        // Laralum::permissionToAccess('laralum.senderid.access');
            
        if($request->id){
	       DB::table('pricing')->where('id', $request->id)->delete();		   
		   $returnData = array(
				'status' => 'success',
				'message' => 'Price range has been deleted!'
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
