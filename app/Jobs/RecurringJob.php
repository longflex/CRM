<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\User;
use App\Donation;
use Validator,DB,File;
use Razorpay\Api\Api;

class RecurringJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
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
}
