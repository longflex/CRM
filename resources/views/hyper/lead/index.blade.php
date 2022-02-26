@extends('hyper.layout.master')
@section('title', "Leads List")
@section('content')
<div class="px-2">
    <!-- start page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::leads_dashboard') }}"><i class="uil-home-alt"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('Crm::leads_create') }}">Create</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
                <h4 class="page-title">Leads List</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    <!-- start page content -->
    <div class="row">
        @if(Laralum::hasPermission('laralum.lead.filters'))
        <div class="col-lg-3">
            <div class="col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body mx-3">
                        <div class="">
                            <h3 class="font-weight-bold"><a class="float-right text-secondary" href="" data-toggle="tooltip" title="Reset Filters" data-placement="top"><i class="mdi mdi-refresh-circle"></i></a><i class="dripicons-experiment"></i> Filters</h3>
                        </div>
                        <hr>
                        <label>Account Filters</label>
                        <div class="form-group">
                            <select class="select2" name="lead_incoming" id="filter_by_lead_incoming" data-toggle="select2" data-placeholder="Select Lead Type">
                                <option value="">Please select..</option>
                                @if(!empty($lead_types))
                                @foreach($lead_types as $k => $lead_type)
                                <option value="{{ $k }}"
                                    {{-- (old('lead_incoming') == $k ? 'selected': '') --}}
                                    >
                                    {{ $lead_type }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="select2" name="lead_status" id="filter_by_lead_status" data-toggle="select2" data-placeholder="Select Lead Status">
                                <option value="">Please select..</option>
                                @if(!empty($lead_statuses))
                                @foreach($lead_statuses as $lead_status)
                                <option value="{{ $lead_status->lead_status }}"
                                    {{-- (old('lead_source') == $lead_status->lead_status ? 'selected': '') --}}
                                    >
                                    {{ $lead_status->description }}
                                </option>
                                @endforeach
                                @endif
                                <!-- <option value="">-- Select Lead Status --</option>
                                <option value="2">Open</option>
                                <option value="1">Assigned</option>
                                <option value="5">Closed</option>
                                <option value="4">Follow Up</option> -->
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="select2" name="account_type" id="filter_by_account_type" data-toggle="select2" data-placeholder="Select Account Type">
                                <option value="">-- Select Account Type --</option>
                                @foreach ($account_types as $account)
                                <option value="{{ $account->type }}">{{ $account->type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="select2" name="member_type" id="filter_by_member_type" data-toggle="select2" data-placeholder="Select Member Type">
                                <option value="">-- Select Member Type --</option>
                                @foreach ($member_types as $member)
                                <option value="{{ $member->type }}">{{ $member->type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="select2" name="source" id="filter_by_source" data-toggle="select2" data-placeholder="Select Source of Lead">
                                <option value="">-- Select Source of Lead --</option>
                                @foreach ($sources as $source)
                                <option value="{{ $source->id }}">{{ $source->source }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="select2" id="filter_by_lead_response" multiple="multiple" data-toggle="select2" data-placeholder="Lead Response">
                                <option value="">Please select..</option>
                                @if(!empty($lead_responses))
                                @foreach($lead_responses as $lead_response)
                                <option value="{{ $lead_response->lead_response }}">
                                    {{ $lead_response->lead_response }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <label>Organisational Related</label>
                         
                        <div class="form-group">
                            <select class="select2" name="agent" id="filter_by_agent" data-toggle="select2" data-placeholder="Select Agent">
                                <option value="">-- Select Agent --</option>
                                @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                @endforeach
                            </select>
                        </div> 
                        <div class="form-group">
                            <select class="select2" name="department" id="filter_by_department" data-toggle="select2" data-placeholder="Select Departments">
                                <option value="">-- Select Departments --</option>
                                @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control date prayer_followup_date" placeholder="Prayer Follow Up Date Range" name="prayer_followup_date" value="" />
                        </div>
                        <div class="form-group">
                            <select class="select2" name="preferred_language" id="filter_by_preferred_language" data-toggle="select2" data-placeholder="Preferred Language">
                                <option value="">--Select Preferred Language--</option>
                                <option value="Hindi">Hindi</option>
                                <option value="English">English</option>
                                <option value="Telugu">Telugu</option>
                                <option value="Tamil">Tamil</option>
                                <option value="Kannada">Kannada</option>
                                <option value="Malayalam">Malayalam</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="select2" name="call_required" id="filter_by_call_required" data-toggle="select2" data-placeholder="Select Call Required">
                                <option value="">-- Select Call Required --</option>
                                <option value="1">Required</option>
                                <option value="0">Not Required</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="select2" name="sms_required" id="filter_by_sms_required" data-toggle="select2" data-placeholder="SMS Required">
                                <option value="">-- SMS Required --</option>
                                <option value="1">Required</option>
                                <option value="0">Not Required</option>
                            </select>
                        </div>
                        <label>Call Filters</label>
                        <div class="form-group">
                            <input type="text" class="form-control date recently_contacted" placeholder="Recently Contacted Date Range" name="recently_contacted" value="" />
                        </div>
                        <div class="form-group">
                            <select class="select2" name="call" id="filter_by_call" data-toggle="select2" data-placeholder="Select Call Status">
                                <option value="">-- Select Call Status --</option>
                                <option value="1">in Process</option>
                                <option value="2">Running</option>
                                <option value="3">Both Answered</option>
                                <option value="4">To (Customer) Answered - From (Agent) Unanswered</option>
                                <option value="5">To (Customer) Answered</option>
                                <option value="6">To (Customer) Unanswered - From (Agent) Answered.</option>
                                <option value="7">From (Agent) Unanswered</option>
                                <option value="8">To (Customer) Unanswered.</option>
                                <option value="9">Both Unanswered</option>
                                <option value="10">From (Agent) Answered.</option>
                                <option value="11">Rejected Call</option>
                                <option value="12">Skipped</option>
                                <option value="13">From (Agent) Failed.</option>
                                <option value="14">To (Customer) Failed - From (Agent) Answered</option>
                                <option value="15">To (Customer) Failed</option>
                                <option value="16">To (Customer) Answered - From (Agent) Failed</option>
                            </select> 
                        </div>
                        
                        <div class="form-group">
                            <select class="select2" id="filter_by_call_type" data-toggle="select2" data-placeholder="Select Call Type">
                                <option value="">-- Select Call Type --</option>
                                <option value="0">Manual</option>
                                <option value="1">Auto</option>
                            </select> 
                        </div>
                        <label>Personal Information Filter</label>
                        <div class="form-group">
                            <input type="text" class="form-control date date_of_birth" placeholder="Date of Birth" name="date_of_birth" value="" />
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control date date_of_anniversary" placeholder="Anniversary Date Range" name="date_of_anniversary" value="" />
                        </div>
                        <div class="form-group">
                            <select class="select2" name="gender" id="filter_by_gender" data-toggle="select2" data-placeholder="Select Gender">
                                <option value="">-- Select Gender --</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="select2" name="blood_group" id="filter_by_blood_group" data-toggle="select2" data-placeholder="Select Blood Group">
                                <option value="">-- Select Blood Group --</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="select2" name="marital_status" id="filter_by_marital_status" data-toggle="select2" data-placeholder="Select Marital Status">
                                <option value="">-- Select Marital Status --</option>
                                <option value="Married">Married</option>
                                <option value="Unmarried">Unmarried</option>
                            </select>
                        </div>                        
                        <label>Campaign Filter</label>      
                        <div class="form-group">
                            <select class="select2" name="campaign_assigned" id="filter_by_campaign_assigned" data-toggle="select2" data-placeholder="Campaign assigned">
                                <option value="">-- Select Campaign assigned --</option>
                                <option value="assigned">Assigned</option>
                                <option value="unassigned">Unassigned</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="filter_by_campaign" name="campaign" data-toggle="select2"
                                data-placeholder="Select Campaign">
                                <option value="">-- Select Campaign --</option>
                                @if(!empty($campaigns))
                                @foreach($campaigns as $campaign)
                                <option value="{{ $campaign->id }}"
                                    {{ (old('campaign') == $campaign->id ? 'selected': '') }}>
                                    {{ $campaign->name }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="select2" id="filter_by_campaign_status" data-toggle="select2" data-placeholder="Campaign Status Filter">
                                <option value="">-- Campaign Status Filter --</option>
                                <option value="1">Available</option>
                                <option value="2">Completed</option>
                                <option value="3">Follow Up</option>
                            </select>
                        </div>
                         
                    </div> 
                </div> 
            </div>            
        </div>
        <div class="col-lg-9">
        @else
        <div class="col-lg-12">
        @endif
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="custom-select" id="check_action" aria-label="Example select with button addon">
                                        <option value="Select Action" selected>Select Action</option>
                                        <option value="Assign Selected To Campaign">Assign Selected To Campaign</option>
                                        <!-- <option value="Assign Selected To Agent">Assign Selected To Agent</option>
                                        <option value="Assign Selected To Group">Assign Selected To Group</option> -->
                                        <option value="Export Selected">Export Selected</option>
                                        <option value="Delete Selected">Delete Selected</option>
                                        @if(Laralum::hasPermission('laralum.member.sendsms'))
                                        <option value="Send Sms">Send Sms</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-4" id="assign_to_campaign_section"> 
                                    <select class="select2 select2-multiple" id="assign_to_campaign" data-toggle="select2" data-placeholder="Choose Campaigns">
                                        <option value=''>Choose Campaign</option>
                                        @if(!empty($campaigns))
                                        @foreach ($campaigns as $campaign)
                                        <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <!-- <div class="col-md-4" id="assign_to_agent_section"> 
                                    <select class="select2 select2-multiple" multiple="multiple" id="assign_to_agent" data-toggle="select2" data-placeholder="Choose Agent">
                                        <option value=''>Choose Agent</option>
                                        @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                        @endforeach
                                    </select>
                                </div> -->
                                <!-- <div class="col-md-4" id="assign_to_agent_group_section">  
                                    <select class="select2" id="assign_to_agent_group" data-toggle="select2" data-placeholder="Choose Agent Group">
                                        <option value=''>Choose Agent Group</option>
                                        @foreach ($agentGroup as $agentG)
                                        <option value="{{ $agentG->id }}">{{ $agentG->name }}</option>
                                        @endforeach
                                    </select> 
                                </div> -->
                                <div class="col-md-2" id="select_all_section">  
                                   <div class="custom-control custom-checkbox mt-2">
                                        <input type="checkbox" class="custom-control-input select_all_option" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">Select All</label>
                                    </div> 
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-primary" id='action_btn'>Go <i class="mdi mdi-arrow-right-bold"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 float-right">
                            <a class="btn btn-light float-right" href="{{ route('Crm::get_leads_import') }}"><i class="uil-cloud-upload"></i></a>
                            <a class="btn btn-danger float-right mr-1" href="{{ route('Crm::leads_create') }}"><i class="uil-plus-circle"></i></a>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group mt-2">
                        <!-- <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="dataTables_length" >
                                    <label>
                                        Show 
                                        <select name="leadDataTable_length" aria-controls="leadDataTable" class="custom-select custom-select-sm form-control form-control-sm">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                        entries
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-8">
                                <div id="leadDataTable_filter" class="dataTables_filter">
                                <label style="float: right;">Search : <input type="search" id="serach" class="form-control form-control-sm" placeholder="" aria-controls="leadDataTable">
                                </label>
                                </div>
                            </div>
                        </div> -->
                        <div class="table-responsive">
                            <!-- id="open-datatable" -->
                            <table  class="table dt-responsive nowrap w-100" id="open-datatable">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll" value=true></th>  
                                        <th>ID</th>
                                        <th>Member ID</th>
                                        <th>Name</th>
                                        <th>Mobile No</th>
                                        <th>Assigned To</th>
                                        <th>Status</th>
                                        <th>Language</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end page content --> 
</div>  

<!-- Radio Modal-->
<div class="modal fade" id="oppenRadioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="donationPrayer" id="donationRadio" onChange ="oppenModalDonationPrayer(this)">
            <h4 class="form-check-label" for="exampleRadios1">
               Add Donation
            </h4>                            
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="donationPrayer" id="prayerRadio" value="prayer" onChange ="oppenModalDonationPrayer()">
            <h4 class="form-check-label" for="exampleRadios2">
                Add Payer Request
            </h4>
        </div>
      </div>
    </div>
  </div>
</div>

<!--Add Donation -->
<div id="AddDonation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="adddanationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="adddanationModalLabel">Add Donation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            {{-- <form class="ui form" action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="upload_donation_form">@csrf --}}
            <form method="POST" enctype="multipart/form-data" id="upload_donation_form" action="javascript:void(0)">    
                <div class="modal-body">
                    <input type="hidden" id="lead_id" name="lead_id" value="" />
                    <div class="lead_data" style="display:none;"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Donation Type<span class="text-danger">*</span></label>
                                <select id="member_type_id" name="donation_type" class="form-control select2">
                                    <option value="">Please select..</option>
                                    @foreach($membertypes as $type)
                                    <option value="{{ $type->type }}" {{ (old('donation_type') == $type->type ? 'selected': '') }}>
                                        {{ $type->type }}
                                    </option>
                                    @endforeach
                                    <option value="add">Add Value</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Donation Purpose<span class="text-danger">*</span></label>
                                <select id="donation_purpose" name="donation_purpose" class="form-control select2">
                                    <option value="">Please select..</option>
                                    @foreach($donation_purposes as $purpose)
                                    <option value="{{ $purpose->id }}" {{ (old('donation_purpose') == $purpose->id ? 'selected': '') }}>
                                        {{ $purpose->purpose }}
                                    </option>
                                    @endforeach
                                    <option value="add">Add Value</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="donation_date">Donation Date</label>
                                <input type="date" class="form-control" id="donation_date" name="donation_date">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Payment Type<span class="text-danger">*</span></label>
                                <select id="payment_type" name="payment_type" class="form-control select2" onchange="stateChange(this)">
                                    <option value="">Please select..</option>
                                    <option value="single" {{ (old('payment_type') == 'single' ? 'selected': '') }}>
                                        Single</option>
                                    <option value="recurring" {{ (old('payment_type') == 'recurring' ? 'selected': '') }}>Recurring</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Payment Mode<span class="text-danger">*</span></label>
                                <select id="payment_mode" name="payment_mode" class="form-control select2">
                                    <option value="">Please select..</option>
                                    <option value="CASH">Cash</option>
                                    <option value="CARD">Card</option>
                                    <option value="CHEQUE">Cheque</option>
                                    @if($razorKey)
                                    <option value="Razorpay">Razorpay</option>
                                    @endif
                                    {{-- <option value="GOOGLEPAY">GooglePay</option> --}}
                                    {{-- <option value="PHONEPAY">PhonePay</option> --}}
                                    <option value="QRCODE">QR code</option>
                                    <option value="OTHER">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 payment-status" style="display: none">
                            <div class="form-group">
                                <label>Payment Status<span class="text-danger">*</span></label>
                                <select id="payment_status" name="payment_status" class="form-control select2">
                                    <option value="">Please select..</option>
                                    <option value="0">Not Paid</option>
                                    <option value="1">Paid</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label>Location</label>
                                <select class="form-control select2" name="location" id="location">
                                    <option value="">Please select..</option>
                                    @foreach($branches as $branch)
                                    <option value="{{ $branch->branch }}" {{ (old('location') == $branch->branch ? 'selected': '') }}>
                                        {{ $branch->branch }}
                                    </option>
                                    @endforeach
                                    <option value="add">Add Value</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Amount<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="amount" placeholder="Please enter the amount" name="amount" />
                            </div>
                        </div>
                        <div class="col-md-6 period" style="display: none">
                            <div class="form-group">
                                <label>Payment Period<span class="text-danger">*</span></label>
                                <select id="payment_period" name="payment_period" class="form-control select2">
                                    <option value="">Please select..</option>
                                    <option value="daily">daily</option>
                                    <option value="weekly">weekly</option>
                                    <option value="monthly">monthly</option>
                                    <option value="yearly">yearly</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 start" style="display: none">
                            <div class="form-group">
                                <label>Payment Start Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="start_date" name="payment_start_date" value="{{old('start_date')}}" />
                            </div>
                        </div>
                        <div class="col-md-6 end" style="display: none">
                            <div class="form-group">
                                <label>Payment End Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="end_date" name="payment_end_date" value="{{old('end_date')}}" />
                            </div>
                        </div>
                        <div class="col-md-6" id="reference_no_field" style="display:none">
                            <div class="form-group">
                                <label>Reference No.<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="reference_no" name="reference_no" placeholder="Please enter the reference no" />
                            </div>
                        </div>
                        <div class="col-md-6" id="bank_name_field" style="display:none">
                            <div class="form-group">
                                <label>Bank<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Please enter the bank name" />
                            </div>
                        </div>
                        <div class="col-md-6" id="cheque_number_field" style="display:none">
                            <div class="form-group">
                                <label>Cheque Number<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="cheque_number" name="cheque_number" placeholder="Please enter the check no." />
                            </div>
                        </div>
                        <div class="col-md-6" id="branch_name_field" style="display:none">
                            <div class="form-group">
                                <label>Branch<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="branch_name" name="branch_name" placeholder="Please enter the branch name" />
                            </div>
                        </div>
                        <div class="col-md-6" id="cheque_date_field" style="display:none">
                            <div class="form-group">
                                <label>Cheque Issue Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="cheque_date" name="cheque_date" placeholder="Please select the cheque issue date" />
                            </div>
                        </div>
                        <div class="col-md-6" id="payment_method_field" style="display:none">
                            <div class="form-group">
                                <label>Payment Method<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="payment_method" name="payment_method" placeholder="Please enter the method name" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="" class="btn btn-success btn-sm">SAVE</button>
                    </div>
                    <div class="history_data" style="display:none;"></div>
            </form>
        </div>
    </div>
</div>
</div>

<!-- Add Note modal -->
<div id="AddNote" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addnoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addnoteModalLabel"><i class="uil-question-circle mr-1"></i>Add Request</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form id="prayer_req_save">@csrf
                <div class="modal-body">
                    <input type="hidden" id="member_id" name="member_id" value=""/>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="follow_up_date">Follow up Date</label>
                                <input type="text" class="form-control" value="" id="follow_up_date" name="follow_up_date">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="create_at">Prayer Request</label>
                                <select class="form-control select2" name="issue" id="issue"  data-toggle="select2" data-placeholder="Please select.." required>
                                    <option value="">Please select..</option>
                                    @foreach($prayer_requests as $issue)
                                    <option value="{{ $issue->prayer_request }}">{{ $issue->prayer_request }}</option>
                                    @endforeach
                                    <!-- <option value="add">Add Value</option> -->
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" id="description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="" class="btn btn-success btn-sm">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('extrascripts')

    <script>
        // function oppenModalDonationPrayer()
        // {
        //     var radioValue = $("input[name='donationPrayer']:checked").val();
        //     var selected_Id = $('input[name="donationPrayer"]:checked').attr('id');
        //     $('#oppenRadioModal').modal('hide');
        //     if(selected_Id == "donationRadio"){
        //         addDonationModal(radioValue);
        //     }else{
        //         addPrayerRequestModal(radioValue);
        //     }
        // }
        // function addDonationModal(id)
        // {
        //     $('#lead_id').val(id);
        //     $('#AddDonation').modal('show');
        // }
        // function addPrayerRequestModal(id){
        //     $('#member_id').val(id);
        //     $('#AddNote').modal('show');
        // }
        // function oppenRadioModal(id)
        // {
        //     $('#donationRadio').val(id);
        //     $('#prayerRadio').val(id);
        //     $('#oppenRadioModal').modal('show');
        // }
        $(document).ready(function() {
            $('#assign_to_campaign_section').hide();
            $('#assign_to_agent_section').hide();
            $('#assign_to_agent_group_section').hide();
            $('#select_all_section').hide();

            $('#check_action').on('change', function () {
                // if($('#check_action').val()=='Assign Selected To Agent') {
                //     $('#assign_to_agent_section').show();
                //     $('#select_all_section').show();
                // } else{
                //     //$('#select_all_section').hide();
                //     $('#assign_to_agent_section').hide();
                // }
                // if($('#check_action').val()=='Assign Selected To Group') {
                //     $('#assign_to_agent_group_section').show();
                //     $('#select_all_section').show();
                // } else{
                //     //$('#select_all_section').hide();
                //     $('#assign_to_agent_group_section').hide();
                // }
                if($('#check_action').val()=='Export Selected') {
                    //$('#assign_to_agent_group_section').show();
                    $('#select_all_section').show();
                } else{
                    //$('#select_all_section').hide();
                    //$('#assign_to_agent_group_section').hide();
                }
                if($('#check_action').val()=='Delete Selected') {
                    //$('#assign_to_agent_group_section').show();
                    $('#select_all_section').show();
                } else{
                    //$('#select_all_section').hide();
                    //$('#assign_to_agent_group_section').hide();
                }
                if($('#check_action').val()=='Assign Selected To Campaign') {
                    //$('#assign_to_agent_group_section').show();
                    $('#assign_to_campaign_section').show();
                    $('#select_all_section').show();
                } else{
                    $('#assign_to_campaign_section').hide();
                }
            });
        });

        




        $(function() {
            $('input[name="recently_contacted"]').daterangepicker({
                autoUpdateInput: false,
                applyButtonClasses: 'btn btn-warning',
                drops: ('up'),
                autoApply: false,
                locale: {
                    cancelLabel: 'Clear',
                }
            });
            $('input[name="recently_contacted"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                leadDataTable();
            });
            $('input[name="recently_contacted"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                leadDataTable();
            });
        });
        $(function() {
            $('input[name="date_of_anniversary"]').daterangepicker({
                autoUpdateInput: false,
                applyButtonClasses: 'btn btn-warning',
                drops: ('up'),
                autoApply: false,
                locale: {
                    cancelLabel: 'Clear',
                }
            });
            $('input[name="date_of_anniversary"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                leadDataTable();
            });
            $('input[name="date_of_anniversary"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                leadDataTable();
            });
        });
        $(function() {
            $('input[name="date_of_birth"]').daterangepicker({
                autoUpdateInput: false,
                applyButtonClasses: 'btn btn-warning',
                drops: ('up'),
                autoApply: false,
                locale: {
                    cancelLabel: 'Clear',
                }
            });
            $('input[name="date_of_birth"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                leadDataTable();
            });
            $('input[name="date_of_birth"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                leadDataTable();
            });
        });
        $(function() {
            $('input[name="prayer_followup_date"]').daterangepicker({
                autoUpdateInput: false,
                applyButtonClasses: 'btn btn-warning',
                drops: ('up'),
                autoApply: false,
                locale: {
                    cancelLabel: 'Clear',
                }
            });
            $('input[name="prayer_followup_date"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                leadDataTable();
            });
            $('input[name="prayer_followup_date"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                leadDataTable();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            leadDataTable();
            $('#filter_by_lead_status').on('change', function (){ 
                leadDataTable();
            });    
            $('#filter_by_account_type').on('change', function () {
                leadDataTable();
            });
            $('#filter_by_member_type').on('change', function () {
                leadDataTable();
            });
            // $('#filter_by_prayer_request').on('change', function () {
            //     leadDataTable();
            // });
            $('#filter_by_department').on('change', function () {
                leadDataTable();
            });
            $('#filter_by_call').on('change', function () {
                leadDataTable();
            });
            $('#filter_by_source').on('change', function () {
                leadDataTable();
            });
            $('#filter_by_gender').on('change', function () {
                leadDataTable();
            });
            $('#filter_by_blood_group').on('change', function () {
                leadDataTable();
            });
            $('#filter_by_marital_status').on('change', function () {
                leadDataTable();
            });
            
            $('#filter_by_call_required').on('change', function () {
                leadDataTable();
            });
            $('#filter_by_sms_required').on('change', function () {
                leadDataTable();
            });
            $('#filter_by_preferred_language').on('change', function () {
                leadDataTable();
            });
            $('#filter_by_campaign').on('change', function () {
                leadDataTable();
            });
            $('#filter_by_lead_incoming').on('change', function () {
                leadDataTable();
            });            
            $('#filter_by_agent').on('change', function () {
                leadDataTable();
            });
            $('#filter_by_campaign_assigned').on('change', function () {
                leadDataTable();
            });
            $('#filter_by_campaign_status').on('change', function () {
                leadDataTable();
            });
            $('#filter_by_call_type').on('change', function () {
                leadDataTable();
            });
            $('#filter_by_lead_response').on('change', function () {
                leadDataTable();
            });
        });
        function leadDataTable() {
            $('#open-datatable').DataTable().destroy();
            let table = $('#open-datatable');
            let data_id = $('#filter_by_lead_status').val();
            table.DataTable(
                {
                    order: [['1', 'desc']],
                    lengthMenu: [[10, 25, 50, 100, 500, 1000], [10, 25, 50, 100, 500, 1000]],
                    serverSide: true,
                    responsive: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('Crm::get_leads_data_lead_list') }}",
                        type: 'POST',
                        data: function (d) {
                                d._token = '{{csrf_token()}}';
                                d.filter_by_data_id = data_id;
                                d.filter_by_recently_contacted = $('.recently_contacted').val();
                                d.filter_by_account_type = $('#filter_by_account_type').val();
                                d.filter_by_member_type = $('#filter_by_member_type').val();
                                //d.filter_by_prayer_request = $('#filter_by_prayer_request').val();
                                d.filter_by_lead_incoming = $('#filter_by_lead_incoming').val();
                                d.filter_by_department = $('#filter_by_department').val();
                                d.filter_by_call = $('#filter_by_call').val();
                                d.filter_by_source = $('#filter_by_source').val();
                                d.filter_by_gender = $('#filter_by_gender').val();
                                d.filter_by_blood_group = $('#filter_by_blood_group').val();
                                d.filter_by_marital_status = $('#filter_by_marital_status').val();
                                d.filter_by_date_of_birth = $('.date_of_birth').val();
                                d.filter_by_date_of_anniversary = $('.date_of_anniversary').val();
                                d.filter_by_call_required = $('#filter_by_call_required').val();
                                d.filter_by_sms_required = $('#filter_by_sms_required').val();
                                d.filter_by_preferred_language = $('#filter_by_preferred_language').val();
                                d.filter_by_agent = $('#filter_by_agent').val();
                                d.filter_by_campaign = $('#filter_by_campaign').val();
                                d.filter_by_campaign_assigned = $('#filter_by_campaign_assigned').val();
                                d.filter_by_campaign_status = $('#filter_by_campaign_status').val();
                                d.filter_by_prayer_followup_date = $('.prayer_followup_date').val();
                                d.filter_by_call_type = $('#filter_by_call_type').val();
                                d.filter_by_lead_response = $('#filter_by_lead_response').val();
                            },
                    },
                    columns: [                        
                        {data: "checkbox", sortable: false, searchable : false},
                        {data: "id", name: 'leads.id',},
                        {data: "member_id", name: 'leads.member_id',},
                        {data: "name", name: 'leads.name'},
                        {data: "mobile", name: 'leads.mobile'},
                        {data: "assign_to", name: 'users.name', searchable : false},
                        {data: "lead_status", name: 'leads.lead_status', searchable : false},
                        {data: "preferred_language", name: 'leads.preferred_language', searchable : false},
                        {data: "action", sortable: false, searchable : false},
                    ]
                }
            );
        //     $.ajax({
        //     method: "POST",
        //     url: "{{ route('Crm::get_leads_data_lead_list') }}",
        //     data: {
        //         _token: "{{ csrf_token() }}",
        //         page : page,
        //         search_query : search_query,
        //         filter_by_data_id : $('#filter_by_lead_status').val(),
        //         filter_by_recently_contacted : $('.recently_contacted').val(),
        //         filter_by_account_type : $('#filter_by_account_type').val(),
        //         filter_by_member_type : $('#filter_by_member_type').val(),
        //         filter_by_prayer_request : $('#filter_by_prayer_request').val(),
        //         filter_by_department : $('#filter_by_department').val(),
        //         filter_by_call : $('#filter_by_call').val(),
        //         filter_by_source : $('#filter_by_source').val(),
        //         filter_by_gender : $('#filter_by_gender').val(),
        //         filter_by_blood_group : $('#filter_by_blood_group').val(),
        //         filter_by_marital_status : $('#filter_by_marital_status').val(),
        //         filter_by_date_of_birth : $('.date_of_birth').val(),
        //         filter_by_date_of_anniversary : $('.date_of_anniversary').val(),
        //         filter_by_call_required : $('#filter_by_call_required').val(),
        //         filter_by_sms_required : $('#filter_by_sms_required').val(),
        //         filter_by_preferred_language : $('#filter_by_preferred_language').val(),
        //         filter_by_agent : $('#filter_by_agent').val(),
        //     }
        // }).done(function(data) {
        //     $('tbody').html('');
        //     $('tbody').html(data);
        // });


    }
    // $(document).on('keyup', '#serach', function(){
    //     var query = $('#serach').val();
    //     var column_name = $('#hidden_column_name').val();
    //     var sort_type = $('#hidden_sort_type').val();
    //     var page = $('#hidden_page').val();
    //     leadDataTable(page, sort_type, column_name, query);
    // });
    // $(document).on('click', '.pagination a', function(event){
    //     event.preventDefault();
    //     var page = $(this).attr('href').split('page=')[1];
    //     $('#hidden_page').val(page);
    //     var column_name = $('#hidden_column_name').val();
    //     var sort_type = $('#hidden_sort_type').val();

    //     var query = $('#serach').val();

    //     $('li').removeClass('active');
    //     $(this).parent().addClass('active');
    //     leadDataTable(page, sort_type, column_name, query);
    // });
    </script>
    <script type="text/javascript">
        function destroy(id) {
            var dataid = id;
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this Lead !!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('Crm::lead.delete') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id" : dataid
                        },
                        success: function (data) {
                            $.NotificationApp.send("Success","Lead has been deleted.","top-center","green","success");
                            setTimeout(function(){
                                location.reload();
                            }, 3500);
                        }, error: function (data) {
                            $.NotificationApp.send("Error","Lead has not been deleted.","top-center","red","error");
                            setTimeout(function(){
                                location.reload();
                            }, 3500);
                        },
                    });
                } else if ( result.dismiss === Swal.DismissReason.cancel ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Lead not deleted !',
                        'error'
                    )
                }
            });
        }
    </script>
    <script>
        $('#selectAll').click(function(e) {
            var table= $(e.target).closest('table');
            $('td input:checkbox',table).prop('checked',this.checked);
        });
        
        
        $("#action_btn").click(function() {
            var ids=[];

            var select_all_option_check=0;
            var filter_by_data_id=$('#filter_by_lead_status').val();
            var filter_by_recently_contacted=$('.recently_contacted').val();
            var filter_by_account_type=$('#filter_by_account_type').val();
            var filter_by_member_type=$('#filter_by_member_type').val();
            //var filter_by_prayer_request=$('#filter_by_prayer_request').val();
            var filter_by_department=$('#filter_by_department').val();
            var filter_by_call=$('#filter_by_call').val();
            var filter_by_source=$('#filter_by_source').val();
            var filter_by_gender=$('#filter_by_gender').val(); 
            var filter_by_blood_group=$('#filter_by_blood_group').val();
            var filter_by_marital_status=$('#filter_by_marital_status').val();
            var filter_by_date_of_birth=$('.date_of_birth').val();
            var filter_by_lead_incoming = $('#filter_by_lead_incoming').val();
            var filter_by_date_of_anniversary=$('.date_of_anniversary').val();
            var filter_by_call_required=$('#filter_by_call_required').val();
            var filter_by_sms_required=$('#filter_by_sms_required').val();
            var filter_by_preferred_language=$('#filter_by_preferred_language').val();
            var filter_by_agent=$('#filter_by_agent').val();

            var filter_by_campaign=$('#filter_by_campaign').val();
            var filter_by_campaign_assigned=$('#filter_by_campaign_assigned').val();
            var filter_by_campaign_status=$('#filter_by_campaign_status').val();
            var filter_by_prayer_followup_date=$('.prayer_followup_date').val();
            var filter_by_call_type=$('#filter_by_call_type').val();
            var filter_by_lead_response=$('#filter_by_lead_response').val();

            if($(".select_all_option").prop('checked') == true){
                select_all_option_check=1; 
            }else{
                select_all_option_check=0;
                ids=[];
                $('input[type=checkbox]:checked').each(function(i, val) {
                    if(val.id!='selectAll')
                    ids.push(val.id);
                });  
            }
            if(ids.length==0 && select_all_option_check==0){
                $.NotificationApp.send("Error","Please select lead first!","top-center","red","error");
                return;
            }
            if($('#check_action').val()!='Select Action') {
                var url="";
                var body={};
                if($('#check_action').val()=='Delete Selected') {
                    url="{{ route('Crm::lead_deleteSelected') }}"
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });    
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: {
                            
                            ids:ids,
                            select_all_option_check:select_all_option_check,
                            filter_by_data_id:filter_by_data_id,
                            filter_by_recently_contacted:filter_by_recently_contacted,
                            filter_by_account_type:filter_by_account_type,
                            filter_by_member_type:filter_by_member_type,
                            filter_by_department:filter_by_department,
                            filter_by_call:filter_by_call,
                            filter_by_source:filter_by_source,
                            filter_by_lead_incoming:filter_by_lead_incoming,
                            filter_by_gender:filter_by_gender,
                            filter_by_blood_group:filter_by_blood_group,
                            filter_by_marital_status:filter_by_marital_status,
                            filter_by_date_of_birth:filter_by_date_of_birth,
                            filter_by_date_of_anniversary:filter_by_date_of_anniversary,
                            filter_by_call_required:filter_by_call_required,
                            filter_by_sms_required:filter_by_sms_required,
                            filter_by_preferred_language:filter_by_preferred_language,
                            filter_by_agent:filter_by_agent,

                            filter_by_campaign:filter_by_campaign,
                            filter_by_campaign_assigned:filter_by_campaign_assigned,
                            filter_by_campaign_status:filter_by_campaign_status,
                            filter_by_prayer_followup_date:filter_by_prayer_followup_date,
                            filter_by_call_type:filter_by_call_type,
                            filter_by_lead_response:filter_by_lead_response,


                        },
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            $.NotificationApp.send("Success","Selected data has been deleted.","top-center","green","success");
                            setTimeout(function(){
                                leadDataTable();
                                //location.reload();
                            }, 3500);
                        }, error: function (data) {console.log(data);
                            $.NotificationApp.send("Error","Selected data hasn't been deleted.","top-center","red","error");
                            setTimeout(function(){
                                leadDataTable();
                                //location.reload();
                            }, 3500);
                        },
                    })
                } else if ($('#check_action').val()=='Export Selected') {
                    var query = {
                        "ids": ids,
                        "select_all_option_check":select_all_option_check,
                        "filter_by_data_id":filter_by_data_id,
                        "filter_by_recently_contacted":filter_by_recently_contacted,
                        "filter_by_account_type":filter_by_account_type,
                        "filter_by_member_type":filter_by_member_type,
                        "filter_by_department":filter_by_department,
                        "filter_by_call":filter_by_call,
                        "filter_by_source":filter_by_source,
                        "filter_by_gender":filter_by_gender,
                        "filter_by_blood_group":filter_by_blood_group,
                        "filter_by_marital_status":filter_by_marital_status,
                        "filter_by_date_of_birth":filter_by_date_of_birth,
                        "filter_by_date_of_anniversary":filter_by_date_of_anniversary,
                        "filter_by_call_required":filter_by_call_required,
                        "filter_by_sms_required":filter_by_sms_required,
                        "filter_by_preferred_language":filter_by_preferred_language,
                        "filter_by_agent":filter_by_agent,

                        "filter_by_campaign":filter_by_campaign,
                        "filter_by_campaign_assigned":filter_by_campaign_assigned,
                        "filter_by_campaign_status":filter_by_campaign_status,
                        "filter_by_prayer_followup_date":filter_by_prayer_followup_date,
                        "filter_by_call_type":filter_by_call_type,
                        "filter_by_lead_response":filter_by_lead_response,
                    }
                    var url = "{{ route('Crm::exportSelectedLeads') }}?" + $.param(query)
                    window.location = url;
                }else if ($('#check_action').val()=='Assign Selected To Campaign') {
                var cid = $('#assign_to_campaign').val();
                //var rem = ids.length %  aid.length;
                // if(rem != 0){
                //     $.NotificationApp.send("Error","Please select leads multiple of agents.You have selected "+ids.length+" leads","top-center","red","error");
                //     return;
                // }   
                // if(aid.length > ids.length){
                //     $.NotificationApp.send("Error","Please select more leads than the agents","top-center","red","error");
                //     return;
                // }   
                if(cid.length !== 0) {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                            },
                            buttonsStyling: false
                    })
                    swalWithBootstrapButtons.fire({
                        title: 'Are you sure?',
                        text: "You want to assign leads to campaign ?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Confirm!',
                        cancelButtonText: 'No, cancel!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('Crm::assign.lead.campaign') }}",
                                data: {
            
                                    "_token": "{{ csrf_token() }}",
                                    "campaigns": cid,
                                    "leads": ids,
                                    "select_all_option_check":select_all_option_check,
                                    "filter_by_data_id":filter_by_data_id,
                                    "filter_by_recently_contacted":filter_by_recently_contacted,
                                    "filter_by_account_type":filter_by_account_type,
                                    "filter_by_member_type":filter_by_member_type,
                                    "filter_by_department":filter_by_department,
                                    "filter_by_call":filter_by_call,
                                    "filter_by_lead_incoming":filter_by_lead_incoming,
                                    "filter_by_source":filter_by_source,
                                    "filter_by_gender":filter_by_gender,
                                    "filter_by_blood_group":filter_by_blood_group,
                                    "filter_by_marital_status":filter_by_marital_status,
                                    "filter_by_date_of_birth":filter_by_date_of_birth,
                                    "filter_by_date_of_anniversary":filter_by_date_of_anniversary,
                                    "filter_by_call_required":filter_by_call_required,
                                    "filter_by_sms_required":filter_by_sms_required,
                                    "filter_by_preferred_language":filter_by_preferred_language,
                                    "filter_by_agent":filter_by_agent,

                                    "filter_by_campaign":filter_by_campaign,
                                    "filter_by_campaign_assigned":filter_by_campaign_assigned,
                                    "filter_by_campaign_status":filter_by_campaign_status,
                                    "filter_by_prayer_followup_date":filter_by_prayer_followup_date,
                                    "filter_by_call_type":filter_by_call_type,
                                    "filter_by_lead_response":filter_by_lead_response
                                },
                                success: function (data) {
                                    $.NotificationApp.send("Success","Leads assigned to campaign.","top-center","green","success");
                                    setTimeout(function(){
                                    }, 3500);
                                    leadDataTable();
                                }, error: function (data) {
                                    $.NotificationApp.send("Error","Leads not assigned to campaign.","top-center","red","error");
                                },
                            });
                        } else if ( result.dismiss === Swal.DismissReason.cancel ) {
                            swalWithBootstrapButtons.fire(
                                'Cancelled',
                                'Leads assign canceled.',
                                'error'
                            )
                        }
                    });
                }else{
                    $.NotificationApp.send("Error","Please select agent first !","top-center","red","error");
                }     
                }






                // else if ($('#check_action').val()=='Assign Selected To Agent') {
                // var aid = $('#assign_to_agent').val();
                // var rem = ids.length %  aid.length;
                // if(rem != 0){
                //     $.NotificationApp.send("Error","Please select leads multiple of agents.You have selected "+ids.length+" leads","top-center","red","error");
                //     return;
                // }   
                // if(aid.length > ids.length){
                //     $.NotificationApp.send("Error","Please select more leads than the agents","top-center","red","error");
                //     return;
                // }   
                // if(aid.length !== 0) {
                //     const swalWithBootstrapButtons = Swal.mixin({
                //         customClass: {
                //             confirmButton: 'btn btn-success',
                //             cancelButton: 'btn btn-danger'
                //             },
                //             buttonsStyling: false
                //     })
                //     swalWithBootstrapButtons.fire({
                //         title: 'Are you sure?',
                //         text: "You want to assign leads to agents ??",
                //         icon: 'question',
                //         showCancelButton: true,
                //         confirmButtonText: 'Yes, Confirm!',
                //         cancelButtonText: 'No, cancel!',
                //         reverseButtons: true
                //     }).then((result) => {
                //         if (result.isConfirmed) {
                //             $.ajax({
                //                 type: "POST",
                //                 url: "{{ route('Crm::assign.lead') }}",
                //                 data: {
                //                     "_token"    : "{{ csrf_token() }}",
                //                     "agents"     : aid,
                //                     "leads"      : ids
                //                 },
                //                 success: function (data) {
                //                     $.NotificationApp.send("Success","Leads assigned to agent.","top-center","green","success");
                //                     setTimeout(function(){
                //                     }, 3500);
                //                     leadDataTable();
                //                 }, error: function (data) {
                //                     $.NotificationApp.send("Error","Leads not assigned to agent.","top-center","red","error");
                //                 },
                //             });
                //         } else if ( result.dismiss === Swal.DismissReason.cancel ) {
                //             swalWithBootstrapButtons.fire(
                //                 'Cancelled',
                //                 'Leads assign canceled.',
                //                 'error'
                //             )
                //         }
                //     });
                // }else{
                //     $.NotificationApp.send("Error","Please select agent first !","top-center","red","error");
                // }     
                // }
                // else if ($('#check_action').val()=='Assign Selected To Group') {
                //     var group_id=$('#assign_to_agent_group').val();
                //     var  agent_ids="";
                    
                //     if(group_id == ''){
                //         $.NotificationApp.send("Error","Please select leads multiple of agents.You have selected "+ids.length+" leads","top-center","red","error");
                //         return;
                //     }

                //     $.ajaxSetup({
                //         headers: {
                //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                //         }
                //     });
                //     var arr = [], len;
                //     $.ajax({
                //         type: 'POST',
                //         url: "{{ route('Crm::get_agentids_by_agent_group') }}",
                //         data: {group_id:group_id},
                //         success: function (data) {
                //             for(key in data.agent_datas) {
                //                 arr.push(key);
                //             }
                //             len = arr.length;
                //             if(len > ids.length){
                //                 $.NotificationApp.send("Error","Please select leads multiple of "+len+".You have selected "+ids.length+" leads","top-center","red","error");
                //                 return;
                //             }

                //             if(group_id !== "") {
                //                 const swalWithBootstrapButtons = Swal.mixin({
                //                     customClass: {
                //                         confirmButton: 'btn btn-success',
                //                         cancelButton: 'btn btn-danger'
                //                         },
                //                         buttonsStyling: false
                //                 })
                //                 swalWithBootstrapButtons.fire({
                //                     title: 'Are you sure?',
                //                     text: "You want to assign leads to agents ??",
                //                     icon: 'question',
                //                     showCancelButton: true,
                //                     confirmButtonText: 'Yes, Confirm!',
                //                     cancelButtonText: 'No, cancel!',
                //                     reverseButtons: true
                //                 }).then((result) => {
                //                     if (result.isConfirmed) {
                //                         $.ajax({
                //                             type: "POST",
                //                             url: "{{ route('Crm::assign.lead') }}",
                //                             data: {
                //                                 "_token"    : "{{ csrf_token() }}",
                //                                 "agents"     : data.agent_datas,
                //                                 "leads"      : ids
                //                             },
                //                             success: function (data) {
                //                                 $.NotificationApp.send("Success","Leads assigned to agent.","top-center","green","success");
                //                                 setTimeout(function(){
                //                                 }, 3500);
                //                                 leadDataTable();
                //                             }, error: function (data) {
                //                                 $.NotificationApp.send("Error","Leads not assigned to agent.","top-center","red","error");
                //                             },
                //                         });
                //                     } else if ( result.dismiss === Swal.DismissReason.cancel ) {
                //                         swalWithBootstrapButtons.fire(
                //                             'Cancelled',
                //                             'Leads assign canceled.',
                //                             'error'
                //                         )
                //                     }
                //                 });
                //             }else{
                //                 $.NotificationApp.send("Error","Please select agent first !","top-center","red","error");
                //             }
                //             //console.log(len)
                //         }, error: function (data) {
                //             //console.log();
                //         },
                //     })

                // } 
                else {
                    $('#sms_ids').val(ids);
                    $('#SendSms').modal('show');
                }
            } else {
                $.NotificationApp.send("Error","Please select action first!","top-center","red","error");
            } 
        });//Assign Selected To Campaign
    </script>

@endsection