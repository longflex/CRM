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
                        
                        <li class="breadcrumb-item"><a href="{{ route('Crm::donations') }}"><i class="uil-home-alt"></i>Donation</a></li>
                        <li class="breadcrumb-item active">Reports</li>
                    </ol>
                </div>
                <h4 class="page-title">Donation Reports</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <!-- start page content -->
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body mx-3">
                    <div class="">
                        <h3 class="font-weight-bold"><a class="float-right text-secondary" href="" data-toggle="tooltip"
                                title="Reset Filters" data-placement="top"><i class="mdi mdi-refresh-circle"></i></a><i
                                class="dripicons-experiment"></i> Filters</h3>
                    </div>
                    <hr>
                    <div class="form-group">
                        <input type="text" class="form-control donation_date_range"
                            placeholder="Donation Date Range" readonly name="datefilter" value="" />
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
                        <label>Amount Lower Limit</label>
                        <input class="form-control" id="filter_by_amount_lower_limit" type="number" min="0">
                    </div>
                    <div class="form-group">
                        <label>Amount Upper Limit</label>
                        <input class="form-control" id="filter_by_amount_upper_limit" type="number" min="0">
                    </div>
                    <div class="form-group">
                        <select id="filter_by_top_sponsor" name="top_sponsor" data-toggle="select2"
                            data-placeholder="-- Select Sponsors --">
                            <option value="">-- Top Sponsors --</option>
                            <option value="10">Top 10 Sponsors</option>
                            <option value="20">Top 20 Sponsors</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" id="filter_by_donations_count" placeholder="donations count"/>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3"><input type="checkbox" class="form-control" id="filter_by_donations_count_type" placeholder="donations count +"/></div>
                            <div class="col-md-9 mt-1"><label for="donationscounttypefilter">Donations Count +</label></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="form-group mt-2"> 
                        <div class="table-responsive">
                            <table class="table dt-responsive nowrap w-100" id="donationReportDataTable">
                                <thead>
                                    <tr>
                                        <th>Created By</th>
                                        <th>Donation Count</th>
                                        <th>Total Amount</th>
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
        //setFiltersValue();
        donationReportDataTable();
    });
    $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        //setFiltersValue();
        donationReportDataTable();
    });
});



$(document).ready(function() {
    //setFiltersValue();
    donationReportDataTable();

    $('#filter_by_donations_count').on('keyup',function() {
        donationReportDataTable();
    });

    $('#filter_by_donations_count_type').on('change',function() {
        donationReportDataTable();
    });

    $('#filter_by_location').on('change', function() {
        donationReportDataTable();
    });

    $('#filter_by_top_sponsor').on('change', function() {
        donationReportDataTable();
    });
    
    // $('.filter_by_amount_range').on('change', function () {
    //     donationAdminDataTable();
    //     //alert($('.filter_by_amount_range').val());
    // });
    $('#filter_by_amount_lower_limit').on('keyup', function() {
        donationReportDataTable();
    });
    $('#filter_by_amount_upper_limit').on('keyup', function() {
        donationReportDataTable();
    });
    $("#filter_by_amount_upper_limit").on("keyup", function() {
        donationReportDataTable();
    });
});
function donationReportDataTable() {
    $('#donationReportDataTable').DataTable().destroy();
    let table = $('#donationReportDataTable');
    let checkboxData = 0;
    if ($("#filter_by_donations_count_type").is(":checked")) {
        checkboxData = 1;
    }
    table.DataTable(
        {
            order: [['1', 'desc']],
            lengthMenu: [[10, 25, 50, 100, 500, 1000], [10, 25, 50, 100, 500, 1000]],
            serverSide: true,
            responsive: true,
            processing: true,
            ajax: {
                url: "{{ route('Crm::get_admin_donation_reports') }}",
                type: 'POST',
                data: function (d) {
                        d._token = '{{csrf_token()}}';
                        d.filter_by_amount_lower_limit = $('#filter_by_amount_lower_limit').val(),
                        d.filter_by_amount_upper_limit = $('#filter_by_amount_upper_limit').val(),
                        d.filter_by_donations_count=$('#filter_by_donations_count').val();
                        d.filter_donation_date_range = $('.donation_date_range').val();
                        d.filter_by_location = $('#filter_by_location').val();
                        d.filter_by_top_sponsor = $('#filter_by_top_sponsor').val();
                        d.filter_by_donations_count_type=checkboxData;
                    },  
            },
            columns: [
                {data: "created_by", name: 'leads.name'},
                {data: "donation_count", name: 'totD', sType: "numeric"},
                {data: "total_amount", name: 'donationCount', sType: "numeric"}
            ]
        }
    );
}

</script>
@endsection