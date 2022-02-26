<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class WelcomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     { 
	    $testimonials = DB::table('testimonials')->orderBy('id', 'DESC')->get();
	    $products = DB::table('products')->whereNotIn('product_type', [9])->get();
		$home_section = DB::table('pages')->where('type', 4)->first();
		$futured_product = DB::table('products')->where('product_type', 9)->first();
		$banner = DB::table('banners')->first();
		
		//echo '<pre>';print_r($products);die;
		
        return view('welcome', compact('testimonials', 'products', 'home_section', 'banner','futured_product'));
    }

    public function getsmsreport(Request $request)
	{
        $request=json_encode($request->all());
        $data=json_decode(json_decode($request)->data);
        foreach($data as $report){
            foreach($report->report as $report_data){
                DB::table('smsreport')->insert([
                    'senderId' => $report->senderId,
                    'requestId' => $report->requestId,
                    'date' => $report_data->date,
                    'status' => $report_data->status,
                    'number' => $report_data->number,
                    'desc'=>$report_data->desc,
                    'userId'=>$report->userId,
                    'campaignName'=>$report->campaignName,
                ]);
            }
            
        }
        
	}
}
