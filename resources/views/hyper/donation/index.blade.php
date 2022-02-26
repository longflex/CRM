@extends('hyper.layout.master')
@section('title', "Donation List")
@section('content')

<div class="px-2">
    <!-- start page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::donations_report') }}"><i class="uil-home-alt"></i> Donation Report</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
                <h4 class="page-title">Donation List</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <!-- start page content -->
    <div class="row">
        @if(Laralum::hasPermission('laralum.donation.filters'))
        <div class="col-md-3">
            <div class="card">
                <div class="card-body mx-3">
                    <div class="">
                        <h3 class="font-weight-bold"><a class="float-right text-secondary" href="{{ route('Crm::donations') }}" data-toggle="tooltip"
                                title="Reset Filters" data-placement="top"><i class="mdi mdi-refresh-circle"></i></a><i
                                class="dripicons-experiment"></i> Filters</h3>
                    </div>
                    <hr>

                    <div class="form-group">
                        <input type="text" class="form-control donation_date_range"
                            placeholder="Donation Date Range" name="datefilter" value="" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control donation_created_date_range"
                            placeholder="Donation Created Date Range" name="donation_created_date_range" value="" />
                    </div>
                    <div class="form-group">
                        <select class="select2" name="created_by" id="filter_by_created_by" multiple="multiple"
                            data-toggle="select2" data-placeholder="-- Select Created By --">
                            @if(!empty($users))
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ (old('created_by') == $user->id ? 'selected': '') }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="select2" name="location" id="filter_by_location" multiple="multiple"
                            data-toggle="select2" data-placeholder="-- Select Location --">
                            <option value="">-- Select Location --</option>
                            @if(!empty($branches))
                            @foreach($branches as $branch)
                            <option value="{{ $branch->branch }}"
                                {{ (old('location') == $branch->branch ? 'selected': '') }}>
                                {{ $branch->branch }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="select2" name="donation_type" id="filter_by_donation_type" multiple="multiple"
                            data-toggle="select2" data-placeholder="-- Select Donation Type --">
                            <option value="">-- Donation Type --</option>
                            @if(!empty($membertypes))
                            @foreach($membertypes as $type)
                            <option value="{{ $type->type }}"
                                {{ (old('donation_type') == $type->type ? 'selected': '') }}>
                                {{ $type->type }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="select2" name="donation_purpose" id="filter_by_donation_purpose"
                            multiple="multiple" data-toggle="select2" data-placeholder="-- Select Donation Purpose --">
                            <option value="">-- Donation Purpose --</option>
                            @if(!empty($donation_purposes))
                            @foreach($donation_purposes as $donation_purpose)
                            <option value="{{ $donation_purpose->id }}"
                                {{ (old('donation_purpose') == $donation_purpose->purpose ? 'selected': '') }}>
                                {{ $donation_purpose->purpose }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="filter_by_payment_status" name="payment_status" data-toggle="select2"
                            data-placeholder="-- Select Payment Status --">
                            <option value="">-- Payment Status --</option>
                            <option value="1">Paid</option>
                            <option value="0">Not Paid</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="filter_by_payment_type" name="payment_type" data-toggle="select2"
                            data-placeholder="-- Select Payment Type --">
                            <option value="">-- Payment Type --</option>
                            <option value="Single">Single</option>
                            <option value="Recurring">Recurring</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="filter_by_payment_mode" name="payment_mode" data-toggle="select2"
                            multiple="multiple" data-placeholder="-- Select Payment Mode --">
                            <option value="">-- Payment Mode --</option>
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
                    <!-- <div class="form-group">
                        <label>Amount Lower Limit</label>
                        <input class="form-control" id="filter_by_amount_lower_limit" type="number" min="0">
                    </div>
                    <div class="form-group">
                        <label>Amount Upper Limit</label>
                        <input class="form-control" id="filter_by_amount_upper_limit" type="number" min="0">
                    </div> -->
                    <div class="form-group">
                        <select id="filter_by_when_will_donate" name="when_will_donate" data-toggle="select2"
                            data-placeholder="-- When Will Donate --">
                            <option value="">-- When Will Donate --</option>
                            <option value="0">Now</option>
                            <option value="1">Will Donate</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="filter_by_donation_decision_type" class="form-control select2" multiple="multiple" data-toggle="select2" data-placeholder="Willing To Donate">
                            <option value="">Willing To Donate</option>
                            <option value="As soon As Possible" >As soon As Possible</option>
                            <option value="This Week">This Week</option>
                            <option value="This Year">This Year</option>
                            <option value="Next Year">Next Year</option>
                            <option value="online">online</option>
                            <option value="Jan">Jan</option>
                            <option value="Feb">Feb</option>
                            <option value="Mar">Mar</option>
                            <option value="Apr">Apr</option>
                            <option value="May">May</option>
                            <option value="Jun">Jun</option>
                            <option value="July">July</option>
                            <option value="Aug">Aug</option>
                            <option value="Sep">Sep</option>
                            <option value="Oct">Oct</option>
                            <option value="Nov">Nov</option>
                            <option value="Dec">Dec</option>
                        </select>
                    </div>
                    <div class="form-group" style="display: none;">
                        <select id="filter_by_campaign" class="form-control select2" name="campaign" data-toggle="select2"
                            data-placeholder="-- Select Campaign --" >
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
                        <select id="filter_by_gift_issued" class="form-control select2" data-toggle="select2"
                            data-placeholder="-- Gift Issued --">
                            <option value="">Please select..</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
        @else
        <div class="col-lg-12">
        @endif    
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="custom-select" id="check_action"
                                        aria-label="Example select with button addon">
                                        <option value="Select Action" selected>Select Action</option>
                                        <option value="Assign Selected To Campaign">Assign Selected To Campaign</option>
                                        <option value="Export Selected">Export Selected</option>
                                        <option value="Delete Selected">Delete Selected</option>
                                        @if(Laralum::hasPermission('laralum.member.sendsms'))
                                        <option value="Send Sms">Send Sms</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-3" id="assign_to_campaign_section"> 
                                    <select class="select2 select2-multiple" id="assign_to_campaign" data-toggle="select2" data-placeholder="Choose Campaigns">
                                        <option value=''>Choose Campaign</option>
                                        @if(!empty($campaigns))
                                        @foreach ($campaigns as $campaign)
                                        <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-3" id="select_all_section">
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input type="checkbox" class="custom-control-input select_all_option"
                                            id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">Select All</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-primary" id='action_btn'>Go <i class="mdi mdi-arrow-right-bold"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 float-right">
                            @if(Laralum::hasPermission('laralum.donation.create'))
                            {{-- <a href="#" class="btn btn-primary float-right" id="Export"><i class="uil-upload mr-1"></i><span>{{ trans('laralum.export') }}</span></a>
                            --}}
                            <a class="btn btn-light float-right" href="{{ route('Crm::donation_import_show') }}"
                                title="{{ trans('laralum.import') }}"><i class="uil-cloud-upload"></i></a>
                            <!-- <a href="{{ route('Crm::donation_export', ['member_id' => 0]) }}" class="btn btn-light float-right mr-1" title="{{ trans('laralum.export') }}"><i class="uil-upload float-right"></i></a> -->
                            <a class="btn btn-danger float-right mr-1" href="{{ route('Crm::donation_create') }}"><i class="uil-plus-circle"></i></a>
                            @endif
                            <button type="button" class="btn btn-light float-right mr-1">Total Amount = <span id="total_amount"></span></button>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group mt-2">
                        <!-- <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="dataTables_length" >
                                    <label>
                                        Show 
                                        <select name="donationAdminDataTable_length" aria-controls="donationAdminDataTable" class="custom-select custom-select-sm form-control form-control-sm">
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
                                <div id="donationAdminDataTable_filter" class="dataTables_filter">
                                <label style="float: right;">Search : <input type="search" id="serach" class="form-control form-control-sm" placeholder="" aria-controls="donationAdminDataTable">
                                </label>
                                </div>
                            </div>
                        </div> -->
                        <div class="table-responsive">
                            <table class="table dt-responsive nowrap w-100" id="donationAdminDataTable">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll" value=true></th>
                                        <th>Id</th>
                                        <th>Receipt No</th>
                                        <th>Donated By</th>
                                        <!-- <th>Created By</th> -->
                                        <th>Donation Type</th>
                                        <th>Purpose</th>
                                        <th>Amount</th>
                                        <th>Payment Mode</th>
                                        <th>Payment Type</th>
                                        <th>Status</th>
                                        <th>Location</th>
                                        <th>Donation Date</th>
                                        <th>Created Date</th>
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
</div>





@endsection
@section('extrascripts')
<script>
$(document).ready(function() {
    $('#assign_to_campaign_section').hide();
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
        text: "You want to delete this Donation !!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "GET",
                url: "{{ route('Crm::donation_delete_post') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": dataid
                },
                success: function(data) {
                    $.NotificationApp.send("Success", "Donation has been deleted.", "top-center",
                        "green", "success");
                    setTimeout(function() {
                        location.reload();
                    }, 3500);
                },
                error: function(data) {
                    $.NotificationApp.send("Error", "Donation has not been deleted.", "top-center",
                        "red", "error");
                    setTimeout(function() {
                        location.reload();
                    }, 3500);
                },
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire(
                'Cancelled',
                'Donation not deleted !',
                'error'
            )
        }
    });
}
</script>
<script>
$('#selectAll').click(function(e) {
    var table = $(e.target).closest('table');
    $('td input:checkbox', table).prop('checked', this.checked);
});
$("#action_btn").click(function() {
    var ids = [];
    var lead_ids = [];

    var select_all_option_check = 0;
    var filter_by_payment_mode = $('#filter_by_payment_mode').val();
    var filter_by_donation_type = $('#filter_by_donation_type').val();
    var filter_donation_date_range = $('.donation_date_range').val();
    var filter_by_created_by = $('#filter_by_created_by').val();
    var filter_by_location = $('#filter_by_location').val();
    var filter_by_donation_purpose = $('#filter_by_donation_purpose').val();
    var filter_by_payment_status = $('#filter_by_payment_status').val();
    var filter_by_payment_type = $('#filter_by_payment_type').val();
    //var filter_by_amount_lower_limit = $('#filter_by_amount_lower_limit').val();
    //var filter_by_amount_upper_limit = $('#filter_by_amount_upper_limit').val();
    var filter_by_when_will_donate = $('#filter_by_when_will_donate').val();
    var filter_by_donation_created_date_range = $('.donation_created_date_range').val();

    if ($(".select_all_option").prop('checked') == true) {
        select_all_option_check = 1;
    } else {
        select_all_option_check = 0;
        ids = [];
        lead_ids = [];
        //var table = $(e.target).closest('table');
        //$('#mytable').find('input[type="checkbox"]:checked').each(function () {
       //this is the current checkbox
    //});
        $('#donationAdminDataTable').find('input[type=checkbox]:checked').each(function(i, val) {
            if (val.id != 'selectAll'){
              //alert(val.id);return;
                var valArr = (val.id).split("_"); 

                ids.push(valArr[0]);
                lead_ids.push(valArr[1]);  
            }
               
        });
    }
    //alert(ids);return;
    if (ids.length == 0 && select_all_option_check == 0) {
        $('.dimmer').removeClass('dimmer');
        $.NotificationApp.send("Error", "Please select rows first!", "top-center", "red", "error");
        return;
    }
    if ($('#check_action').val() != 'Select Action') {
        var url = "";
        var body = {};
        if ($('#check_action').val() == 'Delete Selected') {
            url = "{{ route('Crm::donations_deleteSelected') }}"
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    ids: ids,
                    select_all_option_check: select_all_option_check,
                    filter_by_payment_mode: filter_by_payment_mode,
                    filter_by_donation_type: filter_by_donation_type,
                    filter_donation_date_range: filter_donation_date_range,
                    filter_by_created_by: filter_by_created_by,
                    filter_by_location: filter_by_location,
                    filter_by_donation_purpose: filter_by_donation_purpose,
                    filter_by_payment_status: filter_by_payment_status,
                    filter_by_payment_type: filter_by_payment_type,
                    filter_by_when_will_donate: filter_by_when_will_donate,
                    filter_by_donation_created_date_range : filter_by_donation_created_date_range
                },
                success: function(data) {
                    $.NotificationApp.send("Success", "Selected data has been deleted.",
                        "top-center", "green", "success");
                    setTimeout(function() {
                        location.reload();
                    }, 3500);
                },
                error: function(data) {
                    $.NotificationApp.send("Error", "Selected data not has been deleted.",
                        "top-center", "red", "error");
                    setTimeout(function() {
                        location.reload();
                    }, 3500);
                },
            })
        } else if ($('#check_action').val() == 'Export Selected') {
            var query = {
                ids: ids,
                select_all_option_check: select_all_option_check,
                filter_by_payment_mode: filter_by_payment_mode,
                filter_by_donation_type: filter_by_donation_type,
                filter_donation_date_range: filter_donation_date_range,
                filter_by_created_by: filter_by_created_by,
                filter_by_location: filter_by_location,
                filter_by_donation_purpose: filter_by_donation_purpose,
                filter_by_payment_status: filter_by_payment_status,
                filter_by_payment_type: filter_by_payment_type,
                filter_by_when_will_donate: filter_by_when_will_donate,
                filter_by_donation_created_date_range: filter_by_donation_created_date_range,
                client_id: ""
            }
            var url = "{{route('Crm::exportSelectedDonations')}}?" + $.param(query);
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
                        text: "You want to assign donation leads to campaign ?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Confirm!',
                        cancelButtonText: 'No, cancel!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('Crm::assign.donation.lead.campaign') }}",
                                data: {
                                    "_token": "{{ csrf_token() }}","campaigns": cid,"leads": lead_ids,
                                    "select_all_option_check":select_all_option_check,
                                    "filter_by_payment_mode": filter_by_payment_mode,
                                    "filter_by_donation_type": filter_by_donation_type,
                                    "filter_donation_date_range": filter_donation_date_range,
                                    "filter_by_created_by": filter_by_created_by,
                                    "filter_by_location": filter_by_location,
                                    "filter_by_donation_purpose": filter_by_donation_purpose,
                                    "filter_by_payment_status": filter_by_payment_status,
                                    "filter_by_payment_type": filter_by_payment_type,
                                    "filter_by_when_will_donate": filter_by_when_will_donate,
                                    "filter_by_donation_created_date_range": filter_by_donation_created_date_range
                                },
                                success: function (data) {
                                    $.NotificationApp.send("Success","Donation leads assigned to campaign.","top-center","green","success");
                                    setTimeout(function(){
                                    }, 3500);
                                    //leadDataTable();
                                }, error: function (data) {
                                    $.NotificationApp.send("Error","Donation leads not assigned to campaign.","top-center","red","error");
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
                }else{//
                    $.NotificationApp.send("Error","Please select agent first !","top-center","red","error");
                }     
            } else {
            $('#sms_ids').val(ids);
            $('#SendSms').modal('show');
        }

    } else {
        $.NotificationApp.send("Error", "Please select action first!", "top-center", "red", "error");
    }
    $('.dimmer').removeClass('dimmer');

});
</script>
<script>
function totalAmount() {
    var filter_by_payment_mode = $('#filter_by_payment_mode').val();
    var filter_by_donation_type = $('#filter_by_donation_type').val();
    var filter_donation_date_range = $('.donation_date_range').val();
    var filter_by_created_by = $('#filter_by_created_by').val();
    var filter_by_location = $('#filter_by_location').val();
    var filter_by_donation_purpose = $('#filter_by_donation_purpose').val();
    var filter_by_payment_status = $('#filter_by_payment_status').val();
    var filter_by_payment_type = $('#filter_by_payment_type').val();
    //var filter_by_amount_lower_limit = $('#filter_by_amount_lower_limit').val();
    //var filter_by_amount_upper_limit = $('#filter_by_amount_upper_limit').val();
    var filter_by_when_will_donate = $('#filter_by_when_will_donate').val();
    var filter_by_campaign = $('#filter_by_campaign').val();
    var filter_by_donation_decision_type = $('#filter_by_donation_decision_type').val();
    var filter_by_donation_created_date_range = $('.donation_created_date_range').val();
    $.ajax({ 
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: "{{route('Crm::totalAmountAdminDonations')}}",
            data: {
                _token: "{{ csrf_token() }}",
                filter_by_payment_mode: filter_by_payment_mode,
                filter_by_donation_type: filter_by_donation_type,
                filter_donation_date_range: filter_donation_date_range,
                filter_by_created_by: filter_by_created_by,
                filter_by_location: filter_by_location,
                filter_by_donation_purpose: filter_by_donation_purpose,
                filter_by_payment_status: filter_by_payment_status,
                filter_by_payment_type: filter_by_payment_type,
                filter_by_when_will_donate: filter_by_when_will_donate,
                filter_by_campaign: filter_by_campaign,
                filter_by_donation_decision_type : filter_by_donation_decision_type,
                filter_by_donation_created_date_range : filter_by_donation_created_date_range
            },
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
        // using the done promise callback
        .done(function(data) { // reminders


            //var num = 5.567;
            var n = data.total_amount.toFixed(0);
            const n1 = String(n).replace(/(.)(?=(\d{3})+$)/g, '$1,');
            $('#total_amount').text('₹' + n1);
        })
        // using the fail promise callback
        .fail(function(data) {
            console.log(data);
        });
}
$(function() {
    $('input[name="datefilter"]').daterangepicker({
        autoUpdateInput: false,
        applyButtonClasses: 'btn btn-warning',
        drops: ('up'),
        autoApply: false,
        locale: {
            cancelLabel: 'Clear',
        }
    });
    $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
        'MM/DD/YYYY'));
        setFiltersValue();
        donationAdminDataTable();
    });
    $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        setFiltersValue();
        donationAdminDataTable();
    });
});

$(function() {
    $('input[name="donation_created_date_range"]').daterangepicker({
        autoUpdateInput: false,
        applyButtonClasses: 'btn btn-warning',
        drops: ('up'),
        autoApply: false,
        locale: {
            cancelLabel: 'Clear',
        }
    });
    $('input[name="donation_created_date_range"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
        'MM/DD/YYYY'));
        setFiltersValue();
        donationAdminDataTable();
    });
    $('input[name="donation_created_date_range"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        setFiltersValue();
        donationAdminDataTable();
    });
});
</script>
<script>
function setFiltersValue() {
    var urlParams = new URLSearchParams(window.location.search);
    var campaign = urlParams.get('campaign');
    var agent = urlParams.get('agent');
    var startdate = urlParams.get('startdate');
    var enddate = urlParams.get('enddate');
    var will_donate = urlParams.get('will_donate');

    if (urlParams.has('agent')) {
        $('#filter_by_created_by').val(agent);
        $('#filter_by_created_by').trigger('change');
        
    }
    if (urlParams.has('startdate') && urlParams.has('enddate') && startdate != "" && enddate != "") {
        //var datesData = dates.split(" - ");
        $('.donation_created_date_range').daterangepicker({
            startDate: startdate,
            endDate: enddate
        });
    }
    if (urlParams.has('will_donate')) {
        $('#filter_by_when_will_donate').val('1'); // Select the option with a value of '1'
        $('#filter_by_when_will_donate').trigger('change'); // Notify any JS components that the value changed
    }
    if (urlParams.has('campaign')) {
        $('#filter_by_campaign').val(campaign); // Select the option with a value of '1'
        $('#filter_by_campaign').trigger('change'); // Notify any JS components that the value changed
    }
}
$(document).ready(function() {
    setFiltersValue();
    donationAdminDataTable();

    $('#filter_by_donation_type').on('change', function() {
        donationAdminDataTable();
    });
    $('#filter_by_payment_mode').on('change', function() {
        donationAdminDataTable();
    });

    $('#filter_by_created_by').on('change', function() {
        donationAdminDataTable();
    });
    $('#filter_by_location').on('change', function() {
        donationAdminDataTable();
    });
    $('#filter_by_donation_purpose').on('change', function() {
        donationAdminDataTable();
    });
    $('#filter_by_payment_status').on('change', function() {
        donationAdminDataTable();
    });
    $('#filter_by_payment_type').on('change', function() {
        donationAdminDataTable();
    });
    // $('.filter_by_amount_range').on('change', function () {
    //     donationAdminDataTable();
    //     //alert($('.filter_by_amount_range').val());
    // });
    // $('#filter_by_amount_lower_limit').on('change', function() {
    //     donationAdminDataTable();
    // });
    // $('#filter_by_amount_upper_limit').on('change', function() {
    //     donationAdminDataTable();
    // });
    $("#filter_by_amount_upper_limit").on("keyup", function() {
        donationAdminDataTable();
    });
    $("#filter_by_when_will_donate").on("change", function() {
        donationAdminDataTable();
    });
    $("#filter_by_campaign").on("change", function() {
        donationAdminDataTable();
    });
    $("#filter_by_donation_decision_type").on("change", function() {
        donationAdminDataTable();
    });
    $("#filter_by_gift_issued").on("change", function() {
        donationAdminDataTable();
    });
});
function donationAdminDataTable() {
    $('#donationAdminDataTable').DataTable().destroy();
    let table = $('#donationAdminDataTable');
    totalAmount();
    table.DataTable(
        {
            order: [['1', 'desc']],
            lengthMenu: [[10, 25, 50, 100, 500, 1000], [10, 25, 50, 100, 500, 1000]],
            serverSide: true,
            responsive: true,
            processing: true,
            ajax: {
                url: "{{ route('Crm::get.admin.donation') }}",
                type: 'POST',
                data: function (d) {

                        d._token = '{{csrf_token()}}';
                        d.filter_by_payment_mode = $('#filter_by_payment_mode').val();
                        d.filter_by_donation_type = $('#filter_by_donation_type').val();                       
                        d.filter_donation_date_range = $('.donation_date_range').val();
                        d.filter_by_created_by = $('#filter_by_created_by').val();
                        d.filter_by_location = $('#filter_by_location').val();
                        d.filter_by_donation_purpose = $('#filter_by_donation_purpose').val();
                        d.filter_by_payment_status = $('#filter_by_payment_status').val();
                        d.filter_by_payment_type = $('#filter_by_payment_type').val();
                        d.filter_by_when_will_donate = $('#filter_by_when_will_donate').val();
                        d.filter_by_campaign = $('#filter_by_campaign').val();
                        d.filter_by_donation_decision_type = $('#filter_by_donation_decision_type').val();
                        d.filter_by_gift_issued = $('#filter_by_gift_issued').val();
                        d.donation_created_date_range = $('.donation_created_date_range').val();
                    },  
            },
            columns: [
                {data: "checkbox", sortable: false, searchable : false},
                {data: "donation_id", name: 'donations.id'},
                {data: "receipt_number", name: 'donations.receipt_number', searchable : false},
                {data: "donated_by", name: 'leads.name', searchable : false},
                // {data: "created_by", name: 'users.name', searchable : false},
                {data: "donation_type", name: 'donations.donation_type', searchable : false},
                {data: "purpose", name: 'donation_purpose.purpose', searchable : false},
                //{data: "phone", name: 'leads.mobile'},
                {data: "amount", name: 'donations.amount', searchable : false},
                {data: "mode", name: 'donations.payment_mode', searchable : false},
                {data: "payment_type", name: 'donations.payment_type', searchable : false},
                {data: "status", name: 'donations.payment_status', searchable : false},
                {data: "location", name: 'donations.location', searchable : false},
                {data: "date", name: 'donations.donation_date', searchable : false},
                {data: "created_date", name: 'donations.created_at', searchable : false},
                {data: "action", sortable: false, searchable : false},
            ]
        }
    );
}


// $(document).ready(function() {
//     $('#donationAdminDataTable').DataTable().destroy();
//     let table = $('#donationAdminDataTable');
//     //let id = '';
//     table.DataTable({
//         responsive: true,
//         processing: true,
//         ajax: {
//             url: "{{ route('Crm::get.admin.donation') }}",
//             type: 'POST',
//             data: {_token: "{{ csrf_token() }}"},
//         },
//         columns: [
//             {"data": "receipt_number"},
//             {"data": "donated_by"},
//             {"data": "payment_type"},
//             {"data": "purpose"},
//             {"data": "phone"},
//             {"data": "amount"},
//             {"data": "mode"},
//             {"data": "status"},
//             {"data": "location"},
//             {"data": "date"},
//             {"data": "action", sortable: false},
//         ]
//     });
// });

// $(document).on('keyup', '#serach', function(){
//     var query = $('#serach').val();
//     var column_name = $('#hidden_column_name').val();
//     var sort_type = $('#hidden_sort_type').val();
//     var page = $('#hidden_page').val();
//     donationAdminDataTable(page, sort_type, column_name, query);
// });

// function donationAdminDataTable1(page = 1, sort_type = "asc" , sort_by = "id", search_query = "") {
//     totalAmount();
//     $.ajax({
//         method: "POST",
//         url: "{{ route('Crm::get.admin.donation') }}",
//         data: {
//             _token: "{{ csrf_token() }}",
//             page : page,
//             search_query : search_query,
//             filter_by_payment_mode : $('#filter_by_payment_mode').val(),
//             filter_by_donation_type : $('#filter_by_donation_type').val(),                       
//             filter_donation_date_range : $('.donation_date_range').val(),
//             filter_by_created_by : $('#filter_by_created_by').val(),
//             filter_by_location : $('#filter_by_location').val(),
//             filter_by_donation_purpose : $('#filter_by_donation_purpose').val(),
//             filter_by_payment_status : $('#filter_by_payment_status').val(),
//             filter_by_payment_type : $('#filter_by_payment_type').val(),
//             filter_by_amount_lower_limit : $('#filter_by_amount_lower_limit').val(),
//             filter_by_amount_upper_limit : $('#filter_by_amount_upper_limit').val(),
//             filter_by_when_will_donate : $('#filter_by_when_will_donate').val(),
//             filter_by_campaign : $('#filter_by_campaign').val(),
//         }
//     }).done(function(data) {
//         $('tbody').html('');
//         $('tbody').html(data);
//     });
// }

// $(document).on('click', '.pagination a', function(event){
//     event.preventDefault();
//     var page = $(this).attr('href').split('page=')[1];
//     $('#hidden_page').val(page);
//     var column_name = $('#hidden_column_name').val();
//     var sort_type = $('#hidden_sort_type').val();

//     var query = $('#serach').val();

//     $('li').removeClass('active');
//     $(this).parent().addClass('active');
//     donationAdminDataTable(page, sort_type, column_name, query);
// });
</script>
@endsection