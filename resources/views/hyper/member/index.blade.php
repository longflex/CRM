@extends('hyper.layout.master')
@section('title', "Members List")
@section('content')
<div class="px-2">
    <!-- start page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::members_dashboard') }}"><i class="uil-home-alt"></i> Dashboard</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
                <h4 class="page-title">Members List</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    <!-- start page content -->
    <div class="row">
        @if(Laralum::hasPermission('laralum.member.filters'))
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
                            <select class="select2" name="lead_status" id="filter_by_lead_status" data-toggle="select2" data-placeholder="Select Lead Status">
                                <option value="">Please select..</option>
                                @if(!empty($lead_statuses))
                                @foreach($lead_statuses as $lead_status)
                                <option value="{{ $lead_status->lead_status }}">{{ $lead_status->description }}</option>
                                @endforeach
                                @endif
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
                            <a class="btn btn-light float-right" href="{{ route('Crm::get_members_import') }}"><i class="uil-cloud-upload"></i></a>
                            <a class="btn btn-danger float-right mr-1" href="{{ route('Crm::members_create') }}"><i class="uil-plus-circle"></i></a>
                        </div>
                    </div>

                    <hr>
                    <div class="form-group mt-2">
                        <div class="table-responsive">
                            <table id="server-datatable" class="table table-striped pagination-rounded dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll" value=true></th>  
                                        <th>ID</th>
                                        <th>Member ID</th>
                                        <th>Name</th>
                                        <th>Mobile No</th>
                                        <th>Partner Code</th>
                                        <th>Sponsor Code</th>
                                        <th>Status</th>
                                        <!-- <th>Recently Contacted</th> -->
                                        <th>Language</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end page content --> 
</div>  
@endsection
@section('extrascripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#assign_to_campaign_section').hide();
        $('#assign_to_agent_section').hide();
        $('#assign_to_agent_group_section').hide();
        $('#select_all_section').hide();

        $('#check_action').on('change', function () {

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
        memberDataTable();
    });
    $('input[name="recently_contacted"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        memberDataTable();
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
        memberDataTable();
    });
    $('input[name="date_of_anniversary"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        memberDataTable();
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
        memberDataTable();
    });
    $('input[name="date_of_birth"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        memberDataTable();
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
        memberDataTable();
    });
    $('input[name="prayer_followup_date"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        memberDataTable();
    });
});


</script>
    <script>
        $(document).ready(function() {         
            memberDataTable();
            $('#filter_by_lead_status').on('change', function (){ 
                memberDataTable();
            });    
            $('#filter_by_account_type').on('change', function () {
                memberDataTable();
            });
            $('#filter_by_member_type').on('change', function () {
                memberDataTable();
            });
            // $('#filter_by_prayer_request').on('change', function () {
            //     memberDataTable();
            // });
            $('#filter_by_department').on('change', function () {
                memberDataTable();
            });
            $('#filter_by_call').on('change', function () {
                memberDataTable();
            });
            $('#filter_by_source').on('change', function () {
                memberDataTable();
            });
            $('#filter_by_gender').on('change', function () {
                memberDataTable();
            });
            $('#filter_by_blood_group').on('change', function () {
                memberDataTable();
            });
            $('#filter_by_marital_status').on('change', function () {
                memberDataTable();
            });
            
            $('#filter_by_call_required').on('change', function () {
                memberDataTable();
            });
            $('#filter_by_sms_required').on('change', function () {
                memberDataTable();
            });
            $('#filter_by_preferred_language').on('change', function () {
                memberDataTable();
            });
            $('#filter_by_campaign').on('change', function () {
                memberDataTable();
            });
            $('#filter_by_agent').on('change', function () {
                memberDataTable();
            });
            $('#filter_by_campaign_assigned').on('change', function () {
                memberDataTable();
            });
            $('#filter_by_campaign_status').on('change', function () {
                memberDataTable();
            });
            $('#filter_by_call_type').on('change', function () {
                memberDataTable();
            });
            $('#filter_by_lead_response').on('change', function () {
                memberDataTable();
            });
        });
        function memberDataTable() {
            $('#server-datatable').DataTable().destroy();
            let table = $('#server-datatable');
            let data_id = $('#filter_by_lead_status').val();
            table.DataTable(
                {
                    serverSide: true,
                    responsive: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('Crm::get_members_data') }}",
                        type: 'POST',
                        data: function (d) {
                                d._token = '{{csrf_token()}}';
                                d.filter_by_data_id = data_id;
                                d.filter_by_recently_contacted = $('.recently_contacted').val();
                                d.filter_by_account_type = $('#filter_by_account_type').val();
                                d.filter_by_member_type = $('#filter_by_member_type').val();
                                //d.filter_by_prayer_request = $('#filter_by_prayer_request').val();
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
                        {"data": "checkbox", sortable: false, searchable : false},
                        {"data": "id", name: 'leads.id'},
                        {"data": "member_id", name: 'leads.member_id'},
                        {"data": "name", name: 'leads.name'},
                        {"data": "mobile", name: 'leads.mobile'},
                        {"data": "partner_code", name: 'leads.partner_code'},
                        {"data": "sponsor_code", name: 'leads.sponsor_code'},
                        {"data": "lead_status", name: 'leads.lead_status'},
                        {"data": "preferred_language", name: 'leads.preferred_language'},
                        {"data": "action", sortable: false, searchable : false},
                    ]
                }
            );
        }
    </script>
    <script>
        // $('#selectAll').click(function(e) {
        //     var table= $(e.target).closest('table');
        //     $('td input:checkbox',table).prop('checked',this.checked);
        // });
        
        
        // $('#selectAll').click(function(e) {
        //     // var table= $(e.target).closest('table');
        //     // $('td input:checkbox',table).prop('checked',this.checked);
        //     // });

        //     var ids=[];

        //     var select_all_option_check=0;
        //     var filter_by_data_id=$('#filter_by_lead_status').val();
        //     var filter_by_recently_contacted=$('.recently_contacted').val();
        //     var filter_by_account_type=$('#filter_by_account_type').val();
        //     var filter_by_member_type=$('#filter_by_member_type').val();
        //     //var filter_by_prayer_request=$('#filter_by_prayer_request').val();
        //     var filter_by_department=$('#filter_by_department').val();
        //     var filter_by_call=$('#filter_by_call').val();
        //     var filter_by_source=$('#filter_by_source').val();
        //     var filter_by_gender=$('#filter_by_gender').val(); 
        //     var filter_by_blood_group=$('#filter_by_blood_group').val();
        //     var filter_by_marital_status=$('#filter_by_marital_status').val();
        //     var filter_by_date_of_birth=$('.date_of_birth').val();
        //     var filter_by_date_of_anniversary=$('.date_of_anniversary').val();
        //     var filter_by_call_required=$('#filter_by_call_required').val();
        //     var filter_by_sms_required=$('#filter_by_sms_required').val();
        //     var filter_by_preferred_language=$('#filter_by_preferred_language').val();
        //     var filter_by_agent=$('#filter_by_agent').val();

        //     var filter_by_campaign=$('#filter_by_campaign').val();
        //     var filter_by_campaign_assigned=$('#filter_by_campaign_assigned').val();
        //     var filter_by_campaign_status=$('#filter_by_campaign_status').val();
        //     var filter_by_prayer_followup_date=$('.prayer_followup_date').val();
        //     var filter_by_call_type=$('#filter_by_call_type').val();
        //     var filter_by_lead_response=$('#filter_by_lead_response').val();

        //     if($(".select_all_option").prop('checked') == true){
        //         select_all_option_check=1; 
        //     }else{
        //         select_all_option_check=0;
        //         ids=[];
        //         $('input[type=checkbox]:checked').each(function(i, val) {
        //             if(val.id!='selectAll')
        //             ids.push(val.id);
        //         });  
        //     }
        //     if(ids.length==0 && select_all_option_check==0){
        //         $.NotificationApp.send("Error","Please select lead first!","top-center","red","error");
        //         return;
        //     }
        // $("#action_btn").click(function() {
        //     var ids=[];
        //     $('input[type=checkbox]:checked').each(function(i, val) {
        //         if(val.id!='selectAll')
        //             ids.push(val.id);
        //         });
        //         if(ids.length==0){
        //             //$('.dimmer').removeClass('dimmer');
        //             $.NotificationApp.send("Error","Please select lead first!","top-center","red","error");
        //             return;
        //         }
        //         if($('#check_action').val()!='Select Action') {
        //             var url="";
        //             var body={};
        //             if($('#check_action').val()=='Delete Selected') {
        //                 url="{{ route('Crm::lead_deleteSelected') }}"
        //                 $.ajaxSetup({
        //                 headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        //                 }
        //                 });
        //                 $.ajax({
        //                     type: 'POST',
        //                     url: url,
        //                     data: {ids:ids},
        //                     success: function (data) {
        //                         $.NotificationApp.send("Success","Selected data has been deleted.","top-center","green","success");
        //                         setTimeout(function(){
        //                         location.reload();
        //                         }, 3500);
        //                     }, error: function (data) {
        //                         $.NotificationApp.send("Error","Selected data hasn't been deleted.","top-center","red","error");
        //                         setTimeout(function(){
        //                         location.reload();
        //                         }, 3500);
        //                     },
        //                 })
        //             }
        //             else if ($('#check_action').val()=='Export Selected') {
        //                 var query = {
        //                     ids: ids
        //                 }
        //                 var url = "{{ route('Crm::exportSelectedLeads') }}?" + $.param(query)
        //                 window.location = url;
        //             }
        //             else {
        //                 $('#sms_ids').val(ids);
        //                 $('#SendSms').modal('show');
        //             }
        //     }
        //     else {
        //         $.NotificationApp.send("Error","Please select action first!","top-center","red","error");
        //     }
        // });

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
            $.NotificationApp.send("Error","Please select member first!","top-center","red","error");
            return;
        }
        if($('#check_action').val()!='Select Action') {
            var url="";
            var body={};
            if($('#check_action').val()=='Delete Selected') {
                url="{{ route('Crm::member_deleteSelected') }}"
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
                            memberDataTable();
                            //location.reload();
                        }, 3500);
                    }, error: function (data) {console.log(data);
                        $.NotificationApp.send("Error","Selected data hasn't been deleted.","top-center","red","error");
                        setTimeout(function(){
                            memberDataTable();
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
                var url = "{{ route('Crm::exportSelectedMembers') }}?" + $.param(query)
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
                    text: "You want to assign members to campaign ?",
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
                                memberDataTable();
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