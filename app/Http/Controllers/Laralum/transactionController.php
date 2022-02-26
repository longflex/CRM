<?php
namespace App\Http\Controllers\Laralum;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laralum;
use DB;

class transactionController extends Controller
{
   
	
	
    public function index() {
		
		#get all instant send 
		if(Laralum::loggedInUser()->su){
		      $tanslogs = DB::table('transaction')->orderBy('created_at', 'asc')->get();
			  $users = DB::table('users')->where('reseller_id', 0)->get();
		   }else{
			  $tanslogs = DB::table('transaction')->where('user_id', Laralum::loggedInUser()->id)->orderBy('created_at', 'asc')->get(); 
               $users = DB::table('users')->where('reseller_id', Laralum::loggedInUser()->id)->get();			  
		   }
        # Return the view
		
        return view('laralum/transaction/index', ['logs' => $tanslogs, 'users'=> $users, 'drange'=>'','cid'=>'']);
    }
	
	    public function search(Request $request){
		  
		    //echo '<pre>';print_r($request->all());die;
			$drange = ($request->daterange) ? $request->daterange : '';
			
			$cid = ($request->client) ? $request->client : '';
			
			$range = explode(" - ",$request->daterange);
			$fromDate = $range[0];
			$toDate = $range[1];
			
			$client_id = $request->client;
			if(isset($request->daterange) && !empty($request->daterange)  || isset($request->client) && !empty($request->client) ){
				
				$tanslogs = DB::table('transaction')->whereBetween('created_at', [$fromDate, $toDate]);
				if(isset($request->client) && !empty($request->client)) {
					$tanslogs->where('user_id', $client_id);
				}
				$tanslogs = $tanslogs->get();
				//$tanslogs = DB::table('transaction')->where('user_id', $client_id)->whereBetween('created_at', [$fromDate, $toDate])->get();
				if(Laralum::loggedInUser()->su){
				 
				  $users = DB::table('users')->where('reseller_id', 0)->get();
				}else{
				  
				   $users = DB::table('users')->where('reseller_id', Laralum::loggedInUser()->id)->get();			  
		       }
			}
			else{
				
				if(Laralum::loggedInUser()->su){
				  $tanslogs = DB::table('transaction')->orderBy('created_at', 'asc')->get();
				  $users = DB::table('users')->where('reseller_id', 0)->get();
			   }else{
				   $tanslogs = DB::table('transaction')->where('user_id', Laralum::loggedInUser()->id)->orderBy('created_at', 'asc')->get(); 
				   $users = DB::table('users')->where('reseller_id', Laralum::loggedInUser()->id)->get();			  
		       }
			}
			
			if($request->export=='Export' && $tanslogs){
				
				$i=1;$data=[];
			foreach($tanslogs as $logs)
			{
				$type = ($logs->action=='credit') ? $logs->unit : '-'.$logs->unit;
				$route = ($logs->action==1) ? 'Promotional Route' : 'Transactional Route';
				$data[] = [
					'ID' => $i,
					'Time' => $logs->created_at,
					'Credits' => $type,
					'Price' => $logs->rate,
					'Description' => $logs->description,
					'Amount' => $logs->amount,
					'Type' => $route,
					
					// And many more, lots of them are null
				];
			$i++; }

            $collection = collect($data);
			$collection = json_decode(json_encode($collection), True);
			\Excel::create($drange, function($excel) use ($collection) {
				$excel->sheet('sheet name', function($sheet) use ($collection)
				{
					$sheet->fromArray($collection);
				});
				
				
			  })->download();
			    return \Response::json('success');die;
			}
			
			
			return view('laralum/transaction/index', ['logs' => $tanslogs, 'users'=> $users,'drange'=>$drange,'cid'=>$cid]);
    } 
	
}
