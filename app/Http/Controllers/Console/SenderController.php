<?php
namespace App\Http\Controllers\Console;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Sender;
use Laralum;
use DB;
//use Illuminate\Support\Facades\Validator;
class SenderController extends Controller
{

    public function index(Request $request) {
        Laralum::permissionToAccess('laralum.senderid.access');
        $service_type = $request->service_type;
		$status = $request->status;
        # Get all senderid  
         $sender = DB::table('sender')
		           ->when($service_type, function ($query, $service_type){
					   return $query->where('service', $service_type);
				    })
				    ->when($status, function ($query, $status) {
					  return $query->where('status', $status);
				     })
		            ->orderBy('id', 'desc')
		            ->paginate(15);
		 foreach($sender as $sdr){
			  $name = DB::table('users')->where('id', $sdr->user_id)->first();
			 $sdr->clientname = $name->name;
	      }		
        # Return the view
        return view('console/sender/index', ['senders' => $sender]);
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
