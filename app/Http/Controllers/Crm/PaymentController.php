<?php
namespace App\Http\Controllers\Crm;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Lead;
use App\User;
use App\Donation;
use App\Payment;
use App\Exports\DonationExport;
use Maatwebsite\Excel\Facades\Excel;
use Laralum;
use Validator,DB,File;
use Response;
use PaytmWallet;
use paytm\checksum\PaytmChecksumLibrary;
use App\Http\Controllers\Crm\PaytmController;
use Razorpay\Api\Api;

class PaymentController extends Controller
{

    public function create()
    {

		$due_emis = DB::table('donations')
			->where('donations.payment_type', 'recurring')
			->where('recurring_payments.due_date', \Carbon\Carbon::today())
			->where('recurring_payments.emi_status', 0)
			->join('recurring_payments', 'recurring_payments.donation_id', '=', 'donations.id')
            ->select('donations.*', 'recurring_payments.*')->get();
			
		foreach($due_emis as $emi)
		{
			$donation_id = $emi->donation_id;
			$donated_by = $emi->donated_by;
			$payment_mode = $emi->payment_mode;
			$emi_amount = $emi->emi_amount;
			$receipt_number = $emi->receipt_number;
			$member =  DB::table('leads')->where('leads.id', $donated_by)->first();
			$user_id = $member->user_id;
			if ($payment_mode == 'Razorpay') {

				$api = new Api(User::where('id', $user_id)->value('RAZOR_KEY'), User::where('id', $user_id)->value('RAZOR_SECRET'));
				
				$Params = array();
				$Params = array(
					"type" => "link",
					"view_less" => 1,
					"amount" => intval($emi_amount).'00',
					"currency" => "INR",
					"description" =>  "Donation EMI",
					"receipt" =>  $receipt_number . mt_rand(1, 999999),
					"reminder_enable" =>  true,
					"sms_notify" => 1,
					"email_notify" => 1,
					"callback_url" =>  url('/payments/razorpaycallback?donation_id=' . $donation_id),
					"callback_method" => "get"
				);
				$Params["customer"] = array(
					"name"  => $member->name,
					"email" => $member->email,
					"contact" => $member->mobile
				);
				$response = $api->invoice->create($Params);
				//echo "<pre>";print_r($response);die;

				/*
				Send payment link to user.
				*/
				if (!empty($response)) {
					if (isset($response['status']) && $response['status'] == 'issued') {
						$short_url = $response['short_url'];
						//send message
						$authKey = "130199AKQsRsJy581b6dd5";
						$mobileNumber = $member->mobile;
						$senderId = "CSTACK";
						$message = urlencode("Your Emi is Due You can pay through this link: " . $short_url . "\n Please don't share with anyone");
						$route = 4;
						//Prepare you post parameters
						$postData = array('authkey' => $authKey, 'mobiles' => $mobileNumber, 'message' => $message, 'sender' => $senderId, 'route' => $route);
						//API URL
						$url = "http://sms.mesms.in/api/sendhttp.php";
						// init the resource
						$ch = curl_init();
						curl_setopt_array($ch, array(
							CURLOPT_URL => $url,
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_POST => true,
							CURLOPT_POSTFIELDS => $postData

						));
						//Ignore SSL certificate verification
						curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
						//get response
						$output = curl_exec($ch);
					}
				}
				curl_close($ch);
			}
		}
		die;
        # Return the view
        return view('crm/payment/create');
	}
	
	public function store(Request $request)
    {
		$input = $request->all();
        $input['order_id'] = rand(1,100).Laralum::loggedInUser()->id;       

		$donation = new Donation;
		$donation->client_id = $input['order_id'];
		$donation->branch_id = Laralum::loggedInUser()->branch;
		$donation->donation_type = $request->address;
		$donation->payment_mode = $request->payment_mode;
		$donation->amount = $request->amount;
		$donation->bank_name = $request->name;
		$donation->created_by = Laralum::loggedInUser()->id;
		$donation->reference_no = $request->reference_no;
		$donation->status = "pending";								
		//$donation->save();

		$data_for_request = $this->handlePaymentRequest($input['order_id'], $request->amount);
		
		/* for Staging */
		$payment_txn_url = "https://securegw-stage.paytm.in/theia/processTransaction";
		$checksum =	$data_for_request['checksum'];
		$paramlist = $data_for_request['paramlist'];

		// Payment through app
		//------------------------------
		/* for Staging */
		// $url = "https://securegw-stage.paytm.in/link/create";

		/* for Production */
		$url = "https://securegw.paytm.in/link/create";
		$paytmParams = array();

		$paytmParams["body"] = array(
			"mid"             => env('YOUR_MERCHANT_ID'),
			"linkName"        => "Test",
			"linkDescription" => "Test Payment",
			"linkType"        => "GENERIC",
			"amount"          =>  $request->amount,
			"bindLinkIdMobile" =>  $request->mobile_no,
			"partialPayment"  => true,
		);
		$paytmParams["body"]['customerContact'] = array(
			"customerName"    => $request->name,
			"customerMobile"    => $request->mobile_no,
		);
		/*
		* Generate checksum by parameters we have in body
		* Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
		*/
		$paytmParams["head"] = array(
			"tokenType"	      => "AES",
			"signature"	      => $checksum
		);
		echo "<pre>";print_r($paytmParams);

		$data = callAPI($url, $paytmParams);
		echo "<pre>";print_r($data);die('here..');

		$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
		$response = curl_exec($ch);
		echo "<pre>";print_r($response);


		//print_r($response);
		echo "<pre>";print_r($response);die('here..');
		//------------------------------
		
		return view('crm/payment/marchnatformcreate',compact('payment_txn_url','paramlist','checksum'));
	}
	


	/**
     * Obtain the payment information.
     *
     * @return Object
     */
    public function handlePaymentRequest($order_id, $amount)
    {
		// Load all the function from PaytmController
		PaytmController::getAllEncdecFunction();
		PaytmController::getConfigPaytmSettings();

		$checksum = '';
		$paramlist = array();
		$paytm_merchant_key = env('YOUR_MERCHANT_KEY');

		//Create an array having all required paramenters for creating Checksum.
		$paramlist["MID"] = env('YOUR_MERCHANT_ID');
		$paramlist["ORDER_ID"] = $order_id;
		$paramlist["CUST_ID"] = $order_id;
		$paramlist["INDUSTRY_TYPE_ID"] = "Retail";
		$paramlist["CHANNEL_ID"] = "WEB";
		$paramlist["TXN_AMOUNT"] = $amount;
		$paramlist["WEBSITE"] = "CALVARWAP";
		$paramlist["EMAIL"] = "sgsujay.achari@gmail.com";
		$paramlist["MOBILE_NO"] = "8123235678";
		$paramlist["CALLBACK_URL"] = url('/crm/admin/payments/callback');

		$checksum = getChecksumFromArray($paramlist, $paytm_merchant_key);

		return array(
			'checksum' => $checksum,
			'paramlist' => $paramlist
		);
	}
	
	public function paymentCallback(Request $request)
    {
		dd($request->all());
		return $request;
    }	
		
	public function razorpaycreate()
    {		
		$url = 'https://'.Laralum::loggedInUser()->RAZOR_KEY.':'.Laralum::loggedInUser()->RAZOR_SECRET.'@api.razorpay.com/v1/invoices';
		$paytmParams = array();
		$paytmParams = array(
			"type" => "link",
			"view_less" => 1,
			"amount" =>  100,
			"currency" => "INR",
			"description" =>  "Payment Link for this purpose - cvb.",
			"receipt" =>  "565455546",
			"reminder_enable" =>  true,
			"sms_notify" => 1,
			"email_notify" => 1,
			"expire_by" => 1793630556,
			"callback_url" =>  url('/crm/admin/payments/callback'),
			"callback_method" => "get" 
		);
		$paytmParams["customer"] = array(
			"name"  =>  "Acme Enterprises",
			"email" => "admin@aenterprises.com",
			"contact" => "9888942726"
		);

		$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		//curl_setopt($ch, CURLOPT_USERPWD, "api-key: ".env('RAZOR_KEY')); 
		$headers = array();
		$headers[] = 'Accept: application/json';
		$headers[] = 'Content-Type: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($ch);
		$response = json_decode($response,true);

		echo "<pre>";print_r($response);die;
		// curl_close($ch);


		# Return the view
        return view('crm/payment/razorpaycreate');
	}
		  
	
	public function razorpaystore(Request $request)
    {
		$input = $request->all();
		
		$api = new Api(Laralum::loggedInUser()->RAZOR_KEY, Laralum::loggedInUser()->RAZOR_SECRET);

        $payment = $api->payment->fetch($input['razorpay_payment_id']);
		echo "<pre>";print_r($payment);
		dd($request);
		die;
	}

	public function createplan()
    {
        # Return the view
        return view('crm/payment/createplan');
	}

	public function makeplan(Request $request)
    {
		$input = $request->all();

		$name = $request->name;
		$amount = $request->amount;
		$description = $request->description;
		$period = $request->period;

		$url = 'https://'.Laralum::loggedInUser()->RAZOR_KEY.':'.Laralum::loggedInUser()->RAZOR_SECRET.'@api.razorpay.com/v1/plans';
		$paytmParams = array();
		$paytmParams = array(
			"period"        => $period,
			"interval"      => ($period=='daily')? 7: 1, 
		);
		$paytmParams["item"] = array(
			"name"          => $name,
			"amount"        => $amount.'00',
			"currency"      => "INR",
			"description"   => $description,
		);

		$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		//curl_setopt($ch, CURLOPT_USERPWD, "api-key: ".env('RAZOR_KEY')); 
		$headers = array();
		$headers[] = 'Accept: application/json';
		$headers[] = 'Content-Type: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($ch);
		$response = json_decode($response,true);

		if ($response) {
			if ($response['id']) {
				$id = $response['id'];
			}
		}
		echo "<pre>";print_r($response);die;
		curl_close($ch);
		
        return view('crm/payment/razorpaycreate');
	}

	public function subscriptionspayment(Request $request)
    {
		$input = $request->all();
		
		$api = new Api(Laralum::loggedInUser()->RAZOR_KEY, Laralum::loggedInUser()->RAZOR_SECRET);

        $payment = $api->payment->fetch($input['razorpay_payment_id']);
		echo "<pre>";print_r($payment);
		dd($request);
		die;
	}


	
	public function razorpayCallback(Request $request)
    {
		$donation_id = $request['donation_id'];
		$razorpay_payment_id = $request['razorpay_payment_id'];
		$razorpay_invoice_id = $request['razorpay_invoice_id'];
		$razorpay_invoice_status = $request['razorpay_invoice_status'];
		$razorpay_invoice_receipt = $request['razorpay_invoice_receipt'];
		
		//$api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
		//$api = new Api(Laralum::loggedInUser()->RAZOR_KEY, Laralum::loggedInUser()->RAZOR_SECRET);
		//$payment = $api->payment->fetch($razorpay_payment_id);
	
		
		$payment = new Payment;
		$payment->donation_id = $donation_id;
		$payment->transaction_id = $razorpay_payment_id;
		//$payment->amount = $amount;
		//$payment->currency = $currency;
		$payment->status = $razorpay_invoice_status;
		//$payment->email = $email;
		//$payment->phone = $contact;
		//$payment->description = $description;
		$payment->method = "Razorpay - ";
		$payment->data = '';
		$payment->save();

		DB::table('donations')
			->where('id', $donation_id)
			->update(['payment_status' => 1,'status' => 'Success']);
		
		if(isset($request['emi_id'])){
			$emi_id = $request['emi_id'];
			DB::table('recurring_payments')
					->where('id', $emi_id)
					->update(['emi_status' => 1]);
		}


		$donated_by = Donation::where('id', $donation_id)->value('donated_by');
		if($donated_by != '')
		{
			$member =  DB::table('leads')->where('leads.id', $donated_by)->first();
			if(!empty($member))
			{
				$name = $member->name;
				$email = $member->email;
				$mobile	= $member->mobile;
				//send message
				$authKey = "130199AKQsRsJy581b6dd5";
				$mobileNumber = $mobile;
				$senderId = "CSTACK";
				$message = urlencode("Your Payment is Successfully Received! \nThank You!");
				$route = 4;
				//Prepare you post parameters
				$postData = array('authkey' => $authKey, 'mobiles' => $mobileNumber, 'message' => $message, 'sender' => $senderId, 'route' => $route);
				//API URL
				$url = "http://sms.mesms.in/api/sendhttp.php";
				// init the resource
				$ch = curl_init();
				curl_setopt_array($ch, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => $postData

				));
				//Ignore SSL certificate verification
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				//get response
				$output = curl_exec($ch);
			}
			
		}
		

		return view('crm/payment/thankyou');
	}	
	
	public function recurringJob()
    {
		$due_emis = DB::table('donations')
			->where('donations.payment_type', 'recurring')
			->where('recurring_payments.due_date', \Carbon\Carbon::today())
			->where('recurring_payments.emi_status', 0)
			->join('recurring_payments', 'recurring_payments.donation_id', '=', 'donations.id')
            ->select('donations.*', 'recurring_payments.*')->get();
			
		foreach($due_emis as $emi)
		{
			$emi_id = $emi->id;
			$donation_id = $emi->donation_id;
			$donated_by = $emi->donated_by;
			$payment_mode = $emi->payment_mode;
			$emi_amount = $emi->emi_amount;
			$receipt_number = $emi->receipt_number;
			$member =  DB::table('leads')->where('leads.id', $donated_by)->first();
			$user_id = $member->user_id;
			if ($payment_mode == 'Razorpay') {

				$api = new Api(User::where('id', $user_id)->value('RAZOR_KEY'), User::where('id', $user_id)->value('RAZOR_SECRET'));
				
				$Params = array();
				$Params = array(
					"type" => "link",
					"view_less" => 1,
					"amount" => intval($emi_amount).'00',
					"currency" => "INR",
					"description" =>  "Donation EMI",
					"receipt" =>  $receipt_number . mt_rand(1, 999999),
					"reminder_enable" =>  true,
					"sms_notify" => 1,
					"email_notify" => 1,
					"callback_url" =>  url('/payments/razorpaycallback?donation_id=' . $donation_id.'&emi_id='.$emi_id),
					"callback_method" => "get"
				);
				$Params["customer"] = array(
					"name"  => $member->name,
					"email" => $member->email,
					"contact" => $member->mobile
				);
				$response = $api->invoice->create($Params);
				//echo "<pre>";print_r($response);die;

				/*
				Send payment link to user.
				*/
				if (!empty($response)) {
					if (isset($response['status']) && $response['status'] == 'issued') {
						$short_url = $response['short_url'];
						//send message
						$authKey = "130199AKQsRsJy581b6dd5";
						$mobileNumber = $member->mobile;
						$senderId = "CSTACK";
						$message = urlencode("Your Emi is Due You can pay through this link: " . $short_url . "\n Please don't share with anyone");
						$route = 4;
						//Prepare you post parameters
						$postData = array('authkey' => $authKey, 'mobiles' => $mobileNumber, 'message' => $message, 'sender' => $senderId, 'route' => $route);
						//API URL
						$url = "http://sms.mesms.in/api/sendhttp.php";
						// init the resource
						$ch = curl_init();
						curl_setopt_array($ch, array(
							CURLOPT_URL => $url,
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_POST => true,
							CURLOPT_POSTFIELDS => $postData

						));
						//Ignore SSL certificate verification
						curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
						//get response
						$output = curl_exec($ch);
					}
				}
				curl_close($ch);
			}
		}
	}

	
	public function sendPaymentLinkSMS(Request $request)
    {
		$donation_id = $request['donation_id'];
		$donation = DB::table('donations')->where('id', $donation_id)->first();
		/*
		Razorpay fixed payment link creation
		*/
		if ($donation->payment_mode == 'Razorpay' && $donation->payment_type == 'single') {

			$razorKey = Laralum::loggedInUser()->RAZOR_KEY;
			
			if($razorKey == '' || $razorKey == null){
				$api = new Api(User::where('id', Laralum::loggedInUser()->reseller_id)->value('RAZOR_KEY'),User::where('id', Laralum::loggedInUser()->reseller_id)->value('RAZOR_SECRET'));
			}else{
				$api = new Api(Laralum::loggedInUser()->RAZOR_KEY, Laralum::loggedInUser()->RAZOR_SECRET);
			}

			//$client = DB::table('leads')->where('client_id', $client_id)->orderBy('leads.id', 'desc')->first();
			$lead = DB::table('leads')->where('id', $donation->donated_by)->first();
			$Params = array();
			$Params = array(
				"type" => "link",
				"view_less" => 1,
				"amount" =>  $donation->amount . '00',
				"currency" => "INR",
				"description" =>  "Donation",
				"receipt" =>  $donation->receipt_number . mt_rand(1, 999999),
				"reminder_enable" =>  true,
				"sms_notify" => 1,
				"email_notify" => 1,
				"callback_url" =>  url('/payments/razorpaycallback?donation_id=' . $donation->id),
				"callback_method" => "get"
			);
			$Params["customer"] = array(
				"name"  => $lead->name,
				"email" => $lead->email,
				"contact" => $lead->mobile
			);
			$response = $api->invoice->create($Params);

			/*
			Send payment link to user.
			*/
			// $template=DB::table('sms_templates')->where('id', 3)->first();
			// $messgae=str_replace('$N',$user->first_name, $email_template->body)
			if (!empty($response)) {
				if (isset($response['status']) && $response['status'] == 'issued') {
					$short_url = $response['short_url'];
					//send message
					$authKey = "130199AKQsRsJy581b6dd5";
					$mobileNumber = $lead->mobile;
					$senderId = "CSTACK";
					$message = urlencode("You can pay through this link: " . $short_url . "\n Please don't share with anyone");
					$route = 4;
					//Prepare you post parameters
					$postData = array('authkey' => $authKey, 'mobiles' => $mobileNumber, 'message' => $message, 'sender' => $senderId, 'route' => $route);
					//API URL
					$url = "http://sms.mesms.in/api/sendhttp.php";
					// init the resource
					$ch = curl_init();
					curl_setopt_array($ch, array(
						CURLOPT_URL => $url,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_POST => true,
						CURLOPT_POSTFIELDS => $postData

					));
					//Ignore SSL certificate verification
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
					//get response
					$output = curl_exec($ch);
				}
			}
			curl_close($ch);

			$returnData = array(
				'status' => 'success',
				'message' => 'Payment link is sent successfully!'
			);
		
			return response()->json($returnData);
		}

	}

	
	public function sendEMIPaymentLinkSMS(Request $request)
    {
		$emi_id = $request['emi_id'];
		$emi = DB::table('recurring_payments')->where('id', $emi_id)->first();
		
		$donation_id = $emi->donation_id;
		$emi_amount = $emi->emi_amount;
		$donation = DB::table('donations')->where('id', $donation_id)->first();
		
		/*
		Razorpay fixed payment link creation
		*/
		if ($donation->payment_mode == 'Razorpay') {

			//$api = new Api(Laralum::loggedInUser()->RAZOR_KEY, Laralum::loggedInUser()->RAZOR_SECRET);
			$razorKey = Laralum::loggedInUser()->RAZOR_KEY;
			if($razorKey == '' || $razorKey == null){
				$api = new Api(User::where('id', Laralum::loggedInUser()->reseller_id)->value('RAZOR_KEY'), User::where('id', Laralum::loggedInUser()->reseller_id)->value('RAZOR_SECRET'));
			}else{
				$api = new Api(Laralum::loggedInUser()->RAZOR_KEY, Laralum::loggedInUser()->RAZOR_SECRET);
			}
			//$client = DB::table('leads')->where('client_id', $client_id)->orderBy('leads.id', 'desc')->first();
			$lead = DB::table('leads')->where('id', $donation->donated_by)->first();
			$Params = array();
			$Params = array(
				"type" => "link",
				"view_less" => 1,
				"amount" =>  intval($emi_amount) . '00',
				"currency" => "INR",
				"description" =>  "Donation",
				"receipt" =>  $donation->receipt_number . mt_rand(1, 999999),
				"reminder_enable" =>  true,
				"sms_notify" => 1,
				"email_notify" => 1,
				"callback_url" => url('/payments/razorpaycallback?donation_id=' . $donation_id.'&emi_id='.$emi_id),
				"callback_method" => "get"
			);
			$Params["customer"] = array(
				"name"  => $lead->name,
				"email" => $lead->email,
				"contact" => $lead->mobile
			);
			$response = $api->invoice->create($Params);

			/*
			Send payment link to user.
			*/
			if (!empty($response)) {
				if (isset($response['status']) && $response['status'] == 'issued') {
					$short_url = $response['short_url'];
					//send message
					$authKey = "130199AKQsRsJy581b6dd5";
					$mobileNumber = $lead->mobile;
					$senderId = "CSTACK";
					$message = urlencode("Your EMI payment is pending, You can pay through this link: " . $short_url . "\n Please don't share with anyone");
					$route = 4;
					//Prepare you post parameters
					$postData = array('authkey' => $authKey, 'mobiles' => $mobileNumber, 'message' => $message, 'sender' => $senderId, 'route' => $route);
					//API URL
					$url = "http://sms.mesms.in/api/sendhttp.php";
					// init the resource
					$ch = curl_init();
					curl_setopt_array($ch, array(
						CURLOPT_URL => $url,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_POST => true,
						CURLOPT_POSTFIELDS => $postData

					));
					//Ignore SSL certificate verification
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
					//get response
					$output = curl_exec($ch);
				}
			}
			curl_close($ch);

			// $returnData = array(
			// 	'status' => 'success',
			// 	'message' => 'Payment link is sent successfully!'
			// );
		
			// return response()->json($returnData);
			$msg="Payment link is sent successfully!";
			return response()->json(array('success' => true, 'status' => true,'message' => $msg), 200);
		}

	}

}
