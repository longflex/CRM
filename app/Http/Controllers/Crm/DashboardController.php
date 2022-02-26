<?php

namespace App\Http\Controllers\Crm;

use App\Lead;
use App\Donation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Laralum\Laralum;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Carbon\CarbonPeriod;
use DateTime;

class DashboardController extends Controller
{
    private $dashboard;

    public function __construct(DashboardService $dashboard)
    {
        $this->dashboard = $dashboard;
    }
    public function index()
    {
        if (Laralum::loggedInUser()->reseller_id == 0) {
            $client_id = Laralum::loggedInUser()->id;
        } else {
            $client_id = Laralum::loggedInUser()->reseller_id;
        }

        if(!Laralum::hasPermission('laralum.admin.dashboard')){
            return view('hyper.admin.dashboard');
        }
 
        $total_members = Lead::select('count(*) as allcount')
                        ->where('lead_status', 3)
                        ->where('client_id', $client_id)
                        ->count();
        $total_temporary_members = Lead::select('count(*) as allcount')
                        ->where('lead_status', 3)
                        ->where('account_type', 'Temporary')
                        ->where('client_id', $client_id)
                        ->count();
        $total_permanent_members = Lead::select('count(*) as allcount')
                        ->where('lead_status', 3)
                        ->where('account_type', 'Permanent')
                        ->where('client_id', $client_id)
                        ->count();
        $temporary_members = Lead::select(DB::raw('count(*) as member'),DB::raw('MONTHNAME(created_at) as monthname'))
                        ->where('lead_status', 3)
                        ->where('account_type', 'Temporary')
                        ->where('client_id', $client_id)
                        ->groupBy(DB::raw('MONTH(created_at)'))
                        ->get();

                        
        $permanent_members = Lead::select(DB::raw('count(*) as member'), 
                        DB::raw('MONTHNAME(created_at) as monthname'))
                        ->where('lead_status', 3)
                        ->where('account_type', 'Permanent')
                        ->where('client_id', $client_id)
                        ->groupBy(DB::raw('MONTH(created_at)'))
                        ->get();
       // dd($permanent_members);
        $partners = Lead::select(DB::raw('count(*) as member'))
                        ->where('lead_status', 3)
                        ->where('account_type', 'Temporary')
                        ->where('client_id', $client_id)
                        ->groupBy(DB::raw('MONTH(created_at)'))
                        ->get();
        $sponsors = Lead::select(DB::raw('count(*) as member'), 
                        DB::raw('MONTHNAME(created_at) as monthname'))
                        ->where('lead_status', 3)
                        ->where('account_type', 'Permanent')
                        ->where('client_id', $client_id)
                        ->groupBy(DB::raw('MONTH(created_at)'))
                        ->get();
        $partners = Lead::select('count(*) as allcount')
                        ->where('lead_status', 3)
                        ->where('member_type', 'like','%Partner%')
                        ->where('client_id', $client_id)
                        ->count();
        $sponsors = Lead::select('count(*) as allcount')
                        ->where('lead_status', 3)
                        ->where('member_type', 'like', '%Sponsor%')
                        ->where('client_id', $client_id)
                        ->count();
        $investor = Lead::select('count(*) as allcount')
                        ->where('lead_status', 3)
                        ->where('member_type', 'like','%investor%')
                        ->where('client_id', $client_id)
                        ->count();
        $donations = Donation::whereBetween('donation_date', 
                                [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                ->where('client_id', $client_id)
                                // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                                //     return $query->where('created_by', Laralum::loggedInUser()->id);
                                // })
                                ->sum('amount');
        $startOfWeek = Carbon::now()->startOfWeek()->subDays(7);
        $endOfWeek = Carbon::now()->endOfWeek()->subDays(7);
        $weekly_donations = Donation::whereBetween('donation_date', [$startOfWeek, $endOfWeek])
                                    ->where('client_id', $client_id)
                                    // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                                    //     return $query->where('created_by', Laralum::loggedInUser()->id);
                                    // })
                                    ->sum('amount');
        // $today_date = Carbon::today();
        // $today_donations = Donation::where('donation_date','=', $today_date)
        //                             ->where('client_id', $client_id)
        //                             ->sum('amount');
        // $temporary_member_c = [];
        // foreach($temporary_members as $k){
        //     $temporary_member_c[] = $k->member;

        // } 
        $temporary_member_c=array_fill(0,12,0);
        if(!empty($temporary_members)){    
            foreach ($temporary_members as $key => $value) {
                if($value->monthname == 'January'){
                    $temporary_member_c[0] = (int)$value->member;
                }elseif($value->monthname == 'February'){
                    $temporary_member_c[1] = (int)$value->member;
                }elseif($value->monthname == 'March'){
                    $temporary_member_c[2] = (int)$value->member; 
                }elseif($value->monthname == 'April'){
                    $temporary_member_c[3] = (int)$value->member;
                }elseif($value->monthname == 'May'){
                    $temporary_member_c[4] = (int)$value->member;
                }elseif($value->monthname == 'June'){
                    $temporary_member_c[5] = (int)$value->member;
                }elseif($value->monthname == 'July'){
                    $temporary_member_c[6] = (int)$value->member;
                }elseif($value->monthname == 'August'){
                    $temporary_member_c[7] = (int)$value->member;
                }elseif($value->monthname == 'September'){
                    $temporary_member_c[8] = (int)$value->member;
                }elseif($value->monthname == 'October'){
                    $temporary_member_c[9] = (int)$value->member;
                }elseif($value->monthname == 'November'){
                    $temporary_member_c[10] = (int)$value->member;
                }elseif($value->monthname == 'December'){
                    $temporary_member_c[11] = (int)$value->member;
                }
            }
            $temporary_member_c = implode(', ', $temporary_member_c);
        }else{
            $temporary_member_c = "";
        }  
        //$permanent_member_c = [];
        //$month_name = [];

        $permanent_member_c=array_fill(0,12,0);
        if(!empty($permanent_members)){    
            foreach ($permanent_members as $key => $value) {
                if($value->monthname == 'January'){
                    $permanent_member_c[0] = (int)$value->member;
                }elseif($value->monthname == 'February'){
                    $permanent_member_c[1] = (int)$value->member;
                }elseif($value->monthname == 'March'){
                    $permanent_member_c[2] = (int)$value->member; 
                }elseif($value->monthname == 'April'){
                    $permanent_member_c[3] = (int)$value->member;
                }elseif($value->monthname == 'May'){
                    $permanent_member_c[4] = (int)$value->member;
                }elseif($value->monthname == 'June'){
                    $permanent_member_c[5] = (int)$value->member;
                }elseif($value->monthname == 'July'){
                    $permanent_member_c[6] = (int)$value->member;
                }elseif($value->monthname == 'August'){
                    $permanent_member_c[7] = (int)$value->member;
                }elseif($value->monthname == 'September'){
                    $permanent_member_c[8] = (int)$value->member;
                }elseif($value->monthname == 'October'){
                    $permanent_member_c[9] = (int)$value->member;
                }elseif($value->monthname == 'November'){
                    $permanent_member_c[10] = (int)$value->member;
                }elseif($value->monthname == 'December'){
                    $permanent_member_c[11] = (int)$value->member;
                }
            }
            $permanent_member_c = implode(', ', $permanent_member_c);
        }else{
            $permanent_member_c = "";
        } 
        // foreach($permanent_members as $k){
        //     $permanent_member_c[] = $k->member;
        //     $month_name[] = $k->monthname;
        // }

    //print_r($month_name);die;
        $subscriptionList = [];
        $subscriptionList = DB::table('donation_purpose')
                    ->leftJoin('donations', 'donation_purpose.id', '=', 'donations.donation_purpose')
                    ->select('donation_purpose.purpose', DB::raw("SUM(donations.amount) as totalDonation") )
                    ->where('donations.client_id', $client_id)
                    // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                    //     return $query->where('donations.created_by', Laralum::loggedInUser()->id);
                    // })
                    ->groupBy('donation_purpose.id')
                    ->get();
        $sum_Amounts = [];
        $purposes = []; 
        if(!empty($subscriptionList)){
            foreach ($subscriptionList as $key => $value) {
                $sum_Amounts[] .= (int)$value->totalDonation;
                $purposes[] .= (string)$value->purpose;
            }
            $sum_Amounts = implode(', ', $sum_Amounts); 
            $purposes = '"' . implode('", "', $purposes) . '"';
        }else{
            $sum_Amounts = ""; 
            $purposes = "";
        }          
        
        // $today_date = Carbon::today();
        // $today_donations = Donation::where('donation_date','=', $today_date)
        //                             ->where('client_id', $client_id)
        //                             ->sum('amount');
        // $donationsWeek = [];
        // $donationsWeek = DB::table('donations')
        //                 ->select('created_at', DB::raw('SUM(amount) as totD'),DB::raw("DAYNAME(created_at) as dayname"))
        //                 ->whereBetween('donation_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        //                 ->where('client_id', $client_id)
        //                 // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
        //                 //     return $query->where('created_by', Laralum::loggedInUser()->id);
        //                 // })
        //                 ->groupBy('dayname')
        //                 ->get();
        // $donationsWeekData=array_fill(0,7,0);
        // if(!empty($donationsWeek)){    
        //     foreach ($donationsWeek as $key => $value) {
        //         if($value->dayname == 'Monday'){
        //             $donationsWeekData[0] = (int)$value->totD;
        //         }elseif($value->dayname == 'Tuesday'){
        //             $donationsWeekData[1] = (int)$value->totD;
        //         }elseif($value->dayname == 'Wednesday'){
        //             $donationsWeekData[2] = (int)$value->totD; 
        //         }elseif($value->dayname == 'Thursday'){
        //             $donationsWeekData[3] = (int)$value->totD;
        //         }elseif($value->dayname == 'Friday'){
        //             $donationsWeekData[4] = (int)$value->totD;
        //         }elseif($value->dayname == 'Saturday'){
        //             $donationsWeekData[5] = (int)$value->totD;
        //         }elseif($value->dayname == 'Sunday'){
        //             $donationsWeekData[6] = (int)$value->totD;
        //         }
        //     }
        //     $donationsWeekData = implode(', ', $donationsWeekData);
        // }else{
        //     $donationsWeekData = "";
        // } 

        // $donationsPrWeek = [];
        // $donationsPrWeek = DB::table('donations')
        //                 ->select('donation_date', DB::raw('SUM(amount) as totD'),DB::raw("DAYNAME(donation_date) as dayname"))
        //                 ->whereBetween('donation_date', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
        //                 ->groupBy('dayname')
        //                 ->get();
        // $donationsPrWeekData=array_fill(0,7,0);

        // if(!empty($donationsPrWeek)){
        //     foreach ($donationsPrWeek as $key => $value) {
        //         if($value->dayname == 'Monday'){
        //             $donationsPrWeekData[0] = (int)$value->totD;
        //         }elseif($value->dayname == 'Tuesday'){
        //             $donationsPrWeekData[1] = (int)$value->totD;
        //         }elseif($value->dayname == 'Wednesday'){
        //             $donationsPrWeekData[2] = (int)$value->totD; 
        //         }elseif($value->dayname == 'Thursday'){
        //             $donationsPrWeekData[3] = (int)$value->totD;
        //         }elseif($value->dayname == 'Friday'){
        //             $donationsPrWeekData[4] = (int)$value->totD;
        //         }elseif($value->dayname == 'Saturday'){
        //             $donationsPrWeekData[5] = (int)$value->totD;
        //         }elseif($value->dayname == 'Sunday'){
        //             $donationsPrWeekData[6] = (int)$value->totD;
        //         }
        //     }
        //     $donationsPrWeekData = implode(', ', $donationsPrWeekData);
        // }else{
        //     $donationsPrWeekData = "";
        // } 
        
        
        $donationsByLocations =[];
        $donationsByLocations = DB::table('branch')
                    ->leftJoin('donations', 'branch.branch', '=', 'donations.location')
                    ->select('branch.branch', DB::raw("SUM(donations.amount) as branchTotalDonation") )
                    ->where('branch.client_id', $client_id)
                    ->where('donations.client_id', $client_id)
                    ->groupBy('branch.branch')
                    ->get();
         
        return view('hyper.admin.dashboard', [
                'total_members' => $total_members, 
                'total_temporary_members' => $total_temporary_members, 
                'total_permanent_members' => $total_permanent_members,
                'temporary_member_c' => $temporary_member_c,
                'permanent_member_c' => $permanent_member_c,
                //'month_name' => $month_name,
                'partners' => $partners,
                'sponsors' => $sponsors,
                'investor' => $investor,
                //'donations' => $donations,
                'sum_Amounts' => $sum_Amounts,
                'purposes' => $purposes,
                //'weekly_donations' => $weekly_donations,
                //'today_donations' => $today_donations,
                'subscriptionList' => $subscriptionList,
                //'donationsWeekData' => $donationsWeekData,
                //'donationsPrWeekData' => $donationsPrWeekData, 
                'donationsByLocations' => $donationsByLocations
            ]); 
    }

    public function donationGraph(Request $request)
    {
        if (Laralum::loggedInUser()->reseller_id == 0) {
            $client_id = Laralum::loggedInUser()->id;
        } else {
            $client_id = Laralum::loggedInUser()->reseller_id;
        }
        
        
        return view('hyper.admin.donation_graph', [
                'donations' => $donations,
                'weekly_donations' => $weekly_donations,
                'today_donations' => $today_donations,
                //'subscriptionList' => $subscriptionList,
                'donationsWeekData' => $donationsWeekData,
                'donationsPrWeekData' => $donationsPrWeekData, 
                //'donationsByLocations' => $donationsByLocations
            ]); 
    }

    public function donationsComparison(Request $request)
    {
        if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $today_date = Carbon::today();
        $today_donations = Donation::where('donation_date','=', $today_date)
                                    ->where('client_id', $client_id)
                                    ->sum('amount');
        $current_sp = "";                            
        $previous_sp = "";
        if ($request->val == 'current-week') {
            $currentGraphName= "Current Week";
            $previousGraphName= "Previous Week";
            $graphString = '"Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"'; 
            $current_donations_sum = Donation::whereBetween('donation_date', 
                                            [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                            ->where('client_id', $client_id)
                                            ->sum('amount');
            $startOfWeek = Carbon::now()->startOfWeek()->subDays(7);
            $endOfWeek = Carbon::now()->endOfWeek()->subDays(7);
            $previous_donations_sum = Donation::whereBetween('donation_date', [$startOfWeek, $endOfWeek])
                                            ->where('client_id', $client_id)
                                            ->sum('amount');
            $donationsWeek = [];
            $donationsWeek = DB::table('donations')
                            ->select('created_at', DB::raw('SUM(amount) as totD'),DB::raw("DAYNAME(created_at) as dayname"))
                            ->whereBetween('donation_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                            ->where('client_id', $client_id)
                            ->groupBy('dayname')
                            ->get();
            $donationsData=array_fill(0,7,0);
            if(!empty($donationsWeek)){  

                foreach ($donationsWeek as $key => $value) {
                    if($value->dayname == 'Monday'){
                        $donationsData[0] = (int)$value->totD;
                    }elseif($value->dayname == 'Tuesday'){
                        $donationsData[1] = (int)$value->totD;
                    }elseif($value->dayname == 'Wednesday'){
                        $donationsData[2] = (int)$value->totD; 
                    }elseif($value->dayname == 'Thursday'){
                        $donationsData[3] = (int)$value->totD;
                    }elseif($value->dayname == 'Friday'){
                        $donationsData[4] = (int)$value->totD;
                    }elseif($value->dayname == 'Saturday'){
                        $donationsData[5] = (int)$value->totD;
                    }elseif($value->dayname == 'Sunday'){
                        $donationsData[6] = (int)$value->totD;
                    }
                }
                $donationsData = implode(', ', $donationsData);
            }else{
                $donationsData = "";
            } 
            $donationsPrWeek = [];
            $donationsPrWeek = DB::table('donations')
                                    ->select('donation_date', DB::raw('SUM(amount) as totD'),DB::raw("DAYNAME(donation_date) as dayname"))
                                    ->whereBetween('donation_date', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
                                    ->groupBy('dayname')
                                    ->get();
            $previousDonationsData=array_fill(0,7,0);

            if(!empty($donationsPrWeek)){
                foreach ($donationsPrWeek as $key => $value) {
                    if($value->dayname == 'Monday'){
                        $previousDonationsData[0] = (int)$value->totD;
                    }elseif($value->dayname == 'Tuesday'){
                        $previousDonationsData[1] = (int)$value->totD;
                    }elseif($value->dayname == 'Wednesday'){
                        $previousDonationsData[2] = (int)$value->totD; 
                    }elseif($value->dayname == 'Thursday'){
                        $previousDonationsData[3] = (int)$value->totD;
                    }elseif($value->dayname == 'Friday'){
                        $previousDonationsData[4] = (int)$value->totD;
                    }elseif($value->dayname == 'Saturday'){
                        $previousDonationsData[5] = (int)$value->totD;
                    }elseif($value->dayname == 'Sunday'){
                        $previousDonationsData[6] = (int)$value->totD;
                    }
                }
                $previousDonationsData = implode(', ', $previousDonationsData);
            }else{
                $previousDonationsData = "";
            }                                
        } elseif($request->val == 'current-month') {
            $currentGraphName= "Current Month";
            $previousGraphName= "Previous Month";
            $current_donations_sum = Donation::whereMonth('donation_date', Carbon::now()->month)
                                                ->whereYear('donation_date', Carbon::now()->year)
                                                ->where('client_id', $client_id)
                                                ->sum('amount');
            $currentDonations = DB::table('donations')
                                    ->select('created_at', DB::raw('SUM(amount) as totD'), DB::raw('date(donation_date) as dates'))
                                    ->whereMonth('donation_date', Carbon::now()->month)
                                    ->whereYear('donation_date', Carbon::now()->year)
                                    ->where('client_id', $client_id)
                                    ->groupBy('dates')
                                    ->orderBy('dates','asc')
                                    ->get();
            $monthFirstDate = Carbon::now()->startOfMonth()->toDateString();
            $daysCount = date('t');
            $donationsData=array_fill(0,$daysCount,0);
            $donationsMonthDates=array_fill(0,$daysCount,0);
            $current_sp = " | ".date("F", strtotime($monthFirstDate));                           
        
            for ($i=0; $i < count($donationsMonthDates) ; $i++) { 
                $donationsMonthDates[$i] = date('Y-m-d', strtotime($monthFirstDate.' + '.$i.' day'));
            }
            $graphString = '"' . implode('", "', $donationsMonthDates) . '"';
            if(!empty($currentDonations)){ 
                foreach ($currentDonations as $key => $value) {
                    if($value->dates == $monthFirstDate){
                        $donationsData[0] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 1 day'))){
                        $donationsData[1] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 2 day'))){
                        $donationsData[2] = (int)$value->totD; 
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 3 day'))){
                        $donationsData[3] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 4 day'))){
                        $donationsData[4] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 5 day'))){
                        $donationsData[5] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 6 day'))){
                        $donationsData[6] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 7 day'))){
                        $donationsData[7] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 8 day'))){
                        $donationsData[8] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 9 day'))){
                        $donationsData[9] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 10 day'))){
                        $donationsData[10] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 11 day'))){
                        $donationsData[11] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 12 day'))){
                        $donationsData[12] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 13 day'))){
                        $donationsData[13] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 14 day'))){
                        $donationsData[14] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 15 day'))){
                        $donationsData[15] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 16 day'))){
                        $donationsData[16] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 17 day'))){
                        $donationsData[17] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 18 day'))){
                        $donationsData[18] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 19 day'))){
                        $donationsData[19] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 20 day'))){
                        $donationsData[20] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 21 day'))){
                        $donationsData[21] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 22 day'))){
                        $donationsData[22] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 23 day'))){
                        $donationsData[23] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 24 day'))){
                        $donationsData[24] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 25 day'))){
                        $donationsData[25] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 26 day'))){
                        $donationsData[26] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 27 day'))){
                        $donationsData[27] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 28 day'))){
                        $donationsData[28] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 29 day'))){
                        $donationsData[29] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 30 day'))){
                        $donationsData[30] = (int)$value->totD;
                    }elseif($value->dates == date('Y-m-d', strtotime($monthFirstDate.' + 30 day'))){
                        $donationsData[30] = (int)$value->totD;
                    }
                }
                $donationsData = implode(', ', $donationsData);
            }else{
                $donationsData = "";
            }
            $previous_donations_sum = Donation::whereMonth('donation_date', 
                                            Carbon::now()->subMonth()->month)
                                            //->whereYear('donation_date', date('Y', strtotime('-1 year')))
                                            ->whereYear('donation_date', Carbon::now()->year)
                                            ->where('client_id', $client_id)
                                            ->sum('amount');
            $prDonationsMonth = DB::table('donations')
                                ->select('created_at', DB::raw('SUM(amount) as totD'), DB::raw('date(donation_date) as dates'))
                                ->whereMonth('donation_date', Carbon::now()->subMonth()->month)
                                //->whereYear('donation_date', date('Y', strtotime('-1 year')))
                                ->whereYear('donation_date', Carbon::now()->year)
                                ->where('client_id', $client_id)
                                ->groupBy('dates')
                                ->orderBy('dates','asc')
                                ->get();
        $prMonthFirstDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $prMonthFirstDate = date('Y-m-d', strtotime($prMonthFirstDate));
        $previousDonationsData=array_fill(0,$daysCount,0);
        $previous_sp = " | ".date("F", strtotime($prMonthFirstDate));
        if(!empty($prDonationsMonth)){ 
            foreach ($prDonationsMonth as $key => $value) {
                if($value->dates == $prMonthFirstDate){
                    $previousDonationsData[0] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 1 day'))){
                    $previousDonationsData[1] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 2 day'))){
                    $previousDonationsData[2] = (int)$value->totD; 
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 3 day'))){
                    $previousDonationsData[3] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 4 day'))){
                    $previousDonationsData[4] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 5 day'))){
                    $previousDonationsData[5] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 6 day'))){
                    $previousDonationsData[6] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 7 day'))){
                    $previousDonationsData[7] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 8 day'))){
                    $previousDonationsData[8] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 9 day'))){
                    $previousDonationsData[9] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 10 day'))){
                    $previousDonationsData[10] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 11 day'))){
                    $previousDonationsData[11] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 12 day'))){
                    $previousDonationsData[12] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 13 day'))){
                    $previousDonationsData[13] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 14 day'))){
                    $previousDonationsData[14] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 15 day'))){
                    $previousDonationsData[15] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 16 day'))){
                    $previousDonationsData[16] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 17 day'))){
                    $previousDonationsData[17] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 18 day'))){
                    $previousDonationsData[18] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 19 day'))){
                    $previousDonationsData[19] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 20 day'))){
                    $previousDonationsData[20] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 21 day'))){
                    $previousDonationsData[21] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 22 day'))){
                    $previousDonationsData[22] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 23 day'))){
                    $previousDonationsData[23] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 24 day'))){
                    $previousDonationsData[24] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 25 day'))){
                    $previousDonationsData[25] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 26 day'))){
                    $previousDonationsData[26] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 27 day'))){
                    $previousDonationsData[27] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 28 day'))){
                    $previousDonationsData[28] = (int)$value->totD;
                }elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 29 day'))){
                    $previousDonationsData[29] = (int)$value->totD;
                }
                // elseif($value->dates == date('Y-m-d', strtotime($prMonthFirstDate.' + 30 day'))){
                //     $previousDonationsData[30] = (int)$value->totD;
                // }
            }
                $previousDonationsData = implode(', ', $previousDonationsData);
        }else{
            $previousDonationsData = "";
        }                                
        } elseif($request->val == 'current-year') {
            $currentGraphName= "Current Year";
            $previousGraphName= "Previous Year";
            $graphString = '"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"'; 
            $current_donations_sum = Donation::whereYear('donation_date', Carbon::now()->year)
                                            ->where('client_id', $client_id)
                                            ->sum('amount');
                                            // ->select('amount','donation_date','id')
                                            // ->get();
                        
            $currentDonations = [];
            $currentDonations = DB::table('donations')
                            ->select('created_at', DB::raw('SUM(amount) as totD'),DB::raw("MONTHNAME(donation_date) as monthname"))
                            ->whereYear('donation_date', date('Y'))
                            ->where('client_id', $client_id)
                            // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                            //     return $query->where('created_by', Laralum::loggedInUser()->id);
                            // })
                            ->groupBy('monthname')
                            ->get();
            $donationsData=array_fill(0,12,0);
            if(!empty($currentDonations)){    
                foreach ($currentDonations as $key => $value) {
                    if($value->monthname == 'January'){
                        $donationsData[0] = (int)$value->totD;
                    }elseif($value->monthname == 'February'){
                        $donationsData[1] = (int)$value->totD;
                    }elseif($value->monthname == 'March'){
                        $donationsData[2] = (int)$value->totD; 
                    }elseif($value->monthname == 'April'){
                        $donationsData[3] = (int)$value->totD;
                    }elseif($value->monthname == 'May'){
                        $donationsData[4] = (int)$value->totD;
                    }elseif($value->monthname == 'June'){
                        $donationsData[5] = (int)$value->totD;
                    }elseif($value->monthname == 'July'){
                        $donationsData[6] = (int)$value->totD;
                    }elseif($value->monthname == 'August'){
                        $donationsData[7] = (int)$value->totD;
                    }elseif($value->monthname == 'September'){
                        $donationsData[8] = (int)$value->totD;
                    }elseif($value->monthname == 'October'){
                        $donationsData[9] = (int)$value->totD;
                    }elseif($value->monthname == 'November'){
                        $donationsData[10] = (int)$value->totD;
                    }elseif($value->monthname == 'December'){
                        $donationsData[11] = (int)$value->totD;
                    }
                }
                $donationsData = implode(', ', $donationsData);
            }else{
                $donationsData = "";
            }                                     
            $previous_donations_sum = Donation::whereYear('donation_date', date('Y', strtotime('-1 year')))
                                            ->where('client_id', $client_id)
                                            ->sum('amount');
            $previousDonations = [];
            $previousDonations = DB::table('donations')
                            ->select('donation_date', DB::raw('SUM(amount) as totD'),DB::raw("MONTHNAME(donation_date) as monthname"))
                            ->whereYear('donation_date', date('Y', strtotime('-1 year')))
                            ->groupBy('monthname')
                            ->get();
            $previousDonationsData=array_fill(0,12,0);

            if(!empty($previousDonations)){    
                foreach ($previousDonations as $key => $value) {
                    if($value->monthname == 'January'){
                        $previousDonationsData[0] = (int)$value->totD;
                    }elseif($value->monthname == 'February'){
                        $previousDonationsData[1] = (int)$value->totD;
                    }elseif($value->monthname == 'March'){
                        $previousDonationsData[2] = (int)$value->totD; 
                    }elseif($value->monthname == 'April'){
                        $previousDonationsData[3] = (int)$value->totD;
                    }elseif($value->monthname == 'May'){
                        $previousDonationsData[4] = (int)$value->totD;
                    }elseif($value->monthname == 'June'){
                        $previousDonationsData[5] = (int)$value->totD;
                    }elseif($value->monthname == 'July'){
                        $previousDonationsData[6] = (int)$value->totD;
                    }elseif($value->monthname == 'August'){
                        $previousDonationsData[7] = (int)$value->totD;
                    }elseif($value->monthname == 'September'){
                        $previousDonationsData[8] = (int)$value->totD;
                    }elseif($value->monthname == 'October'){
                        $previousDonationsData[9] = (int)$value->totD;
                    }elseif($value->monthname == 'November'){
                        $previousDonationsData[10] = (int)$value->totD;
                    }elseif($value->monthname == 'December'){
                        $previousDonationsData[11] = (int)$value->totD;
                    }
                }
                $previousDonationsData = implode(', ', $previousDonationsData);
            }else{
                $previousDonationsData = "";
            }                                    
        }elseif($request->val == 'date-range') {
            $currentDataa = explode(' - ', $request->filter_by_current_Date);
            $previousDataa = explode(' - ', $request->filter_by_previous_Date);
            $current_donations_sum = Donation::whereBetween('donation_date', [date("Y-m-d", strtotime($currentDataa[0])), date("Y-m-d", strtotime($currentDataa[1]))])
                                            ->where('client_id', $client_id)
                                            // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                                            //         return $query->where('created_by', Laralum::loggedInUser()->id);
                                            //     })
                                            ->sum('amount');
            $previous_donations_sum = Donation::whereBetween('donation_date', [date("Y-m-d", strtotime($previousDataa[0])), date("Y-m-d", strtotime($previousDataa[1]))])
                                            ->where('client_id', $client_id)
                                            // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                                            //         return $query->where('donations.created_by', Laralum::loggedInUser()->id);
                                            //     })
                                            ->sum('amount');
                                            


            $currentGraphName= "Current Date Range";
            $previousGraphName= "Previous Date Range";

            $period = $this->createRange($currentDataa[0], $currentDataa[1]);
            $donationsData = array_fill(0,count($period),0);
            $graphString = '"' . implode('", "', $period) . '"'; 

            $currentDonations = DB::table('donations')
                                    ->select('created_at', DB::raw('SUM(amount) as totD'), DB::raw('date(donation_date) as dates'))
                                    ->whereBetween('donation_date', [date("Y-m-d", strtotime($currentDataa[0])), date("Y-m-d", strtotime($currentDataa[1]))])
                                    ->where('client_id', $client_id)
                                    ->groupBy('dates')
                                    ->orderBy('dates','asc')
                                    ->get();

            if(!empty($currentDonations)){ 
                foreach ($currentDonations as $key => $value) {
                        
                    for ($i=0; $i < count($donationsData); $i++) { 
                            if($value->dates == $period[$i]){
                                $donationsData[$i] = (int)$value->totD;        
                            }
                        }    
                    
                }
                $donationsData = implode(', ', $donationsData);
            }else{
                $donationsData = "";
            }

 
            $prPeriod = $this->createRange(date("Y-m-d", strtotime($previousDataa[0])), date("Y-m-d", strtotime($previousDataa[1])));
            // Convert the period to an array of dates
            $previousDonationsData = array_fill(0,count($prPeriod),0);
            $prDonationsCustome = DB::table('donations')
                                ->select('created_at', DB::raw('SUM(amount) as totD'), DB::raw('date(donation_date) as dates'))
                                ->whereBetween('donation_date', [date("Y-m-d", strtotime($previousDataa[0])), date("Y-m-d", strtotime($previousDataa[1]))])
                                ->where('client_id', $client_id)
                                ->groupBy('dates')
                                ->orderBy('dates','asc')
                                ->get();

            if(!empty($prDonationsCustome)){ 
                foreach ($prDonationsCustome as $key => $value) {
                        
                    for ($i=0; $i < count($previousDonationsData); $i++) { 
                            if($value->dates == $prPeriod[$i]){
                                $previousDonationsData[$i] = (int)$value->totD;        
                            }
                        }    
                    
                }
                $previousDonationsData = implode(', ', $previousDonationsData);
            }else{
                $previousDonationsData = "";
            }
                    
                                          
        }

        return view('hyper.admin.donation_graph', [
                //'donations' => $donations,
                'today_donations' => $today_donations,
                'currentGraphName' => $currentGraphName,
                'previousGraphName' => $previousGraphName,
                'graphString' => $graphString,
                
                'previous_donations' => $previous_donations_sum,
                'current_donations' => $current_donations_sum,
                // 'weekly_donations' => $weekly_donations,
                // 'today_donations' => $today_donations,
                //'subscriptionList' => $subscriptionList,
                'donationsData' => $donationsData,
                'previousDonationsData' => $previousDonationsData, 
                //'donationsByLocations' => $donationsByLocations
                'current_sp' => $current_sp, 
                'previous_sp' => $previous_sp, 

            ]); 
        // return response()->json([
        //     'previous_donations' => $previous_donations,
        //     'current_donations' => $current_donations,
        // ]);
    }

    public function sponsor_category_admin_data(Request $request)
    {
        $dashboards = $this->dashboard->getSponsorCategoryForTable($request);
        return $this->dashboard->sponsorCategoryDataTable($dashboards);
    }

    public function custom_date_validation(Request $request)
    {
        $currentDataa = explode(' - ', $request->filter_by_current_Date);
        $previousDataa = explode(' - ', $request->filter_by_previous_Date);

        $period = $this->createRange($currentDataa[0], $currentDataa[1]);
        $prPeriod = $this->createRange(date("Y-m-d", strtotime($previousDataa[0])), date("Y-m-d", strtotime($previousDataa[1])));
        if(count($period) == count($prPeriod)){
            return response()->json(['status' => true]);
        }else{
            return response()->json(['status' => false]);
        }

        
    }


 function createRange($start, $end, $format = 'Y-m-d') {
        $start  = new DateTime($start);
        $end    = new DateTime($end);
        $invert = $start > $end;

        $dates = array();
        $dates[] = $start->format($format);
        while ($start != $end) {
            $start->modify(($invert ? '-' : '+') . '1 day');
            $dates[] = $start->format($format);
        }
        return $dates;
    }
}
