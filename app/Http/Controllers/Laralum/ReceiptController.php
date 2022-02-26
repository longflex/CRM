<?php
namespace App\Http\Controllers\Laralum;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laralum;
use DB;
class ReceiptController extends Controller
{
    public function index()
    {
		
		#get all bank details 
		$receipt = DB::table('buy_credit')->where('user_id', Laralum::loggedInUser()->id)->orderBy('created_at', 'asc')->get();
		foreach($receipt as $recpt){
			
			$clientname = DB::table('users')->select('name')->where('id', $recpt->user_id)->first();
			$recpt->user_id = $clientname->name;
			
			
		}
		
        return view('laralum/receipt/index',[
		'receipts' => $receipt,
		]);
    }
		
}
