<?php
namespace App\Http\Controllers\Laralum;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\groups_Role;
use Laralum;
use DB;
use Ixudra\Curl\Facades\Curl;

class SendsmsController extends Controller
{
    protected $smsLimit = 153;
	protected $smsLimitUnicode = 67;
	//protected $smsCost = 1;
	
	
    public function index() {
		#check access permission
		$balance = array();
        Laralum::permissionToAccess('laralum.sendsms.access');
		
		// #check group access permission
		Laralum::permissionToAccess('laralum.groups.access');

        # Get all group
        $group = Laralum::group('client_id', Laralum::loggedInUser()->id);
     
	   foreach($group as $grp){
		 $grp->Contactcount = DB::table('contacts')->where('group_id', $grp->id)->count();  
	   }
	   #get promotional sender ID
	   $getpromo = DB::table('sender')->where('user_id', Laralum::loggedInUser()->id)->where('status', 'Approved')->where('service', 'Promotional')->get();
	   
	   #get Transactiona sender ID
	   $gettrans = DB::table('sender')->where('user_id', Laralum::loggedInUser()->id)->where('status', 'Approved')->where('service', 'Transactional')->get();
	   
	   #get balance
	    $balance = DB::table('balance')->where('user_id', Laralum::loggedInUser()->id)->first();
	   
	    $adminBal = explode(",",$this->getAdminBalance()); 
		$adminPbal = $adminBal[0];
		$adminTbal = $adminBal[1];
		if(Laralum::loggedInUser()->su){			
		$update_su_balance = DB::table('balance')
              ->where('user_id', Laralum::loggedInUser()->id)
              ->update(['promotional' => $adminPbal, 'transactional' => $adminTbal]);			
		}
	  
	   #get all campaign name
	   $campaignName = DB::table('campaign')->where('user_id', Laralum::loggedInUser()->id)->get();
        # Return the view
        return view('laralum/sendsms/index',['group' => $group, 'getpromo' => $getpromo, 'gettrans' => $gettrans, 'campaignName' => $campaignName, 'balance'=>$balance, 'adminpBal'=>$adminPbal, 'admintBal'=>$adminTbal ]);
    }
	
	public function csvCount(Request $request) {
		
		
		foreach ($request->files as $files_row) {
				   $files[] = $files_row->getRealPath();
				   
					
				   $rows = \Excel::load($files_row->getRealPath(), function($reader) {})->get(); 
				   foreach($rows as $row){
						$contactList[] = $row->mobile;
					  
				   }  
			   }
		#check access permission
		
        return count($contactList);
		
    }
	
	
	public function sendSMS(Request $request) {
		//echo '<pre>';print_r($request->all());die;
		#check access permission
        Laralum::permissionToAccess('laralum.sendsms.access');
		 $unicode = "";
		 $isSch=0;
		 $flash = "";
		 $schtime = "";
				 
		 if($request->interviewradio== 'Transactional'){
			$this->validate($request, [
				'troute'     => 'required|size:6|alpha',
				'recipientList' => 'required',
				'ShowsmsTemplet' => 'required',
			]);		
	    }
		elseif($request->interviewradio== 'Promotional'){
			$this->validate($request, [
				'proute'     => 'required',
				'recipientList' => 'required',
				'ShowsmsTemplet' => 'required',
			]);
	   }
		
	    #check message length
		if($request->msgType=='unicode'){
		    $smsCount = $this->smsCountUnicode($request->ShowsmsTemplet);	
		}else{
			$smsCount = $this->smsCount($request->ShowsmsTemplet);
		}
		
	   
	    #check recipient list
		$recepientArr = $this->RecepientCount($request);
		//echo '<pre>';print_r($recepientArr);die;
		$count = count($recepientArr);
		$recepients = implode(',',$recepientArr);
		$units = $smsCount*$count*1;
		 if($request->interviewradio=='Promotional'){
			$route = 1;
			//$sender = $request->promotionalSenderID;
			$sender = $request->proute;
		 }else{
			$route = 4;
			$sender = $request->troute;
			//$sender = $request->transactionalSenderID;
			
		 }
		 /*if($request->openSenderID){
			$sender = $request->openSenderID; 
		 }*/
		 
		  if($request->campaignName){
			$campaign = $request->campaignName;            			
			$checkCampaign = DB::table('campaign')->where('campaign_name', $campaign)->where('user_id', Laralum::loggedInUser()->id)->first();			
			if(!empty($checkCampaign)){
				 DB::table('campaign')->where('user_id', Laralum::loggedInUser()->id)->where('campaign_name', $campaign)->update(['campaign_name' => $campaign ]);
				 $campaignID = $request->campaignID;
			}else{
				 $campaignID = DB::table('campaign')->insertGetId(['campaign_name' => $campaign, 'user_id' => Laralum::loggedInUser()->id ]);
			}
		 }
		 
		 if($request->ShowsmsTemplet){
			$message = $request->ShowsmsTemplet; 
			$message = urlencode($message);
		 }
		 
		  $send_date = date('Y-m-d H:i:s');
		
		#check balance
		$checkBalance = $this->checkBalance(Laralum::loggedInUser()->id, $request->interviewradio); 
		//Gateway
		$gateway = $this->getDefaultGateway();
		$smsgateway = $this->getDefaultApi($gateway->default_for_sms);
		$mmsgateway = $this->getDefaultApi($gateway->default_for_mms);
		$unicodegateway = $this->getDefaultApi($gateway->default_for_unicode);
		if($gateway->default_for_sms == 1 && $smsgateway->gateway_name=='Msg91') {
			if($checkBalance>=$units){
				$data = array('authkey'=> $smsgateway->authentication_string, 'mobiles'=>$recepients, 'message'=>$message, 'sender'=>$sender, 'route'=>$route, 'campaign'=>$campaign, 'country'=>91, 'response'=>'json');
				if($request->scheduleDate && $request->scheduleTime){
				  $scdate = date('Y-m-d',strtotime($request->scheduleDate));
				  $time = $request->scheduleTime;
				  $schtime = $scdate . " " . $time.':00';
				  $isSch = 1;
				  $data['schtime'] = $schtime;
				} 
				if($request->msgType=='unicode'){
					$unicode = 1;
					$data['unicode'] = $unicode;
				} 
				if($request->flash=='flash'){
					$flash = 1;
					$data['flash'] = $flash;
				} 
			$response = Curl::to($smsgateway->send_sms_api)
						->withData($data)
						->post();
						
			$response = json_decode($response, true);
			if($response['type'] == 'success') {
				DB::table('sentmessages')->insert( ['message'=>$request->ShowsmsTemplet, 'senderID' => $sender, 'campagin_id'=>$campaignID, 'recipient'=>$recepients, 'route'=>$route, 'customer'=>Laralum::loggedInUser()->id, 'reseller'=>Laralum::loggedInUser()->isReseller, 'pages'=>$smsCount, 'status'=>'Sending', 'response_id'=> $response['message'], 'units'=>$units, 'sentFrom'=>'panel','is_mms'=>$flash, 'is_schedule'=>$isSch, 'sch_time'=>$schtime, 'is_unicode'=>$unicode, 'gateway_id'=>1, 'error'=> $response['message'],'created_at'=>$send_date] );
				
				#update balance
				 if($request->interviewradio=='Promotional'){
			          $updatebalance = DB::table('balance')->where('user_id', Laralum::loggedInUser()->id)->decrement('promotional', $units);
				 }else{
					 $updatebalance = DB::table('balance')->where('user_id', Laralum::loggedInUser()->id)->decrement('transactional',$units);
				 }
				
				
				return redirect()->route('Laralum::sendsms')->with('success', "SMS submitted successfully! you may check delivery report after some time.");
			}	else {
				
				return redirect()->route('Laralum::sendsms')->with('error', $response['message']);
			}	
			
			}else{
				
				return redirect()->route('Laralum::sendsms')->with('error', "You have unsufficient balance!!");
			}
		}
    }

	


    protected function smsCount($message)
	{
		$len = strlen($message);
		$i  = $this->smsLimit;
		$j   = 1;
		if($len>160) {
			while ($i < $len) {
				$i += $this->smsLimit;
				$j++;
			}
			return $j;
		} else {
			return 1;
		}
	}
	
	 protected function smsCountUnicode($message)
	 {
		$len = strlen($message);
		$i  = $this->smsLimitUnicode;
		$j   = 1;
		if($len>70) {
			while ($i < $len) {
				$i += $this->smsLimitUnicode;
				$j++;
			}
			return $j;
		} else {
			return 1;
		}
	}

	protected function RecepientCount($data)
	{		
	  $contactList =array();
	  if(!empty($data->group)){
		  $group = $data->group;
		  $contacts = array();
		  foreach($group as $groupid){
			 $recipientList = DB::table('contacts')->select('mobile')->where('group_id', $groupid)->groupBy('mobile')->get();  
			$contacts = array_merge($contacts, $recipientList->toArray());
		  }
		  foreach($contacts as $con) {
			  
				 $contactList[] = $con->mobile;
			 }
	  }
	   
	  if($data->recipientList) {
		  $recipient = $data->recipientList;
		  $rlist = explode(',', $recipient);
		  $contactList = array_merge( $contactList, $rlist);
	  }
	  if(!empty($data->hasFile('files'))) {
		   $file_ext = 0;
			   $files_rows = $data->file('files');
			   $ext_mime = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel', 'application/msexcel', 'application/xls', 'application/x-xls','text/plain');
			   
			   foreach ($files_rows as $files_row) {
				   $files[] = $files_row->getRealPath();
				   $ext = $files_row->getMimeType();
				   if(in_array($ext, $ext_mime)) $file_ext = 1; else $file_ext = 0; 
				   
				   
				    if($file_ext == 0)  {
						return redirect()->route('Laralum::sendsms')->with('error', "Invalid file extension. Allowed extension csv,xls,xlsx");
					}
					
				   $rows = \Excel::load($files_row->getRealPath(), function($reader) {})->get(); 
				   foreach($rows as $row){
					   
					   if($row->mobile=='') { 
						
							return redirect()->route('Laralum::sendsms')->with('error', "Please put respective header as sample sheet");
						}
						$contactList[] = $row->mobile;
					  
				   }  
			   }
	  }
	  
		return $contactList;
	}
	
	protected function checkBalance($user_id,$route)
	{
		if($route=='Promotional'){
		   $checkBal = DB::table('balance')->select('promotional')->where('user_id', $user_id)->first();
		   $checkBal = $checkBal->promotional;
		}else{
		  $checkBal = DB::table('balance')->select('transactional')->where('user_id', $user_id)->first();
		  $checkBal = $checkBal->transactional;
		}		
		return $checkBal;
	}
    
	protected function getDefaultGateway()
	{
		$gateway = DB::table('gateway_default')->first();
		return $gateway;
	}
	protected function getDefaultApi($gatewayid)
	{
		$gateway = DB::table('gateways')->where('id', $gatewayid)->first();
		return $gateway;
	}
	protected function updateBalance($id,$creditused)
	{
		if($route=='Promotional'){
		   $checkBal = DB::table('balance')->select('promotional')->where('user_id', $user_id)->first();
		   $checkBal = $checkBal->promotional;
		}
		else{
		  $checkBal = DB::table('balance')->select('transactional')->where('user_id', $user_id)->first();
		  $checkBal = $checkBal->transactional;
		}
		
		return $checkBal;
	}	
	protected function getAdminBalance()
	{
		
		$pbalance = Curl::to('https://control.msg91.com/api/balance.php')
						->withData(['authkey'=>'130199AKQsRsJy581b6dd5', 'type'=>1])
						->post();
		$tbalance = Curl::to('https://control.msg91.com/api/balance.php')
		   ->withData(['authkey'=>'130199AKQsRsJy581b6dd5', 'type'=>4])
		   ->post();
		return  $pbalance.','.$tbalance;
	}	
	
}
