@extends('hyper.layout.master')
@section('title', "Campaign Details")
@section('content')
<div class="px-2">
    <!-- start page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::campaign') }}"><i class="uil-home-alt"></i>Campaign</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Campaign Details</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <!-- start page content -->
    <div class="row">
        @if(Laralum::hasPermission('laralum.campaign.filters'))
        <div class="col-lg-3">
            <div class="col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body mx-3">
                        <div class="">
                            <h3 class="font-weight-bold"><a class="float-right text-secondary" href="" data-toggle="tooltip" title="Reset Filters" data-placement="top"><i class="mdi mdi-refresh-circle"></i></a><i class="dripicons-experiment"></i> Filters</h3>
                        </div>
                        <hr>
                        <label>Campaign Filter</label>      
                        <div class="form-group" style="display: none;">
                            <select id="filter_by_campaign" class="form-control select2" name="campaign" data-toggle="select2"
                                data-placeholder="-- Select Campaign --" >
                                <option value="">-- Select Campaign --</option>
                                @if(!empty($campaigns))
                                @foreach($campaigns as $campaign)
                                <option value="{{ $campaign->id }}"
                                    {{ ($id == $campaign->id ? 'selected': '') }}>
                                    {{ $campaign->name }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control date filter_by_date_range" placeholder="Select Date Range" name="date_range_filter" value="" />
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
                            <select class="select2" name="agent" id="filter_by_agent" data-toggle="select2" data-placeholder="Select Agent">
                                <option value="">-- Select Agent --</option>
                                @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="select2" name="agentGroup" id="filter_by_agentGroup" data-toggle="select2" data-placeholder="Select Agent Group">
                                <option value="">-- Select Agent Group --</option>
                                @foreach ($agentGroups as $agentGroup)
                                <option value="{{ $agentGroup->id }}">{{ $agentGroup->name }}</option>
                                @endforeach
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
                                <div class="col-md-6">
                                    <select class="custom-select" id="check_action" aria-label="Example select with button addon">
                                        <option value="Select Action" selected>Select Action</option>
                                        <option value="Delete Selected">Unassigned Selected</option>
                                        <option value="Export Selected">Export Selected</option>
                                    </select>
                                </div>
                                <div class="col-md-2" id="select_all_section">  
                                   <div class="custom-control custom-checkbox mt-2">
                                        <input type="checkbox" class="custom-control-input select_all_option" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">Select All</label>
                                    </div> 
                                </div>
                                <div class="col-md-4">
                                    <a class="btn btn-primary" id='action_btn'>Go <i class="mdi mdi-arrow-right-bold"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 float-right">
                            <a class="btn btn-light float-right" href="{{ route('Crm::get_campaign_import', $id) }}"><i class="uil-cloud-upload"></i></a>
                            <!-- <a class="btn btn-danger float-right mr-1" href="{{ route('Crm::create-campaign') }}"><i class="uil-plus-circle"></i></a> -->
                        </div>
                    </div>
                    <hr>
                    <div class="table-responsive mt-2">
                        <table class="table table-striped dt-responsive nowrap w-100" id="campaign-DataTable">
                            <thead>
                                <th><input type="checkbox" id="selectAll" value=true></th>
                                <th>Lead Name</th>
                                <th>Assigned To</th>
                                <th>Call Status</th>
                                <th>Lead Mobile</th>
                                <th>Agent Mobile</th>
                                <th>Campaign Status</th>
                                <th>Call Purpose</th>
                                <th>Action</th>
                            </thead>
                        </table>
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
        campaignDataTable();
        $('#filter_by_campaign').on('change', function () {
            campaignDataTable();
        });
        $('#filter_by_agent').on('change', function () {
            campaignDataTable();
        });
        // $('#filter_by_agentGroup').on('change', function () {
        //     campaignDataTable();
        // });  
        $('#filter_by_campaign_status').on('change', function () {
            campaignDataTable();
        });
        $('#filter_by_call_type').on('change', function () {
            campaignDataTable();
        });
        $('#filter_by_call_purpose').on('change', function () {
            campaignDataTable();
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
                campaignDataTable();
            });
            $('input[name="date_range_filter"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                campaignDataTable();
            });
        });

    });
    function campaignDataTable() {
        $('#campaign-DataTable').DataTable().destroy();
        let table = $('#campaign-DataTable');
        table.DataTable(
            {
                order: [['0', 'DESC']],
                serverSide: true,
                responsive: true,
                processing: true,
                ajax: {
                    url: "{{ route('Crm::get_campaign_table') }}",
                    type: 'POST',
                    data: function (d) {
                        d._token = '{{ csrf_token() }}';
                        d.filter_by_campaign = $('#filter_by_campaign').val();
                        d.filter_by_agent = $('#filter_by_agent').val(); 
                        d.filter_by_date_range = $('.filter_by_date_range').val();
                        d.filter_by_campaign_status = $('#filter_by_campaign_status').val();
                        d.filter_by_call_type = $('#filter_by_call_type').val();
                        d.filter_by_call_purpose = $('#filter_by_call_purpose').val();
                    }
                }, 
                columns: [                        
                    {"data": "checkbox", sortable: false, searchable : false},
                    {"data": "name", name: 'leads.name'},
                    {"data": "assigned_to", name: 'users.name'},
                    {"data": "call_status", name: 'manual_logged_call.outcome'},
                    {"data": "lead_mobile", name: 'leads.mobile'},
                    {"data": "user_mobile", name: 'users.mobile'},

                    {"data": "campaign_status", name: 'campaigns.status'},
                    {"data": "call_purpose", name: 'manual_logged_call.call_purpose'},
                    {"data": "action", sortable: false, searchable : false},
                ]
            }
        );
    }

    function campaignAssignedLeadDestroy(id,campaign_id) {
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
                text: "You want to delete this Campaign lead!!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('Crm::campaignAssignedLeadDestroy') }}",
                    data: { "id" : dataid, "campaign_id" : campaign_id },
                    success: function (data) {
                        if (data.campaign_delete == true) {
                            $.NotificationApp.send("Success","Campaign lead deleted successfully.","top-center","green","success");
                            campaignDataTable();
                        }
                    }, error: function (data) {
                        $.NotificationApp.send("Error","Campaign lead not deleted successfully.","top-center","red","error");
                        campaignDataTable();
                    },
                });
            } else if ( result.dismiss === Swal.DismissReason.cancel ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Campaign lead not deleted !',
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
        var filter_by_campaign=$('#filter_by_campaign').val();
        var filter_by_agent=$('#filter_by_agent').val();
        var filter_by_agentGroup=$('#filter_by_agentGroup').val();
        var filter_by_campaign_status=$('#filter_by_campaign_status').val();
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
            $.NotificationApp.send("Error","Please select row first!","top-center","red","error");
            return;
        }
        if($('#check_action').val()!='Select Action') {
            var url="";
            var body={};
            if($('#check_action').val()=='Delete Selected') {
                url="{{ route('Crm::campaign_leads_deleteSelected') }}"
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
                        filter_by_campaign:filter_by_campaign,
                        filter_by_agent:filter_by_agent,
                        filter_by_agentGroup:filter_by_agentGroup,
                        filter_by_campaign_status:filter_by_campaign_status
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        $.NotificationApp.send("Success","Selected data has been deleted.","top-center","green","success");
                        setTimeout(function(){
                            campaignDataTable();
                            //location.reload();
                        }, 3500);
                    }, error: function (data) {console.log(data);
                        $.NotificationApp.send("Error","Selected data hasn't been deleted.","top-center","red","error");
                        setTimeout(function(){
                            campaignDataTable();
                            //location.reload();
                        }, 3500);
                    },
                })
            } else if ($('#check_action').val()=='Export Selected') {
                var query = {
                    "ids": ids,
                    "select_all_option_check":select_all_option_check,
                    "filter_by_campaign":filter_by_campaign,
                    "filter_by_agent":filter_by_agent,
                    "filter_by_agentGroup":filter_by_agentGroup,
                    "filter_by_campaign_status":filter_by_campaign_status
                }
                var url = "{{ route('Crm::exportSelectedCampaignLeads') }}?" + $.param(query)
                window.location = url;
            }
        } else {
            $.NotificationApp.send("Error","Please select action first!","top-center","red","error");
        } 
    });//Assign Selected To Campaign
</script>
@endsection