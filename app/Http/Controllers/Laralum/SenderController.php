<?php
namespace App\Http\Controllers\Laralum;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Sender;
use Laralum;
use DB;
//use Illuminate\Support\Facades\Validator;
class SenderController extends Controller
{

    public function index() {
        Laralum::permissionToAccess('laralum.senderid.access');

        # Get all senderid  
         if(Laralum::loggedInUser()->reseller_id==0){
			$client_id = Laralum::loggedInUser()->id;
		 }else{
			$client_id = Laralum::loggedInUser()->reseller_id;
		 }		
         $sender = DB::table('sender')->where('user_id', $client_id)->orderBy('id', 'desc')->paginate(15);
		 foreach($sender as $sdr){
			  $name = DB::table('users')->where('id', $sdr->user_id)->first();
			 $sdr->clientname = $name->name;
	      }		
        # Return the view
        return view('laralum/senderid/index', ['senders' => $sender]);
    }

    public function store(Request $request)
    {		
		# Check permissions
        Laralum::permissionToAccess('laralum.senderid.access');
        
	    if($request->service== 'Transactional'){			
			$this->validate($request, [
				'sender_name'     => 'required|size:6|alpha',
				'service'     => 'required',				
			]);			
	    }else if($request->service== 'Promotional'){			
			$this->validate($request, [
				'sender_name'     => 'required|digits:6|numeric',
				'service'     => 'required',				
			]);												
		}
		
		 # Save the data
		if(Laralum::loggedInUser()->reseller_id==0){
			$client_id = Laralum::loggedInUser()->id;
		}else{
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		        	    		
		$sender = new Sender;
		$sender->user_id = $client_id;
		$sender->sender_name = $request->sender_name;
		$sender->service = $request->service;
        $sender->assign_date = date('Y-m-d');		
		$sender->save();      
        # Return the admin to the sender id page with a success message
        return response()->json(array('success' => true, 'status' => 'success'), 200);
    }
    #update record
	public function Update(Request $request)
	{
		
	   Laralum::permissionToAccess('laralum.senderid.access');
	   if($request->edit_service== 'Transactional'){			
			$this->validate($request, [
				'edit_sender_name'     => 'required|size:6|alpha',
				'edit_service'     => 'required',				
			]);			
	    }else if($request->edit_service== 'Promotional'){			
			$this->validate($request, [
				'edit_sender_name'     => 'required|digits:6|numeric',
				'edit_service'     => 'required',				
			]);												
		}
	   $id = $request->sender_id;
        if($request->sender_id){
           # Update the data
          DB::table('sender')
            ->where('id', $request->sender_id)
            ->update(['sender_name' => $request->edit_sender_name, 'service' => $request->edit_service]);
		}
		 # Return the true
         return response()->json(array('success' => true, 'status' => 'success'), 200);
		
	} 

    public function senderDelete(Request $request)
	{
        if($request->id)
		   DB::table('sender')->where('id', $request->id)->delete();
		# Return the view
    	return response()->json(array('success' => true, 'status' => 'success'), 200);
	}
	
     public function Approve(Request $request)
     {
		# Check permissions
        Laralum::permissionToAccess('laralum.senderid.access');
        $senderNameid = $request->senderNameID;
		$adate= date('Y-m-d');
        DB::table('sender')->where('id', $senderNameid)->update(['status' => 'Approved','approval_date'=>$adate]);
        echo json_encode($request->all());
        
    }
	 public function Reject(Request $request)
     {
		# Check permissions
        Laralum::permissionToAccess('laralum.senderid.access');
        $senderNameid = $request->senderNameID;
		$adate= date('Y-m-d');
        DB::table('sender')->where('id', $senderNameid)->update(['status' => 'Rejected','approval_date'=>$adate]);
        echo json_encode($request->all());
    }
   
   
	
}
