<?php

namespace App\Imports;

use App\Lead;
use App\Leadsdata;
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
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Events\AfterImport;
HeadingRowFormatter::default('none');

class LeadsImport implements 
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

    public function __construct($client_id, $user_id)
    {
        $this->client_id = $client_id;
        $this->user_id = $user_id;
    }
    /** 
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            if($row['Lead Owner']=="" && $row['Lead Status'] == ""){
                $status_lead=2;
            }elseif($row['Lead Owner']!="" && $row['Lead Status'] == ""){
                $status_lead=1;
            }else{
                $status_lead=$row['Lead Status'];
            }
            if($row['Mobile'] != ""  && preg_match('/[0-9]{10}/s', $row['Mobile'])){
                $this->leadCheck = DB::table('leads')
                ->where('mobile', $row['Mobile'])
                ->where('user_id', $this->user_id)
                ->where('client_id', $this->client_id)
                ->count();
                // $this->leadCheck = new LeadService();
                // $this->leadCheck->mobileExistCheck($row['Mobile'],$this->client_id,$this->user_id);

                if($this->leadCheck > 0){

                }else{
                    $member_type=explode(',', $row['Member Type']);

                    $alt_numbers=explode('-', $row['Alt Number']);

                    $address_type=['permanent','temp'];
                    $address=[$row['Address 1'],$row['Address 2']];
                    $country=[$row['Country 1'],$row['Country 2']];
                    $state=[$row['State 1'],$row['State 2']];
                    $district=[$row['District 1'],$row['District 2']];
                    $pincode=[$row['Pincode 1'],$row['Pincode 2']];

                    $member_relation_name=[$row['Family Member Name 1'],$row['Family Member Name 2'],$row['Family Member Name 3']];
                    $member_relation=[$row['Family Member Relation 1'],$row['Family Member Relation 2'],$row['Family Member Relation 3']];
                    $member_relation_dob=[$row['Family Member DOB 1'],$row['Family Member DOB 2'],$row['Family Member DOB 3']];
                    $member_relation_mobile=[$row['Family Member Mobile 1'],$row['Family Member Mobile 2'],$row['Family Member Mobile 3']];
                    $lead = new Lead;
                    $lead->user_id = $this->user_id;
                    $lead->client_id = $this->client_id;
                    $lead->account_type = $row['Account Type'];
                    $lead->department = $row['Department'];
                    $lead->member_type = json_encode($member_type);

                    $lead->lead_source = $row['Lead Source'];
                    $lead->lead_status = $status_lead;
                    $lead->preferred_language = $row['Preferred Language'];
                    $lead->agent_id =$row['Lead Owner'];
                    $lead->profile_photo = $row['Profile Photo'];
                    $lead->member_id = $row['Member ID'];
                    $lead->name = $row['Name'];

                    $lead->date_of_birth = ($row['Date of Birth'] != '') ? date('Y-m-d', strtotime($row['Date of Birth'])) : NULL;
                    $lead->date_of_joining = ($row['Date of Joining'] != '') ? date('Y-m-d', strtotime($row['Date of Joining'])) : NULL;
                    $lead->date_of_anniversary = ($row['Date Of Anniversary'] != '') ? date('Y-m-d', strtotime($row['Date Of Anniversary'])) : NULL;
                    $lead->rfid = $row['RFID'];
                    $lead->gender = $row['Gender'];
                    $lead->blood_group = $row['Blood Group'];
                    $lead->married_status = $row['Married Status'];
                    $lead->email = $row['Email'];
                    $lead->mobile = $row['Mobile'];

                    $lead->alt_numbers = empty($alt_numbers) ? '' : implode(',', $alt_numbers);//json_encode($alt_numbers);

                    $lead->id_proof = $row['Id Proof'];
                    $lead->created_by = $this->user_id;
                    $lead->qualification = $row['Qualification'];
                    $lead->branch = $row['Branch'];
                    $lead->profession = $row['Profession'];
                    $lead->sms_required = $row['Sms Requred'];
                    $lead->call_required = $row['Call Requred'];
                    $lead->sms_language = $row['Sms Language'];
                    $lead->lead_response = $row['Lead Response'];
                    $lead->address_type = serialize($address_type);
                    $lead->address = empty($address) ? '' : serialize($address);
                    $lead->country = empty($country) ? '' : serialize($country);
                    $lead->state = empty($state) ? '' : serialize($state);
                    $lead->district = empty($district) ? '' : serialize($district);
                    $lead->pincode = empty($pincode) ? '' : serialize($pincode);

                    
                    //$lead->last_contacted_date = ($line[5] != '') ? date('Y-m-d', strtotime($line[5])) : NULL;//campaign
                    $lead->save();
                }
            }
            

            /*if (!empty($member_relation_name)) {
                $name_relation = array();
                foreach ($member_relation_name as $k => $v) {
                    $name_relation[$k][] = $v;
                    if ($member_relation) {
                        foreach ($member_relation as $key => $val) {
                            if ($k == $key) {
                                $name_relation[$k][] = $val;
                            }
                        }
                    }
                    if ($member_relation_dob) {
                        foreach ($member_relation_dob as $keys => $value) {
                            if ($k == $keys) {
                                $name_relation[$k][] = $value;
                            }
                        }
                    }
                    if ($member_relation_mobile) {
                        foreach ($member_relation_mobile as $mKeys => $mValue) {
                            if ($k == $mKeys) {
                                $name_relation[$k][] = $mValue;
                            }
                        }
                    }
                }
                foreach ($name_relation as $value) {
                    Leadsdata::create([
                        'member_id' => $lead->id,
                        'member_relation' => $value[1],
                        'member_relation_name' => $value[0],
                        'member_relation_mobile' => $value[3],
                        'member_relation_dob' =>($value[2] != '') ? date('Y-m-d', strtotime($value[2])) : NULL
                    ]);
                }
            }*/
            //echo 2222;die;

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

    public static function afterImport(AfterImport $event)
    {
        //Session::flash('import_message',  'This is a message!');
        session(['import_message' => 'hello vikash']);
    }




















}
