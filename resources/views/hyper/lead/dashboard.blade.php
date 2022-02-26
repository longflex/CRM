@extends('hyper.layout.master')
@section('title', "Leads Dashboard")
@section('content')
<div class="px-2">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box row">
                <h4 class="page-title col-lg-3">Leads Dashboard</h4>
                <div class="page-title-right col-lg-9">
                    <?php
                    $currentDate = date('m/d/Y');
                    $setDate1 = $currentDate;//date('m/d/Y', strtotime($currentDate.' - 1 day'));
                    $setDate2 = $currentDate;//date('m/d/Y', strtotime($currentDate.' + 1 day'));
                    $setDate= $setDate1.' - '.$setDate2;

                    ?>
                    @if (Laralum::hasPermission('laralum.lead.dashboard'))
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="input-group">
                                <input type="text" class="form-control date filter_by_Date" autocomplete="off" placeholder="-- Filter By Date Range --" title="-- Filter By Date Range --" name="filter_by_Date" value="" />
                                <div class="input-group-append">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <select class="select2" name="campaign" id="filter_by_campaign" data-toggle="select2" data-placeholder=" Select Campaign " title=" Select Campaign ">
                                <option value="0"> Select Campaign </option>
                                @if(!empty($campaigns))
                                @foreach ($campaigns as $campaign)
                                <option {{(session()->has('campaigns_selected_id') && (session()->get('campaigns_selected_id') == $campaign->id)) ? "selected" : ""}} value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                                @endforeach
                                @endif
                            </select>
                            <input type="checkbox" id="filter_by_campaign_enable" name="filter_by_campaign_enable" value="1"> Apply As Filter
                        </div>
                        @if (Laralum::hasPermission('laralum.admin.dashboard'))
                        <div class="col-lg-3">
                            <select class="select2" name="agent" id="filter_by_agent" data-toggle="select2" data-placeholder=" Select Agent " title=" Select Agent ">
                                <option value=""> Select Agent </option>
                                @if(!empty($campaigns))
                                @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        @else
                        <div class="col-lg-3" style="display: none;">
                            <select class="select2" name="agent" id="filter_by_agent" data-toggle="select2" data-placeholder=" Select Agent " title=" Select Agent ">
                                <option value=""> Select Agent </option>
                            </select>
                        </div>
                        @endif
                        <div class="col-lg-1">
                            <a class="float- right text-secondary" href="" data-toggle="tooltip" title="Reset Filters" data-placement="left"><i class="mdi mdi-refresh-circle font-24"></i></a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div data-simplebar style="height: 423px;">
                        <table class="table table-centered mb-0">
                            <thead>
                                <tr>
                                    <th>Call Status</th>
                                    <th>Total calls</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> Total Calls: </td>
                                    <td><a href="javascript:void(0);" class="btn btn-sm btn-light callLog_redirect"><span id="total_calls_count">0</span> </a></td>
                                </tr>

                                <tr>
                                    <td>Incomming Calls:</td>
                                    <td><a href="javascript:void(0);" class="btn btn-sm btn-light incomming_callLog_redirect"><span id="total_incoming_calls_count">0</span> </a></td>
                                </tr>
                                <tr>
                                    <td>Outgoing Calls:</td>
                                    <td><a href="javascript:void(0);" class="btn btn-sm btn-light outgoing_callLog_redirect"> <span id="total_outgoing_calls_count">0</span></a></td>
                                </tr>
                                <tr>
                                    <td>Both Answered: </td>
                                    <td><a href="javascript:void(0);" class="btn btn-sm btn-light both_answered_callLog_redirect"> <span id="both_answered_calls_count">0</span></a></td>
                                </tr>
                                <tr>
                                    <td>Agent UnAns:</td>
                                    <td><a href="javascript:void(0);" class="btn btn-sm btn-light agent_unans_callLog_redirect"> <span id="total_agentNotAnswered_calls_count">0</span></a></td>
                                </tr>
                                <tr>
                                    <td>Cust. Ans - Agent UnAns: </td>
                                    <td><a href="javascript:void(0);" class="btn btn-sm btn-light custAnsAgentUnAns_callLog_redirect"><span id="customer_answered_agent_not_answered_calls_count">0</span> </a></td>
                                </tr>
                                <tr>
                                    <td>Cust. UnAns - Agent Ans:</td>
                                    <td><a href="javascript:void(0);" class="btn btn-sm btn-light custUnAnsAgentAns_callLog_redirect"><span id="customer_not_answered_agent_answered_calls_count">0</span> </a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>                          
                </div>
            </div> 
            <!-- <div class="col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <h5 class="text-muted font-weight-normal mt-0 text-truncate" title="Campaign Sent">Calls Count</h5>
                                <h3 class="my-2 py-1" id="total_calls_count"></h3>
                            </div>
                            <div class="col-6">
                                <div class="text-right">
                                    <div id="campaign-sent-chart" data-colors="#727cf5"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div> 

            <div class="col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <h5 class="text-muted font-weight-normal mt-0 text-truncate" title="New Leads">Answered</h5>
                                <h3 class="my-2 py-1" id="total_answered_calls_count"></h3>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-right">
                                    <div id="new-leads-chart" data-colors="#0acf97"></div>
                                </div>
                            </div>
                        </div> 
                    </div> 
                </div> 
            </div> 

            <div class="col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <h5 class="text-muted font-weight-normal mt-0 text-truncate" title="Deals">Not Answered</h5>
                                <h3 class="my-2 py-1" id="total_not_answered_calls_count"></h3>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-right">
                                    <div id="deals-chart" data-colors="#727cf5"></div>
                                </div>
                            </div>
                        </div> 
                    </div> 
                </div> 
            </div>  -->
        </div>
        @if(Laralum::permissionToAccessModule() === true)
        <div class="col-lg-6">
        @else
        <div class="col-lg-9">
        @endif
            <div class="card">
                <div class="card-body">
                    <div data-simplebar style="height: 423px;">
                        <ul class="nav nav-tabs nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#available" id="available-tab" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                    <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Available (<span id="total_leads_count"></span>)</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#completed_leads" id="leads-tab" data-toggle="tab" aria-expanded="true" class="nav-link">
                                    <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Completed</span>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="#calls" id="calls-tab" data-toggle="tab" aria-expanded="false" class="nav-link">
                                    <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Call Logs</span>
                                </a>
                            </li> -->
                            <li class="nav-item">
                                <a href="#follow_up_leads" id="close-task" data-toggle="tab" aria-expanded="true" class="nav-link">
                                    <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Follow Up</span>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="#campaign_list" id="campaign-list" data-toggle="tab" aria-expanded="true" class="nav-link">
                                    <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Campaign</span>
                                </a>
                            </li> -->
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane tab_status active" id="available">
                                <div class="table-responsive">
                                    <table class="table w-100 dt-responsive nowrap" id="avilable-server-datatable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Campaign Status</th>
                                                <th>Lead Status</th>
                                                <!-- <th>Last Contacted</th> -->
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane tab_status" id="completed_leads">
                                <div class="table-responsive">
                                    <table class="table w-100 dt-responsive nowrap" id="server-datatable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Campaign Status</th>
                                                <th>Lead Status</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <!-- <div class="tab-pane tab_status" id="calls">
                                <div class="col-lg-12 table-responsive">
                                    <table class="table w-100 dt-responsive nowrap" id="manualCallLogTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Attended By</th>
                                                <th>Call Status</th>
                                                <th>Time</th>
                                                <th>Created Time</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div> -->
                            <div class="tab-pane tab_status" id="follow_up_leads">
                                <div class="table-responsive">
                                    <table class="table w-100 dt-responsive nowrap" id="follow-up-server-datatable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Campaign Status</th>
                                                <th>Lead Status</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <!-- <div class="tab-pane tab_status" id="campaign_list">
                                <div class="table-responsive">
                                    <table class="table w-100 dt-responsive nowrap" id="campaign-datatable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div> -->
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        @if(Laralum::permissionToAccessModule() === true) 
        <div class="col-lg-3">
            <div class="col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center my-2">
                            <div class="col-lg-6">
                                <h5 class="text-muted font-weight-normal mt-0 text-truncate" title="Campaign Sent">Prayer Request</h5>
                                <a class="btn btn-light prayer_request_redirect" href="javascript:void(0);"><span id="prayer_request_count"></span></a>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-right">
                                    <div id="campaign-sent-chart" data-colors="#727cf5"></div>
                                </div>
                            </div>
                        </div> 
                    </div> 
                </div> 
            </div> 

            <div class="col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center my-2">
                            <div class="col-lg-6">
                                <h5 class="text-muted font-weight-normal mt-0 text-truncate" title="New Leads">Donation</h5>
                                <a class="btn btn-light donations_redirect" href="javascript:void(0);"><span id="reminders_count"></span></a>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-right">
                                    <div id="new-leads-chart" data-colors="#0acf97"></div>
                                </div>
                            </div>
                        </div> 
                    </div> 
                </div> 
            </div> 

            <div class="col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center my-2">
                            <div class="col-lg-6">
                                <h5 class="text-muted font-weight-normal mt-0 text-truncate" title="Deals">Will Donate</h5>
                                <!-- <h3 class="my-2 py-1">0</h3> -->
                                <a class="btn btn-light will_donate_redirect" href="javascript:void(0);"><span id="will_donate_count"></span></a>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-right">
                                    <div id="deals-chart" data-colors="#727cf5"></div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div> 
            </div> 
        </div>
        @endif
    </div>

    <div class="row px-2">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-1"><h4 class="mt-0">Session</h4></div>
                        <div class="col-md-1">Active : <span class="mt-0" id="sessionActiveCount">0</span></div>
                        <div class="col-md-1">Inactive : <span class="mt-0" id="sessionInactiveCount">0</span></div>
                        <div class="col-md-3">
                            <select class="select2" id="filter_by_session_status" data-toggle="select2" data-placeholder=" Select Session Status " title=" Select Session Status ">
                                <option value=""> Select Session Status </option>
                                <option value="1"> Active </option>
                                <option value="0"> Inactive </option>
                            </select>  
                        </div>
                        <div class="col-md-3">
                            <select class="select2" id="filter_by_session_campaign" data-toggle="select2" data-placeholder=" Select Campaign " title=" Select Campaign ">
                                <option value=""> Select Campaign </option>
                                @if(!empty($campaigns))
                                @foreach ($campaigns as $campaign)
                                <option {{(session()->has('campaigns_selected_id') && (session()->get('campaigns_selected_id') == $campaign->id)) ? "selected" : ""}} value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="select2" id="filter_by_session_call_type" data-toggle="select2" data-placeholder=" Select Call Type " title=" Select Call Type ">
                                <option value=""> Select Call Type </option>
                                <option value="0"> Manual </option>
                                <option value="1"> Auto </option>
                            </select>  
                        </div>
                    </div>
                    <hr>
                    <div data-simplebar style="height: 435px;">
                        <table id="user-session-datatable" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <!-- <th>Campaign</th> -->
                                    <th>Session</th>

                                    <th>Total Calls</th>
                                     
                                    <th>Total Received</th>
                                    <th>Total Missed calls</th>
                                    <!-- <th>Live Call</th> -->
                                    <th>Total Call Duration</th>
                                    <th>Total Manual Dial</th>
                                    <th>Total Auto Dial</th>
                                    <th>Total Prayer Request</th>
                                    <th>Total Donations</th>
                                    <th>Total Will Donate</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table> 
                    </div>                           
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- <div class="dropdown float-right">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="javascript:void(0);" class="dropdown-item">Today</a>
                            <a href="javascript:void(0);" class="dropdown-item">Yesterday</a>
                            <a href="javascript:void(0);" class="dropdown-item">Last Week</a>
                            <a href="javascript:void(0);" class="dropdown-item">Last Month</a>
                        </div>
                    </div> -->

                    <div class="chart-content-bg">
                        <div class="row text-center">
                            <div class="col-md-6">
                                <p class="text-muted mb-0 mt-3">Total Hit Analysis</p>
                                <h4 class="header-title mb-3">Traffic</h4>
                            </div>
                        </div>
                    </div>

                    <div id="spline-area" class="apex-charts" data-colors="#727cf5,#6c757d"></div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Call Log Modal Start-->
<div id="callLogEditModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-top">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="callLogEditModalLabel">Call Log Edit</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="POST" enctype="multipart/form-data" id="editCallLogForm" action="javascript:void(0)">
                <input type="hidden" id="callLogEditId" name="callLogEditId" value=""/>
                <input type="hidden" id="callLogRadioValue" name="callLogRadioValue" value=""/>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="create_at">Call Status</label>
                                <select class="form-control select2" name="call_outcome" id="call_outcome"  data-toggle="select2" data-placeholder="Please select..">
                                    <option value="">Please select..</option>
                                    <option value="Answered">Answered</option>
                                    <option value="Not Answered">Not Answered</option>
                                    <option value="Switched Off">Switched Off</option>
                                    <option value="Not working">Not working</option>
                                    <option value="Wrong number">Wrong number</option>
                                    <option value="Call back">Call back</option>
                                    <option value="Not Reachable">Not Reachable</option>
                                    <option value="add">Add Value</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="create_at">Call Purpose</label>
                                <select class="form-control select2" name="call_purpose" id="call_purpose" multiple  data-toggle="select2" data-placeholder="Please select..">
                                    <option value="">Please select..</option>
                                    <option value="Add Donation">Add Donation</option>
                                    <option value="Add Prayer Request">Add Prayer Request</option>
                                    <option value="Will Donate">Will Donate</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="call_description" id="call_description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="submit" id="editclForm" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- <div class="modal fade" id="oppenRadioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Choose One</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="mt-3 mb-3 pl-3">
                <div class="custom-control custom-radio mb-2">
                    <input class="custom-control-input" type="radio" name="donationPrayer" id="donationRadio" onChange ="oppenModalDonationPrayer(this)">
                    <label  class="custom-control-label" for="donationRadio">
                    Add Donation
                    </label>                            
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" name="donationPrayer" id="prayerRadio" value="prayer" onChange ="oppenModalDonationPrayer()">
                    <label  class="custom-control-label" for="prayerRadio">
                        Add Payer Request
                    </label>
                </div>
            </div>
        </div>
    </div>
  </div>
</div> -->
<!--Add Donation -->
<div id="AddDonation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="adddanationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="adddanationModalLabel">Add Donation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            <form id="upload_donation_form" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="lead_id" name="lead_id" value="" />
                        <input type="hidden" id="search_check" name="search_check" value="0">
                        @csrf
                        <div class="lead_data" style="display:none;">
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Donation Type *</label>
                                    <select id="member_type_id" name="donation_type" class="form-control select2" data-toggle="select2" data-placeholder="Please select..">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Donation Purpose</label>
                                    <select id="donation_purpose" name="donation_purpose" class="form-control select2" data-toggle="select2" data-placeholder="Please select..">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>When Will Donate</label>
                                    <select id="donation_decision" name="donation_decision" class="form-control select2" onchange="decisionChange(this)" data-toggle="select2" data-placeholder="Please select..">
                                        <option value="">Please select..</option>
                                        <option value="0" {{ (old('donation_decision') == 0 ? 'selected': '') }}>Now</option>
                                        <option value="1" {{ (old('donation_decision') == 1 ? 'selected': '') }}>Will Donate</option>
                                        <option value="2" {{ (old('donation_decision') == '2' ? 'selected': '') }}>Already Donate</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4" id="will_donate_type_div" style="display: none;">
                            <div class="form-group">
                                <label>Willing To Donate</label>
                                <select id="donation_decision_type" name="donation_decision_type" class="form-control select2" data-toggle="select2" data-placeholder="Please select..">
                                    <option value="">Please select..</option>
                                    <option value="As soon As Possible" {{ (old('donation_decision') == 'As soon As Possible' ? 'selected': '') }}>
                                        As soon As Possible</option>
                                    <option value="This Week" {{ (old('donation_decision') == 'This Week' ? 'selected': '') }}>This Week</option>
                                    <option value="This Year" {{ (old('donation_decision') == 'This Year' ? 'selected': '') }}>This Year</option>
                                    <option value="Next Year" {{ (old('donation_decision') == 'Next Year' ? 'selected': '') }}>Next Year</option>
                                    <option value="online" {{ (old('donation_decision') == "online" ? 'selected': '') }}>online</option>
                                    <option value="Jan" {{ (old('donation_decision') == "Jan" ? 'selected': '') }}>Jan</option>
                                    <option value="Feb" {{ (old('donation_decision') == "Feb" ? 'selected': '') }}>Feb</option>
                                    <option value="Mar" {{ (old('donation_decision') == "Mar" ? 'selected': '') }}>Mar</option>
                                    <option value="Apr" {{ (old('donation_decision') == "Apr" ? 'selected': '') }}>Apr</option>
                                    <option value="May" {{ (old('donation_decision') == "May" ? 'selected': '') }}>May</option>
                                    <option value="Jun" {{ (old('donation_decision') == "Jun" ? 'selected': '') }}>Jun</option>
                                    <option value="July" {{ (old('donation_decision') == "July" ? 'selected': '') }}>July</option>
                                    <option value="Aug" {{ (old('donation_decision') == "Aug" ? 'selected': '') }}>Aug</option>
                                    <option value="Sep" {{ (old('donation_decision') == "Sep" ? 'selected': '') }}>Sep</option>
                                    <option value="Oct" {{ (old('donation_decision') == "Oct" ? 'selected': '') }}>Oct</option>
                                    <option value="Nov" {{ (old('donation_decision') == "Nov" ? 'selected': '') }}>Nov</option>
                                    <option value="Dec" {{ (old('donation_decision') == "Dec" ? 'selected': '') }}>Dec</option>
                                </select>
                            </div>
                        </div>


                            <div class="col-lg-4" id="donation_date_div" style="display: none;">
                                <div class="form-group">
                                    <label for="donation_date">Donation Date</label>
                                    <input type="text" readonly class="form-control" id="donation_date" name="donation_date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Payment Type</label>
                                    <select id="payment_type" name="payment_type" class="form-control select2" onchange="stateChange(this)" data-toggle="select2" data-placeholder="Please select..">
                                        <option value="">Please select..</option>
                                        <option value="single" {{ (old('payment_type') == 'single' ? 'selected': '') }}>
                                            Single</option>
                                        <option value="recurring" {{ (old('payment_type') == 'recurring' ? 'selected': '') }}>Recurring</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Payment Mode</label>
                                    <select id="payment_mode" name="payment_mode" class="form-control select2" data-toggle="select2" data-placeholder="Please select..">
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
                            <div class="col-md-4 payment-status" style="display: none">
                                <div class="form-group">
                                    <label>Payment Status</label>
                                    <select id="payment_status" name="payment_status" class="form-control select2" data-toggle="select2" data-placeholder="Please select..">
                                        <option value="">Please select..</option>
                                        <option value="0">Not Paid</option>
                                        <option value="1">Paid</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label>Location</label>
                                    <select class="form-control select2" name="location" id="location" data-toggle="select2" data-placeholder="Please select..">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Amount *</label>
                                    <input type="text" class="form-control" id="amount" placeholder="Please enter the amount" name="amount" />
                                </div>
                            </div>
                            <div class="col-md-4 period" style="display: none">
                                <div class="form-group">
                                    <label>Payment Period</label>
                                    <select id="payment_period" name="payment_period" class="form-control select2">
                                        <option value="">Please select..</option>
                                        <option value="daily">daily</option>
                                        <option value="weekly">weekly</option>
                                        <option value="monthly">monthly</option>
                                        <option value="yearly">yearly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 start" style="display: none">
                                <div class="form-group">
                                    <label>Payment Start Date</label>
                                    <input type="text" class="form-control" readonly id="start_date" name="payment_start_date" value="{{old('start_date')}}" />
                                </div>
                            </div>
                            <div class="col-md-4 end" style="display: none">
                                <div class="form-group">
                                    <label>Payment End Date</label>
                                    <input type="text" class="form-control" readonly id="end_date" name="payment_end_date" value="{{old('end_date')}}" />
                                </div>
                            </div>
                            <div class="col-md-4" id="reference_no_field" style="display:none">
                                <div class="form-group">
                                    <label>Reference No. *</label>
                                    <input type="text" class="form-control" id="reference_no" name="reference_no" placeholder="Please enter the reference no" />
                                </div>
                            </div>
                            <div class="col-md-4" id="bank_name_field" style="display:none">
                                <div class="form-group">
                                    <label>Bank *</label>
                                    <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Please enter the bank name" />
                                </div>
                            </div>
                            <div class="col-md-4" id="cheque_number_field" style="display:none">
                                <div class="form-group">
                                    <label>Cheque Number *</label>
                                    <input type="text" class="form-control" id="cheque_number" name="cheque_number" placeholder="Please enter the check no." />
                                </div>
                            </div>
                            <div class="col-md-4" id="branch_name_field" style="display:none">
                                <div class="form-group">
                                    <label>Branch *</label>
                                    <input type="text" class="form-control" id="branch_name" name="branch_name" placeholder="Please enter the branch name" />
                                </div>
                            </div>
                            <div class="col-md-4" id="cheque_date_field" style="display:none">
                                <div class="form-group">
                                    <label>Cheque Issue Date</label>
                                    <input type="text" class="form-control" readonly id="cheque_date" name="cheque_date" placeholder="Please select the cheque issue date" />
                                </div>
                            </div>
                            <div class="col-md-4" id="payment_method_field" style="display:none">
                                <div class="form-group">
                                    <label>Payment Method</label>
                                    <input type="text" class="form-control" id="payment_method" name="payment_method" placeholder="Please enter the method name" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Gift Issued</label>
                                    <select id="gift_issued" name="gift_issued" class="form-control select2">
                                        <option value="">Please select..</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <button type="submit" id="save_admin_donation" class="btn btn-success btn-sm" onClick="donationPurposeSelected()">SAVE</button>
                        <div class="history_data" style="display:none;">
                        </div>
                    </form>
                </div>
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
                                <input type="text" readonly class="form-control" value="" id="follow_up_date" name="follow_up_date">
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
                                    <option value="add">Add Value</option>
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
<!-- Add Details Modal -->
<div id="AddDetails" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addDetailsModalLabel">Add Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="POST" enctype="multipart/form-data" id="add_detail" action="javascript:void(0)">@csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Add Detail</label>
                        <input type="text" name="detail" id="detail" class="form-control" />
                        <input type="hidden" name="type" id="detail_type" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="editMemberForm" class="btn btn-success btn-sm"><span id="hidebutext">Add</span>&nbsp;<span class="editMemberForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('extrascripts')
<script>
$(function() {
    $("#payment_mode").change(function() {
        if ($(this).val() == "CHEQUE") {
            $("#cheque_date_field").show();
            $("#bank_name_field").show();
            $("#cheque_number_field").show();
            $("#branch_name_field").show();
            $(".payment-status").show();
            $("#reference_no_field").hide();
            $("#payment_method_field").hide();
        } else if ($(this).val() == "OTHER") {
            $("#payment_method_field").show();
            $(".payment-status").show();
            $("#cheque_date_field").hide();
            $("#bank_name_field").hide();
            $("#cheque_number_field").hide();
            $("#branch_name_field").hide();
            $("#reference_no_field").hide();
        } else if ($(this).val() == "QRCODE") {
            $("#reference_no_field").show();
            $(".payment-status").show();
            $("#cheque_date_field").hide();
            $("#bank_name_field").hide();
            $("#cheque_number_field").hide();
            $("#branch_name_field").hide();
            $("#payment_method_field").hide();
        } else if ($(this).val() == "CASH") {
            $(".payment-status").show();
            $("#cheque_date_field").hide();
            $("#bank_name_field").hide();
            $("#cheque_number_field").hide();
            $("#branch_name_field").hide();
            $("#reference_no_field").hide();
            $("#payment_method_field").hide();
        } else if ($(this).val() == "CARD") {
            $(".payment-status").show();
            $("#cheque_date_field").hide();
            $("#bank_name_field").hide();
            $("#cheque_number_field").hide();
            $("#branch_name_field").hide();
            $("#reference_no_field").hide();
            $("#payment_method_field").hide();
        } else {
            $("#cheque_date_field").hide();
            $("#bank_name_field").hide();
            $("#cheque_number_field").hide();
            $("#branch_name_field").hide();
            $("#payment_method_field").hide();
            $("#reference_no_field").hide();
            $(".payment-status").hide();
        }
    });

});    
function decisionChange(object) {
    var value = object.value;
    if (value == 0) {
        $('#donation_date_div').hide();
        $('#will_donate_type_div').hide();
    }
    else if (value == 2){
        $('#donation_date_div').hide();
        $('#will_donate_type_div').hide();
    }
     else {
        $('#donation_date_div').show();
        $('#will_donate_type_div').show();
    }
}    
   
$("#editCallLogForm").submit(function(event){
    event.preventDefault();
    $( ".btn" ).prop( "disabled", true );
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
    var edit_id=$('#callLogEditId').val();
    if(edit_id == ""){
        $.NotificationApp.send("Error",'Call log data is not available.',"top-center","red","error");
        $('#callLogEditModal').modal('hide');
        $( ".btn" ).prop( "disabled", false ); 
        return;
    }
    var formData=new FormData(this);
    console.log('formdata='+JSON.stringify(formData));
    $.ajax({
        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
        url:  "{{route('Crm::callLogUpdate')}}",
        data:formData ,
        dataType: 'json', // what type of data do we expect back from the server
        processData: false,
        contentType: false,
        dataType: 'json',
    })
    // using the done promise callback
    .done(function(data) {
        
        if(data.status==false){
            $.NotificationApp.send("Error",data.message,"top-center","red","error");
            setTimeout(function(){
                //location.reload();
            }, 3500);
            //callLogsDataTable();
            $('#callLogEditModal').modal('hide'); 
        }

        if(data.status==true){
            $( ".btn" ).prop( "disabled", false );
            $('#callLogEditModal').modal('hide'); 
            $.NotificationApp.send("Success",data.message,"top-center","green","success");
            setTimeout(function(){
                //location.reload();
                
            }, 3500);
            $( ".btn" ).prop( "disabled", false );
            var radioValue=$('#callLogRadioValue').val();
            var call_purpose=$('#call_purpose').val();
            if ('Add Donation' == call_purpose){
                addDonationModal(radioValue);
            }else if('Will Donate' == call_purpose){
                addDonationModal(radioValue);
            }else if('Add Prayer Request' == call_purpose){
                addPrayerRequestModal(radioValue);
            }
        }
        $( ".btn" ).prop( "disabled", false );
    })
    // using the fail promise callback
    .fail(function(data) {
        $.NotificationApp.send("Error",data.message,"top-center","red","error");
        setTimeout(function(){
            //location.reload();
        }, 3500);
        $( ".btn" ).prop( "disabled", false );
        //prayerReqDatatable();
    });

});


</script>
<script>

$(function() {
  $('input[name="donation_date"]').daterangepicker({
    singleDatePicker: true,
    autoUpdateInput: false,
    autoApply: false,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  });
  $('input[name="donation_date"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));

    });
});


    function manualsinglecall(mobile) {
        $('#Showcall').css("display", "block");
        $('#Dialer').css("display", "none");
        $('#CALLEND').addClass('btn-danger');
        $('#CALLEND').data("id", "end");
        $('#CALLING').css("display", "none");
        $('#CALLING').html('<i class="uil-dialpad-alt"></i>');
        $('#CALLING').attr("data-original-title", "Manual Calling");
        $('#CALLEND').attr("data-original-title", "End Call");
        $('#CALLEND').html('<i class="uil-phone-slash"></i>');
        $('#dialnum').val('');
        $('#dialbox-popup').data("id", "close");
        $('#dialbox-popup').attr("data-original-title", "Minimize Dialer");
        $("#DIS").slideToggle("slow", "linear");
        $.ajax({
            url: "{{ route('Crm::leads_load_api') }}",
            type: "GET",
            data: { mobile: mobile },
            success: function(arr_response) {
                console.log(arr_response);
                console.log(mobile);
                $('#Dailing').html(mobile);
                $('#DISMSG').html(arr_response.msg_text);
                if (arr_response.msg === 'success') {
                    $('#DISMSG').css("color", "green");
                }
                if (arr_response.msg === 'error') {
                    $('#DISMSG').css("color", "red");
                }
            },
            error: function(arr_response) {
                $.NotificationApp.send("Error", "Calling API Failed !", "top-center", "red", "error");
            }
        });
    }

    function oppenRadioEditPurpose(){
        $('#member_type_id').val(null).trigger('change');
        $('#donation_purpose').val(null).trigger('change');
        $('#donation_decision').val(null).trigger('change');
        $('#donation_decision_type').val(null).trigger('change');
        $('#payment_mode').val(null).trigger('change');
        $('#payment_status').val(null).trigger('change');
        $('#location').val(null).trigger('change');
        $('#gift_issued').val(null).trigger('change');
        $('#payment_type').val(null).trigger('change');
        $('#payment_period').val(null).trigger('change');
        $('#donation_date').val('');
        $('#amount').val('');
        $('#start_date').val('');
        $('#end_date').val('');
        $('#reference_no').val('');
        $('#bank_name').val('');
        $('#cheque_number').val('');
        $('#branch_name').val('');
        $('#cheque_date').val('');
        $('#payment_method').val('');
        
        $('#oppenRadioModal').modal('show');
    }
    function oppenRadioModal(id,mobile)
    {
        $('#callLogEditModal').modal({
            backdrop: 'static',
            keyboard: false
        });

        $('#callLogRadioValue').val(id);
        $('#call_outcome').val(null).trigger('change');
        $('#call_purpose').val(null).trigger('change');
        $('#call_description').val('');


        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        $.ajax({
                type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url:  "{{route('Crm::call_log_edit_radio')}}",
                data:{mobile:mobile} ,
                dataType: 'json', // what type of data do we expect back from the server
                encode: true
            })
            // using the done promise callback
            .done(function(data) {
                $('#callLogEditId').val('');
                if(data.status==true){
                    $('.optn').removeAttr('selected');
                    $('#call_outcome').val(data.logData.call_outcome);
                    $('#call_outcome').trigger('change');
                    $('#call_purpose').val(data.logData.call_purpose);
                    //$('#edit_issue').val(data.message.issue); // Select the option with a value of '1'
                    $('#call_purpose').trigger('change'); // Notify any JS components that the value changed
                    $('#call_description').val(data.logData.description);
                    
                    $('#callLogEditId').val(data.logData.id);
                }
                $('#callLogEditModal').modal('show');               
                })
                
            // using the fail promise callback
            .fail(function(data) {
                console.log(data);
            });
    }

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
    function userSessionDataTable() {
        $('#user-session-datatable').DataTable().destroy();
        let table = $('#user-session-datatable');
        //dashbordCountData(call_status);
        table.DataTable(
            {
                order: [['0', 'DESC']],
                serverSide: true,
                responsive: true,
                processing: true,
                ajax: {
                url: "{{ route('Crm::get_userSession_data') }}",
                type: 'POST',
                data: function (d) {
                        d._token = '{{ csrf_token() }}';
                        d.filter_by_session_campaign = $('#filter_by_session_campaign').val();
                        d.filter_by_session_call_type = $('#filter_by_session_call_type').val();
                        d.filter_by_session_status = $('#filter_by_session_status').val();
                    },
                },
                columns: [
                    {"data": "name", name: 'u.name'},
                    {"data": "mobile", name: 'u.mobile'},
                    //{"data": "campaign", name: 'campaigns.name'},
                    {"data": "session"},

                    {"data": "total_calls"},
                    {"data": "total_recieved"},
                    {"data": "total_missed_call"},
                    {"data": "tatal_call_duration"},
                    {"data": "total_manual_dial"},
                    {"data": "total_auto_dial"},
                    {"data": "total_prayer_request"},
                    {"data": "total_donations"},
                    {"data": "total_will_donate"}
                ]
            }
        );
    }
    function activeInactiveSessionCount(){
        $.ajax({
                type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
                url:  "{{route('Crm::active_inctive_session_count')}}",
                data: null,
                dataType: 'json', // what type of data do we expect back from the server
                encode: true
            })
            // using the done promise callback
            .done(function(data) {
                // alert(); inactiveCount active
                // alert(data.active);
                $('#sessionActiveCount').text(data.active);
                $('#sessionInactiveCount').text(data.inactiveCount);
                           
            })
                
            // using the fail promise callback
            .fail(function(data) {
                console.log(data);
            });
    }
    function followUpServerDataTable() {
        $('#follow-up-server-datatable').DataTable().destroy();
        let table = $('#follow-up-server-datatable');
        let call_status = '3';
        //dashbordCountData(call_status);
        table.DataTable(
            {
                order: [['5', 'DESC']],
                serverSide: true,
                responsive: true,
                processing: true,
                ajax: {
                url: "{{ route('Crm::get_leads_data') }}",
                type: 'POST',
                data: function (d) {
                        d._token = '{{ csrf_token() }}';
                        d.filter_by_campaign = $('#filter_by_campaign').val();
                        d.filter_by_agent = $('#filter_by_agent').val();
                        d.filter_by_Date = $('.filter_by_Date').val();
                        d.filter_by_call_status = call_status;
                    },
                },
                columns: [
                    {"data": "id", name: 'leads.id'},
                    {"data": "name", name: 'leads.name'},
                    {"data": "mobile", name: 'leads.mobile'},
                    {"data": "call_status", name: 'manual_logged_call.call_status'},
                    {"data": "lead_status", name: 'leads.lead_status'},
                    {"data": "updated_at", name: 'manual_logged_call.updated_at'},
                    {"data": "action", sortable: false, searchable : false},
                ]
            }
        );
    }
    function avilableServerDataTable() {
        // $.ajax({
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
        $('#avilable-server-datatable').DataTable().destroy();
        let table = $('#avilable-server-datatable');
        let call_status = '1';
        //dashbordCountData(call_status);
        table.DataTable(
            {
                order: [['0', 'DESC']],
                serverSide: true,
                responsive: true,
                processing: true,
                ajax: {
                url: "{{ route('Crm::get_leads_data') }}",
                type: 'POST',
                data: function (d) {
                        d._token = '{{ csrf_token() }}';
                        d.filter_by_campaign = $('#filter_by_campaign').val();
                        d.filter_by_agent = $('#filter_by_agent').val();
                        d.filter_by_Date = $('.filter_by_Date').val();
                        d.filter_by_call_status = call_status;
                    },
                },
                columns: [
                    {"data": "id", name: 'leads.id'},
                    {"data": "name", name: 'leads.name'},
                    {"data": "mobile", name: 'leads.mobile'},
                    {"data": "call_status", name: 'manual_logged_call.call_status'},
                    {"data": "lead_status", name: 'leads.lead_status'},
                    // {"data": "last_contacted_date", name: 'leads.last_contacted_date'},
                    {"data": "action", sortable: false, searchable : false},
                ]
            }
        );
    }
    function serverDataTable() {
        $('#server-datatable').DataTable().destroy();
        let table = $('#server-datatable');
        let call_status = '2';
        //dashbordCountData(call_status);
        table.DataTable(
            {
                order: [['5', 'DESC']],
                serverSide: true,
                responsive: true,
                processing: true,
                ajax: {
                url: "{{ route('Crm::get_leads_data') }}",
                type: 'POST',
                data: function (d) {
                        d._token = '{{ csrf_token() }}';
                        d.filter_by_campaign = $('#filter_by_campaign').val();
                        d.filter_by_agent = $('#filter_by_agent').val();
                        d.filter_by_Date = $('.filter_by_Date').val();
                        d.filter_by_call_status = call_status;
                    },
                },
                columns: [
                    {"data": "id", name: 'leads.id'},
                    {"data": "name", name: 'leads.name'},
                    {"data": "mobile", name: 'leads.mobile'},
                    {"data": "call_status", name: 'manual_logged_call.call_status'},
                    {"data": "lead_status", name: 'leads.lead_status'},
                    {"data": "updated_at", name: 'manual_logged_call.updated_at'},
                    {"data": "action", sortable: false, searchable : false},
                ]
            }
        );
    }
    function dashbordCountData(call_status){
        var filter_by_campaign = $('#filter_by_campaign').val();
        if ($('#filter_by_campaign_enable').is(":checked")){
            var filter_by_campaign_enable = $('#filter_by_campaign_enable').val();
        }else{
            var filter_by_campaign_enable = null;
        }
        var filter_by_agent = $('#filter_by_agent').val();
        var filter_by_Date = $('.filter_by_Date').val();
        $.ajax({
            type: 'GET', 
            url:  "{{ route('Crm::dashbordCountData') }}",
            data: {
                _token : "{{ csrf_token() }}",
                filter_by_campaign : filter_by_campaign,
                filter_by_campaign_enable : filter_by_campaign_enable,
                filter_by_agent : filter_by_agent,
                filter_by_Date : filter_by_Date,
                filter_by_call_status: call_status
            },
            success: function(data) {
                $('#prayer_request_count').html(data.prayer_request_count); 
                $('#reminders_count').html(data.reminders_count); 
                $('#total_leads_count').html(data.total_leads_count); 
                $('#total_calls_count').html(data.total_calls_count); 
                // $('#total_answered_calls_count').html(data.total_answered_calls_count); 
                // $('#total_not_answered_calls_count').html(data.total_not_answered_calls_count); 
                $('#both_answered_calls_count').html(data.total_bothAnswered_calls_count); 
                $('#customer_not_answered_agent_answered_calls_count').html(data.total_custNotAnswered_calls_count);
                $('#will_donate_count').html(data.will_donate_count);
                $('#total_incoming_calls_count').html(data.total_incoming_calls_count);
                $('#total_outgoing_calls_count').html(data.total_outgoing_calls_count);
                $('#total_agentNotAnswered_calls_count').html(data.total_agentNotAnswered_calls_count);
                $('#customer_answered_agent_not_answered_calls_count').html(data.customer_answered_agent_not_answered_calls_count);
                
            },
            error: function(data) {
            }
        })
    }
    //href="{{route('Crm::leads.call.log.reports')}}" callLog_redirect
    

    $('#filter_by_campaign_enable').click(function(e) {
        setCallLogParams();
        setPrayerRequestParams();
        setDonationsParams();
        setWillDonateParams();
        setIncommingCallLogParams();
        setOutgoingCallLogParams();
        setBothAnsCallLogParams();
        setCustUnAnsAgentAnsCallLogParams();
        setCustAnsAgentUnAnsCallLogParams();
        setAgentUnAnsCallLogParams();
    });
//incomming_callLog_redirect  both_answered_callLog_redirect agent_unans_callLog_redirect custAnsAgentUnAns_callLog_redirect custUnAnsAgentAns_callLog_redirect
    function setCustUnAnsAgentAnsCallLogParams(){
        var filter_by_campaign = $('#filter_by_campaign').val();
        var filter_by_agent = "";
        filter_by_agent = $('#filter_by_agent').val();
        var filter_by_Date = $('.filter_by_Date').val();
        var callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?purpose=0";
        var dateString1 =  "";
        var dateString2 =  "";
        if(filter_by_Date != ""){
            var dateString =  filter_by_Date.split(" - ");
            dateString1 =  dateString[0];
            dateString2 =  dateString[1]; 
        }
        var setDate1 = "<?=$setDate1?>";
        var setDate2 = "<?=$setDate2?>";
        if ($('#filter_by_campaign_enable').is(":checked")){
            if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=6";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=6";
            }else if(filter_by_campaign == "" && filter_by_agent == "" && filter_by_Date != ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=6";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date == ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=6";
            }else if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=6";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=6";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=6";
            }
        }else{
            if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=6";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=6";
            }else if(filter_by_campaign == "" && filter_by_agent == "" && filter_by_Date != ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=6";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date == ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=6";
            }else if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=6";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=6";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=6";
            }
        }
        
        $("a.custUnAnsAgentAns_callLog_redirect").attr("href", callLog_url);
    }

    function setCustAnsAgentUnAnsCallLogParams(){
        var filter_by_campaign = $('#filter_by_campaign').val();
        var filter_by_agent = "";
        filter_by_agent = $('#filter_by_agent').val();
        var filter_by_Date = $('.filter_by_Date').val();
        var callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?purpose=0";
        var dateString1 =  "";
        var dateString2 =  "";
        if(filter_by_Date != ""){
            var dateString =  filter_by_Date.split(" - ");
            dateString1 =  dateString[0];
            dateString2 =  dateString[1]; 
        }
        var setDate1 = "<?=$setDate1?>";
        var setDate2 = "<?=$setDate2?>";
        if ($('#filter_by_campaign_enable').is(":checked")){
            if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=4";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=4";
            }else if(filter_by_campaign == "" && filter_by_agent == "" && filter_by_Date != ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=4";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date == ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=4";
            }else if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=4";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=4";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=4";
            }
        }else{
            if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=4";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=4";
            }else if(filter_by_campaign == "" && filter_by_agent == "" && filter_by_Date != ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=4";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date == ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=4";
            }else if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=4";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=4";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=4";
            }
        }
        
        $("a.custAnsAgentUnAns_callLog_redirect").attr("href", callLog_url);
    }
    function setAgentUnAnsCallLogParams(){
        var filter_by_campaign = $('#filter_by_campaign').val();
        var filter_by_agent = "";
        filter_by_agent = $('#filter_by_agent').val();
        var filter_by_Date = $('.filter_by_Date').val();
        var callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?purpose=0";
        var dateString1 =  "";
        var dateString2 =  "";
        if(filter_by_Date != ""){
            var dateString =  filter_by_Date.split(" - ");
            dateString1 =  dateString[0];
            dateString2 =  dateString[1]; 
        }
        var setDate1 = "<?=$setDate1?>";
        var setDate2 = "<?=$setDate2?>";
        if ($('#filter_by_campaign_enable').is(":checked")){
            if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=7";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=7";
            }else if(filter_by_campaign == "" && filter_by_agent == "" && filter_by_Date != ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=7";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date == ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=7";
            }else if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=7";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=7";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=7";
            }
        }else{
            if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=7";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=7";
            }else if(filter_by_campaign == "" && filter_by_agent == "" && filter_by_Date != ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=7";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date == ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=7";
            }else if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=7";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=7";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=7";
            }
        }
        
        $("a.agent_unans_callLog_redirect").attr("href", callLog_url);
    }
    function setBothAnsCallLogParams(){
        var filter_by_campaign = $('#filter_by_campaign').val();
        var filter_by_agent = "";
        filter_by_agent = $('#filter_by_agent').val();
        var filter_by_Date = $('.filter_by_Date').val();
        var callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?purpose=0";
        var dateString1 =  "";
        var dateString2 =  "";
        if(filter_by_Date != ""){
            var dateString =  filter_by_Date.split(" - ");
            dateString1 =  dateString[0];
            dateString2 =  dateString[1]; 
        }
        var setDate1 = "<?=$setDate1?>";
        var setDate2 = "<?=$setDate2?>";
        if ($('#filter_by_campaign_enable').is(":checked")){
            if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=3";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=3";
            }else if(filter_by_campaign == "" && filter_by_agent == "" && filter_by_Date != ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=3";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date == ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=3";
            }else if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=3";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=3";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=3";
            }
        }else{
            if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=3";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=3";
            }else if(filter_by_campaign == "" && filter_by_agent == "" && filter_by_Date != ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=3";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date == ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&outcome=3";
            }else if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=3";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=3";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&outcome=3";
            }
        }
        
        $("a.both_answered_callLog_redirect").attr("href", callLog_url);
    }

    function setOutgoingCallLogParams(){
        var filter_by_campaign = $('#filter_by_campaign').val();
        var filter_by_agent = "";
        filter_by_agent = $('#filter_by_agent').val();
        var filter_by_Date = $('.filter_by_Date').val();
        var callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?purpose=0";
        var dateString1 =  "";
        var dateString2 =  "";
        if(filter_by_Date != ""){
            var dateString =  filter_by_Date.split(" - ");
            dateString1 =  dateString[0];
            dateString2 =  dateString[1]; 
        }
        var setDate1 = "<?=$setDate1?>";
        var setDate2 = "<?=$setDate2?>";
        if ($('#filter_by_campaign_enable').is(":checked")){
            if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&type=0";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&type=0";
            }else if(filter_by_campaign == "" && filter_by_agent == "" && filter_by_Date != ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&type=0";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date == ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&type=0";
            }else if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&type=0";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&type=0";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&type=0";
            }
        }else{
            if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&type=0";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&type=0";
            }else if(filter_by_campaign == "" && filter_by_agent == "" && filter_by_Date != ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&type=0";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date == ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&type=0";
            }else if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&type=0";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&type=0";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&type=0";
            }
        }
        
        $("a.outgoing_callLog_redirect").attr("href", callLog_url);
    }


    function setIncommingCallLogParams(){
        var filter_by_campaign = $('#filter_by_campaign').val();
        var filter_by_agent = "";
        filter_by_agent = $('#filter_by_agent').val();
        var filter_by_Date = $('.filter_by_Date').val();
        var callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?purpose=0";
        var dateString1 =  "";
        var dateString2 =  "";
        if(filter_by_Date != ""){
            var dateString =  filter_by_Date.split(" - ");
            dateString1 =  dateString[0];
            dateString2 =  dateString[1]; 
        }
        var setDate1 = "<?=$setDate1?>";
        var setDate2 = "<?=$setDate2?>";
        if ($('#filter_by_campaign_enable').is(":checked")){
            if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&type=1";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&type=1";
            }else if(filter_by_campaign == "" && filter_by_agent == "" && filter_by_Date != ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&type=1";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date == ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&type=1";
            }else if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&type=1";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&type=1";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&type=1";
            }
        }else{
            if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&type=1";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&type=1";
            }else if(filter_by_campaign == "" && filter_by_agent == "" && filter_by_Date != ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&type=1";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date == ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0&type=1";
            }else if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&type=1";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&type=1";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0&type=1";
            }
        }
        
        $("a.incomming_callLog_redirect").attr("href", callLog_url);
    }

    function setCallLogParams(){
        var filter_by_campaign = $('#filter_by_campaign').val();
        var filter_by_agent = "";
        filter_by_agent = $('#filter_by_agent').val();
        var filter_by_Date = $('.filter_by_Date').val();
        var callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?purpose=0";
        var dateString1 =  "";
        var dateString2 =  "";
        if(filter_by_Date != ""){
            var dateString =  filter_by_Date.split(" - ");
            dateString1 =  dateString[0];
            dateString2 =  dateString[1]; 
        }
        //alert(dateString1);
        //alert(filter_by_Date);
        var setDate1 = "<?=$setDate1?>";
        var setDate2 = "<?=$setDate2?>";
        if ($('#filter_by_campaign_enable').is(":checked")){
            if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0";
            }else if(filter_by_campaign == "" && filter_by_agent == "" && filter_by_Date != ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=0";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date == ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0";
            }else if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0";
            }
        }else{
            if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+setDate1+"&enddate="+setDate2+"&purpose=0";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date == ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0";
            }else if(filter_by_campaign == "" && filter_by_agent == "" && filter_by_Date != ""){
                callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=0";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date == ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=0";
            }else if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=0";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date != ""){
               callLog_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=0";
            }
        }
        
        $("a.callLog_redirect").attr("href", callLog_url);
    }

    //prayer_request_redirect
    //purpose no acc.to dashbord view
    function setPrayerRequestParams(){
        var prayer_request_url = "{{ route('Crm::leads.call.log.reports') }}"+"?purpose=1";
        var filter_by_campaign = $('#filter_by_campaign').val();
        var filter_by_agent = "";//setDate1
        filter_by_agent = $('#filter_by_agent').val();
        var filter_by_Date = $('.filter_by_Date').val();
        var dateString1 =  "";
        var dateString2 =  "";
        if(filter_by_Date != ""){
            var dateString =  filter_by_Date.split(" - ");
            dateString1 =  dateString[0];
            dateString2 =  dateString[1]; 
        } 
        //alert(filter_by_agent);
        //alert(filter_by_Date);
        var setDate1 = "<?=$setDate1?>";
        var setDate2 = "<?=$setDate2?>";
        if ($('#filter_by_campaign_enable').is(":checked")){
           if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date == ""){
                prayer_request_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=1";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date == ""){
                prayer_request_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=1";
            }else if(filter_by_campaign == "" && filter_by_agent == "" && filter_by_Date != ""){
                prayer_request_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=1";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date == ""){
               prayer_request_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=1";
            }else if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date != ""){
               prayer_request_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=1";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date != ""){
               prayer_request_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=1";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date != ""){
               prayer_request_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=1";
            } 
        }else{
            if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date == ""){
                prayer_request_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+setDate1+"&enddate="+setDate2+"&purpose=1";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date == ""){
                prayer_request_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=1";
            }else if(filter_by_campaign == "" && filter_by_agent == "" && filter_by_Date != ""){
                prayer_request_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=1";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date == ""){
               prayer_request_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=1";
            }else if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date != ""){
               prayer_request_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=1";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date != ""){
               prayer_request_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=1";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date != ""){
               prayer_request_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=1";
            }
        }

        
        $("a.prayer_request_redirect").attr("href", prayer_request_url);
    }

    function setDonationsParams(){
        var filter_by_campaign = $('#filter_by_campaign').val();
        var filter_by_agent = "";
        filter_by_agent = $('#filter_by_agent').val();
        var filter_by_Date = $('.filter_by_Date').val();
        var donations_url = "{{ route('Crm::leads.call.log.reports') }}"+"?purpose=2";
        var dateString1 =  "";
        var dateString2 =  "";
        if(filter_by_Date != ""){
            var dateString =  filter_by_Date.split(" - ");
            dateString1 =  dateString[0];
            dateString2 =  dateString[1]; 
        }
        //alert(dateString1);
        //alert(filter_by_Date);
        var setDate1 = "<?=$setDate1?>";
        var setDate2 = "<?=$setDate2?>";
        if ($('#filter_by_campaign_enable').is(":checked")){
            if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date == ""){
                donations_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=2";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date == ""){
                donations_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=2";
            }else if(filter_by_campaign == "" && filter_by_agent == "" && filter_by_Date != ""){
                donations_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=2";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date == ""){
               donations_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=2";
            }else if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date != ""){
               donations_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=2";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date != ""){
               donations_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=2";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date != ""){
               donations_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=2";
            }
        }else{
            if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date == ""){
                donations_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+setDate1+"&enddate="+setDate2+"&purpose=2";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date == ""){
                donations_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=2";
            }else if(filter_by_campaign == "" && filter_by_agent == "" && filter_by_Date != ""){
                donations_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=2";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date == ""){
               donations_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=2";
            }else if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date != ""){
               donations_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=2";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date != ""){
               donations_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=2";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date != ""){
               donations_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=2";
            }
        }
        
        $("a.donations_redirect").attr("href", donations_url);
    }

    function setWillDonateParams(){
        var will_donate_url = "{{ route('Crm::leads.call.log.reports') }}"+"?purpose=3";
        var filter_by_campaign = $('#filter_by_campaign').val();
        var filter_by_agent = "";//setDate1
        filter_by_agent = $('#filter_by_agent').val();
        var filter_by_Date = $('.filter_by_Date').val();
        var dateString1 =  "";
        var dateString2 =  "";
        if(filter_by_Date != ""){
            var dateString =  filter_by_Date.split(" - ");
            dateString1 =  dateString[0];
            dateString2 =  dateString[1]; 
        } 
        //alert(filter_by_agent);
        //alert(filter_by_Date);
        var setDate1 = "<?=$setDate1?>";
        var setDate2 = "<?=$setDate2?>";
        if ($('#filter_by_campaign_enable').is(":checked")){
           if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date == ""){
                will_donate_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=3";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date == ""){
                will_donate_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=3";
            }else if(filter_by_campaign == "" && filter_by_agent == "" && filter_by_Date != ""){
                will_donate_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=3";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date == ""){
               will_donate_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=3";
            }else if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date != ""){
               will_donate_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=3";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date != ""){
               will_donate_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=3";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date != ""){
               will_donate_url = "{{ route('Crm::leads.call.log.reports') }}"+"?campaign="+filter_by_campaign+"&agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=3";
            } 
        }else{
            if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date == ""){
                will_donate_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+setDate1+"&enddate="+setDate2+"&purpose=3";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date == ""){
                will_donate_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=3";
            }else if(filter_by_campaign == "" && filter_by_agent == "" && filter_by_Date != ""){
                will_donate_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=3";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date == ""){
               will_donate_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+setDate1+"&enddate="+setDate2+"&purpose=3";
            }else if(filter_by_campaign != "" && filter_by_agent == "" && filter_by_Date != ""){
               will_donate_url = "{{ route('Crm::leads.call.log.reports') }}"+"?startdate="+dateString1+"&enddate="+dateString2+"&purpose=3";
            }else if(filter_by_campaign == "" && filter_by_agent != "" && filter_by_Date != ""){
               will_donate_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=3";
            }else if(filter_by_campaign != "" && filter_by_agent != "" && filter_by_Date != ""){
               will_donate_url = "{{ route('Crm::leads.call.log.reports') }}"+"?agent="+filter_by_agent+"&startdate="+dateString1+"&enddate="+dateString2+"&purpose=3";
            }
        }
        
        $("a.will_donate_redirect").attr("href", will_donate_url);
    }
    
    $(document).ready(function() {
        avilableServerDataTable();
        dashbordCountData(1);
        setWillDonateParams();
        setPrayerRequestParams();
        setCallLogParams();
        setDonationsParams();
        setIncommingCallLogParams();
        setOutgoingCallLogParams();
        setBothAnsCallLogParams();
        setCustUnAnsAgentAnsCallLogParams();
        setCustAnsAgentUnAnsCallLogParams();
        setAgentUnAnsCallLogParams();
        userSessionDataTable();
        activeInactiveSessionCount();

        $('#filter_by_session_campaign').on('change', function () {    
            userSessionDataTable();
            activeInactiveSessionCount();
            dashbordCountData(1);
            setWillDonateParams();
            setPrayerRequestParams();
            setCallLogParams();
            setDonationsParams();
            setIncommingCallLogParams();
            setOutgoingCallLogParams();
            setBothAnsCallLogParams();
            setCustUnAnsAgentAnsCallLogParams();
            setCustAnsAgentUnAnsCallLogParams();
            setAgentUnAnsCallLogParams();            
        });
        $('#filter_by_session_call_type').on('change', function () {    
            userSessionDataTable();
            activeInactiveSessionCount();
            dashbordCountData(1);
            setWillDonateParams();
            setPrayerRequestParams();
            setCallLogParams();
            setDonationsParams();
            setIncommingCallLogParams();
            setOutgoingCallLogParams();
            setBothAnsCallLogParams();
            setCustUnAnsAgentAnsCallLogParams();
            setCustAnsAgentUnAnsCallLogParams();
            setAgentUnAnsCallLogParams(); 
        });
        $('#filter_by_session_status').on('change', function () {    
            userSessionDataTable();
            activeInactiveSessionCount();
            dashbordCountData(1);
            setWillDonateParams();
            setPrayerRequestParams();
            setCallLogParams();
            setDonationsParams(); 
            setIncommingCallLogParams();
            setOutgoingCallLogParams();
            setBothAnsCallLogParams();
            setCustUnAnsAgentAnsCallLogParams();
            setCustAnsAgentUnAnsCallLogParams();
            setAgentUnAnsCallLogParams(); 
        });


        $(function() {
            $('input[name="filter_by_Date"]').daterangepicker({
                autoUpdateInput: false,
                applyButtonClasses: 'btn btn-warning',
                drops: ('down'),
                autoApply: false,
                locale: {
                    cancelLabel: 'Clear',
                }
            });
            $('input[name="filter_by_Date"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                var startDate = picker.startDate.format('MM/DD/YYYY');
                var endDate = picker.endDate.format('MM/DD/YYYY');
                //alert(picker.startDate.format('YYYY-MM-DD'));
                // console.log(picker.startDate.format('YYYY-MM-DD'));
                // console.log(picker.endDate.format('YYYY-MM-DD'));
                //serverDataTable();
                //callLogsDataTable()
                avilableServerDataTable();
                //followUpServerDataTable();
                dashbordCountData(1);
                setWillDonateParams();
                setPrayerRequestParams();
                setCallLogParams();
                setDonationsParams();
                setIncommingCallLogParams();
                setOutgoingCallLogParams();
                setBothAnsCallLogParams();
                setCustUnAnsAgentAnsCallLogParams();
                setCustAnsAgentUnAnsCallLogParams();
                setAgentUnAnsCallLogParams(); 
                userSessionDataTable();
                activeInactiveSessionCount();

            });
            $('input[name="filter_by_Date"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                //serverDataTable();
                //callLogsDataTable()
                avilableServerDataTable();
                //followUpServerDataTable();
                dashbordCountData(1);
                setWillDonateParams();
                setPrayerRequestParams();
                setCallLogParams();
                setDonationsParams();
                setIncommingCallLogParams();
                setOutgoingCallLogParams();
                setBothAnsCallLogParams();
                setCustUnAnsAgentAnsCallLogParams();
                setCustAnsAgentUnAnsCallLogParams();
                setAgentUnAnsCallLogParams(); 
                userSessionDataTable();
                activeInactiveSessionCount();


            });
        });

        $('#available-tab').on('click', function () {  
            avilableServerDataTable();
            dashbordCountData(1);
            userSessionDataTable();
            activeInactiveSessionCount();
            setWillDonateParams();
            setPrayerRequestParams();
            setIncommingCallLogParams();
            setOutgoingCallLogParams();
            setBothAnsCallLogParams();
            setCustUnAnsAgentAnsCallLogParams();
            setCustAnsAgentUnAnsCallLogParams();
            setAgentUnAnsCallLogParams(); 
            setCallLogParams();
            setDonationsParams();
        });
        $('#leads-tab').on('click', function () {   
            serverDataTable();
            dashbordCountData(1);
            userSessionDataTable();
            activeInactiveSessionCount();
            setWillDonateParams();
            setPrayerRequestParams();
            setCallLogParams();
            setDonationsParams();
            setIncommingCallLogParams();
            setOutgoingCallLogParams();
            setBothAnsCallLogParams();
            setCustUnAnsAgentAnsCallLogParams();
            setCustAnsAgentUnAnsCallLogParams();
            setAgentUnAnsCallLogParams(); 
        });
        // $('#calls-tab').on('click', function () {
        //     callLogsDataTable(1);
        // });
        $('#close-task').on('click', function () {    
            followUpServerDataTable();
            dashbordCountData(1);
            userSessionDataTable();
            activeInactiveSessionCount();
            setWillDonateParams();
            setPrayerRequestParams();
            setCallLogParams();
            setDonationsParams();
            setIncommingCallLogParams();
            setOutgoingCallLogParams();
            setBothAnsCallLogParams();
            setCustUnAnsAgentAnsCallLogParams();
            setCustAnsAgentUnAnsCallLogParams();
            setAgentUnAnsCallLogParams(); 
        });
        $('#filter_by_agent').on('change', function () {    
            //serverDataTable();
            //callLogsDataTable()
            avilableServerDataTable();
            //followUpServerDataTable();
            dashbordCountData(1);
            setWillDonateParams();
            setPrayerRequestParams();
            setCallLogParams();
            setDonationsParams();
            setIncommingCallLogParams();
            setOutgoingCallLogParams();
            setBothAnsCallLogParams();
            setCustUnAnsAgentAnsCallLogParams();
            setCustAnsAgentUnAnsCallLogParams();
            setAgentUnAnsCallLogParams(); 
            userSessionDataTable();
            activeInactiveSessionCount();

        });
        $('#filter_by_campaign').on('change', function () {
            var campaign_id = $("#filter_by_campaign").val();
            $.ajax({
                type: "POST",
                url: "{{ route('Crm::add.campaign.selected') }}",
                data: {
                    '_token'        : "{{ csrf_token() }}",
                    'campaign_id'     : $("#filter_by_campaign").val()
                },
                success: function (data) {               
                }, error: function (data) {
                },
            });
            //serverDataTable();
            //callLogsDataTable()
            avilableServerDataTable();
            //followUpServerDataTable();
            dashbordCountData(1);
            setWillDonateParams();
            setPrayerRequestParams();
            setCallLogParams();
            setDonationsParams();
            setIncommingCallLogParams();
            setOutgoingCallLogParams();
            setBothAnsCallLogParams();
            setCustUnAnsAgentAnsCallLogParams();
            setCustAnsAgentUnAnsCallLogParams();
            setAgentUnAnsCallLogParams(); 
            userSessionDataTable();
            activeInactiveSessionCount();
        });
        
    });
    // function callLogsDataTable(){
    //     $('#manualCallLogTable').DataTable().destroy();
    //     let table = $('#manualCallLogTable');
    //     let call_status = '0';
    //     table.DataTable({
    //         order: [['0', 'DESC']],
    //         serverSide: true,
    //         responsive: true,
    //         processing: true,
    //         ajax: {
    //             url: "{{ route('Crm::get.lead.dashboard.calllog') }}",
    //             type: 'POST',
    //             data: function (d) {
    //                 d._token = '{{ csrf_token() }}';
    //                 d.filter_by_campaign = $('#filter_by_campaign').val();
    //                 d.filter_by_agent = $('#filter_by_agent').val();
    //                 d.filter_by_Date = $('.filter_by_Date').val();
    //                 d.filter_by_call_status = "";
    //             },
    //         },
    //         columns: [
    //             {"data": "id", name: 'manual_logged_call.id'},
    //             {"data": "name", name: 'leads.name'},
    //             {"data": "attended_by", name: 'users.name'},
    //             {"data": "call_outcome", name: 'manual_logged_call.call_outcome'},
    //             {"data": "duration", name: 'manual_logged_call.duration'},
    //             {"data": "created_at", name: 'manual_logged_call.created_at'},
    //             {"data": "description", name: 'manual_logged_call.description'},
    //             //{"data": "action", sortable: false, searchable : false},   
    //         ]
    //     });
    // }              
    $(function() {
        $('input[name="follow_up_date"]').daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
            autoApply: false,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format('YYYY'),10)
        });
        $('input[name="follow_up_date"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM-DD-YYYY'));
        });
    });
    $(document).ready(function() {
        $('#prayer_req_save').submit(function( e ) {
                var id = $("#member_id").val();
                e.preventDefault();
                $( ".btn" ).prop( "disabled", true );
                $.ajax({
                    type: "POST",
                    url: "{{ route('Crm::prayer.request') }}",
                    data: {
                        '_token'        : "{{ csrf_token() }}",
                        'member_id'     : $("#member_id").val(),
                        'issue'         : $("#issue").val(),
                        'follow_up_date': $("#follow_up_date").val(),
                        'description'   : $("#description").val(),
                    },
                    
                    success: function (data) {
                        //serverDataTable();
                        //callLogsDataTable();
                        avilableServerDataTable();
                        //followUpServerDataTable();
                        dashbordCountData(1);
                        setWillDonateParams();
                        setPrayerRequestParams();
                        setCallLogParams();
                        setDonationsParams();
                        setIncommingCallLogParams();
                        setOutgoingCallLogParams();
                        setBothAnsCallLogParams();
                        setCustUnAnsAgentAnsCallLogParams();
                        setCustAnsAgentUnAnsCallLogParams();
                        setAgentUnAnsCallLogParams(); 
                        userSessionDataTable();
                        activeInactiveSessionCount();
                        
                        $( ".btn" ).prop( "disabled", false );
                        $('#AddNote').modal('toggle');
                        //$('#oppenRadioEditModal').modal('show');
                        $.NotificationApp.send("Success","Prayer Request Created Successfully.","top-center","green","success");
                        setTimeout(function(){
                        }, 3500);
                        
                    }, error: function (data) {
                        $.NotificationApp.send("Error","Prayer Request Not Created.","top-center","red","error");
                        setTimeout(function(){
                        }, 3500);
                        $( ".btn" ).prop( "disabled", false );
                    },

                });
            });
        });
        $("#upload_donation_form").submit(function(event){
            event.preventDefault();
            $( ".btn" ).prop( "disabled", true );
                var name = $('#name').val();
                var email = $('#email').val();
                var phone = $('#phone').val();
                var address = $('#address').val();
                var donation_type = $('#donation_type').val();
                var payment_mode = $('#payment_mode').val();
                var amount = $('#amount').val();
                var reference_no = $('#reference_no').val();
                var bank_name = $('#bank_name').val();
                var cheque_number = $('#cheque_number').val();
                var branch_name = $('#branch_name').val();
                var cheque_date = $('#cheque_date').val();
                var donation_purpose = $('#donation_purpose').val();
                var searched_member_id = $('#searched_member_id').val();
                if(searched_member_id==""){
                    if(payment_mode=="CHEQUE"){			
                        if(name=='' || email=='' || phone=='' || address=='' || donation_type=='' || amount=='' || bank_name=='' || cheque_number=='' || branch_name=='' || cheque_date==''){
                        $.NotificationApp.send("Error","All (*) mark fields are mandatory.","top-center","red","error");
                        $( ".btn" ).prop( "disabled", false );
                        return false;
                        }
                    }else if(payment_mode=="QRCODE"){
                        if(name=='' || email=='' || phone=='' || address=='' || amount=='' || reference_no==''){
                        $.NotificationApp.send("Error","All (*) mark fields are mandatory.","top-center","red","error");
                        $( ".btn" ).prop( "disabled", false );
                        return false;
                        }
                    }else{
                        if(name=='' || email=='' || phone=='' || address=='' || amount==''){
                        $.NotificationApp.send("Error","All (*) mark fields are mandatory.","top-center","red","error");
                        $( ".btn" ).prop( "disabled", false );
                        return false;
                        }
                    }
                }else{
                    if(payment_mode=="CHEQUE"){			
                        if(donation_type=='' || amount=='' || bank_name=='' || cheque_number=='' || branch_name=='' || cheque_date==''){
                        $.NotificationApp.send("Error","All (*) mark fields are mandatory.","top-center","red","error");
                        $( ".btn" ).prop( "disabled", false );
                        return false;
                        }
                    }else if(payment_mode=="QRCODE"){
                        if(amount=='' || reference_no==''){
                        $.NotificationApp.send("Error","All (*) mark fields are mandatory","top-center","red","error");
                        $( ".btn" ).prop( "disabled", false );
                        return false;
                        }
                    }else{
                        // if(amount==''){
                        // $.NotificationApp.send("Error","All (*) mark fields are mandatory","top-center","red","error");
                        // $( ".btn" ).prop( "disabled", false );
                        // return false;
                        // }
                    }
                }
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            $("#hide_donation_text").css('display','none');
            $(".donationForm").css('display','inline-block');
            var formData=new FormData(this);
            $.ajax({
                type: 'POST',
                url:  "{{route('Crm::donation_store')}}",
                data:formData ,
                dataType: 'json',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                dataType: 'json',
            })
            .done(function(data) {
                if(data.status==false){
                    $.NotificationApp.send("Error",data.message,"top-center","red","error");
                    setTimeout(function(){
                    }, 3500);
                }
                if(data.status==true){
                    //serverDataTable();
                    //callLogsDataTable();
                    avilableServerDataTable();
                    //followUpServerDataTable();
                    dashbordCountData(1);
                    setWillDonateParams();
                    setPrayerRequestParams();
                    setCallLogParams();

                    setDonationsParams();
                    setIncommingCallLogParams();
                    setOutgoingCallLogParams();
                    setBothAnsCallLogParams();
                    setCustUnAnsAgentAnsCallLogParams();
                    setCustAnsAgentUnAnsCallLogParams();
                    setAgentUnAnsCallLogParams(); 
                    userSessionDataTable();
                    activeInactiveSessionCount();
                    $(".donationForm").css('display','none');
                    $("#hide_donation_text").css('display','inline-block');	
                    $.NotificationApp.send("Success","The donation has been created!","top-center","green","success");
                    setTimeout(function(){
                    }, 3500);
                    $('#AddDonation').modal('hide');
                    
                    $('#member_type_id').val(null).trigger('change');
                    $('#donation_purpose').val(null).trigger('change');
                    $('#donation_decision').val(null).trigger('change');
                    $('#donation_decision_type').val(null).trigger('change');
                    $('#payment_mode').val(null).trigger('change');
                    $('#payment_status').val(null).trigger('change');
                    $('#location').val(null).trigger('change');
                    $('#gift_issued').val(null).trigger('change');
                    $('#payment_type').val(null).trigger('change');
                    $('#payment_period').val(null).trigger('change');
                    $('#donation_date').val('');
                    $('#amount').val('');
                    $('#start_date').val('');
                    $('#end_date').val('');
                    $('#reference_no').val('');
                    $('#bank_name').val('');
                    $('#cheque_number').val('');
                    $('#branch_name').val('');
                    $('#cheque_date').val('');
                    $('#payment_method').val('');
                    //$('#oppenRadioEditModal').modal('show');
                    // if($('#oppenRadioEditModal').hasClass('show')){
                    //     $('#call_purpose_radio_edit_modal').append('<option value="Donation" selected="selected">Donation</option>');
                    // }
                }
                $( ".btn" ).prop( "disabled", false );
            })
            .fail(function(data) {
                $.NotificationApp.send("Error",data.message,"top-center","red","error");
                setTimeout(function(){
                }, 3500);
                $( ".btn" ).prop( "disabled", false );
            });
        })
        function addDonationModal(id){
            $('#lead_id').val(id);
            $('#callLogEditModal').modal('hide');
            $('#AddDonation').modal('show');

            $('#AddDonation').modal({
                backdrop: 'static',
                keyboard: false
            });
            
        }
        function addPrayerRequestModal(id){
            $('#member_id').val(id);
            $('#callLogEditModal').modal('hide');
            $('#follow_up_date').val('');
            $('#issue').val(null).trigger('change');
            $('#description').val('');
            $('#AddNote').modal({
                backdrop: 'static',
                keyboard: false
            });

            $('#AddNote').modal('show'); 
        }

        
        $(document).on('change', '.leadstatusupdate', function() {
            var val = $(this).val();
            var id = $(this).attr('data-id');
            // alert(id);
            $.ajax({
                type: "GET",
                url: "{{ route('Crm::lead_status_update') }}",
                data: {
                    'lead_id'     : id,
                    'lead_status'   : val,
                },
                success: function (data) {
                    //serverDataTable();
                    avilableServerDataTable();
                    //followUpServerDataTable();
                    dashbordCountData(1);
                    setWillDonateParams();
                    setPrayerRequestParams();
                    setCallLogParams();
                    setDonationsParams();
                    setIncommingCallLogParams();
                    setOutgoingCallLogParams();
                    setBothAnsCallLogParams();
                    setCustUnAnsAgentAnsCallLogParams();
                    setCustAnsAgentUnAnsCallLogParams();
                    setAgentUnAnsCallLogParams(); 
                    userSessionDataTable();
                    activeInactiveSessionCount();
                    $.NotificationApp.send("Success", data.message, "top-center", "green","success");
                }, error: function (data) {
                    $.NotificationApp.send("Error", "Call Status not changed !!", "top-center","red","error");
                },
            });
            //console.log(1);
        });
//outcomestatus
    // $(document).on('change', '.outcomestatus', function() {
    //     var val = $(this).val();
    //     var id = $(this).attr('data-id');
    //     // alert(id);
    //     $.ajax({
    //         type: "GET",
    //         url: "{{ route('Crm::manual_call_status_outcome_update') }}",
    //         data: {
    //             'member_id'     : id,
    //             'call_status'   : val,
    //         },
    //         success: function (data) {
    //             //serverDataTable();
    //             avilableServerDataTable();
    //             callLogsDataTable();
    //             $.NotificationApp.send("Success", data.message, "top-center", "green","success");
    //         }, error: function (data) {
    //             $.NotificationApp.send("Error", "Call Status not changed !!", "top-center","red","error");
    //         },
    //     });
    //     //console.log(1);
    // });


        // function leadCallStatusUpdate(id){
        $(document).on('change', '.callstatus', function() {
            var val = $(this).val();
            var id = $(this).attr('data-id');
            var filter_by_campaign = $("#filter_by_campaign").val(); 
            // alert(id);
            $.ajax({
                type: "GET",
                url: "{{ route('Crm::manual_call_status') }}",
                data: {
                    'member_id'     : id,
                    'call_status'   : val,
                    'campaign_id'   : filter_by_campaign
                },
                success: function (data) {
                    //serverDataTable();
                    avilableServerDataTable();
                    //followUpServerDataTable();
                    dashbordCountData(1);
                    setWillDonateParams();
                    setPrayerRequestParams();
                    setCallLogParams();
                    setDonationsParams();
                    setIncommingCallLogParams();
                    setOutgoingCallLogParams();
                    setBothAnsCallLogParams();
                    setCustUnAnsAgentAnsCallLogParams();
                    setCustAnsAgentUnAnsCallLogParams();
                    setAgentUnAnsCallLogParams(); 
                    userSessionDataTable();
                    activeInactiveSessionCount();
                    $.NotificationApp.send("Success", data.message, "top-center", "green","success");
                }, error: function (data) {
                    $.NotificationApp.send("Error", "Call Status not changed !!", "top-center","red","error");
                },
            });
            //console.log(1);
        });
    $(document).on('change', '#member_type_id', function(e) {
        var inputValue = $(this).val();
        if ('add' == inputValue) {
            $("#detail_type").val(1);
            $("#AddDonation").modal("hide");
            $("#AddDetails").modal("show");
        }
    });
    $('#location').change(function() {
        var inputValue = $(this).val();
        if ('add' == inputValue) {
            $("#detail_type").val(4);
            $("#AddDonation").modal("hide");
            $("#AddDetails").modal("show");
        }
    });
    $('#donation_purpose').change(function() {
        var inputValue = $(this).val();
        if ('add' == inputValue) {
            $("#detail_type").val(2);
            $("#AddDonation").modal("hide");
            $("#AddDetails").modal("show");
        }
    });
    $('#call_purpose').change(function() {
        var inputValue = $(this).val();
        if ('add' == inputValue) {
            $("#detail_type").val(5);
            $("#callLogEditModal").modal("hide");
            $("#AddDetails").modal("show");
        }
    });

    $('#call_purpose_radio_edit_modal').change(function(){
        var inputValue = $(this).val();
    });

    $('#issue').change(function() {
        var inputValue = $(this).val();
        if ('add' == inputValue) {
            $("#detail_type").val(6);
            $("#AddNote").modal("hide");
            $("#AddDetails").modal("show");
        }
    });


    $(document).on('submit', '#add_detail', function(e) {
        e.preventDefault();
        $("#AddDetails").modal("hide");
        var detail = $('#detail').val();
        if (detail == '') {
            $.NotificationApp.send("Error",'Please enter value',"top-center","red","error");
            return false;
        }
        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var formData = new FormData(this);
        var my_url = '';
        var APP_URL="{{route('console::console')}}";
        if ($('#detail_type').val() == 3) {
            my_url = APP_URL + '/manage/departmentData';
            formData.append('department', detail);
        } else if ($('#detail_type').val() == 4) {
            my_url = APP_URL + '/manage/branchData';
            formData.append('branch', detail);
        } else if ($('#detail_type').val() == 5) {
            my_url = APP_URL + '/manage/callPurposeData';
            formData.append('call_purpose', detail);
        } else if ($('#detail_type').val() == 2) {
            my_url = APP_URL + '/manage/insertDonationpurpose';
            formData.append('purpose', detail);
        } else if ($('#detail_type').val() == 6) {
            my_url = APP_URL + '/manage/requestData';
            formData.append('prayer_request', detail);
        } else
            my_url = APP_URL + '/manage/memberData';
        var type = "POST";

        var addText=$('#detail').val();  
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                if(data.status==true){
                if($('#detail_type').val()==1){
                    $('#member_type_id').val(null).trigger('change');
                    $("#member_type_id option:last").before("<option value="+addText+">"+addText+"</option>");
                    }else if($('#detail_type').val()==2){
                        $('#donation_purpose').val(null).trigger('change');
                        $("#donation_purpose option:last").before("<option value="+addText+">"+addText+"</option>");
                    }else if($('#detail_type').val()==4){
                        $('#location').val(null).trigger('change');
                        $("#location option:last").before("<option value="+addText+">"+addText+"</option>");
                    }else if($('#detail_type').val()==5){
                        $('#call_purpose').val(null).trigger('change');
                        $("#call_purpose option:last").before("<option value="+addText+">"+addText+"</option>");

                        $('#call_purpose_radio').val(null).trigger('change');
                        $("#call_purpose_radio option:last").before("<option value="+addText+">"+addText+"</option>");
                    }else if($('#detail_type').val()==6){
                        $('#issue').val(null).trigger('change');
                        $("#issue option:last").before("<option value="+addText+">"+addText+"</option>");
                    }
                }
                $.NotificationApp.send("Success","Data has been submited!","top-center","green","success");
                setTimeout(function(){
                }, 3500);
                
                if($('#detail_type').val()==1){
                        $('#AddDonation').modal('show');
                    }else if($('#detail_type').val()==2){
                        $('#AddDonation').modal('show');  
                    }else if($('#detail_type').val()==4){
                        $('#AddDonation').modal('show');
                    }else if($('#detail_type').val()==5){
                        $('#callLogEditModal').modal('show');
                    }else if($('#detail_type').val()==6){
                        $('#AddNote').modal('show');
                    }
            },
            error: function(data) {
                $.NotificationApp.send("Error",data,"top-center","red","error");
            }
        });
    });
</script>
<script>
    var colors = ["#fa6767"],
    //dataColors && (colors = dataColors.split(","));

    colors = ["#727cf5", "#6c757d"];
    (dataColors = $("#spline-area").data("colors")) && (colors = dataColors.split(","));
    options = {
    chart: {
        height: 400,
        type: "area"
    },
    dataLabels: {
        enabled: !1
    },
    stroke: {
        width: 3,
        curve: "smooth"
    },
    colors: colors,
    series: [{
        name: "Connected", 
        data: [<?=$AC?>]
    }, {
        name: "Not Connected", 
        data: [<?=$NAC?>]
    }],

    legend: {
        offsetY: 5
    },
    xaxis: {
        categories: ["0", "1:00", "2:00", "3:00", "4:00", "5:00", "6:00", "7:00", "8:00", "9:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00", "23:00", "24:00"]
    },
    tooltip: {
        fixed: {
            enabled: !1,
            position: "topRight"
        }
    },
    grid: {
        borderColor: "#f1f3fa"
    }
};
(chart = new ApexCharts(document.querySelector("#spline-area"), options)).render(); 


$(document).on('click','.donation', function(){
    const val = $(this).attr('data-value');
    if(val== 'current-week'){
        $('#donation_text1').text('Current Week');
        $('#donation_text2').text('Previous Week');
    }else if(val== 'current-month'){
        $('#donation_text1').text('Current Month');
        $('#donation_text2').text('Previous Month');
    }else if(val== 'current-year'){
        $('#donation_text1').text('Current Year');
        $('#donation_text2').text('Previous Year');
    }
    
    $.ajax({
        type: "GET",
        url: "/crm/admin/donations/comparison/"+val,
        data: null,
        success: function (data) {
            //console.log(data);
            $("#current-donation").html(data.current_donations);
            $("#previous-donation").html(data.previous_donations);
        }, error: function (data) {},
    });

});



</script>
@endsection