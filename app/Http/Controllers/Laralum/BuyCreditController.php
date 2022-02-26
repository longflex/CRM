<?php
namespace App\Http\Controllers\Laralum;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laralum;
use DB;
class BuyCreditController extends Controller
{
    public function index()
    {
		
		#get all bank details 
		$banks = DB::table('bank_details')->where('user_id', Laralum::loggedInUser()->id)->orderBy('created_at', 'asc')->get();
        return view('laralum/buy/index',[
		'banks' => $banks,
		]);
    }
	
	 public function store(Request $request)
     {
		 
        $this->validate($request, [
		    'image'   => 'required|mimes:jpg,png,gif,jpeg,txt,doc,docx|max:1000',
        ]);
        
		if(array_key_exists('image', $request->all())){	
			 $file = $request->file('image');
			 $image = time().$file->getClientOriginalName();
             $request->file('image')->move('receipt',$image);
			 
			 DB::table('buy_credit')->insert(['user_id' => Laralum::loggedInUser()->id, 'image' => $image,'description' => $request->desc ]);
			 
          }
      
		
        return redirect()->route('Laralum::buy')->with('success',"The receipt has been uploaded");
        
    }
	
	 public function requestList()
    {
		
		#get all bank details 
		$receipt = DB::table('buy_credit')->where('user_id', Laralum::loggedInUser()->id)->orderBy('created_at', 'asc')->get();
        return view('laralum/buy/receipt',[
		'receipts' => $receipt,
		]);
    }

	
}
