<?php

namespace App\Imports;

use App\Lead;
use App\Leadsdata;
use App\Donation;
use App\Http\Controllers\Laralum\Laralum;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use App\Services\LeadService;
use Throwable;

HeadingRowFormatter::default('none');

class DonationImport implements 
    ToCollection, 
    WithHeadingRow, 
    SkipsOnError, 
    WithValidation,
    SkipsOnFailure,
    WithChunkReading,
    ShouldQueue,
    WithEvents 
{
    use Importable, SkipsErrors, SkipsFailures, RegistersEventListeners;

    public function __construct($client_id, $user_id, $branch_id)
    {
        $this->client_id = $client_id;
        $this->user_id = $user_id;
        $this->branch_id = $branch_id;
    }
    /** 
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

           
            if($row['Mobile'] != ""  && preg_match('/[0-9]{10}/s', $row['Mobile'])){
                $this->leadCheck = DB::table('leads')
                ->where('mobile', $row['Mobile'])
                ->where('user_id', $this->user_id)
                ->where('client_id', $this->client_id)
                ->count();

                if($this->leadCheck > 0){

                    $leadCheckData = DB::table('leads')
                                    ->where('mobile', $row['Mobile'])
                                    ->where('user_id', $this->user_id)
                                    ->where('client_id', $this->client_id)
                                    ->pluck('id');
                    $donation_lead_id = $leadCheckData[0];
                    Lead::where('id', $leadCheckData[0])->update([ 

                        'user_id' => $this->user_id,
                        'client_id' => $this->client_id,
                        'member_id' => $row['Member Id'],
                        'name' => $row['Name'],
                        'email' => $row['Email'],
                        'created_by' => $this->user_id,

                    ]);

                }else{

                    $lead = new Lead;
                    $lead->user_id = $this->user_id;
                    $lead->client_id = $this->client_id;
                    $lead->member_id = $row['Member Id'];
                    $lead->name = $row['Name'];
                    $lead->email = $row['Email'];
                    $lead->mobile = $row['Mobile'];
                    $lead->created_by = $this->user_id;
                    $lead->save();

                    $donation_lead_id = $lead->id;
                }

                $donation_date=NULL;
                if ($row['When Will Donate'] == 0 || $row['When Will Donate'] == 2 ) {
                    $donation_date = date('Y-m-d');
                } else {
                    $donation_date = ($row['Donation Date'] !='') ? date('Y-m-d',strtotime($row['Donation Date'])) : NULL;
                }

                if ($row['When Will Donate'] == 2) {
                    $paymentStatus = 1 ;
                } else {
                    $paymentStatus = $row['Payment Status'];
                }



                $donation = new Donation;
                $donation->client_id = $this->client_id;
                $donation->branch_id = $this->branch_id;
                $donation->donation_type = $row['Donation type'];   
                $donation->donation_purpose = $row['Donation Purpose'];
                $donation->donation_decision = $row['When Will Donate'];
                $donation->donation_decision_type = $row['Willing To Donate'];
                $donation->donation_date =$donation_date;
                $donation->payment_type = $row['Payment Type'];

                $donation->payment_mode = $row['Payment mode'];
                $donation->payment_status = $paymentStatus;
                $donation->amount = $row['Amount'];
                $donation->gift_issued = $row['Gift Issued'];  

                $donation->cheque_number = $row['Cheque number'];
                $donation->bank_branch = $row['Branch'];
                $donation->bank_name = $row['Bank name']; 
                $donation->cheque_date = ($row['Cheque date'] != '') ? date('Y-m-d', strtotime($row['Cheque date'])) : NULL;
                $donation->donated_by = $donation_lead_id;
                $donation->created_by = $this->user_id;
                $donation->reference_no = $row['Reference no.'];
                //$donation->payment_method = $row['Payment Method'];
                $donation->payment_period = $row['Payment Period'];
                $donation->payment_start = ($row['Payment Start Date'] != '') ? date('Y-m-d', strtotime($row['Payment Start Date'])) : NULL;
                $donation->payment_end = ($row['Payment End Date'] != '') ? date('Y-m-d', strtotime($row['Payment End Date'])) : NULL;
                
                $donation->status = "Success";
                $donation->save();
                if ($donation->id) {
                    $org_name = DB::table('organization_profile')->select('organization_name')->where('client_id', $this->client_id)->first();
                    $string = $org_name->organization_name;
                    $s = ucfirst($string);
                    $bar = ucwords(strtoupper($s));
                    $orgname = preg_replace('/\s+/', '', $bar);
                    $receipt = $orgname . (str_pad((int)$donation->id + 1, 3, '0', STR_PAD_LEFT));
                    DB::table('donations')
                        ->where('id', $donation->id)
                        ->update(['receipt_number' => $receipt]);

                }

            }



        }

    }

    // public function onError(Throwable $error){

    // }

    public function rules(): array
    {
        return [
           '*.mobile' => ['Mobile', 'unique:leads,mobile']     

        ];


    }

    // public function onFailure(Failure ...$failure){

    // }



    public function chunkSize(): int
    {
        return 50;
    }

    // public static function afterImport(AfterImport $event)
    // {
    //     //Log::info(' after import excel file');
    // }

















}
