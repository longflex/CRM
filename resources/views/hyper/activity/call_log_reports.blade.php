@extends('hyper.layout.master')
@section('title', "Call Log Reports")
@section('content')
<div class="px-2">
    <!-- start page title -->
    <?php 
        $currentDate = date('m/d/Y');
        $setDate1 = $currentDate;//date('m/d/Y', strtotime($currentDate.' - 1 day'));
        $setDate2 = date('m/d/Y', strtotime($currentDate.' + 1 day'));
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="uil-home-alt"></i>Home</a></li>
                        <li class="breadcrumb-item active">Call Log Reports</li>
                    </ol>
                </div>
                <h4 class="page-title">Call Log Reports</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    <!-- start page content -->
    <div class="row">
        @if(Laralum::hasPermission('laralum.activity.filters'))
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
                            <input type="text" class="form-control date date_range_filter" placeholder="Date Range Filter" name="date_range_filter" value="" />
                        </div>
                        <div class="form-group">
                            <select class="select2" name="agent" id="filter_by_agent" data-toggle="select2" data-placeholder="Select Agent">
                                <option value="">-- Select Agent --</option>
                                @if(!empty($agents))
                                @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                @endforeach
                                @endif
                            </select>
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
                        <div class="form-group">
                            <select class="select2" id="filter_by_call_source" data-toggle="select2" data-placeholder="Select Call Source">
                                <option value="">-- Select Call Source --</option>
                                <option value="0">Outgoing</option>
                                <option value="1">Incoming</option>
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
                        <div class="form-group">
                            <select id="filter_by_campaign" data-toggle="select2"
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
                            <select class="select2" id="filter_by_call_purpose" data-toggle="select2" data-placeholder="Select Call Purpose">
                                <option value="">-- Select Call Purpose --</option>
                                <option value="Add Donation">Add Donation</option>
                                <option value="Add Prayer Request">Add Prayer Request</option>
                                <option value="Will Donate">Will Donate</option>
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
                        <!-- <div class="col-md-2 float-right">
                            <a class="btn btn-light float-right" href="{{ route('Crm::get_leads_import') }}"><i class="uil-cloud-upload"></i></a>
                            <a class="btn btn-danger float-right mr-1" href="{{ route('Crm::leads_create') }}"><i class="uil-plus-circle"></i></a>
                        </div> -->
                    </div>
                    <hr>
                    <div class="form-group mt-2">
                        <div class="table-responsive">
                            <table  class="table dt-responsive nowrap w-100" id="call-log-datatable">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll" value=true></th>  
                                        <th>ID</th>
                                        <th>Lead Number</th>
                                        <th>Agent Number</th>
                                        <th>DID Number</th>
                                        <th>Call Status</th>
                                        <th>Call purpose</th>
                                        <!-- <th>Status To</th> -->
                                        <th>Call Type</th>
                                        <th>Call Source</th>
                                        <th>Recording</th>
                                        <th>Created At</th>
                                        <th>Call Duration</th>
                                        <!-- <th>Outcome</th> -->
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



@endsection
@section('extrascripts')
<script>
    function setFiltersValue() {
        var urlParams = new URLSearchParams(window.location.search);
        var campaign = urlParams.get('campaign');
        var purpose = urlParams.get('purpose');
        var agent = urlParams.get('agent');
        var startdate = urlParams.get('startdate');
        var enddate = urlParams.get('enddate');
        var source_type = urlParams.get('type');
        var outcome = urlParams.get('outcome');

            if(urlParams.has('agent')){
                $('#filter_by_agent').val(agent);
                $('#filter_by_agent').trigger('change'); 
            }
            if(urlParams.has('purpose')){
                if(purpose == 1){
                    $('#filter_by_call_purpose').val('Add Prayer Request');
                    $('#filter_by_call_purpose').trigger('change'); 
                }else if(purpose == 2){
                    $('#filter_by_call_purpose').val('Add Donation');
                    $('#filter_by_call_purpose').trigger('change'); 
                }else if(purpose == 3){
                    $('#filter_by_call_purpose').val('Will Donate');
                    $('#filter_by_call_purpose').trigger('change'); 
                }

                if (urlParams.has('startdate') && urlParams.has('enddate') && startdate != "" && enddate != "") {
                    $('.date_range_filter').daterangepicker({
                        startDate: startdate,
                        endDate: enddate
                    });
                }else{
                    var setDate1 = "{{$setDate1}}";
                    var setDate2 = "{{$setDate2}}";
                    $('.date_range_filter').daterangepicker({
                        startDate: setDate1,
                        endDate: setDate2
                    }); 
                }
                
            }

        if (urlParams.has('campaign')) {
            $('#filter_by_campaign').val(campaign); // Select the option with a value of '1'
            $('#filter_by_campaign').trigger('change'); // Notify any JS components that the value changed
        }
        if (urlParams.has('type')) {
            $('#filter_by_call_source').val(source_type); 
            $('#filter_by_call_source').trigger('change'); 
        }
        if (urlParams.has('outcome')) {
            $('#filter_by_call').val(outcome); 
            $('#filter_by_call').trigger('change'); 
        }
    }
</script>
    <script>
        $(document).ready(function() {
            setFiltersValue();

            $('#assign_to_campaign_section').hide();
            $('#assign_to_agent_section').hide();
            $('#assign_to_agent_group_section').hide();
            $('#select_all_section').hide();

            $('#check_action').on('change', function () {

                if($('#check_action').val()=='Export Selected') {
                    $('#select_all_section').show();
                }
                if($('#check_action').val()=='Delete Selected') {
                    $('#select_all_section').show();
                }
                if($('#check_action').val()=='Assign Selected To Campaign') {
                    $('#assign_to_campaign_section').show();
                    $('#select_all_section').show();
                } else{
                    $('#assign_to_campaign_section').hide();
                }
            });
        });
        
        $(function() {
            $('input[name="date_range_filter"]').daterangepicker({
                autoUpdateInput: false,
                applyButtonClasses: 'btn btn-warning',
                drops: ('up'),
                autoApply: false,
                locale: {
                    cancelLabel: 'Clear',
                }
            });
            $('input[name="date_range_filter"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                setFiltersValue();
                leadCallLogDataTable();
            });
            $('input[name="date_range_filter"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                setFiltersValue();
                leadCallLogDataTable();
            });
        });

    </script>
    <script>
      
        $(document).ready(function() {
            leadCallLogDataTable();
            $('#filter_by_call').on('change', function () {
                leadCallLogDataTable();
            });
            
            $('#filter_by_campaign').on('change', function () {
                setFiltersValue();
                leadCallLogDataTable();
            });
            $('#filter_by_agent').on('change', function () {
                setFiltersValue();
                leadCallLogDataTable();
            });
            $('#filter_by_campaign_status').on('change', function () {
                leadCallLogDataTable();
            });
            $('#filter_by_call_type').on('change', function () {
                leadCallLogDataTable();
            });
            $('#filter_by_call_purpose').on('change', function () {
                leadCallLogDataTable();
            });
            $('#filter_by_call_source').on('change', function () {
                leadCallLogDataTable();
            });
        });
        function leadCallLogDataTable() {
            $('#call-log-datatable').DataTable().destroy();
            let table = $('#call-log-datatable');
            table.DataTable(
                {
                    order: [['1', 'desc']],
                    lengthMenu: [[10, 25, 50, 100, 500, 1000], [10, 25, 50, 100, 500, 1000]],
                    serverSide: true,
                    responsive: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('Crm::get.lead.calllog.report.data') }}",
                        type: 'POST',
                        data: function (d) {
                                d._token = '{{csrf_token()}}';
                                d.date_range_filter = $('.date_range_filter').val();
                                d.filter_by_agent = $('#filter_by_agent').val();
                                d.filter_by_call = $('#filter_by_call').val();
                                d.filter_by_call_type = $('#filter_by_call_type').val();
                                d.filter_by_campaign_status = $('#filter_by_campaign_status').val();
                                d.filter_by_call_purpose = $('#filter_by_call_purpose').val();
                                d.filter_by_campaign = $('#filter_by_campaign').val();
                                d.filter_by_call_source = $('#filter_by_call_source').val();
                            },
                    },
                    columns: [                        
                        {data: "checkbox", sortable: false, searchable : false},
                        {data: "id", name: 'manual_logged_call.id',},
                        {data: "lead_number", name: 'manual_logged_call.lead_number',},
                        {data: "agent_number", name: 'manual_logged_call.agent_number'},
                        {data: "did", name: 'manual_logged_call.did'},
                        {data: "call_outcome", name: 'manual_logged_call.call_outcome'},
                        {data: "call_purpose", name: 'manual_logged_call.call_purpose'},
                        // {data: "status", name: 'manual_logged_call.status'},
                        {data: "call_type", name: 'manual_logged_call.call_type'},
                        {data: "call_source", name: 'manual_logged_call.call_source'},
                        {data: "recordings_file", name: 'manual_logged_call.recordings_file'},
                        {data: "created_at", name: 'manual_logged_call.created_at'},
                        {data: "duration", name: 'manual_logged_call.duration'},  
                    ]
                } 
            );
    }

    </script>

    <script>
        $('#selectAll').click(function(e) {
            var table= $(e.target).closest('table');
            $('td input:checkbox',table).prop('checked',this.checked);
        });

        $(document).on("click", ".play-audio", function(e) {
            var url = $(this).attr("data-index");
            new Audio(url).play();
        });

        

        $("#action_btn").click(function() {
            var ids=[];
            var lead_ids = [];

            var select_all_option_check=0;
            var filter_by_call=$('#filter_by_call').val();
            var filter_by_agent=$('#filter_by_agent').val();
            var filter_by_call_type=$('#filter_by_call_type').val();
            var filter_by_campaign_status=$('#filter_by_campaign_status').val();
            var date_range_filter=$('.date_range_filter').val();
            var filter_by_call_purpose=$('#filter_by_call_purpose').val();
            if($(".select_all_option").prop('checked') == true){
                select_all_option_check=1; 
            }else{
                select_all_option_check=0;
                ids = [];
                lead_ids = [];
                $('input[type=checkbox]:checked').each(function(i, val) {
                    if(val.id!='selectAll')
                    //var valArr = (val.id).split("_"); 
                    ids.push(val.id);
                    //lead_ids.push(valArr[1]);
                });  
            }
            //alert(ids);return;24,22,21,20,19,18,17,16,15,12
            if(ids.length==0 && select_all_option_check==0){
                $.NotificationApp.send("Error","Please select rows first!","top-center","red","error");
                return;
            }
            if($('#check_action').val()!='Select Action') {
                var url="";
                var body={};
                if($('#check_action').val()=='Delete Selected') {return;
                    url="{{ route('Crm::lead_deleteSelected') }}"
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });    
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: {ids:ids,select_all_option_check:select_all_option_check},
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            $.NotificationApp.send("Success","Selected data has been deleted.","top-center","green","success");
                            setTimeout(function(){
                                leadCallLogDataTable();
                                //location.reload();
                            }, 3500);
                        }, error: function (data) {console.log(data);
                            $.NotificationApp.send("Error","Selected data hasn't been deleted.","top-center","red","error");
                            setTimeout(function(){
                                leadCallLogDataTable();
                                //location.reload();
                            }, 3500);
                        },
                    })
                } else if ($('#check_action').val()=='Export Selected') {
                    var query = {
                        "ids": ids,"select_all_option_check":select_all_option_check,"filter_by_call":filter_by_call,"filter_by_agent":filter_by_agent,"filter_by_call_type":filter_by_call_type,"filter_by_campaign_status":filter_by_campaign_status,"date_range_filter":date_range_filter, "filter_by_call_purpose": filter_by_call_purpose
                    }
                    var url = "{{ route('Crm::exportSelectedCallLogReport') }}?" + $.param(query)
                    window.location = url;
                }else if ($('#check_action').val()=='Assign Selected To Campaign') {
                var cid = $('#assign_to_campaign').val();  
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
                                    "_token": "{{ csrf_token() }}","campaigns": cid,"leads": lead_ids,"select_all_option_check":select_all_option_check,"filter_by_call":filter_by_call,"filter_by_agent":filter_by_agent,"filter_by_call_type":filter_by_call_type,"filter_by_campaign_status":filter_by_campaign_status,"date_range_filter":date_range_filter,"filter_by_call_purpose":filter_by_call_purpose
                                },
                                success: function (data) {
                                    $.NotificationApp.send("Success","Leads assigned to campaign.","top-center","green","success");
                                    setTimeout(function(){
                                    }, 3500);
                                    leadCallLogDataTable();
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
        });
    </script>

@endsection