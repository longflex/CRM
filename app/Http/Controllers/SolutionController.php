<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class SolutionController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$products = DB::table('products')->where('product_type', '!=', 9)->orderBy('id', 'DESC')->get();
		foreach($products as $product){
			$product->url = Str::slug($product->title);
		}
        return view('solution', compact('products'));
    }
	
	public function getSingle()
    {		
		$parameters = \Request::segment(2);
		$prod_details = DB::table('products')->where('id', $parameters)->first();
		
		$price_details = DB::table('pricing')->where('product', $prod_details->product_type)->first();
		//echo '<pre>';print_r($price_details);die;
	
		return view('solution_details',[		
			     'prod_details' => $prod_details, 		 
			     'price_details' => $price_details, 		 
			]);
			
		
		
    }
	
	public function calculatePrice(Request $request)
    {		
		
		$price = DB::table('price_lists')
		            ->where('from_qty', '<=', trim($request->msg_qty))
					->where('to_qty', '>=', trim($request->msg_qty))
                    ->where('sms_type', '=', trim($request->sms_type))               
                    ->first();
	  if(!empty($price)){
		  $returnData = array(
				'status' => 'success',
				'price' => $price->price,
				'msg_qty' => $request->msg_qty,
				'total_amount' => number_format($request->msg_qty*$price->price)
			); 		     
	  }else{
		 $returnData = array(
		        'status' => 'error',
			); 	 
	  }
       
       return response()->json($returnData);
			
    }
}
