<?php

namespace App\Http\Controllers\Crm;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Lead;
use App\User;
use App\Donation;
use App\IncommingLead;
use App\Services\DonationService;
use App\Exports\DonationExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Laralum\Laralum;
use Validator, File;
use Response;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\DB;
use App\Imports\DonationImport;


class DonationController extends Controller
{

	public function __construct(DonationService $donation)
    {
        $this->donation = $donation;
    }

	public function index(Request $request)
	{
		//Laralum::permissionToAccess('laralum.donation.access');
		Laralum::permissionToAccess('laralum.donation.list');
		//Laralum::permissionToAccess('laralum.donation.view');
		// $donation_type = $request->donation_type;
		// $payment_mode = $request->payment_mode;
		// $from_date = $request->from_date;
		// $to_date = $request->to_date;
		// # Get all appointments for admin
		$agent_id = NULL;
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
			$agent_id = Laralum::loggedInUser()->id;
		}
		
		// $donations = DB::table('donations')
		// 	->when($donation_type, function ($query, $donation_type) {
		// 		return $query->where('donations.donation_type', $donation_type);
		// 	})
		// 	->when($payment_mode, function ($query, $payment_mode) {
		// 		return $query->where('donations.payment_mode', $payment_mode);
		// 	})
		// 	->when($from_date, function ($query, $from_date) {
		// 		return $query->whereDate('donations.created_at', '>=', $from_date);
		// 	})
		// 	->when($to_date, function ($query, $to_date) {
		// 		return $query->whereDate('donations.created_at', '<=', $to_date);
		// 	})
		// 	->where('donations.created_by', Laralum::loggedInUser()->id)
		// 	->join('leads', 'donations.donated_by', '=', 'leads.id')
		// 	->select('donations.*', 'leads.name', 'leads.email', 'leads.mobile', 'leads.address')
		// 	->orderBy('donations.id', 'desc')
		// 	->paginate(12);

		// foreach ($donations as $key => $donation) {
		// 	$donation->donation_purpose = DB::table('donation_purpose')
		// 		->where('id', '=', $donation->donation_purpose)
		// 		->pluck('purpose')->first();
		// }
		// if (Laralum::loggedInUser()->reseller_id == 0) {
		// 	$donations = DB::table('donations')
		// 		->when($donation_type, function ($query, $donation_type) {
		// 			return $query->where('donations.donation_type', $donation_type);
		// 		})
		// 		->when($payment_mode, function ($query, $payment_mode) {
		// 			return $query->where('donations.payment_mode', $payment_mode);
		// 		})
		// 		->when($from_date, function ($query, $from_date) {
		// 			return $query->whereDate('donations.created_at', '>=', $from_date);
		// 		})
		// 		->when($to_date, function ($query, $to_date) {
		// 			return $query->whereDate('donations.created_at', '<=', $to_date);
		// 		})
		// 		->where('donations.client_id', Laralum::loggedInUser()->id)
		// 		->join('leads', 'donations.donated_by', '=', 'leads.id')
		// 		->select('donations.*', 'leads.name', 'leads.email', 'leads.mobile')
		// 		->orderBy('donations.id', 'desc')
		// 		->paginate(12);
		// } else {

		// }
		$donation_purposes = DB::table('donation_purpose')->where('user_id', $client_id)->get();
		$branches = DB::table('branch')
					->where('client_id', $client_id)
					->get();
		$users = DB::table('users')
				->select('id', 'name')
				->where('reseller_id', $client_id)
				->get();
		$razorKey = Laralum::loggedInUser()->RAZOR_KEY;
			
		if($razorKey == '' || $razorKey == null){
			$razorKey = User::where('id', Laralum::loggedInUser()->reseller_id)->value('RAZOR_KEY');
		}
		$membertypes = DB::table('member_types')->where('user_id', $client_id)->get();
		$campaigns = DB::table('campaigns')
					->leftJoin('campaign_agents', 'campaigns.id', '=', 'campaign_agents.campaign_id')
					->leftJoin('campaigns_selecteds', 'campaigns.id', '=', 'campaigns_selecteds.campaign_id')
					->where('campaigns.client_id', $client_id)
					->when($agent_id, function ($query, $agent_id) {
	                    return $query->where('campaign_agents.agent_id', $agent_id);
	                })

					->orderBy('campaigns.id', 'desc')
					->groupBy('campaigns.id')
					->select('campaigns.*','campaigns_selecteds.campaign_check')
					->get();
			
		# Return the view  crm/donations/index  , ['donations' => $donations, 'client_id' => $client_id]


		
		return view('hyper/donation/index', ['donation_purposes'=>$donation_purposes,'branches'=>$branches,'users'=>$users,'razorKey' => $razorKey,'membertypes' => $membertypes,'client_id' => $client_id, 'campaigns'=>$campaigns]);
	}

	public function dashboard(Request $request)
	{
		Laralum::permissionToAccess('laralum.donation.dashboard');

		# Get all leads for admin
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$sponser = DB::table('donations')->where('client_id', Laralum::loggedInUser()->id)->where('donation_type', 1)->sum('amount');
			$land = DB::table('donations')->where('client_id', Laralum::loggedInUser()->id)->where('donation_type', 2)->sum('amount');
			$total = DB::table('donations')->where('client_id', Laralum::loggedInUser()->id)->sum('amount');
			$todays = DB::table('donations')->where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d"))->sum('amount');
			$card = DB::table('donations')->where('client_id', Laralum::loggedInUser()->id)->where('payment_mode', 'CASH')->sum('amount');
			$cash = DB::table('donations')->where('client_id', Laralum::loggedInUser()->id)->where('payment_mode', 'CARD')->sum('amount');
			$cheque = DB::table('donations')->where('client_id', Laralum::loggedInUser()->id)->where('payment_mode', 'CHEQUE')->sum('amount');
		} else {
			$sponser = DB::table('donations')->where('created_by', Laralum::loggedInUser()->id)->where('donation_type', 1)->sum('amount');
			$land = DB::table('donations')->where('created_by', Laralum::loggedInUser()->id)->where('donation_type', 2)->sum('amount');
			$total = DB::table('donations')->where('created_by', Laralum::loggedInUser()->id)->sum('amount');
			$todays = DB::table('donations')->where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d"))->sum('amount');
			$card = DB::table('donations')->where('created_by', Laralum::loggedInUser()->id)->where('payment_mode', 'CASH')->sum('amount');
			$cash = DB::table('donations')->where('created_by', Laralum::loggedInUser()->id)->where('payment_mode', 'CARD')->sum('amount');
			$cheque = DB::table('donations')->where('created_by', Laralum::loggedInUser()->id)->where('payment_mode', 'CHEQUE')->sum('amount');
		}
		$account_types = DB::table('account_types')->get();
		# Return the view
		return view('crm/donations/dashboard', [
			'sponser' => $this->number_format_short($sponser),
			'land' => $this->number_format_short($land),
			'total' => $this->number_format_short($total),
			'todays' => $this->number_format_short($todays),
			'card' => $this->number_format_short($card),
			'cash' => $this->number_format_short($cash),
			'cheque' => $this->number_format_short($cheque),
		]);
	}

	public function donationsDashboardFilter(Request $request)
	{
		$exp_requested_date = explode("-", $request->data);
		$from = $exp_requested_date[0];
		$to = $exp_requested_date[1];

		$from_date = date('Y-m-d H:i:s', strtotime($from));
		$to_date = date('Y-m-d H:i:s', strtotime($to));

		# Get all donation for admin
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$sponser = DB::table('donations')->where('client_id', Laralum::loggedInUser()->id)->where('donation_type', 1)->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->sum('amount');
			$land = DB::table('donations')->where('client_id', Laralum::loggedInUser()->id)->where('donation_type', 2)->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->sum('amount');
			$total = DB::table('donations')->where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->sum('amount');
			$todays = DB::table('donations')->where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d"))->sum('amount');
			$card = DB::table('donations')->where('client_id', Laralum::loggedInUser()->id)->where('payment_mode', 'CASH')->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->sum('amount');
			$cash = DB::table('donations')->where('client_id', Laralum::loggedInUser()->id)->where('payment_mode', 'CARD')->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->sum('amount');
			$cheque = DB::table('donations')->where('client_id', Laralum::loggedInUser()->id)->where('payment_mode', 'CHEQUE')->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->sum('amount');
		} else {
			$sponser = DB::table('donations')->where('created_by', Laralum::loggedInUser()->id)->where('donation_type', 1)->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->sum('amount');
			$land = DB::table('donations')->where('created_by', Laralum::loggedInUser()->id)->where('donation_type', 2)->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->sum('amount');
			$total = DB::table('donations')->where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->sum('amount');
			$todays = DB::table('donations')->where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d"))->sum('amount');
			$card = DB::table('donations')->where('created_by', Laralum::loggedInUser()->id)->where('payment_mode', 'CASH')->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->sum('amount');
			$cash = DB::table('donations')->where('created_by', Laralum::loggedInUser()->id)->where('payment_mode', 'CARD')->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->sum('amount');
			$cheque = DB::table('donations')->where('created_by', Laralum::loggedInUser()->id)->where('payment_mode', 'CHEQUE')->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->sum('amount');
		}

		return response()->json(array(
			'success' => true,
			'status' => 'success',
			'sponser' => $this->number_format_short($sponser),
			'land' => $this->number_format_short($land),
			'total' => $this->number_format_short($total),
			'todays' => $this->number_format_short($todays),
			'card' => $this->number_format_short($card),
			'cash' => $this->number_format_short($cash),
			'cheque' => $this->number_format_short($cheque),
		), 200);
	}

	public function create()
	{
		Laralum::permissionToAccess('laralum.donation.create');
		//Laralum::permissionToAccess('laralum.lead.view');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$membertypes = DB::table('member_types')->where('user_id', $client_id)->get();
		$branches = DB::table('branch')->where('client_id', $client_id)->get();
		$donation_purposes = DB::table('donation_purpose')->where('user_id', $client_id)->get();
		$razorKey = Laralum::loggedInUser()->RAZOR_KEY;
		# Return the view crm/donations/create
		return view('hyper/donation/create', compact('membertypes', 'branches', 'donation_purposes', 'razorKey'));
	}

	public function store(Request $request)
	{
		Laralum::permissionToAccess('laralum.donation.create');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$donation_date=NULL;
		if ($request->donation_decision== 0 || $request->donation_decision== 2 ) {
			$donation_date = date('Y-m-d');
		} else {
			$donation_date = ($request->donation_date !='') ? date('Y-m-d',strtotime($request->donation_date)) : NULL;
		}

		if ($request->donation_decision== 2) {
			$paymentStatus = 1 ;
		} else {
			$paymentStatus = $request->payment_status;
		}
		$lead_id  = $request->lead_id;
		$donation = new Donation;
		$donation->client_id = $client_id;
		$donation->branch_id = Laralum::loggedInUser()->branch;
		$donation->donation_type = $request->donation_type;
		$donation->payment_method = $request->payment_method;
		$donation->payment_status = $paymentStatus;
		$donation->donation_purpose = $request->donation_purpose;
		$donation->payment_type = $request->payment_type;
		$donation->payment_period = $request->payment_period;
		$donation->payment_start =($request->payment_start_date !='') ? date('Y-m-d',strtotime($request->payment_start_date)) : NULL;
		$donation->payment_end =($request->payment_end_date !='') ? date('Y-m-d',strtotime($request->payment_end_date)) : NULL;
		$donation->payment_mode = $request->payment_mode;
		$donation->amount = $request->amount;
		$donation->location = $request->location;
		$donation->cheque_number = $request->cheque_number;
		$donation->bank_branch = $request->branch_name;
		$donation->bank_name = $request->bank_name;
		$donation->cheque_date =($request->cheque_date !='') ? date('Y-m-d',strtotime($request->cheque_date)) : NULL;
		$donation->donated_by = $lead_id;
		$donation->created_by = Laralum::loggedInUser()->id;
		$donation->reference_no = $request->reference_no;
		$donation->status = "Success";
		$donation->donation_date = $donation_date;
		$donation->donation_decision = $request->donation_decision;
		$donation->donation_decision_type = ($request->donation_decision_type !='') ? $request->donation_decision_type : NULL;
		$donation->gift_issued = $request->gift_issued;

		$donation->save();
		
		if ($donation->id) {
			$org_name = DB::table('organization_profile')->select('organization_name')->where('client_id', $client_id)->first();
			$string = $org_name->organization_name;
			$s = ucfirst($string);
			$bar = ucwords(strtoupper($s));
			$receipt = '';
			foreach (explode(' ', $bar) as $word) {
				$receipt .= strtoupper($word[0]);
			}
			//$orgname = preg_replace('/\s+/', '', $bar);
			$receipt = $receipt . (str_pad((int)$donation->id + 1, 3, '0', STR_PAD_LEFT));
			DB::table('donations')
				->where('id', $donation->id)
				->update(['receipt_number' => $receipt]);
			/*
			For Recuring payment
			*/
			if ($request->payment_type == "recurring") {
				$payment_period = $request->payment_period;
				$payment_start_date = $request->payment_start_date;
				$payment_end_date = $request->payment_end_date;
				$amount = $request->amount;
				$start = \Carbon\Carbon::parse($payment_start_date);
				$end = \Carbon\Carbon::parse($payment_end_date);
				$installment = '';
				if ($payment_period == 'daily') {
					$installment = $start->diffInDays($end);
					for ($i = 0; $i < $installment; $i++) {
						DB::table('recurring_payments')->insert(
							[
								'donation_id' => $donation->id,
								'emi_amount' => $amount / $installment,
								'emi_period' => ($start->format('d/m/y') . ' - ' . $start->addDays(1)->format('d/m/y')),
								'emi_status' => 0,
								'due_date' => date($start),
								'paid_date' => '',
								'created_at' => date('Y-m-d H:i:s')
							]
						);
					}
				}
				if ($payment_period == 'weekly') {
					$installment = $start->diffInWeeks($end);
					for ($i = 0; $i < $installment; $i++) {
						DB::table('recurring_payments')->insert(
							[
								'donation_id' => $donation->id,
								'emi_amount' => $amount / $installment,
								'emi_period' => ($start->format('d/m/y') . ' - ' . $start->addWeeks(1)->format('d/m/y')),
								'emi_status' => 0,
								'due_date' => date($start),
								'paid_date' => '',
								'created_at' => date('Y-m-d H:i:s')
							]
						);
					}
				}
				if ($payment_period == 'monthly') {
					$installment = $start->diffInMonths($end);
					for ($i = 0; $i < $installment; $i++) {
						DB::table('recurring_payments')->insert(
							[
								'donation_id' => $donation->id,
								'emi_amount' => $amount / $installment,
								'emi_period' => ($start->format('d/m/y') . ' - ' . $start->addMonths(1)->format('d/m/y')),
								'emi_status' => 0,
								'due_date' => date($start),
								'paid_date' => '',
								'created_at' => date('Y-m-d H:i:s')
							]
						);
					}
				}
				if ($payment_period == 'yearly') {
					$installment = $start->diffInYears($end);
					for ($i = 0; $i < $installment; $i++) {
						DB::table('recurring_payments')->insert([
							'donation_id' => $donation->id,
							'emi_amount' => $amount / $installment,
							'emi_period' => ($start->format('d/m/y') . ' - ' . $start->addYear(1)->format('d/m/y')),
							'emi_status' => 0,
							'due_date' => date($start),
							'paid_date' => '',
							'created_at' => date('Y-m-d H:i:s')
						]);
					}
				}
			}
			/*
			Razorpay fixed payment link creation
			*/
			if ($request->payment_mode == 'Razorpay' && $request->payment_type == 'single') 
			{
				//$api = new Api(Laralum::loggedInUser()->RAZOR_KEY, Laralum::loggedInUser()->RAZOR_SECRET);
				$api = new Api(User::where('id', $client_id)->value('RAZOR_KEY'), User::where('id', $client_id)->value('RAZOR_SECRET'));

				//$client = DB::table('leads')->where('client_id', $client_id)->orderBy('leads.id', 'desc')->first();
				$lead = DB::table('leads')->where('id', $lead_id)->first();
				$Params = array();
				$Params = array(
					"type" => "link",
					"view_less" => 1,
					"amount" =>  $request->amount . '00',
					"currency" => "INR",
					"description" =>  "Donation",
					"receipt" =>  $receipt . mt_rand(1, 999999),
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
				//echo "<pre>";print_r($response);die;

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
			}
		}

		# Return the admin to the blogs page with a success message
		return response()->json(array('success' => true, 'status' => true), 200);
	}

	public function edit($id)
	{
		Laralum::permissionToAccess('laralum.donation.edit');
		//Laralum::permissionToAccess('laralum.donation.edit');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		# Check permissions to access
		//Laralum::permissionToAccess('laralum.senderid.access');
		$membertypes = DB::table('member_types')->where('user_id', $client_id)->get();
		# Find the donation
		$donation = DB::table('donations')->where('id', $id)->first();
		# Return the edit form
		return view('hyper/donation/edit', compact('donation', 'membertypes'));
	}

	/**
	 *@author {Para}
	 *@description {Function to show payment detail screen for reccuring}
	 */
	public function paymentDetail($id)
	{
		
	// echo "<pre>";
	// print_r($donations);die;
		// $emis = [];

		// $emis = DB::table('donations')
		// 	->where('donations.id', $id)
		// 	->join('recurring_payments', 'recurring_payments.donation_id', '=', 'donations.id')
		// 	->select('donations.*', 'recurring_payments.*')->get();

		// if ($emis->isEmpty()) {
		// 	$donation = DB::table('donations')->where('id', $id)->first();
		// 	$end = \Carbon\Carbon::parse($donation->payment_end);
		// 	$start = \Carbon\Carbon::parse($donation->payment_start);
		// 	$months = $start->diffInMonths($end);
		// 	for ($i = 0; $i < $months; $i++) {
		// 		DB::table('recurring_payments')->insert(
		// 			['donation_id' => $donation->id, 'emi_amount' => $donation->amount / $months, 'emi_period' => ($start->format('d/m/y') . ' - ' . $start->addMonth(1)->format('d/m/y')), 'emi_status' => 0, 'paid_date' => '', 'created_at' => date('Y-m-d H:i:s')]
		// 		);
		// 		// array_push($emis, ((object)['date' =>($start->format('d/m/y').' - '.$start->addMonth(1)->format('d/m/y')) , 'amount' => $donation->amount/$months, 'Status' => 'Pending','mode'=>$donation->payment_mode,'location'=>$donation->location]));
		// 	}
		// 	$emis = DB::table('donations')
		// 		->where('donations.id', $id)
		// 		->join('recurring_payments', 'recurring_payments.donation_id', '=', 'donations.id')
		// 		->select('donations.*', 'recurring_payments.*')->get();
		// }
		$member = '';
		$donated_by = Donation::where('id', $id)->value('donated_by');
		if($donated_by != '')
		{
			$member =  DB::table('leads')->where('leads.id', $donated_by)->first();
		}
		return view('hyper/donation/payment_detail', compact('id','member'));//'emis',  crm/donations/payment_detail
	}
	public function updatePaymentDetail(Request $request)
	{
		//Laralum::permissionToAccess('laralum.donation.access');
		//Laralum::permissionToAccess('laralum.donation.edit');

		DB::table('recurring_payments')->where('id', $request->id)->update([
			'emi_status' => $request->value,
			'paid_date' => date('Y-m-d')
		]);

		if($request->value){
			
			$donation_id = DB::table('recurring_payments')->where('id', $request->id)->value('donation_id');

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
					$message = urlencode("Your EMI Payment is Successfully Received! \nThank You!");
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
		}
		$msg="Payment detail updated successfully.";
		# Return the admin to the donation page with a success message
		return response()->json(array('success' => true, 'status' => true, 'message' => $msg, 'id' => $request->id), 200);
	}

	public function updateDonationPaymentDetail(Request $request)
	{
		$donation_id = $request->donation_id;
		Donation::where('id', $donation_id)->update([
			'payment_status' => 1,
			'donation_date' => date('Y-m-d')
		]);

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
				$message = urlencode("Your Donation Payment is Successfully Received! \nThank You!");
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
		$msg="Donation payment status updated to paid successfully.";
		# Return the admin to the donation page with a success message
		return response()->json(array('success' => true, 'status' => true,'message' => $msg, 'data' => $request->id), 200);
	}

	public function updateDonation(Request $request)
	{
		Laralum::permissionToAccess('laralum.donation.edit');
		//Laralum::permissionToAccess('laralum.donation.edit');

		# Check permissions
		//Laralum::permissionToAccess('laralum.senderid.access');

		DB::table('donations')->where('id', $request->donation_id)->update([
			'donation_type' => $request->donation_type,
			'payment_mode' => $request->payment_mode,
			'amount' => $request->amount,
			'reference_no' => $request->reference_no,
			'bank_name' => $request->bank_name,
			'cheque_number' => $request->cheque_number,
			'bank_branch' => $request->branch_name,
			'cheque_date' => $request->cheque_date,
		]);

		# Return the admin to the donation page with a success message
		return response()->json(array('success' => true, 'status' => 'success'), 200);
	}

	public function show($id)
	{
		//Laralum::permissionToAccess('laralum.donation.view');
		Laralum::permissionToAccess('laralum.donation.view');
		$donation = DB::table('donations')
			->where('donations.id', $id)
			->join('leads', 'leads.id', '=', 'donations.donated_by')
			->select('donations.*', 'leads.name', 'leads.mobile', 'leads.address')
			->first();
		$org_profile = DB::table('organization_profile')
			->where('client_id', $donation->client_id)
			->first();
		$amount = $this->getIndianCurrency((int)$donation->amount);
//dd($donation);
		return view('hyper/donation/show', [
			'donations' => $donation,
			'org_profile' => $org_profile,
			'amount' => $amount,
		]);
	}
	public function printEmi($id)
	{
		$donation = DB::table('recurring_payments')
			->where('recurring_payments.id', $id)
			->join('donations', 'donations.id', '=', 'recurring_payments.donation_id')
			->join('leads', 'leads.id', '=', 'donations.donated_by')
			->select('donations.*', 'recurring_payments.*', 'leads.name', 'leads.mobile', 'leads.address')
			->first();
		$org_profile = DB::table('organization_profile')
			->where('client_id', $donation->client_id)
			->first();
		$amount = $this->getIndianCurrency((int)$donation->emi_amount);
		return view('crm/donations/payment_detail_print', [
			'donations' => $donation,
			'org_profile' => $org_profile,
			'amount' => $amount,
		]);
	}

	public function getIndianCurrency(float $number)
	{
		$decimal = round($number - ($no = floor($number)), 2) * 100;
		$hundred = null;
		$digits_length = strlen($no);
		$i = 0;
		$str = array();
		$words = array(
			0 => '', 1 => 'One', 2 => 'Two',
			3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
			7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
			10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
			13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
			16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
			19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
			40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
			70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
		);
		$digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
		while ($i < $digits_length) {
			$divider = ($i == 2) ? 10 : 100;
			$number = floor($no % $divider);
			$no = floor($no / $divider);
			$i += $divider == 10 ? 1 : 2;
			if ($number) {
				$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
				$hundred = ($counter == 1 && $str[0]) ? ' And ' : null;
				$str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
			} else $str[] = null;
		}
		$Rupees = implode('', array_reverse($str));
		$paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
		return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
	}

	function number_format_short($n, $precision = 1)
	{
		if ($n < 900) {
			// 0 - 900
			$n_format = number_format($n, $precision);
			$suffix = '';
		} else if ($n < 900000) {
			// 0.9k-850k
			$n_format = number_format($n / 1000, $precision);
			$suffix = 'K';
		} else if ($n < 900000000) {
			// 0.9m-850m
			$n_format = number_format($n / 1000000, $precision);
			$suffix = 'M';
		} else if ($n < 900000000000) {
			// 0.9b-850b
			$n_format = number_format($n / 1000000000, $precision);
			$suffix = 'B';
		} else {
			// 0.9t+
			$n_format = number_format($n / 1000000000000, $precision);
			$suffix = 'T';
		}

		// Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
		// Intentionally does not affect partials, eg "1.50" -> "1.50"
		if ($precision > 0) {
			$dotzero = '.' . str_repeat('0', $precision);
			$n_format = str_replace($dotzero, '', $n_format);
		}

		return $n_format . $suffix;
	}


	public function destroy(Request $request, $id)
	{
		//Laralum::permissionToAccess('laralum.donation.access');
		Laralum::permissionToAccess('laralum.donation.delete');

		# Find The Donation
		$donation = Laralum::donation('id', $id);

		# Delete Donation 
		$donation->delete();

		# Return a redirect
		return redirect()->route('Crm::donations')->with('success', "The donation has been deleted");
	}

	public function export(Request $request)
	{
		return Excel::download(new DonationExport($request->client_id), 'donation.xlsx');
	}

	public function import(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		// Allowed mime types
		$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

		// Validate whether selected file is a CSV file
		if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {
			$file = $request->file('file')->store('donationImport');
			//Excel::import(new LeadsImport, $file);
			$import = new DonationImport($client_id, Laralum::loggedInUser()->id, Laralum::loggedInUser()->branch);
			$import->import($file);
			//dd($import->errors());
			//return back()->withStatus('File imported successfully');
			$msg = "File is in queue, Please wait...";
			return response()->json(['status' => true ,'message' => $msg]);

		}


	}


	/*public function import(Request $request)
	{
		Laralum::permissionToAccess('laralum.donation.create');
		// Allowed mime types
		$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

		// Validate whether selected file is a CSV file
		if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {

		// If the file is uploaded
		if (is_uploaded_file($_FILES['file']['tmp_name'])) {

		// Open uploaded CSV file with read-only mode
		$csvFile = fopen($_FILES['file']['tmp_name'], 'r');

		// Skip the first line
		fgetcsv($csvFile);//dd($csvFile);

		if (Laralum::loggedInUser()->reseller_id == 0) {
		$client_id = Laralum::loggedInUser()->id;
		} else {
		$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$rowcount = 0;
		$countrow=1;
		$row_exist=array();
		// Parse data from CSV file line by line
		while (($line = fgetcsv($csvFile)) !== FALSE) {
		//if ($this->lead->mobileExistCheck($line[16],$client_id) > 0) {
		//$row_exist[] .=$countrow;
		//}else
		//{

		// Get row data						
		$lead = new Lead;
		$lead->client_id = $request->import_donation_client_id;
		$lead->user_id = Laralum::loggedInUser()->id;
		$lead->account_type = 'Permanent';
		$lead->department = 'Donation';
		$lead->name = $line[0];
		$lead->email = $line[1];
		$lead->mobile = $line[2];
		$lead->member_id = $line[3];
		$lead->save();
//Name,Email,Mobile,Member Id,Donation type,Payment mode,Amount,Cheque number,Branch,
//Bank name, Cheque date ,Reference no.,Donation Date
		$donation = new Donation;
		$donation->client_id = $request->import_donation_client_id;
		$donation->branch_id = Laralum::loggedInUser()->branch;
		$donation->donation_type = $line[4];
		$donation->payment_mode = $line[5];
		$donation->amount = $line[6];
		$donation->cheque_number = $line[7];
		$donation->bank_branch = $line[8];
		$donation->bank_name = $line[9];
		$donation->cheque_date = ($line[10] != '') ? date('Y-m-d', strtotime($line[10])) : '';
		$donation->donated_by = $lead->id;
		$donation->created_by = Laralum::loggedInUser()->id;
		$donation->reference_no = $line[11];
		$donation->donation_date =($request->dob != '') ? date('Y-m-d', strtotime($request->dob)) : NULL;
		$donation->status = "Success";
		$donation->save();
		if ($donation->id) {
			$org_name = DB::table('organization_profile')->select('organization_name')->where('client_id', $request->import_donation_client_id)->first();
			$string = $org_name->organization_name;
			$s = ucfirst($string);
			$bar = ucwords(strtoupper($s));
			$orgname = preg_replace('/\s+/', '', $bar);
			$receipt = $orgname . (str_pad((int)$donation->id + 1, 3, '0', STR_PAD_LEFT));
			DB::table('donations')
				->where('id', $donation->id)
				->update(['receipt_number' => $receipt]);
		}

		$rowcount++;
		//}
		//$countrow++;
		}
		$total_row=$countrow - 1;
		// Close opened CSV file
		fclose($csvFile);
		if(count($row_exist)>0){
		$duplicate_data=json_encode($row_exist);
		$msg='Total ' . $total_row . " records found in CSV file. Total " . $rowcount . ' records imported successfully. Duplicate recods are '.$duplicate_data.'';
		}else{
		$msg='Total ' . $total_row . " records found in CSV file. Total " . $rowcount . ' records imported successfully.';
		}

		return response()->json(['status' => true ,'message' => $msg]);
		//return redirect()->route('Crm::staff')->with('success', 'Staff data has been imported successfully.');
		} else {
		$msg="Lead data has not been imported successfully.";
		return response()->json(['status' => false ,'message' => $msg]);
		//return redirect()->back()->with('error', 'Some problem occurred, please try again.');
		}
		} else {
		$msg="Please upload a valid CSV file.";
		return response()->json(['status' => false ,'message' => $msg]);

		}
	}*/

	// public function import(Request $request)
	// {

	// 	if (isset($_POST['importSubmit'])) {
	// 		// Allowed mime types
	// 		$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

	// 		// Validate whether selected file is a CSV file
	// 		if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {

	// 			// If the file is uploaded
	// 			if (is_uploaded_file($_FILES['file']['tmp_name'])) {

	// 				// Open uploaded CSV file with read-only mode
	// 				$csvFile = fopen($_FILES['file']['tmp_name'], 'r');

	// 				// Skip the first line
	// 				fgetcsv($csvFile);

	// 				// Parse data from CSV file line by line
	// 				while (($line = fgetcsv($csvFile)) !== FALSE) {

	// 					// Get row data						
	// 					$lead = new Lead;
	// 					$lead->client_id = $request->import_donation_client_id;
	// 					$lead->user_id = Laralum::loggedInUser()->id;
	// 					$lead->account_type = 'Permanent';
	// 					$lead->department = 'Donation';
	// 					$lead->name = $line[0];
	// 					$lead->email = $line[1];
	// 					$lead->mobile = $line[2];
	// 					$lead->save();

	// 					$donation = new Donation;
	// 					$donation->client_id = $request->import_donation_client_id;
	// 					$donation->branch_id = Laralum::loggedInUser()->branch;
	// 					$donation->donation_type = $line[3];
	// 					$donation->payment_mode = $line[4];
	// 					$donation->amount = $line[5];
	// 					$donation->cheque_number = $line[6];
	// 					$donation->bank_branch = $line[7];
	// 					$donation->bank_name = $line[8];
	// 					$donation->cheque_date = ($line[9] != '') ? date('Y-m-d', strtotime($line[9])) : '';
	// 					$donation->donated_by = $lead->id;
	// 					$donation->created_by = Laralum::loggedInUser()->id;
	// 					$donation->reference_no = $line[10];
	// 					$donation->status = "Success";
	// 					$donation->save();
	// 					if ($donation->id) {
	// 						$org_name = DB::table('organization_profile')->select('organization_name')->where('client_id', $request->import_donation_client_id)->first();
	// 						$string = $org_name->organization_name;
	// 						$s = ucfirst($string);
	// 						$bar = ucwords(strtoupper($s));
	// 						$orgname = preg_replace('/\s+/', '', $bar);
	// 						$receipt = $orgname . (str_pad((int)$donation->id + 1, 3, '0', STR_PAD_LEFT));
	// 						DB::table('donations')
	// 							->where('id', $donation->id)
	// 							->update(['receipt_number' => $receipt]);
	// 					}
	// 				}

	// 				// Close opened CSV file
	// 				fclose($csvFile);

	// 				return redirect()->route('Crm::donations')->with('success', 'Donations data has been imported successfully.');
	// 			} else {

	// 				return redirect()->route('Crm::donations')->with('error', 'Some problem occurred, please try again.');
	// 			}
	// 		} else {

	// 			return redirect()->route('Crm::donations')->with('error', 'Please upload a valid CSV file.');
	// 		}
	// 	}
	// }


	//recurring_payments  donations 

	public function deleteSelected(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		//Laralum::permissionToAccess('laralum.donation.access');
		$ids=$request->ids;
		Laralum::permissionToAccess('laralum.donation.delete');
		$select_all_option_check = $request->input('select_all_option_check');
		$filter_by_payment_mode = $request->input('filter_by_payment_mode');
		$filter_by_donation_type = $request->input('filter_by_donation_type');
		$filter_donation_date_range = $request->input('filter_donation_date_range');
		$filter_by_created_by = $request->input('filter_by_created_by');
		$filter_by_location = $request->input('filter_by_location');
		$filter_by_donation_purpose = $request->input('filter_by_donation_purpose');
		$filter_by_payment_status = $request->input('filter_by_payment_status');
		$filter_by_payment_type = $request->input('filter_by_payment_type');
		//$filter_by_amount_lower_limit = $request->input('filter_by_amount_lower_limit');
		//$filter_by_amount_upper_limit = $request->input('filter_by_amount_upper_limit');
		$filter_by_when_will_donate = $request->input('filter_by_when_will_donate');
		$filter_by_donation_created_date_range = $request->input('filter_by_donation_created_date_range');
		$donationIds = [];
		
        if($select_all_option_check == 1){
        	$donationData = DB::table('donations')
                ->leftJoin('users', 'donations.created_by', 'users.id')
                ->leftJoin('donation_purpose', 'donations.donation_purpose', 'donation_purpose.id')
                ->leftJoin('leads', 'donations.donated_by', 'leads.id')
                ->where('donations.client_id', $client_id)
                ->select('donations.id')
                ->when($filter_by_payment_mode, function ($query, $filter_by_payment_mode) {
	                return $query->whereIn('donations.payment_mode', $filter_by_payment_mode);
	            })
                ->when($filter_by_donation_type, function ($query, $filter_by_donation_type) {
	                return $query->whereIn('donations.donation_type', $filter_by_donation_type);
	            })
                ->when($filter_donation_date_range, function ($query, $filter_donation_date_range) {
                	$dateData = explode(' - ', $filter_donation_date_range);
                    return $query->whereBetween('donations.donation_date', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
	            })
	            ->when($filter_by_donation_created_date_range, function ($query, $filter_by_donation_created_date_range) {
                	$dateData1 = explode(' - ', $filter_by_donation_created_date_range);
                    return $query->whereBetween('donations.created_at', [date("Y-m-d", strtotime($dateData1[0])), date("Y-m-d", strtotime($dateData1[1]))]);
	            })
    			->when($filter_by_created_by, function ($query, $filter_by_created_by) {
	                return $query->whereIn('donations.created_by', $filter_by_created_by);
	            })
    			->when($filter_by_location, function ($query, $filter_by_location) {
	                return $query->whereIn('donations.location', $filter_by_location);
	            })
    			->when($filter_by_donation_purpose, function ($query, $filter_by_donation_purpose) {
	                return $query->whereIn('donations.donation_purpose', $filter_by_donation_purpose);
	            })
	            ->when($filter_by_payment_status, function ($query, $filter_by_payment_status) {
	                return $query->where('donations.payment_status', $filter_by_payment_status);
	            })
	            ->when($filter_by_payment_type, function ($query, $filter_by_payment_type) {
	                return $query->where('donations.payment_type', $filter_by_payment_type);
	            })
	            // ->when($filter_by_amount_lower_limit, function ($query, $filter_by_amount_lower_limit) {
	            //     return $query->where('donations.amount', $filter_by_amount_lower_limit);
	            // })
	            // ->when($filter_by_amount_upper_limit, function ($query, $filter_by_amount_upper_limit) {
	            //     return $query->where('donations.amount', $filter_by_amount_upper_limit);
	            // })
	            ->when($filter_by_when_will_donate, function ($query, $filter_by_when_will_donate) {
	                return $query->where('donations.donation_decision', $filter_by_when_will_donate);
	            })
        		->get();
        		foreach ($donationData as $key => $value) {
        			$donationIds[] .=$value->id;
        		}
        	DB::beginTransaction();
			try {
			    $donation=Donation::whereIn('id', $donationIds)->delete();
				$recurring_payments= DB::table('recurring_payments')->whereIn('donation_id', $donationIds)->count();
				if($recurring_payments > 0){
					DB::table('recurring_payments')->where('donation_id', $donationIds)->delete();
				}
			    DB::commit();
			    return response()->json(array('status' => 'success',));
			} catch (\Exception $e) {
			    DB::rollback();
			    //return response()->json(['error' => $ex->getMessage()], 500);
			    return response()->json(array('status' => 'false',));
			}	

        }else{
        	DB::beginTransaction();
			try {
			    $donation=Donation::whereIn('id', $ids)->delete();
				$recurring_payments= DB::table('recurring_payments')->whereIn('donation_id', $ids)->count();
				if($recurring_payments > 0){
					DB::table('recurring_payments')->where('donation_id', $ids)->delete();
				}
			    DB::commit();
			    return response()->json(array('status' => 'success',));
			} catch (\Exception $e) {
			    DB::rollback();
			    //return response()->json(['error' => $ex->getMessage()], 500);
			    return response()->json(array('status' => 'false',));
			}
        }		
			
	}

	public function exportSelected(Request $request)
	{

		if($request->client_id==""){
			$client_id=0;
		}
		$select_all_option_check = $request->input('select_all_option_check');
		$filter_by_payment_mode = $request->input('filter_by_payment_mode');
		$filter_by_donation_type = $request->input('filter_by_donation_type');
		$filter_donation_date_range = $request->input('filter_donation_date_range');
		$filter_by_created_by = $request->input('filter_by_created_by');
		$filter_by_location = $request->input('filter_by_location');
		$filter_by_donation_purpose = $request->input('filter_by_donation_purpose');
		$filter_by_payment_status = $request->input('filter_by_payment_status');
		$filter_by_payment_type = $request->input('filter_by_payment_type');
		// $filter_by_amount_lower_limit = $request->input('filter_by_amount_lower_limit');
		// $filter_by_amount_upper_limit = $request->input('filter_by_amount_upper_limit');
		$filter_by_when_will_donate = $request->input('filter_by_when_will_donate');
		$filter_by_donation_created_date_range = $request->input('filter_by_donation_created_date_range');
		
		$donationIds = [];
		
        if($select_all_option_check == 1){
        	$donationData = DB::table('donations')
                ->leftJoin('users', 'donations.created_by', 'users.id')
                ->leftJoin('donation_purpose', 'donations.donation_purpose', 'donation_purpose.id')
                ->leftJoin('leads', 'donations.donated_by', 'leads.id')
                ->where('donations.client_id', $client_id)
                ->select('donations.id')
                ->when($filter_by_payment_mode, function ($query, $filter_by_payment_mode) {
	                return $query->whereIn('donations.payment_mode', $filter_by_payment_mode);
	            })
                ->when($filter_by_donation_type, function ($query, $filter_by_donation_type) {
	                return $query->whereIn('donations.donation_type', $filter_by_donation_type);
	            })
                ->when($filter_donation_date_range, function ($query, $filter_donation_date_range) {
                	$dateData = explode(' - ', $filter_donation_date_range);
                    return $query->whereBetween('donations.donation_date', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
	            })
	            ->when($filter_by_donation_created_date_range, function ($query, $filter_by_donation_created_date_range) {
                	$dateData1 = explode(' - ', $filter_by_donation_created_date_range);
                    return $query->whereBetween('donations.created_at', [date("Y-m-d", strtotime($dateData1[0])), date("Y-m-d", strtotime($dateData1[1]))]);
	            })
    			->when($filter_by_created_by, function ($query, $filter_by_created_by) {
	                return $query->whereIn('donations.created_by', $filter_by_created_by);
	            })
    			->when($filter_by_location, function ($query, $filter_by_location) {
	                return $query->whereIn('donations.location', $filter_by_location);
	            })
    			->when($filter_by_donation_purpose, function ($query, $filter_by_donation_purpose) {
	                return $query->whereIn('donations.donation_purpose', $filter_by_donation_purpose);
	            })
	            ->when($filter_by_payment_status, function ($query, $filter_by_payment_status) {
	                return $query->where('donations.payment_status', $filter_by_payment_status);
	            })
	            ->when($filter_by_payment_type, function ($query, $filter_by_payment_type) {
	                return $query->where('donations.payment_type', $filter_by_payment_type);
	            })
	            ->when($filter_by_amount_lower_limit, function ($query, $filter_by_amount_lower_limit) {
	                return $query->where('donations.amount', $filter_by_amount_lower_limit);
	            })
	            ->when($filter_by_amount_upper_limit, function ($query, $filter_by_amount_upper_limit) {
	                return $query->where('donations.amount', $filter_by_amount_upper_limit);
	            })
	            ->when($filter_by_when_will_donate, function ($query, $filter_by_when_will_donate) {
	                return $query->where('donations.donation_decision', $filter_by_when_will_donate);
	            })
        		->get();
        		foreach ($donationData as $key => $value) {
        			$donationIds[] .=$value->id;
        		}	
			return Excel::download(new DonationExport($client_id,$donationIds), 'donation.xlsx');
        }else{
        	return Excel::download(new DonationExport($client_id,$request->ids), 'donation.xlsx');
        }
		
	}


	public function importShow()
	{
		// $dateDataA = explode(';', "500;5366");
		// echo $dateDataA[0];die;
		Laralum::permissionToAccess('laralum.donation.create');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		return view('hyper/donation/importShow', ['client_id'=> $client_id]);
	}


	public function donation_delete(Request $request)
	{
		//Laralum::permissionToAccess('laralum.donation.access');
		$id=$request->id;

		Laralum::permissionToAccess('laralum.donation.delete');

		DB::beginTransaction();

		try {
		    $donation=Donation::where('id', $id)->delete();
			$recurring_payments= DB::table('recurring_payments')->where('donation_id', $id)->count();
			if($recurring_payments > 0){
				DB::table('recurring_payments')->where('recurring_payments', $id)->delete();
			}
		    DB::commit();
		    return response()->json(array('status' => 'success',));
		} catch (\Exception $e) {
		    DB::rollback();
		    //return response()->json(['error' => $ex->getMessage()], 500);
		    return response()->json(array('status' => 'false',));
		}	
	}


	public function totalAmountAdminDonations(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

		$filter_by_payment_mode = $request->input('filter_by_payment_mode');
		$filter_by_donation_type = $request->input('filter_by_donation_type');
		$filter_donation_date_range = $request->input('filter_donation_date_range');
		
		$filter_by_location = $request->input('filter_by_location');
		$filter_by_donation_purpose = $request->input('filter_by_donation_purpose');
		$filter_by_payment_status = $request->input('filter_by_payment_status');
		$filter_by_payment_type = $request->input('filter_by_payment_type');
		// $filter_by_amount_lower_limit = $request->input('filter_by_amount_lower_limit');
		// $filter_by_amount_upper_limit = $request->input('filter_by_amount_upper_limit');
		$filter_by_when_will_donate = $request->input('filter_by_when_will_donate');
		$filter_by_campaign = $request->input('filter_by_campaign');
		$filter_by_donation_decision_type = $request->input('filter_by_donation_decision_type');
		$filter_by_donation_created_date_range = $request->input('filter_by_donation_created_date_range');

		
		$total_amount = 0;
        if (isset($request->filter_by_created_by) && count($request->filter_by_created_by) >0) {
           	$filter_by_created_by = $request->input('filter_by_created_by'); 
        }else{
        	$filter_by_created_by = [];	
        }        

		$totalAmountData = DB::table('donations')
                ->leftJoin('campaign_leads', 'donations.donated_by', 'campaign_leads.lead_id')
                ->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
                //->leftJoin('users', 'donations.created_by', 'users.id')
                ->leftJoin('donation_purpose', 'donations.donation_purpose', 'donation_purpose.id')
                ->leftJoin('leads', 'donations.donated_by', 'leads.id')
                ->where('donations.client_id', $client_id)
                ->select('donations.id','donations.amount')

                ->when($filter_by_payment_mode, function ($query, $filter_by_payment_mode) {
	                return $query->whereIn('donations.payment_mode', $filter_by_payment_mode);
	            })
	            ->when($filter_by_donation_type, function ($query, $filter_by_donation_type) {
	                return $query->whereIn('donations.donation_type', $filter_by_donation_type);
	            })
                //to do
        		->when(Laralum::loggedInUser()->id != 1, function ($query) {
	                return $query->where('campaign_leads.agent_id', Laralum::loggedInUser()->id);
	            })
                
                
                ->when($filter_donation_date_range, function ($query, $filter_donation_date_range) {
                	$dateData = explode(' - ', $filter_donation_date_range);
                    return $query->whereBetween('donations.donation_date', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
	            })
	            ->when($filter_by_donation_created_date_range, function ($query, $filter_by_donation_created_date_range) {
                	$dateData1 = explode(' - ', $filter_by_donation_created_date_range);
                    return $query->whereBetween('donations.created_at', [date("Y-m-d", strtotime($dateData1[0])), date("Y-m-d", strtotime($dateData1[1]))]);
	            })

    			->when($filter_by_created_by, function ($query, $filter_by_created_by) {
	                return $query->whereIn('donations.created_by', $filter_by_created_by);
	            })
    			->when($filter_by_location, function ($query, $filter_by_location) {
	                return $query->whereIn('donations.location', $filter_by_location);
	            })
    			->when($filter_by_donation_purpose, function ($query, $filter_by_donation_purpose) {
	                return $query->whereIn('donations.donation_purpose', $filter_by_donation_purpose);
	            })
	            ->when($filter_by_payment_status, function ($query, $filter_by_payment_status) {
	                return $query->where('donations.payment_status', $filter_by_payment_status);
	            })
	            ->when($filter_by_payment_type, function ($query, $filter_by_payment_type) {
	                return $query->where('donations.payment_type', $filter_by_payment_type);
	            })
	            // ->when($filter_by_amount_lower_limit, function ($query, $filter_by_amount_lower_limit) {
	            //     return $query->where('donations.amount', $filter_by_amount_lower_limit);
	            // })
	            // ->when($filter_by_amount_upper_limit, function ($query, $filter_by_amount_upper_limit) {
	            //     return $query->where('donations.amount', $filter_by_amount_upper_limit);
	            // })
	            ->when($filter_by_when_will_donate, function ($query, $filter_by_when_will_donate) {
	                return $query->where('donations.donation_decision', $filter_by_when_will_donate);
	            })
	            ->when($filter_by_campaign, function ($query, $filter_by_campaign) {
	                return $query->where('campaign_leads.campaign_id', $filter_by_campaign);
	            })
	            ->when($filter_by_donation_decision_type, function ($query, $filter_by_donation_decision_type) {
	                return $query->whereIn('donations.donation_decision_type', $filter_by_donation_decision_type);
	            })
	            ->groupBy('donations.id')
	            ->get(); 
	         //    ->groupBy('donations.id')
        		// ->sum('amount');		
			if(!empty($totalAmountData)){
				foreach ($totalAmountData as $key => $value) {
					$total_amount = $total_amount + (int)$value->amount;
				}
			}
		return response()->json(array(
			'status' => 'success', 'total_amount'=>$total_amount
		));
	}

	public function assign_donation_lead_campaign(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$filter_by_payment_mode = $request->input('filter_by_payment_mode');
		$filter_by_donation_type = $request->input('filter_by_donation_type');
		$filter_donation_date_range = $request->input('filter_donation_date_range');
		$filter_by_created_by = $request->input('filter_by_created_by');
		$filter_by_location = $request->input('filter_by_location');
		$filter_by_donation_purpose = $request->input('filter_by_donation_purpose');
		$filter_by_payment_status = $request->input('filter_by_payment_status');
		$filter_by_payment_type = $request->input('filter_by_payment_type');
		// $filter_by_amount_lower_limit = $request->input('filter_by_amount_lower_limit');
		// $filter_by_amount_upper_limit = $request->input('filter_by_amount_upper_limit');
		$filter_by_when_will_donate = $request->input('filter_by_when_will_donate');
		$filter_by_campaign = $request->input('filter_by_campaign');
		$filter_by_donation_created_date_range = $request->input('filter_by_donation_created_date_range');
                                    
		if(Laralum::loggedInUser()->id != 1){
            $agent_check=Laralum::loggedInUser()->id;
        }else{
        	$agent_check="";
        }

        if($request->select_all_option_check==1){
        	
        	$leadsData = DB::table('donations')
		                ->leftJoin('campaign_leads', 'donations.donated_by', 'campaign_leads.lead_id')
		                ->leftJoin('users', 'campaign_leads.agent_id', 'users.id')
		                ->leftJoin('donation_purpose', 'donations.donation_purpose', 'donation_purpose.id')
		                ->leftJoin('leads', 'donations.donated_by', 'leads.id')
		                ->where('donations.client_id', $client_id)
		                ->where('leads.lead_status','!=',3)
		                ->select('donations.donated_by')
		                ->when($filter_by_payment_mode, function ($query, $filter_by_payment_mode) {
			                return $query->whereIn('donations.payment_mode', $filter_by_payment_mode);
			            })
			            ->when($filter_by_donation_type, function ($query, $filter_by_donation_type) {
			                return $query->whereIn('donations.donation_type', $filter_by_donation_type);
			            })
		                //to do
		        		->when(Laralum::loggedInUser()->id != 1, function ($query) {
			                return $query->where('campaign_leads.agent_id', Laralum::loggedInUser()->id);
			            })
		                ->when($filter_donation_date_range, function ($query, $filter_donation_date_range) {
		                	$dateData = explode(' - ', $filter_donation_date_range);
		                    return $query->whereBetween('donations.donation_date', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
			            }) 
			            ->when($filter_by_donation_created_date_range, function ($query, $filter_by_donation_created_date_range) {
		                	$dateData1 = explode(' - ', $filter_by_donation_created_date_range);
		                    return $query->whereBetween('donations.created_at', [date("Y-m-d", strtotime($dateData1[0])), date("Y-m-d", strtotime($dateData1[1]))]);
			            })
		    			->when($filter_by_created_by, function ($query, $filter_by_created_by) {
			                return $query->whereIn('donations.created_by', $filter_by_created_by);
			            })
		    			->when($filter_by_location, function ($query, $filter_by_location) {
			                return $query->whereIn('donations.location', $filter_by_location);
			            })
		    			->when($filter_by_donation_purpose, function ($query, $filter_by_donation_purpose) {
			                return $query->whereIn('donations.donation_purpose', $filter_by_donation_purpose);
			            })
			            ->when($filter_by_payment_status, function ($query, $filter_by_payment_status) {
			                return $query->where('donations.payment_status', $filter_by_payment_status);
			            })
			            ->when($filter_by_payment_type, function ($query, $filter_by_payment_type) {
			                return $query->where('donations.payment_type', $filter_by_payment_type);
			            })
			            ->when($filter_by_amount_lower_limit, function ($query, $filter_by_amount_lower_limit) {
			                return $query->where('donations.amount', $filter_by_amount_lower_limit);
			            })
			            ->when($filter_by_amount_upper_limit, function ($query, $filter_by_amount_upper_limit) {
			                return $query->where('donations.amount', $filter_by_amount_upper_limit);
			            })
			            ->when($filter_by_when_will_donate, function ($query, $filter_by_when_will_donate) {
			                return $query->where('donations.donation_decision', $filter_by_when_will_donate);
			            })
			            ->when($filter_by_campaign, function ($query, $filter_by_campaign) {
			                return $query->where('campaign_leads.campaign_id', $filter_by_campaign);
			            })

        				->groupBy('donations.id')->get();
        	    $leads=[];
        		foreach ($leadsData as $key => $value) {
        			$leads[] .= $value->id;
        		}
        		$leads_count = count($leads);
				$campaigns = $request->campaigns;
				$agentDatas = DB::table('campaign_agents')->where('campaign_id', $campaigns)->select('campaign_agents.agent_id')->get();
				$agent_ids=[];
        		foreach ($agentDatas as $key => $value) {
        			$agent_ids[] .=$value->agent_id;
        		}
				//$campaigns_count=count($campaigns);
        		$agent_count = count($agent_ids);
				//$lead_share = round ( ($leads_count / $agent_count) , 0 , PHP_ROUND_HALF_UP );
        		$lead_share = ceil($leads_count / $agent_count);
				$arr = array_chunk($leads, $lead_share);
				
				// foreach ($leadsData as $key => $value) {
				// 	$leadCheck = DB::table('campaign_leads')->where('campaign_id', $campaigns)->where('lead_id', $value->id)->first();
				// 	if(empty($leadCheck)){
				// 		DB::table('campaign_leads')
				// 			->insert(['campaign_id' => $campaigns, 'lead_id' =>$value->id, 'created_at'=>date('Y-m-d H:i'), 'updated_at'=>date('Y-m-d H:i') ]);
				// 	}
        			
    //     		}
				for ($i=0; $i <count($arr) ; $i++) {
					for ($j=0; $j <count($arr[$i]) ; $j++) { 
						$leadCheck = DB::table('campaign_leads')->where('campaign_id', $campaigns)->where('lead_id', $arr[$i][$j])->first();
						if(empty($leadCheck)){
							DB::table('campaign_leads')
								->insert(['campaign_id' => $campaigns, 'lead_id' =>$arr[$i][$j], 'agent_id' =>$agent_ids[$i],'created_at'=>date('Y-m-d H:i'), 'updated_at'=>date('Y-m-d H:i') ]);
						}
					} 
				}



        }else{
        	$leads=$request->leads;
			$leads_count=count($leads);
			$campaigns=$request->campaigns;
			$agentDatas = DB::table('campaign_agents')->where('campaign_id', $campaigns)->select('campaign_agents.agent_id')->get();
				$agent_ids=[];
        		foreach ($agentDatas as $key => $value) {
        			$agent_ids[] .=$value->agent_id;
        		}
				//$campaigns_count=count($campaigns);
        		$agent_count = count($agent_ids);
				//$lead_share = round ( ($leads_count / $agent_count) , 0 , PHP_ROUND_HALF_UP );
        		$lead_share = ceil($leads_count / $agent_count);
				$arr = array_chunk($leads, $lead_share);



			for ($i=0; $i <count($arr) ; $i++) {
					for ($j=0; $j <count($arr[$i]) ; $j++) { 
						$leadCheck = DB::table('campaign_leads')->where('campaign_id', $campaigns)->where('lead_id', $arr[$i][$j])->first();
						if(empty($leadCheck)){
							DB::table('campaign_leads')
								->insert(['campaign_id' => $campaigns, 'lead_id' =>$arr[$i][$j], 'agent_id' =>$agent_ids[$i],'created_at'=>date('Y-m-d H:i'), 'updated_at'=>date('Y-m-d H:i') ]);
						}
					} 
				}
        }
		return response()->json(array(
			'status' => 'success','leads'=>$leads,'leads_count'=>$leads_count,'campaigns'=>$campaigns,'agent_ids'=>$agent_ids,'agent_count'=>$agent_count,'lead_share'=>$lead_share,'arr'=>$arr
		));

    }

    public function donation_report(Request $request){

		Laralum::permissionToAccess('laralum.donation.list');
		
		$agent_id = NULL;
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
			$agent_id = Laralum::loggedInUser()->id;
		}

		$donation_purposes = DB::table('donation_purpose')->where('user_id', $client_id)->get();
		$branches = DB::table('branch')
					->where('client_id', $client_id)
					->get();
		$users = DB::table('users')
				->select('id', 'name')
				->where('reseller_id', $client_id)
				->get();
		$razorKey = Laralum::loggedInUser()->RAZOR_KEY;
			
		if($razorKey == '' || $razorKey == null){
			$razorKey = User::where('id', Laralum::loggedInUser()->reseller_id)->value('RAZOR_KEY');
		}
		$membertypes = DB::table('member_types')->where('user_id', $client_id)->get();
		$campaigns = DB::table('campaigns')
					->leftJoin('campaign_agents', 'campaigns.id', '=', 'campaign_agents.campaign_id')
					->leftJoin('campaigns_selecteds', 'campaigns.id', '=', 'campaigns_selecteds.campaign_id')
					->where('campaigns.client_id', $client_id)
					->when($agent_id, function ($query, $agent_id) {
	                    return $query->where('campaign_agents.agent_id', $agent_id);
	                })

					->orderBy('campaigns.id', 'desc')
					->groupBy('campaigns.id')
					->select('campaigns.*','campaigns_selecteds.campaign_check')
					->get();
			


		
		return view('hyper/donation/report', ['donation_purposes'=>$donation_purposes,'branches'=>$branches,'users'=>$users,'razorKey' => $razorKey,'membertypes' => $membertypes,'client_id' => $client_id, 'campaigns'=>$campaigns]);

    }

    public function getAdminDonationReports(Request $request)
	{
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $donations = $this->donation->getDonationReportForTable($request,$client_id);
        return $this->donation->donationReportDataTable($donations);
    }

    public function incoming_donation_form(Request $request)
	{
		//Laralum::permissionToAccess('laralum.lead.view');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$membertypes = DB::table('member_types')->where('user_id', $client_id)->get();
		$branches = DB::table('branch')->where('client_id', $client_id)->get();
		$donation_purposes = DB::table('donation_purpose')->where('user_id', $client_id)->get();
		$razorKey = Laralum::loggedInUser()->RAZOR_KEY;
		# Return the view crm/donations/create
		return view('hyper/lead/donation', compact('membertypes', 'branches', 'donation_purposes', 'razorKey'));
	}

	public function incoming_prayer_form(Request $request)
	{
		//Laralum::permissionToAccess('laralum.lead.view');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		$prayer_requests = DB::table('prayer_requests')->where('user_id', $client_id)->get();
		# Return the view crm/donations/create
		return view('hyper/lead/prayer_request_form', compact('prayer_requests'));
	}



	public function incoming_call_donation_store(Request $request)
	{
		//Laralum::permissionToAccess('laralum.donation.create');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		
		$donation_date=NULL;
		if ($request->incoming_donation_decision== 0 || $request->incoming_donation_decision== 2 ) {
			$donation_date = date('Y-m-d');
		} else {
			$donation_date = ($request->incoming_donation_date !='') ? date('Y-m-d',strtotime($request->incoming_donation_date)) : NULL;
		}

		if ($request->incoming_donation_decision== 2) {
			$paymentStatus = 1 ;
		} else {
			$paymentStatus = $request->incoming_payment_status;
		}
		//incoming_donation_type incoming_donation_purpose incoming_donation_decision incoming_donation_decision_type
       // incoming_donation_date incoming_payment_type incoming_payment_mode incoming_payment_status incoming_location
       // incoming_amount incoming_payment_period incoming_payment_start_date  incoming_payment_end_date incoming_reference_no
       // incoming_bank_name  incoming_cheque_number incoming_branch_name incoming_cheque_date  incoming_payment_method incoming_gift_issued
		$lead_id  = $request->member_id;
		$donation = new Donation;
		$donation->client_id = $client_id;
		$donation->branch_id = Laralum::loggedInUser()->branch;
		$donation->donation_type = $request->incoming_donation_type;
		$donation->payment_method = $request->incoming_payment_method;
		$donation->payment_status = $paymentStatus;
		$donation->donation_purpose = $request->incoming_donation_purpose;
		$donation->payment_type = $request->incoming_payment_type;
		$donation->payment_period = $request->incoming_payment_period;
		$donation->payment_start =($request->incoming_payment_start_date !='') ? date('Y-m-d',strtotime($request->incoming_payment_start_date)) : NULL;
		$donation->payment_end =($request->incoming_payment_end_date !='') ? date('Y-m-d',strtotime($request->incoming_payment_end_date)) : NULL;
		$donation->payment_mode = $request->incoming_payment_mode;
		$donation->amount = $request->incoming_amount;
		$donation->location = $request->incoming_location;
		$donation->cheque_number = $request->incoming_cheque_number;
		$donation->bank_branch = $request->incoming_branch_name;
		$donation->bank_name = $request->incoming_bank_name;
		$donation->cheque_date =($request->incoming_cheque_date !='') ? date('Y-m-d',strtotime($request->incoming_cheque_date)) : NULL;
		$donation->donated_by = $lead_id;
		$donation->created_by = Laralum::loggedInUser()->id;
		$donation->reference_no = $request->incoming_reference_no;
		$donation->status = "Success";
		$donation->donation_date = $donation_date;
		$donation->donation_decision = $request->incoming_donation_decision;
		$donation->donation_decision_type = ($request->incoming_donation_decision_type !='') ? $request->incoming_donation_decision_type : NULL;
		$donation->gift_issued = $request->incoming_gift_issued;

		$donation->save();

		if($request->incoming_donation_type == 'Partner' && $paymentStatus == '1'){
			$lead = Lead::find($request->member_id);
			if($lead->partner_code == ''){
				$partner_code = rand(1000,99999);
				DB::table('leads')
					->where('id', $request->member_id)
					->update(['partner_code' => $partner_code]);
			}
		}

		if($request->incoming_donation_type == 'Sponsor' && $paymentStatus == '1'){
			$lead = Lead::find($request->member_id);
			if($lead->sponsor_code == ''){
				$sponsor_code = rand(1000,99999);
				DB::table('leads')
					->where('id', $request->member_id)
					->update(['sponsor_code' => $sponsor_code]);
			}
		}
		
		if ($donation->id) {
			$org_name = DB::table('organization_profile')->select('organization_name')->where('client_id', $client_id)->first();
			$string = $org_name->organization_name;
			$s = ucfirst($string);
			$bar = ucwords(strtoupper($s));
			$receipt = '';
			foreach (explode(' ', $bar) as $word) {
				$receipt .= strtoupper($word[0]);
			}
			//$orgname = preg_replace('/\s+/', '', $bar);
			$receipt = $receipt . (str_pad((int)$donation->id + 1, 3, '0', STR_PAD_LEFT));
			DB::table('donations')
				->where('id', $donation->id)
				->update(['receipt_number' => $receipt]);
			/*
			For Recuring payment
			*/
			if ($request->incoming_payment_type == "recurring") {
				$payment_period = $request->incoming_payment_period;
				$payment_start_date = $request->incoming_payment_start_date;
				$payment_end_date = $request->incoming_payment_end_date;
				$amount = $request->incoming_amount;
				$start = \Carbon\Carbon::parse($payment_start_date);
				$end = \Carbon\Carbon::parse($payment_end_date);
				$installment = '';
				if ($payment_period == 'daily') {
					$installment = $start->diffInDays($end);
					for ($i = 0; $i < $installment; $i++) {
						DB::table('recurring_payments')->insert(
							[
								'donation_id' => $donation->id,
								'emi_amount' => $amount / $installment,
								'emi_period' => ($start->format('d/m/y') . ' - ' . $start->addDays(1)->format('d/m/y')),
								'emi_status' => 0,
								'due_date' => date($start),
								'paid_date' => '',
								'created_at' => date('Y-m-d H:i:s')
							]
						);
					}
				}
				if ($payment_period == 'weekly') {
					$installment = $start->diffInWeeks($end);
					for ($i = 0; $i < $installment; $i++) {
						DB::table('recurring_payments')->insert(
							[
								'donation_id' => $donation->id,
								'emi_amount' => $amount / $installment,
								'emi_period' => ($start->format('d/m/y') . ' - ' . $start->addWeeks(1)->format('d/m/y')),
								'emi_status' => 0,
								'due_date' => date($start),
								'paid_date' => '',
								'created_at' => date('Y-m-d H:i:s')
							]
						);
					}
				}
				if ($payment_period == 'monthly') {
					$installment = $start->diffInMonths($end);
					for ($i = 0; $i < $installment; $i++) {
						DB::table('recurring_payments')->insert(
							[
								'donation_id' => $donation->id,
								'emi_amount' => $amount / $installment,
								'emi_period' => ($start->format('d/m/y') . ' - ' . $start->addMonths(1)->format('d/m/y')),
								'emi_status' => 0,
								'due_date' => date($start),
								'paid_date' => '',
								'created_at' => date('Y-m-d H:i:s')
							]
						);
					}
				}
				if ($payment_period == 'yearly') {
					$installment = $start->diffInYears($end);
					for ($i = 0; $i < $installment; $i++) {
						DB::table('recurring_payments')->insert([
							'donation_id' => $donation->id,
							'emi_amount' => $amount / $installment,
							'emi_period' => ($start->format('d/m/y') . ' - ' . $start->addYear(1)->format('d/m/y')),
							'emi_status' => 0,
							'due_date' => date($start),
							'paid_date' => '',
							'created_at' => date('Y-m-d H:i:s')
						]);
					}
				}
			}
			/*
			Razorpay fixed payment link creation
			*/
			if ($request->incoming_payment_mode == 'Razorpay' && $request->incoming_payment_type == 'single') 
			{
				//$api = new Api(Laralum::loggedInUser()->RAZOR_KEY, Laralum::loggedInUser()->RAZOR_SECRET);
				$api = new Api(User::where('id', $client_id)->value('RAZOR_KEY'), User::where('id', $client_id)->value('RAZOR_SECRET'));

				//$client = DB::table('leads')->where('client_id', $client_id)->orderBy('leads.id', 'desc')->first();
				$lead = DB::table('leads')->where('id', $lead_id)->first();
				$Params = array();
				$Params = array(
					"type" => "link",
					"view_less" => 1,
					"amount" =>  $request->incoming_amount . '00',
					"currency" => "INR",
					"description" =>  "Donation",
					"receipt" =>  $receipt . mt_rand(1, 999999),
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
				//echo "<pre>";print_r($response);die;

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
			}
		}
		if($request->incoming_manual_callLog_id !=""){
			DB::table('manual_logged_call')
					->where('id', $request->incoming_manual_callLog_id)
					->update(
						[
							'call_purpose' => $request->incoming_call_purpose,
					 		'updated_at'=>date('Y-m-d H:i') 
					 	]
					);
		}

		if(isset($request->call_sourse) && $request->call_sourse == '1'){
			$IncommingLead = IncommingLead::where('lead_id', $lead_id)->first();
			if(!$IncommingLead){
				$incomming_lead = new IncommingLead;
				$incomming_lead->lead_id = $lead->id;
				$incomming_lead->save();
			}
		}
		
		
		# Return the admin to the blogs page with a success message
		return response()->json(array('success' => true, 'status' => true), 200);
	}

























}
