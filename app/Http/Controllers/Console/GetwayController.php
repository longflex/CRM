<?php
namespace App\Http\Controllers\Console;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Getway;
use Laralum;
use DB;
use Ixudra\Curl\Facades\Curl;
class GetwayController extends Controller
{

    public function index() {
        # Get all getway
        $getway = Laralum::getway('user_id', Laralum::loggedInUser()->id );
		$default = DB::table('gateway_default')->first();
		//echo '<pre>';print_r($getway);die;
		foreach($getway  as $gate){
			$gate->promo =  $this->getAdminBalance($gate->promotional, $gate->gateway_name, $gate->authentication_string);
			$gate->trans =  $this->getAdminBalance($gate->transactional, $gate->gateway_name, $gate->authentication_string);
		}
        # Return the view
        return view('console/gateways/index', ['getways' => $getway, 'default'=> $default]);
    }

    public function create()
    {  
       
        # Return the view
        return view('console/gateways/create');
    }

     public function store(Request $request)
     {   

           //echo '<pre>';print_r($request->all());die;	 
          #validate te data 
          $request->validate([
			'gateway_name' => 'required',
			'send_sms_api' => 'required',
			'transactional' => 'required',
			'authentication_string' => 'required'
            ], 
			[
			'gateway_name.required' => 'The gateway name is required',
			'send_sms_api.required' => 'The sms api is required',
			'transactional.required' => 'The transactional sms id is required',
			'authentication_string.required' => 'The authentication string (API KEY) is required'
            ]);		
        # Save the data
		$row = Laralum::newGateway();
        $row->user_id = Laralum::loggedInUser()->id;
        $row->gateway_name = $request->gateway_name;
        $row->send_sms_api = $request->send_sms_api;
        $row->send_unicode_sms_api = $request->send_unicode_sms_api;
        $row->balance_sms_api = $request->balance_sms_api;
        $row->delivery_sms_api = $request->delivery_sms_api;
        $row->batch_size = $request->batch_size;
        $row->transactional = $request->transactional;
        $row->promotional = $request->promotional;
        $row->method = $request->method;
        $row->authentication_string = $request->authentication_string;
        $row->save();
        # Return the admin to the blogs page with a success message
        return redirect()->route('console::getway')->with('success', "The gateway has been created");
    }


    public function edit($id)
    {       
        # Check if gateway owner
         Laralum::mustOwnGatewayID($id);

        # Find the blog
       $row = Laralum::getway('id', $id)[0];

        # Get all the data
        $data_index = 'gateways';
        require('Data/Edit/Get.php');

        # Return the edit form
        return view('console/gateways/edit', [
            'row'       =>  $row,
            'fields'    =>  $fields,
            'confirmed' =>  $confirmed,
            'empty'     =>  $empty,
            'encrypted' =>  $encrypted,
            'hashed'    =>  $hashed,
            'masked'    =>  $masked,
            'table'     =>  $table,
            'code'      =>  $code,
            'wysiwyg'   =>  $wysiwyg,
            'relations' =>  $relations,
        ]);
    }

    public function update($id, Request $request)
    {
       
        # Check if gateway owner
        Laralum::mustOwnGatewayID($id);

        # Find the getway
        $row = Laralum::getway('id', $id)[0];

        if($row->user_id == Laralum::loggedInUser()->id AND Laralum::loggedInUser()->su) {
            # The user who's trying to modify the post is able to do such because it's the owner or it's su

            # Save the data
            $data_index = 'gateways';
            require('Data/Edit/Save.php');

            # Return the admin to the gateways page with a success message
            return redirect()->route('console::getway')->with('success', "The gateway has been edited");
        } else {
            #The user is not allowed to delete the blog
            abort(403, trans('laralum.error_not_allowed'));
        }
    }

    public function destroy(Request $request)
    {
		$gateway_id = $request->gateway_id;
      
        # Check if group owner
        Laralum::mustOwnGatewayID($gateway_id);

        # Find The Group
        $row = Laralum::getway('id', $gateway_id)[0];
        
    	if($row->user_id == Laralum::loggedInUser()->id AND Laralum::loggedInUser()->su) {
            # The user who's trying to delete the post is able to do such because it's the owner or it's su
        
            
            # Delete gateway
            $row->delete();

            # Return a redirect
            # Return the true
            return response()->json(array('success' => true, 'id' => $gateway_id), 200);
        } else {
            #The user is not allowed to delete the blog
            abort(403, trans('laralum.error_not_allowed'));
        }
    }
	#Set Default Method	
	  public function setDefault($id,$type) {		  
				if($type=='sms') {
					 DB::table('gateway_default')->update(['default_for_sms' => $id]);
				} elseif($type=='mms') {
					DB::table('gateway_default')->update(['default_for_mms' => $id]);
				} elseif($type=='unicode') {
					DB::table('gateway_default')->update(['default_for_unicode' => $id]);
				} elseif($type=='incoming') {
					DB::table('gateway_default')->update(['default_for_incoming' => $id]);
				}
		return redirect()->route('console::getway')->with('success', "Default set successfully!");
    }	

    protected function getAdminBalance($type, $gateway, $authkey)
	{
		if($gateway=='Msg91'){
		     $balance = Curl::to('https://control.msg91.com/api/balance.php')
				->withData(['authkey'=>$authkey, 'type'=>$type])
				->post();
		}elseif($gateway=='AutoBySMS'){			
			  $api_key = $authkey;
			  $api_url = "http://txt.mesms.in/app/miscapi/".$api_key."/getBalance/true/";
			  $balances = file_get_contents($api_url);
			  $json = json_decode($balances, true);
              $balance = $json[0]['BALANCE'];			  
		}
		
		return  $balance;
	}		
	
}
