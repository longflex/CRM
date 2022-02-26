<?php


namespace App\Services;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Laralum\Laralum;
use Illuminate\Support\Facades\Auth;

/**
 * Class LeadService
 * @package App\Services\Lead
 */
class DashboardService
{
    public function getSponsorCategoryForTable($data){
        $dashboards = DB::table('donation_purpose')
                    ->leftJoin('donations', 'donation_purpose.id', '=', 'donations.donation_purpose')
                    //->leftJoin('leads', 'donation_purpose.donated_by', '=', 'leads.donation_purpose')
                    ->select('donation_purpose.purpose', DB::raw("count(donations.id) as count"), DB::raw("SUM(donations.amount) as totalDonation") );
        if (Laralum::loggedInUser()->reseller_id == 0) {
            $dashboards->where('donations.client_id', Laralum::loggedInUser()->id);
        } else {
            $dashboards->where('donations.client_id', Laralum::loggedInUser()->reseller_id);
        }
        // if ($data->filter_by_agent != null) {
        //     $dashboards->where('donations.created_by', $data->filter_by_agent);
        // }
        if ($data->filter_by_dataId == 1) {
            $dashboards->whereDate('donations.donation_date', Carbon::today()->toDateString());
        }
        if ($data->filter_by_dataId == 2) {
            $dashboards->whereMonth('donations.donation_date', Carbon::now()->month);
        }
        if ($data->filter_by_dataId == 3) {
            $dashboards->whereYear('donations.donation_date', Carbon::now()->format('Y'));
        }
        // if(Laralum::loggedInUser()->id != 1){
        //     $userData->where('u.id', Laralum::loggedInUser()->id);
        // }
        if ($data->filter_by_Date != null && $data->filter_by_dataId == 4) {
            $dateData4 = explode(' - ', $data->filter_by_Date);
            $dashboards->whereBetween('donations.donation_date', [date("Y-m-d", strtotime($dateData4[0])), date("Y-m-d", strtotime($dateData4[1]))]);
        }
        $dashboards->groupBy('donation_purpose.id');
        return $dashboards;
    }

    public function sponsorCategoryDataTable($dashboards)
    {
        return DataTables::of($dashboards)
            ->addColumn('category', function ($dashboard) {
                if ($dashboard->purpose != null || $dashboard->purpose != "") {
                    return $dashboard->purpose;
                } else {
                    return 'N.A';
                }
            })->addColumn('count', function ($dashboard) {
                return number_format($dashboard->count);
            })->addColumn('revenue', function ($dashboard) {
                return '₹'.number_format($dashboard->totalDonation);
            })
            //->escapeColumns('checkbox,action')
            ->make(true);
    }


    
}
