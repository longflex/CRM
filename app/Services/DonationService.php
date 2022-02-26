<?php


namespace App\Services;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Laralum\Laralum;
use Yajra\DataTables\DataTables;
use Auth;

/**
 * Class DonationService
 * @package App\Services\Lead
 */
class DonationService
{
    /**
     * @param $data
     */
  

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getLeadDonationForTable($id){
        $donations = DB::table('donations')
        ->leftJoin('donation_purpose', 'donations.donation_purpose', 'donation_purpose.id')
        ->where('donations.donated_by', $id)
        ->select('donations.*', 'donation_purpose.purpose');
        // ->orderBy('donations.id','desc');
        return $donations;
    }
   
    public function donationDataTable($donations)
    {
        return DataTables::of($donations)
            ->addColumn('id', function ($donation) {
                return $donation->id;
            })->addColumn('receipt_number', function ($donation) {
                return $donation->receipt_number;
            })->addColumn('donation_type', function ($donation) {
                return $donation->donation_type;
            })->addColumn('amount', function ($donation) {
                return $donation->amount;
            })->addColumn('payment_mode', function ($donation) {
                return $donation->payment_mode;
            })->addColumn('payment_status', function ($donation) {
                $payment_status= $donation->payment_status ? '<span class="badge badge-success">Paid</span>' : '<span class="badge badge-warning">Not Paid</span>';
                return $payment_status;
            })->addColumn('donation_date', function ($donation) {
                return date('d-M-Y', strtotime($donation->donation_date));
            })->addColumn('created_at', function ($donation) {
                return date('d-M-Y', strtotime($donation->created_at));
            })->addColumn('donation_purpose', function ($donation) {
                return $donation->purpose;
            })->addColumn('action', function ($donation) {
                if($donation->payment_status && $donation->amount > 0){
                    $button1='<a href="'. route('Crm::donation_details', ['id' => $donation->id]) .'" title="Print"><i class="uil-print font-20"></i></a>';
                }else{
                    $button1='';
                 }
                 if(!$donation->payment_status && $donation->payment_mode=='Razorpay'){
                    $button2='<a href="javascript:void(0);"  onclick="send_payment_link_sms('.$donation->id.')" data-id="'.$donation->id.'" data-toggle="tooltip" title="Send Payment Link SMS" data-placement="top"><i class="uil-message font-20"></i></a>';       
                }else{
                    $button2='';  
                  }
                  if(!$donation->payment_status && $donation->payment_mode!='Razorpay'){
                    $button3='<a href="javascript:void(0);" onclick="update_payment_status_paid('.$donation->id.')"  title="Mark as Paid"><i class="uil-check-circle font-20"></i></a>';
                    
                }else{
                     $button3=''; 
                  }    
                if($donation->payment_type=='recurring'){
                //<a href="'.route('Crm::donation_edit', ['id' => $donation->id]).'" class=""><i class="uil-edit font-20"></i></a>';
                
                $action ='<a href="'.route('Crm::payment_detail', ['id' => $donation->id]).'" class=""><i class="uil-edit font-20"></i></a>';
                    }else{
                $action =$button1.$button2.$button3;
                    }
                return  $action;
  
            
            })
            ->escapeColumns('action')
            ->make(true);
    }

//new by vikash

public function getLeadDonationDetailForTable($id){
    $donations = DB::table('donations')
	->where('donations.id', $id)
	->leftJoin('recurring_payments', 'recurring_payments.donation_id', 'donations.id')
	->select('donations.payment_mode','donations.location','donations.payment_status', 'recurring_payments.*');
	// ->orderBy('recurring_payments.id','desc');
    return $donations;
}

public function donationDetailDataTable($donations)
{
    return DataTables::of($donations)
        ->addColumn('no', function ($donation) {
            return $donation->id;
        })->addColumn('due_date', function ($donation) {
            return date('d/m/Y', strtotime($donation->due_date));
        })->addColumn('emi_amount', function ($donation) {
            return $donation->emi_amount;
        })->addColumn('payment_mode', function ($donation) {
            return $donation->payment_mode;
        })->addColumn('location', function ($donation) {
            return $donation->location;
        })->addColumn('payment_status', function ($donation) {
            $payment_status= $donation->emi_status ? '<span class="badge badge-success">Paid</span>' : '<span class="badge badge-warning">Not Paid</span>';
            return $payment_status;
        })->addColumn('payment_date', function ($donation) {
            return $donation->paid_date!="0000-00-00"? date('d/m/Y', strtotime($donation->paid_date)) :'<span class="badge badge-secondary">N.A.</span>';
        })->addColumn('action', function ($donation) {
        if($donation->emi_status){
            $button1='<a href="'. route('Crm::payment_details_print', ['id' => $donation->id]) .'" title="Print"><i class="uil-print font-20"></i></a>';
        }else{
            $button1='';
         }
        if(!$donation->emi_status && $donation->payment_mode=='CASH'){
            $button2='<a href="javascript:void(0);" onclick="update_payment_status_paid('.$donation->id.')" title="Mark as Paid" data-id="'.$donation->id.'"><i class="uil-check-circle font-20"></i></a>';
        }else{
            $button2='';  
          }

        if(!$donation->emi_status && $donation->payment_mode=='Razorpay'){
            $button3='<a href="javascript:void(0);" onclick="send_emi_payment_link_sms('.$donation->id.')" data-id="'.$donation->id.'" data-toggle="tooltip" title="Send Payment Link SMS" data-placement="top"><i class="uil-message font-20"></i></a>';
        }else{
            $button3='';
        }

        return $action =$button1.$button2.$button3;


        })
        ->escapeColumns('action')
        ->make(true);
}

public function getAdminDonationForTable($data, $client_id){

    $donations = DB::table('donations');

                if ($data->filter_by_campaign != null) {
                    $donations->leftJoin('campaign_leads', 'donations.donated_by', 'campaign_leads.lead_id');
                }
               
                $donations->leftJoin('donation_purpose', 'donations.donation_purpose', 'donation_purpose.id')
                ->leftJoin('leads', 'donations.donated_by', 'leads.id')
                ->select('donations.*','leads.name','leads.mobile','donation_purpose.purpose')
                ->where('donations.client_id', $client_id)
                ->where(function ($donations) use ($data) {
                    if ($data->filter_by_payment_mode != null) {
                        $donations->whereIn('donations.payment_mode', $data->filter_by_payment_mode);
                    }
                    if ($data->filter_by_donation_type != null) {
                        $donations->whereIn('donations.donation_type', $data->filter_by_donation_type);
                    }
                    //to do
                    if(Laralum::loggedInUser()->id != 1){
                        $donations->where('donations.created_by', Laralum::loggedInUser()->id);
                    }
                    if ($data->filter_donation_date_range != null) {
                        $dateData = explode(' - ', $data->filter_donation_date_range);
                        $donations->whereBetween('donations.donation_date', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
                    }
                    if ($data->donation_created_date_range != null) {
                        $dateData7 = explode(' - ', $data->donation_created_date_range);
                        $donations->whereBetween('donations.created_at', [date("Y-m-d", strtotime($dateData7[0])), date("Y-m-d", strtotime($dateData7[1]))]);
                    }

                    if (isset($data->filter_by_created_by) && count($data->filter_by_created_by) >0) {
                        $donations->whereIn('donations.created_by', $data->filter_by_created_by);
                    }
                    if ($data->filter_by_location != null) {
                        $donations->whereIn('donations.location', $data->filter_by_location);
                    }
                    if ($data->filter_by_donation_purpose != null) {
                        $donations->whereIn('donations.donation_purpose', $data->filter_by_donation_purpose);
                    }
                    if ($data->filter_by_payment_status != null) {
                        $donations->where('donations.payment_status', $data->filter_by_payment_status);
                    }
                    if ($data->filter_by_payment_type != null) {
                        $donations->where('donations.payment_type', $data->filter_by_payment_type);
                    } 
                    // if ($data->filter_by_amount_range != null) {
                    //     $dateDataA = explode(';', $data->filter_by_amount_range);
                    //     //$donations->whereBetween('donations.amount', [$dateDataA[0], $dateDataA[1]]);
                    //     $donations->where('donations.amount','>=', (int)$dateDataA[0]);
                    //     $donations->where('donations.amount','<=', (int)$dateDataA[1]);
                    // }
                    if ($data->filter_by_amount_lower_limit != null) {
                        $donations->where('donations.amount','>=', (int)$data->filter_by_amount_lower_limit);
                    }
                    if ($data->filter_by_amount_upper_limit != null) {
                        $donations->where('donations.amount','<=', (int)$data->filter_by_amount_upper_limit);
                    }
                    if ($data->filter_by_when_will_donate != null) {
                        $donations->where('donations.donation_decision', $data->filter_by_when_will_donate);
                    }
                    if ($data->filter_by_campaign != null) {
                        $donations->where('campaign_leads.campaign_id', $data->filter_by_campaign);
                    }
                    if ($data->filter_by_donation_decision_type != null) {
                        $donations->whereIn('donations.donation_decision_type', $data->filter_by_donation_decision_type);
                    }

                    if ($data->filter_by_gift_issued != null) {
                        $donations->where('donations.gift_issued', $data->filter_by_gift_issued);
                    }

                    // if ($data->search_query != null) {
                    //     $query = $data->search_query;
                    //     //$donations->where('donations.id', '6');
                    //     $donations->where('donations.id', 'like', '%'.$query.'%')
                    //     ->orWhere('leads.name', 'like', '%'.$query.'%');
                    // }
                });
                //->orderBy('donations.id', 'desc')
                //->groupBy('donations.id')
                //->paginate(10);
                //$donations->groupBy('donations.id');
    return $donations;
}

public function donationAdminDataTable($donations)
{
    return DataTables::of($donations)
        ->addColumn('checkbox', function ($donation) {       
            return "<input type='checkbox' id='".$donation->id."_".$donation->donated_by."' name='sms' value='".$donation->id."_".$donation->donated_by."'>";
        })->addColumn('donation_id', function ($donation) {
            return $donation->id;
        })->addColumn('receipt_number', function ($donation) {
            return $donation->receipt_number;
        })->addColumn('donated_by', function ($donation) {
            return $donation->name;
        })
        // ->addColumn('created_by', function ($donation) {
        //     return $donation->created_name;
        // })
        ->addColumn('donation_type', function ($donation) {
            return $donation->donation_type;
        })->addColumn('purpose', function ($donation) {
            return $donation->purpose??'N.A.';
        })->addColumn('amount', function ($donation) {
            return $donation->amount;
        })->addColumn('mode', function ($donation) {
            return $donation->payment_mode=='OTHER'?$donation->payment_method:$donation->payment_mode;
        })->addColumn('payment_type', function ($donation) {
            return $donation->payment_type;
        })->addColumn('status', function ($donation) {
            $payment_status= $donation->payment_status ? '<span class="badge badge-success">Paid</span>' : '<span class="badge badge-warning">Not Paid</span>';
            return $payment_status;
        })->addColumn('location', function ($donation) {
            return $donation->location;
        })->addColumn('date', function ($donation) {
            if ($donation->donation_date != NULL || $donation->donation_date != "") { 
                    return date('d-M-Y', strtotime($donation->donation_date));
                } else {
                    return 'Not available';
                }
        })->addColumn('created_date', function ($donation) {
            if ($donation->created_at != NULL || $donation->created_at != "") { 
                    return date('d-M-Y', strtotime($donation->created_at));
                } else {
                    return 'Not available';
                }
        })->addColumn('action', function ($donation) {
            $button1='';
            $button2='';
            $button3='<a href="'.route('Crm::donation_edit', ['id' => $donation->id]).'" title="Edit Donation" class=""><i class="uil-edit font-20"></i></a>';
            $button4='<a href="javascript:void(0);"  onclick="destroy('.$donation->id.')" title="Delete Donation" class=""><i class="uil-trash-alt font-20"></i></a>';
            if($donation->payment_type=='recurring'){
                $button1='<a href="'.route('Crm::payment_detail', ['id' => $donation->id]).'" title="View payment details" class=""><i class="uil-receipt-alt font-20"></i></a>';
            }else{
                $button2='<a href="'. route('Crm::donation_details', ['id' => $donation->id]) .'" title="Print"><i class="uil-print font-20"></i></a>';
             }
            return  $button1.$button2.$button3.$button4;
        })
        
        ->escapeColumns('checkbox,action')
        ->make(true);
}

public function getDonationReportForTable($data, $client_id){

    $donations = DB::table('donations')
                //->leftJoin('campaign_leads', 'donations.donated_by', 'campaign_leads.lead_id')
                //->leftJoin('users', 'donations.created_by', 'users.id')
                ->Join('leads', 'donations.donated_by', 'leads.id')
                ->select('donations.created_by','leads.name as lead_name','donations.id',DB::raw('SUM(donations.amount) as totD'), DB::raw('COUNT(donations.id) as donationCount'))
                ->where('donations.client_id', $client_id);
                if ($data->filter_by_donations_count != null && $data->filter_by_donations_count_type == 0) {
                        //$donations->where('totD', $data->filter_by_donations_count);
                        $donations->having('donationCount', '=', $data->filter_by_donations_count);
                    }
                if ($data->filter_by_donations_count != null && $data->filter_by_donations_count_type == 1) {
                        //$donations->where('totD', $data->filter_by_donations_count);
                        $donations->having('donationCount', '>=', $data->filter_by_donations_count);
                }
                if ($data->filter_donation_date_range != null) {
                    $dateData = explode(' - ', $data->filter_donation_date_range);
                    $donations->whereBetween('donations.donation_date', [date("Y-m-d", strtotime($dateData[0])), date("Y-m-d", strtotime($dateData[1]))]);
                }    
                if ($data->filter_by_location != null) {
                    $donations->whereIn('donations.location', $data->filter_by_location);
                }
                if ($data->filter_by_amount_lower_limit != null) {
                    //$donations->where('totD','>=', (int)$data->filter_by_amount_lower_limit);
                    $donations->having('totD', '>=', $data->filter_by_amount_lower_limit);
                }
                if ($data->filter_by_amount_upper_limit != null) {
                    //$donations->where('totD','<=', (int)$data->filter_by_amount_upper_limit);
                    $donations->having('totD', '<=', $data->filter_by_amount_upper_limit);
                }

                if ($data->filter_by_top_sponsor != null) {
                    $donations->orderBy('totD','desc')->limit($data->filter_by_top_sponsor);
                }
                  
                // ->where(function ($donations) use ($data) {
                //     if ($data->filter_by_donations_count != null) {
                //         //$donations->where('totD', $data->filter_by_donations_count);
                //         $donations->having('donationCount', '=', $data->filter_by_donations_count);
                //     }
                //     // if ($data->filter_by_donations_count_type != null) {
                //     //     $donations->whereIn('donations.donation_count', $data->filter_by_donations_count_type);
                //     // }
                    
                // }) //filter_by_donations_count_type
                $donations->groupBy('donations.donated_by');
    return $donations;
}

public function donationReportDataTable($donations)
{
    return DataTables::of($donations)
        ->addColumn('created_by', function ($donation) {
            return $donation->lead_name;
        })->addColumn('donation_count', function ($donation) {
            return $donation->donationCount;
        })->addColumn('total_amount', function ($donation) {
            return $donation->totD;
        })
        ->make(true);
}












}
