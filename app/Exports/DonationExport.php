<?php
namespace App\Exports;
use App\Donation;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\DB;

class DonationExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
	
	use Exportable;

    public function __construct(int $client_id, $ids=null)
    {
        $this->client = $client_id;
        $this->ids = $ids;
    }

    public function query()
    { //`donations``id``client_id``branch_id``donation_type``payment_mode``amount``cheque_number``bank_branch``bank_name``cheque_date``donated_by``created_by``reference_no``receipt_number``status``created_at``updated_at``payment_status``donation_purpose``payment_method``payment_type``location``payment_start``payment_end``payment_period``donation_date``donation_decision``donation_decision_type``gift_issued`   
        $donations=DB::table('donations')
        ->leftJoin('leads', 'donations.donated_by', 'leads.id')
        ->leftJoin('donation_purpose', 'donations.donation_purpose', 'donation_purpose.id')
        ->leftJoin('users', 'donations.created_by', 'users.id')
        ->select('donations.id','donations.donation_type','leads.name','users.name as agent_name','donation_purpose.purpose','donations.location','donations.receipt_number','donations.payment_type','donations.amount','donations.payment_mode','donations.payment_status','donations.created_at');
        if(!empty($this->ids)){
            $donations->whereIn('donations.id', $this->ids);
        }
        if(!empty($this->client)){
            $donations->where('donations.donated_by', $this->client);
        }
        $donations->orderBy('donations.id', 'desc')->get();
        // if (!empty($donations)) {
        //         foreach ($donations as $key => $donation) {
        //             if ($donation->ps==0){
        //                 $donations[$key]->ps= 'Not Paid';
        //             }elseif($donation->ps==1){
        //                 $donations[$key]->ps='Paid';
        //             }
        //             else{
        //                 $donations[$key]->ps='';
        //             }

        //         }
        //     }
        return $donations;	
    }
	
	
   
	public function headings(): array
    {
       //'id','branch_id','donation_type','donated_by','created_by','donation_purpose','payment_method','location','receipt_number','payment_type','amount','payment_mode','payment_status','created_at 
        return [
            'id',
            'donation_type',
            'donated_by',
            'created_by',
            'donation_purpose',
            'location',
		    'Receipt Number',
		    'Donation Type',
		    'Amount',
		    'Payment Mode',
		    'Payment Status',
		    'Date',    
        ];

    }
}
