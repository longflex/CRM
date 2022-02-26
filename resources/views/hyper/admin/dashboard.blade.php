@extends('hyper.layout.master')
@section('title', "Dashboard")

@if(Laralum::hasPermission('laralum.admin.dashboard'))
@section('content')

<div class="col-xl-12">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <form class="form-inline">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-light" id="dash-daterange">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-primary border-primary text-white">
                                        <i class="mdi mdi-calendar-range font-13"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <a href="javascript: void(0);" class="btn btn-primary ml-2">
                            <i class="mdi mdi-autorenew"></i>
                        </a>
                        <a href="javascript: void(0);" class="btn btn-primary ml-1">
                            <i class="mdi mdi-filter-variant"></i>
                        </a>
                    </form>
                </div>
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-5 col-lg-6">

            <div class="row">
                <div class="col-lg-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-account-multiple widget-icon"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Number of Customers">
                                Total Members</h5>
                            <h3 class="mt-3 mb-3">{{$total_members}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i>
                                    5.27%</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
                @if(Laralum::permissionToAccessModule() === true)
                <div class="col-lg-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-account-multiple widget-icon"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Number of Orders">
                                Permanent</h5>
                            <h3 class="mt-3 mb-3">{{$total_permanent_members}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i>
                                    1.08%</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-lg-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-account-multiple widget-icon"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Number of Orders">
                                Temporary</h5>
                            <h3 class="mt-3 mb-3">{{$total_temporary_members}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i>
                                    1.08%</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
                @endif
            </div> <!-- end row -->
            @if(Laralum::permissionToAccessModule() === true)
            <div class="row">
                <div class="col-lg-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-account-multiple widget-icon"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Average Revenue">
                                Partners</h5>
                            <h3 class="mt-3 mb-3">{{$partners}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i>
                                    7.00%</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-lg-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-account-multiple widget-icon"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Growth">Sponsors</h5>
                            <h3 class="mt-3 mb-3">{{$sponsors}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i>
                                    4.87%</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-lg-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-account-multiple widget-icon"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Growth">CST</h5>
                            <h3 class="mt-3 mb-3">{{(isset($cst) && $cst) ? $cst : 'NA'}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i>
                                    4.87%</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div> <!-- end row -->
            @endif
        </div> <!-- end col -->
        @if(Laralum::permissionToAccessModule() === true)
        <div class="col-xl-7  col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown float-right">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown"
                            aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Today</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Yesterday</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Last 7 Days</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Last 30 Days</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">This Month</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Custom Range</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Export</a>
                        </div>
                    </div>
                    <h4 class="header-title mb-3">Permanent Vs Temporary Members</h4>

                    <div id="high-performing-product" class="apex-charts" data-colors="#727cf5,#e3eaef">
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
        @endif
    </div>
    <!-- end row -->
    @if(Laralum::permissionToAccessModule() === true)
    <div class="row">


        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <h4 class="header-title mb-3">Donations</h4>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-1">
                                        <input type="text" class="form-control date filter_by_current_Date" placeholder="-- Filter By Current Date Range --" title="-- Filter By Current Date Range --" name="filter_by_current_Date" value="" />
                                        <div class="input-group-append">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-1">
                                        <input type="text" class="form-control date filter_by_previous_Date" placeholder="-- Filter By Previous Date Range --" title="-- Filter By Previous Date Range --" name="filter_by_previous_Date" value="" />
                                        <div class="input-group-append">
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:void(0);" data-value="current-week" class="dropdown-item donation">Current Week vs Previous
                                        Week</a>
                                    <a href="javascript:void(0);" data-value="current-month" class="dropdown-item donation">Current Month vs
                                        Previous Month</a>
                                    <a href="javascript:void(0);" data-value="current-year" class="dropdown-item donation">Current Year vs Previous
                                        Year</a>
                                    <a href="javascript:void(0);" data-value="date-range" class="dropdown-item donation">Current vs Previous
                                        Date Range</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="donation-graph"></div>
                </div>
            </div>
        </div>






        
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div data-simplebar style="height: 540px;">
                        <!-- <div class="dropdown float-right">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown"
                                aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div> -->
                        <h4 class="header-title">Donations By Location</h4>
                        <div class="mb-4 mt-4">
                            <div id="world-map-markers" style="height: 224px"></div>
                        </div>
                        @php
                        $donationsByLocationsSum = 0;
                        if(!empty($donationsByLocations)){
                            foreach($donationsByLocations as $val){
                                $donationsByLocationsSum = $donationsByLocationsSum + $val->branchTotalDonation;
                            }
                        }
                        @endphp

                        @forelse($donationsByLocations as $donationsByLocation)
                        <h5 class="mb-1 mt-0 font-weight-normal">{{$donationsByLocation->branch}}</h5>
                        <div class="progress-w-percent">
                            <div class="row">
                                <div class="col-md-9">
                                   <div class="progress progress-sm">
                                        <div class="progress-bar" role="progressbar" style="width: {{(100 * ($donationsByLocation->branchTotalDonation))/($donationsByLocationsSum)}}%;" aria-valuenow="{{(100 * ($donationsByLocationsSum - $donationsByLocation->branchTotalDonation))/($donationsByLocationsSum)}}"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div> 
                                </div>
                                <div class="col-md-3">
                                    <p>₹{{number_format($donationsByLocation->branchTotalDonation)}}</p>
                                </div>
                            </div>
                            
                            
                        </div>
                        @empty
                        <div>No Data Found.</div>
                        @endforelse
                    </div>
                    
                </div>
            </div>
        </div> 
    </div>
    @endif
    <!-- end row -->

    @if(Laralum::permissionToAccessModule() === true)                    
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-7">
            <div class="card">
                <div class="card-body">
                    <div data-simplebar style="height: 340px;">
                        <div class="row">
                            <div class="col-md-5">
                                <h4 class="header-title mt-2">Sponsors by Categories</h4>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control date filter_by_Date" placeholder="-- Filter By Date Range --" title="-- Filter By Date Range --" name="filter_by_Date" value="" />
                                    <div class="input-group-append">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="dropdown float-right mt-1">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="javascript:void(0);" data-value="1" class="dropdown-item sponsorCatDonation">Current Date</a>
                                        <a href="javascript:void(0);" data-value="2" class="dropdown-item sponsorCatDonation">Current Month</a>
                                        <a href="javascript:void(0);" data-value="3" class="dropdown-item sponsorCatDonation">Current Year</a>
                                    </div>
                                </div>
                                <a href="" class="btn btn-sm btn-link float-right mb-3">Export
                                    <i class="mdi mdi-download ml-1"></i>
                                </a>  
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table w-100 dt-responsive nowrap" id="sponsor-category-datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Category</th>
                                        <th>Registered Users</th>
                                        <th>Revenue</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 order-lg-1">
            <div class="card">
                <div class="card-body">
                    <!-- <div class="dropdown float-right">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown"
                            aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        </div>
                    </div> -->
                    <h4 class="header-title">Graph by Category</h4>

                    <div id="average-sales" class="apex-charts mb-4 mt-4" data-colors="#727cf5,#0acf97,#fa5c7c,#ffbc00">
                    </div>

                    <!-- <div data-simplebar style="max-height: 151px;">
                        <div class="chart-widget-list">
                            <p>
                                <i class="mdi mdi-square text-primary"></i> Aradhana Channel
                                <span class="float-right">$300.56</span>
                            </p>
                            <p>
                                <i class="mdi mdi-square text-danger"></i> Nirikshana
                                <span class="float-right">$135.18</span>
                            </p>
                            <p>
                                <i class="mdi mdi-square text-success"></i> Ee TV
                                <span class="float-right">$48.96</span>
                            </p>
                            <p class="mb-0">
                                <i class="mdi mdi-square text-warning"></i> Land Donors
                                <span class="float-right">$154.02</span>
                            </p>
                            <p class="mb-0">
                                <i class="mdi mdi-square text-warning"></i> Land Donors
                                <span class="float-right">$154.02</span>
                            </p>
                            <p class="mb-0">
                                <i class="mdi mdi-square text-warning"></i> Land Donors
                                <span class="float-right">$154.02</span>
                            </p>
                            <p class="mb-0">
                                <i class="mdi mdi-square text-warning"></i> Land Donors
                                <span class="float-right">$154.02</span>
                            </p>
                            <p class="mb-0">
                                <i class="mdi mdi-square text-warning"></i> Land Donors
                                <span class="float-right">$154.02</span>
                            </p>
                            <p class="mb-0">
                                <i class="mdi mdi-square text-warning"></i> Land Donors
                                <span class="float-right">$154.02</span>
                            </p>
                            <p class="mb-0">
                                <i class="mdi mdi-square text-warning"></i> Land Donors
                                <span class="float-right">$154.02</span>
                            </p>
                            <p class="mb-0">
                                <i class="mdi mdi-square text-warning"></i> Land Donors
                                <span class="float-right">$154.02</span>
                            </p>
                            <p class="mb-0">
                                <i class="mdi mdi-square text-warning"></i> Land Donors
                                <span class="float-right">$154.02</span>
                            </p>
                            <p class="mb-0">
                                <i class="mdi mdi-square text-warning"></i> Land Donors
                                <span class="float-right">$154.02</span>
                            </p>
                        </div>
                        
                    </div> -->
                </div> 
            </div> 
        </div>

        <div class="col-xl-3 col-lg-3 order-lg-1">
            <div class="card">
                <div class="card-body">
                    <div data-simplebar style="height: 340px;">
                        <h4 class="header-title mb-2">Subscription List</h4>
                        <div data-simplebar style="max-height: 424px;">
                            <div class="chart-widget-list">
                                @forelse($subscriptionList as $subscription)
                                <p>
                                    <i class="mdi mdi-square text-primary"></i> {{$subscription->purpose}}
                                    <span class="float-right">₹{{number_format($subscription->totalDonation)}}</span>
                                </p>
                                @empty
                                <div>No Data Found.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    @endif
</div>
@else
@section('content')
@endif
@endsection

@if(Laralum::hasPermission('laralum.admin.dashboard'))
@section('extrascripts')


<script>
$(document).ready(function(){
    sponsorCategoryDataTable(1);
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
            sponsorCategoryDataTable(4);
        });
        $('input[name="filter_by_Date"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            sponsorCategoryDataTable(1);
        });
    });
    $(function() {
        $('input[name="filter_by_current_Date"]').daterangepicker({
            autoUpdateInput: false,
            applyButtonClasses: 'btn btn-warning',
            drops: ('down'),
            autoApply: false,
            locale: {
                cancelLabel: 'Clear',
            }
        });
        $('input[name="filter_by_current_Date"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            //sponsorCategoryDataTable(1);
        });
        $('input[name="filter_by_current_Date"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            //sponsorCategoryDataTable(1);
        });
    });
    $(function() {
        $('input[name="filter_by_previous_Date"]').daterangepicker({
            autoUpdateInput: false,
            applyButtonClasses: 'btn btn-warning',
            drops: ('down'),
            autoApply: false,
            locale: {
                cancelLabel: 'Clear',
            }
        });
        $('input[name="filter_by_previous_Date"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            //sponsorCategoryDataTable(1);
        });
        $('input[name="filter_by_previous_Date"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            //sponsorCategoryDataTable(1);
        });
    });
});



$(document).on('click','.sponsorCatDonation', function(){
    const val = $(this).attr('data-value');
    sponsorCategoryDataTable(val);
});
function sponsorCategoryDataTable(dataId) {
    $('#sponsor-category-datatable').DataTable().destroy();
    let table = $('#sponsor-category-datatable');

    //dashbordCountData(call_status);
    table.DataTable(
        {
            order: [['2', 'DESC']],
            serverSide: true,
            responsive: true,
            processing: true,
            ajax: {
            url: "{{ route('Crm::sponsor_category_admin_data') }}",
            type: 'POST',
            data: function (d) {
                    d._token = '{{ csrf_token() }}';
                    d.filter_by_dataId = dataId;
                    //d.filter_by_campaign = $('#filter_by_campaign').val();
                    //d.filter_by_agent = $('#filter_by_agent').val();
                    d.filter_by_Date = $('.filter_by_Date').val();
                },
            },
            columns: [
                {"data": "category", name: 'donation_purpose.purpose'},
                {"data": "count", name: 'count', searchable: false},
                {"data": "revenue", name: 'totalDonation', searchable: false},
            ]
        }
    );
}

//, name: 'leads.member_id'

</script>
<script>
! function(o) {
    "use strict";
        function e() {
            this.$body = o("body"), this.charts = []
        }
        e.prototype.initCharts = function() {
            window.Apex = {
                chart: {
                    parentHeightOffset: 0,
                    toolbar: {
                        show: !1
                    }
                },
                grid: {
                    padding: {
                        left: 0,
                        right: 0
                    }
                },
                colors: ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00"]
            };
            
            var e = ["#727cf5", "#e3eaef"],
            t = o("#high-performing-product").data("colors");
            t && (e = t.split(","));
            //(t = o("#high-performing-product").data("colors")) && (e = t.split(","));
            var r = {
                    chart: {
                        height: 257,
                        type: "bar",
                        stacked: !0
                    },
                    plotOptions: {
                        bar: {
                            horizontal: !1,
                            columnWidth: "4%"
                        }
                    },
                    dataLabels: {
                        enabled: !1
                    },
                    stroke: {
                        show: !0,
                        width: 5,
                        colors: ["transparent"]
                    },
                    series: [{
                        name: "Permanent",
                        data: [<?= $permanent_member_c ?>]
                    }, {
                        name: "Temporary",
                        data: [<?= $temporary_member_c ?>]
                    }],
                    zoom: {
                        enabled: !1
                    },
                    legend: {
                        show: !1
                    },
                    colors: e,
                    xaxis: {
                        categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        axisBorder: {
                            show: !1
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: function(e) {
                                return e
                            },
                            offsetX: -15
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function(e) {
                                return e
                            }
                        }
                    }
                };
            new ApexCharts(document.querySelector("#high-performing-product"), r).render();
            e = ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00", "#e0d2a6"];
            (t = o("#average-sales").data("colors")) && (e = t.split(","));
            r = {
                    chart: {
                        height: 250,
                        type: "donut"
                    },
                    legend: {
                        show: !1
                    },
                    stroke: {
                        colors: ["transparent"]
                    },
                    series: [<?=$sum_Amounts;?>],
                    labels: [<?=$purposes;?>],
                    colors: e,
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: "bottom"
                            }
                        }
                    }]
                };
            new ApexCharts(document.querySelector("#average-sales"), r).render()
        }, 
        e.prototype.initMaps = function() {
            0 < o("#world-map-markers").length && o("#world-map-markers").vectorMap({
                map: "world_mill_en",
                normalizeFunction: "polynomial",
                hoverOpacity: .7,
                hoverColor: !1,
                regionStyle: {
                    initial: {
                        fill: "#e3eaef"
                    }
                },
                markerStyle: {
                    initial: {
                        r: 9,
                        fill: "#727cf5",
                        "fill-opacity": .9,
                        stroke: "#fff",
                        "stroke-width": 7,
                        "stroke-opacity": .4
                    },
                    hover: {
                        stroke: "#fff",
                        "fill-opacity": 1,
                        "stroke-width": 1.5
                    }
                },
                backgroundColor: "transparent",
                markers: [{
                    latLng: [40.71, -74],
                    name: "New York"
                }, {
                    latLng: [37.77, -122.41],
                    name: "San Francisco"
                }, {
                    latLng: [-33.86, 151.2],
                    name: "Sydney"
                }, {
                    latLng: [1.3, 103.8],
                    name: "Singapore"
                }],
                zoomOnScroll: !1
            })
        }, 
        e.prototype.init = function() {
            o("#dash-daterange").daterangepicker({
                singleDatePicker: !0
            }), this.initCharts(), this.initMaps()
        }, 
        o.Dashboard = new e, o.Dashboard.Constructor = e
}(window.jQuery),
function(t) {
    "use strict";
    t(document).ready(function(e) {
        t.Dashboard.init()
    })
}(window.jQuery);    
</script>
<script>
$(document).on('click','.donation', function(){
    const val = $(this).attr('data-value');
    donationComparisonGraph(val);
    // if(val== 'current-week'){
    //     $('#donation_text1').text('Current Week');
    //     $('#donation_text2').text('Previous Week');
    // }else if(val== 'current-month'){
    //     $('#donation_text1').text('Current Month');
    //     $('#donation_text2').text('Previous Month');
    // }else if(val== 'current-year'){
    //     $('#donation_text1').text('Current Year');
    //     $('#donation_text2').text('Previous Year');
    // }else if(val== 'date-range'){
    //     $('#donation_text1').text('Current Date Range');
    //     $('#donation_text2').text('Previous Date Range');
    // }
    /*filter_by_current_Date  filter_by_previous_Date
    filter_by_donation_Date donations-comparison Crm*/
    // var filter_by_current_Date = $('.filter_by_current_Date').val();
    // var filter_by_previous_Date = $('.filter_by_previous_Date').val();
    // if(val== 'date-range'){
    //     if(filter_by_current_Date == "" || filter_by_previous_Date == ""){
    //         alert('Please set current and previous date range');
    //         return;
    //     }
    // }
    
    // $.ajax({
    //     type: "GET",
    //     url: "{{ route('Crm::donations-comparison') }}",
    //     data: {
    //             _token : "{{ csrf_token() }}",
    //             val : val,
    //             filter_by_current_Date : filter_by_current_Date,
    //             filter_by_previous_Date : filter_by_previous_Date
    //         },
    //     success: function (data) {
    //         //console.log(data);
    //         var n1 = 0;
    //         var n2 = 0;
    //         n1 = String(data.current_donations).replace(/(.)(?=(\d{3})+$)/g,'$1,');
    //         n2 = String(data.previous_donations).replace(/(.)(?=(\d{3})+$)/g,'$1,');
    //         $("#current-donation").html('₹'+n1);
    //         $("#previous-donation").html('₹'+n2);
    //     }, error: function (data) {},
    // });

});
$(document).ready(function(){
    donationComparisonGraph('current-week');
});
function donationComparisonGraph(graph_type){
    
    var filter_by_current_Date = $('.filter_by_current_Date').val();
    var filter_by_previous_Date = $('.filter_by_previous_Date').val();
    
    if(graph_type == 'date-range'){
        if(filter_by_current_Date == "" || filter_by_previous_Date == ""){
            $.NotificationApp.send("Error","Please set current and previous date range","top-center","red","error");
            return;
        }
        $.ajax({
            type: "GET",
            url: "{{ route('Crm::custom_date_validation') }}",
            data: {
                    _token : "{{ csrf_token() }}",
                    filter_by_current_Date : filter_by_current_Date,
                    filter_by_previous_Date : filter_by_previous_Date
                },
            success: function (data) {
                if(data.status == false){
                    $.NotificationApp.send("Error","Please set same date range period","top-center","red","error");
                    return false;
                }

            }, error: function (data) {},
        });
        
    }
    //dashboard_graph
    $('#donation-graph').html('<img class="img-fluid" style="height: 200px; width= 200px; margin-top: 148px; margin-bottom: 148px; margin-left: 300px;" src="{{ asset("/hyper/assets/tenor.gif") }}">');
    $.ajax({
        type: "GET",
        url: "{{ route('Crm::donations-comparison') }}",
        data: {
                _token : "{{ csrf_token() }}",
                val : graph_type,
                filter_by_current_Date : filter_by_current_Date,
                filter_by_previous_Date : filter_by_previous_Date
            },
        success: function (data) {
            $("#donation-graph").html(data);
        }, error: function (data) {},
    });   
}



</script>
@endsection
@endif