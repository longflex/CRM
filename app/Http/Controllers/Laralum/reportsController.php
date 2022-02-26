<?php
namespace App\Http\Controllers\Laralum;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Exports\MessageExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Laralum;
use DB;

class reportsController extends Controller
{
   
	
	
    public function index(Request $request) {
		#check access permission
        Laralum::permissionToAccess('laralum.reports.access');
		
		if(Laralum::loggedInUser()->reseller_id==0){
			$client_id = Laralum::loggedInUser()->id;
		}else{
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		//Instant message
		$reqid = $request->search_inst_msg_request_id;
		$campaign = $request->campaign;
		$platform = $request->platform;
		$route = $request->route;
		$date_range = $request->date_range;
		$current_date = date('Y-m-d H:i:s');
		$past_date = date('Y-m-d H:i:s', strtotime('-'.$date_range.' days'));
        //Scheduled message		
		$schReqid = $request->search_sch_msg_request_id;
		$schCampaign = $request->schCampaign;
		
		#get all instant send 
		$send_instant_msg = DB::table('sentmessages')
		    ->when($reqid, function ($query, $reqid){
				return $query->where('request_id', $reqid);
			 })
			 ->when($campaign, function ($query, $campaign) {
				return $query->where('campagin_id', $campaign);
			 })
			 ->when($platform, function ($query, $platform) {
				return $query->where('sentFrom', $platform);
			 })
			 ->when($route, function ($query, $route) {
				return $query->where('route', $route);
			 })
			 ->when($past_date, function ($query, $past_date) {
				return $query->whereDate('created_at', '>=', $past_date);
			 })
			 ->when($current_date, function ($query, $current_date) {
				return $query->whereDate('created_at', '<=', $current_date);
			 })
			->where('customer', $client_id)
			->where('is_schedule',0)
			->orderBy('created_at', 'asc')
			->get();
		
		
		#get reports summery 
		
		foreach($send_instant_msg as $instmsg){			
			$campaign_name = DB::table('campaign')->select('campaign_name')->where('id', $instmsg->campagin_id)->first();
			$instmsg->campagin_id = isset($campaign_name) ? $campaign_name->campaign_name : '';						
		}
		$schReqid = $request->search_sch_msg_request_id;
		$schCampaign = $request->schCampaign;
		#get all scheduled send 
		$send_scheduled_msg = DB::table('sentmessages')
				 ->when($schReqid, function ($query, $schReqid){
					return $query->where('request_id', $schReqid);
				 })
				 ->when($schCampaign, function ($query, $schCampaign) {
					return $query->where('campagin_id', $schCampaign);
				 })
				->where('customer', $client_id)
				->where('is_schedule',1)->orderBy('created_at', 'asc')
				->get();
		
		foreach($send_scheduled_msg as $scmsg){			
			$campaign_names = DB::table('campaign')->select('campaign_name')->where('id', $scmsg->campagin_id)->first();
			$scmsg->campagin_id = isset($campaign_names) ? $campaign_names->campaign_name : '';							
		}
		#get all campaign name 
		$allCam = DB::table('campaign')->where('user_id', $client_id)->orderBy('created_at', 'asc')->get();
		
        # Return the view
		return view('laralum/reports/index',[
			'instantMsg' => $send_instant_msg, 
			'scheduleMsg' => $send_scheduled_msg,
			'allcampaign' => $allCam,
		]);
    }
	
	
    public function ReportsDetails($id){
		
		
		  $resid = $id;
		  $msg = DB::table('sentmessages')->where('response_id', $resid)->first();
		
		  $msgStrn = $msg->message;
		  $reports = DB::table('reports')->where('request_id',$resid )->paginate(100);
		   $reportsCnt = DB::table('reports')->where('request_id',$resid )->get();
		   
			$delivered=0;$failed=0;$rejected=0;$failed_retry=0;$rejected_retry=0;$auto_failed=0;$block=0;$total=0;$str='';
			
			foreach ($reportsCnt as $report) {
				switch($report->status) {
					
					case 1 : 
					++$delivered;
					break;
					case 2 : 
					++$failed;
					break;
					case 16 :
					++$rejected;
					break;
				}
				$total = $delivered+$failed+$rejected+$failed_retry+$rejected_retry+$auto_failed+$block;
				$str = $rejected.','.$delivered.','.$failed.','.$rejected_retry.','.$failed_retry.','.$auto_failed.','.$block;
					  
				
				
			}
	   return view('laralum/reports/details',[
			'reports' => $reports,
			'delivered' => $delivered, 
			'failed' => $failed,
			'rejected' => $rejected, 
			'failed_retry' => $failed_retry,
			'rejected_retry' => $rejected_retry, 
			'auto_failed' => $auto_failed,
		    'block' => $block,
			'total' => $total,
			'str' => $str,
			'msg' => $msgStrn,
			'resid' =>$resid,
			
		]);
    }
	
   #Ajax contact search

       public function Search(Request $request){
		 
        $read = "";
		
        $keyword = '91'.$request->search; 
        $resid = $request->res_id;
        
        if($keyword){
			 $results = DB::table('reports')->where('request_id',$resid )->where('receiver','LIKE','%'.$keyword.'%')->get();
           }
	   else{
		   $results = DB::table('reports')->where('request_id',$resid )->where('receiver','LIKE','%'.$keyword.'%')->paginate(100);
		  
	   } 
	     $key=1;
		 foreach($results as $key=>$val) {
			 $key++;
			 $read .="	 
					  <tr>
						<td align='center'>$key</td>
						<td>$val->receiver</td>
						<td>$val->description</td>
						<td>$val->created_at</td>
					  </tr>";
		 }
		 
		return $read;
         

	 }
	 
	public function downloadExcelFile(Request $request) 
    {
      return Excel::download(new MessageExport($request->id), 'message.xlsx');
    } 

}
